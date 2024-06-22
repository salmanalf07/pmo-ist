<?php

namespace App\Jobs;

use App\Models\asanaDetailTask;
use App\Models\asanaProject;
use App\Models\asanaSection;
use App\Models\asanaStatus;
use App\Models\asanaSubTask;
use App\Models\asanaSubTask2;
use App\Models\asanaTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\MaxAttemptsExceededException;
use GuzzleHttp\Client;

class SyncProjectAsanaRef2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    public $timeout = 5000;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    function Log($log, $description, $err, $gid)
    {
        $activity = activity()
            ->withProperties(['login_ip' => request()->ip(), 'status' => $err, 'gid' => $gid])
            ->log($description);
        $activity->log_name = $log; // Set log_name
        $activity->save(); // Simpan aktivitas dengan log_name yang telah ditetapkan
    }

    public function GetDataProject($gid)
    {
        try {

            $detailProject = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/projects/' . $gid);
            if (!$detailProject->successful()) {
                throw new \Exception('Failed to fetch project details from Asana API');
            }

            $deProject = $detailProject->json();

            // Memulai transaksi database
            DB::beginTransaction();

            $startDate = $deProject['data']['start_on'];
            $dueDate = $deProject['data']['due_date'];

            if ($deProject['data']['current_status'] != null) {
                $getStatus = asanaStatus::where('color', $deProject['data']['current_status']['color'])->first();
                $currentStatus = $getStatus->code;
            } else {
                $currentStatus = null;
            }
            $asanaProject = asanaProject::firstOrNew(['gid' => $gid]);
            $asanaProject->gid = $gid;
            $asanaProject->archived = $deProject['data']['archived'] ?? null;
            $asanaProject->projectName = $deProject['data']['name'];
            $asanaProject->owner = $deProject['data']['owner']['gid'] ?? null;
            $asanaProject->startDate = $startDate ?? null;
            $asanaProject->dueDate = $dueDate ?? null;
            $asanaProject->status = $currentStatus;
            $asanaProject->sync_today = null;
            $asanaProject->save();

            $getSection = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/projects/' . $gid . '/sections');

            if (!$detailProject->successful()) {
                throw new \Exception('Failed to fetch section from Asana API');
            }
            $dataSection = $getSection->json();
            $ref = 1;

            $returnedGids = array_column($dataSection['data'], 'gid');

            // Cari gid yang ada di database tetapi tidak ada di data yang di-return dan hapus
            $sectionToDelete =  asanaSection::where('asana_id', $asanaProject->id)
                ->whereNotIn('gid', $returnedGids)
                ->get();

            // Hapus setiap task beserta relasinya
            $sectionToDelete->each(function ($task) {
                // Hapus task utama
                $task->delete();
            });

            foreach ($dataSection['data'] as $section) {
                $existingSection = asanaSection::withTrashed()->where('gid', $section['gid'])->first();

                if (!$existingSection || ($existingSection && is_null($existingSection->deleted_at))) {
                    // Jika tidak ditemukan atau ditemukan tetapi tidak di-soft-delete, buat record baru
                    if (!in_array($section['name'], ['Bagian tanpa judul', 'Untitled section'])) {
                        $saveSection = asanaSection::firstOrNew(['gid' => $section['gid']]);
                        $saveSection->ref = $ref++;
                        $saveSection->asana_id = $asanaProject->id;
                        $saveSection->gid = $section['gid'];
                        $saveSection->sectionName = $section['name'];
                        $saveSection->save();


                        $getTask = Http::withHeaders([
                            'Authorization' => env('TOKEN_ASANA'),
                        ])->get('https://app.asana.com/api/1.0/sections/' . $saveSection['gid'] . '/tasks');
                        if (!$getTask->successful()) {
                            throw new \Exception('Failed to fetch task from Asana API');
                        }
                        $dataTask = $getTask->json();
                        // Ambil semua gid dari data yang di-return
                        $GidsTask = array_column($dataTask['data'], 'gid');

                        // Cari gid yang ada di database tetapi tidak ada di data yang di-return dan hapus
                        $tasksToDelete = asanaSubTask2::where('section_id', $saveSection['gid'])
                            ->whereNotIn('gid', $GidsTask)
                            ->get();
                        // Hapus setiap task beserta relasinya
                        $tasksToDelete->each(function ($task) {
                            // Hapus task utama
                            $task->delete();
                        });

                        $refDetailTask = 1;
                        foreach ($dataTask['data'] as $task) {

                            $getDataTask = Http::withHeaders([
                                'Authorization' => env('TOKEN_ASANA'),
                            ])->get('https://app.asana.com/api/1.0/tasks/' . $task['gid']);

                            if (!$getDataTask->successful()) {
                                throw new \Exception('Failed to fetch Data task from Asana API');
                            }
                            $dataDetailTask = $getDataTask->json()['data'];
                            // foreach ($dataDetailTask['data'] as $detailTask) {
                            $saveTask = asanaSubTask2::firstOrNew(['gid' => $dataDetailTask['gid']]);
                            $saveTask->gid = $dataDetailTask['gid'];
                            $saveTask->ref = $refDetailTask++;
                            $saveTask->section_id = $saveSection['id'];
                            $saveTask->taskName = $dataDetailTask['name'];
                            $saveTask->assignee = $dataDetailTask['assignee']['gid'] ?? null;
                            $saveTask->start_on = $dataDetailTask['start_on'];
                            $saveTask->due_on = $dataDetailTask['due_on'];
                            $saveTask->permalink_url = $dataDetailTask['permalink_url'];
                            foreach ($dataDetailTask['custom_fields'] as $value) {
                                if ($value['gid'] === "1206277209339208") {
                                    $saveTask->progress = $value['number_value'] ?? 0;
                                }
                            }
                            $saveTask->status = $dataDetailTask['completed'];
                            $saveTask->save();
                            // }
                            $this->GetDataSubTask($task['gid'], $saveTask);
                        }
                    }
                }
            }
            $this->calculate($asanaProject->id);
            $updStatusSync = asanaProject::find($asanaProject->id);
            $updStatusSync->sync_today = 1;
            $updStatusSync->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function GetDataSubTask($gid, $taskId)
    {
        // try {
        $detailTask = Http::withHeaders([
            'Authorization' => env('TOKEN_ASANA'),
        ])->get('https://app.asana.com/api/1.0/tasks/' . $gid . '/subtasks');

        if ($detailTask->successful()) {
            $dataTask = $detailTask->json();
            $refSubTask = 1;

            $GidsSubTask = array_column($dataTask['data'], 'gid');

            $subTasksToDelete = asanaSubTask2::where('parent_uuid', $taskId['id'])
                ->whereNotIn('gid', $GidsSubTask)
                ->get();
            // Hapus setiap task beserta relasinya
            $subTasksToDelete->each(function ($task) {
                // Hapus task utama
                $task->delete();
            });

            foreach ($dataTask['data'] as $tasks) {
                $getSubTask = Http::withHeaders([
                    'Authorization' => env('TOKEN_ASANA'),
                ])->get('https://app.asana.com/api/1.0/tasks/' . $tasks['gid']);
                if ($getSubTask->successful()) {
                    $dataSubTask = $getSubTask->json()['data'];
                    $asanaSubTask = asanaSubTask2::firstOrNew(
                        ['gid' => $dataSubTask['gid']] // Kondisi untuk dicari
                    );

                    // Isi atribut lainnya
                    $asanaSubTask->ref = $refSubTask++;
                    $asanaSubTask->parent_uuid = $taskId['id'];
                    $asanaSubTask->taskName = $dataSubTask['name'];
                    $asanaSubTask->assignee = $dataSubTask['assignee']['gid'] ?? null;
                    $asanaSubTask->start_on = $dataSubTask['start_on'] ?? null;
                    $asanaSubTask->due_on = $dataSubTask['due_on'] ?? null;
                    $asanaSubTask->permalink_url = $dataSubTask['permalink_url'];
                    $asanaSubTask->status = $dataSubTask['completed'];

                    // Simpan instance ke database
                    $asanaSubTask->save();

                    $this->GetDataSubTask($tasks['gid'], $asanaSubTask);
                }
            }
        }
        // } catch (\Throwable $th) {
        //     throw new \Exception($th->getMessage());
        // }
    }

    public function calculate($gid)
    {
        DB::beginTransaction();
        try {
            $section = asanaSection::where('asana_id', $gid)->get();
            foreach ($section as $data) {
                $tasksCalSub = asanaSubTask2::with('children')->where('section_id', $data['id'])->orderBy('ref', 'asc')->get();

                foreach ($tasksCalSub as $subtask) {
                    $updTask = asanaSubTask2::with('children')->find($subtask['id']);
                    if (count($updTask->children)) {
                        $progressSubtask = $updTask->children->avg('status') * 100 ?? 0;
                        $updTask->progress =  $progressSubtask;
                        $updTask->status = $progressSubtask == 100 ? 1 : 0;
                        $updTask->save();
                    }
                }
                $tasks = asanaSubTask2::where('section_id', $data['id'])->orderBy('ref', 'asc')->get();
                $totalTasks = $tasks->count();
                $completedTasks = $tasks->filter(function ($task) {
                    return optional($task)->status == 1;
                })->count();

                // Hitung persentase task yang complete
                $percentageComplete = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

                $updSection = asanaSection::find($data['id']);
                $updSection->start_on = $tasks->first()->start_on
                    ?? $tasks->first()->due_on
                    ?? null;
                $updSection->due_on = $tasks->last()->due_on ?? null;
                $updSection->progress = round($percentageComplete, 0);
                $updSection->status = $percentageComplete == 100 ? 1 : 0;
                $updSection->save();
            }

            $project = asanaProject::find($gid);

            $sections = asanaSection::where('asana_id', $project['id'])->orderBy('ref', 'asc')->get();

            // $startDate = $sections->first()->start_on
            //     ?? $sections->first()->due_on
            //     ?? null; // Misalkan null
            // $dueDate = $sections->last()->due_on ?? null;


            $updProject = asanaProject::with('section')->find($project['id']);
            $progressTask = round($updProject->section->avg('progress'), 0);
            $status = tentukanStatusProyek($updProject->startDate, $updProject->dueDate, $progressTask);
            // $updProject->startDate = $startDate;
            // $updProject->dueDate = $dueDate;
            $updProject->progress = $progressTask;
            if ($status != $updProject->status) {
                if (!in_array($updProject->status, ['on_hold', 'complete'])) {
                    $updProject->status = $status;
                    $this->setStatus($updProject->gid, $status);
                }
            }
            $updProject->save();


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
    public function setStatus($gid, $status)
    {
        try {

            $response = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://app.asana.com/api/1.0/status_updates', [
                'data' => [
                    'status_type' => $status,
                    'text' => 'Update By Portal',
                    'parent' => $gid,
                ],
            ]);
            $this->Log('Sync Data', 'Set Status', 'Succes', $gid);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function handle()
    {
        $this->Log('Sync Data', 'Sync Data By Job Start', 'Sync Data Project By Job', $this->data);
        try {
            $this->GetDataProject($this->data);
            $this->Log('Sync Data', 'Sync Data Successfully', 'Get Data Project By Job', $this->data);
        } catch (\Throwable $th) {
            $this->Log('Sync Data', 'Sync Data By Job Failed', $th->getMessage(), $this->data);
        }
    }


    public function failed(\Throwable $exception)
    {
        if ($exception instanceof MaxAttemptsExceededException) {
            $this->Log('Sync Data', 'Sync Data By Job Failed', $exception->getMessage(), $this->data);
        }
    }
    // }
}
