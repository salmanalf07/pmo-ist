<?php

namespace App\Jobs;

use App\Models\asanaDetailTask;
use App\Models\asanaProject;
use App\Models\asanaSection;
use App\Models\asanaSubTask;
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

class SyncProjectAsanaRef implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
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
        $client = new Client([
            'base_uri' => 'https://app.asana.com/api/1.0/',
            'timeout'  => 60.0,  // Set timeout to 10 seconds
        ]);

        DB::beginTransaction();
        try {
            $detailProject = $client->request('GET', "projects/" . $gid, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => env('TOKEN_ASANA'),
                ],
            ]);

            if ($detailProject->getStatusCode() == 200) {
                $deProject = json_decode($detailProject->getBody(), true);

                $startDate = $deProject['data']['start_on'];
                $dueDate = $deProject['data']['due_date'];
            }
            $asanaProject = asanaProject::firstOrNew(['gid' => $gid]);
            $asanaProject->gid = $gid;
            $asanaProject->archived = $deProject['data']['archived'] ?? null;
            $asanaProject->projectName = $deProject['data']['name'];
            $asanaProject->owner = $deProject['data']['owner']['gid'] ?? null;
            $asanaProject->startDate = $startDate ?? null;
            $asanaProject->dueDate = $dueDate ?? null;
            $asanaProject->sync_today = null;
            $asanaProject->save();

            $getSection = $client->request('GET', "projects/" . $gid . "/sections", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => env('TOKEN_ASANA'),
                ],
            ]);
            if ($getSection->getStatusCode() == 200) {
                $dataSection = json_decode($getSection->getBody(), true);
                $ref = 1;
                foreach ($dataSection['data'] as $section) {
                    $existingSection = asanaSection::withTrashed()->where('gid', $section['gid'])->first();

                    if (!$existingSection || ($existingSection && is_null($existingSection->deleted_at))) {
                        // Jika tidak ditemukan atau ditemukan tetapi tidak di-soft-delete, buat record baru
                        $saveSection = asanaSection::firstOrNew(['gid' => $section['gid']]);
                        $saveSection->ref = $ref++;
                        $saveSection->asana_id = $asanaProject->id;
                        $saveSection->gid = $section['gid'];
                        $saveSection->sectionName = $section['name'];
                        $saveSection->save();

                        $getTask = $client->request('GET', "sections/" . $section['gid'] . '/tasks', [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Authorization' => env('TOKEN_ASANA'),
                            ],
                        ]);
                        if ($getTask->getStatusCode() == 200) {
                            $dataTask = json_decode($getTask->getBody(), true);
                            $refTask = 1;
                            foreach ($dataTask['data'] as $task) {
                                $saveTask = asanaTask::firstOrNew(['gid' => $task['gid']]);
                                $saveTask->ref = $refTask++;
                                $saveTask->section_id = $saveSection->id;
                                $saveTask->gid = $task['gid'];
                                $saveTask->taskName = $task['name'];
                                $saveTask->save();

                                $getDetailTask = $client->request('GET', "tasks/" . $task['gid'], [
                                    'headers' => [
                                        'Accept' => 'application/json',
                                        'Authorization' => env('TOKEN_ASANA'),
                                    ],
                                ]);
                                if ($getDetailTask->getStatusCode() == 200) {
                                    $dataDetailTask = json_decode($getDetailTask->getBody(), true);
                                    $refDetailTask = 1;
                                    // foreach ($dataDetailTask['data'] as $detailTask) {
                                    $saveDetailTask = asanaDetailTask::firstOrNew(['gid' => $dataDetailTask['data']['gid']]);
                                    $saveDetailTask->gid = $dataDetailTask['data']['gid'];
                                    $saveDetailTask->ref = $refDetailTask;
                                    $saveDetailTask->task_id = $saveTask->id;
                                    $saveDetailTask->assignee = $dataDetailTask['data']['assignee']['gid'] ?? null;
                                    $saveDetailTask->start_on = $dataDetailTask['data']['start_on'];
                                    $saveDetailTask->due_on = $dataDetailTask['data']['due_on'];
                                    $saveDetailTask->permalink_url = $dataDetailTask['data']['permalink_url'];
                                    foreach ($dataDetailTask['data']['custom_fields'] as $value) {
                                        if ($value['gid'] === "1206277209339208") {
                                            $saveDetailTask->progress = $value['number_value'] ?? 0;
                                        }
                                    }
                                    $saveDetailTask->status = $dataDetailTask['data']['completed'];
                                    $saveDetailTask->save();
                                    // }
                                }
                                $this->GetDataSubTask($task['gid'], $saveTask->id);
                            }
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
        $client = new Client([
            'base_uri' => 'https://app.asana.com/api/1.0/',
            'timeout'  => 60.0,  // Set timeout to 10 seconds
        ]);
        DB::beginTransaction();
        try {
            $detailTask = $client->request('GET', "tasks/" . $gid . '/subtasks', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => env('TOKEN_ASANA'),
                ],
            ]);
            if ($detailTask->getStatusCode() == 200) {
                $dataTask = json_decode($detailTask->getBody(), true);
                $refSubTask = 1;
                foreach ($dataTask['data'] as $tasks) {
                    $getSubTask = $client->request('GET', "tasks/" . $tasks['gid'], [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization' => env('TOKEN_ASANA'),
                        ],
                    ]);
                    if ($getSubTask->getStatusCode() == 200) {
                        $dataSubTask = json_decode($getSubTask->getBody(), true);
                        $asanaSubTask = asanaSubTask::firstOrNew(['gid' => $dataSubTask['data']['gid']]);
                        $asanaSubTask->task_id = $taskId;
                        $asanaSubTask->gid = $dataSubTask['data']['gid'];
                        $asanaSubTask->ref = $refSubTask++;
                        $asanaSubTask->subTaskName = $dataSubTask['data']['name'];
                        $asanaSubTask->assignee = $dataSubTask['data']['assignee']['gid'] ?? null;
                        $asanaSubTask->start_on = $dataSubTask['data']['start_on'] ?? null;
                        $asanaSubTask->due_on = $dataSubTask['data']['due_on'] ?? null;
                        $asanaSubTask->permalink_url = $dataSubTask['data']['permalink_url'];
                        $asanaSubTask->status = $dataSubTask['data']['completed'];
                        $asanaSubTask->save();
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function GetDataSubTask2($gid, $taskId)
    {
        DB::beginTransaction();
        try {
            $detailTask = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/tasks/' . $gid . '/subtasks');

            if ($detailTask->successful()) {
                $dataTask = $detailTask->json();
                $refSubTask = 1;
                foreach ($dataTask['data'] as $tasks) {
                    $getSubTask = Http::withHeaders([
                        'Authorization' => env('TOKEN_ASANA'),
                    ])->get('https://app.asana.com/api/1.0/tasks/' . $tasks['gid']);
                    if ($getSubTask->successful()) {
                        $dataSubTask = $getSubTask->json();
                        $asanaSubTask = asanaSubTask::firstOrNew(['gid' => $dataSubTask['data']['gid']]);
                        $asanaSubTask->task_id = $taskId;
                        $asanaSubTask->gid = $dataSubTask['data']['gid'];
                        $asanaSubTask->ref = $refSubTask++;
                        $asanaSubTask->subTaskName = $dataSubTask['data']['name'];
                        $asanaSubTask->assignee = $dataSubTask['data']['assignee']['gid'] ?? null;
                        $asanaSubTask->start_on = $dataSubTask['data']['start_on'] ?? null;
                        $asanaSubTask->due_on = $dataSubTask['data']['due_on'] ?? null;
                        $asanaSubTask->permalink_url = $dataSubTask['data']['permalink_url'];
                        $asanaSubTask->status = $dataSubTask['data']['completed'];
                        $asanaSubTask->save();
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function calculate($gid)
    {
        DB::beginTransaction();
        try {
            $section = asanaSection::where('asana_id', $gid)->get();
            foreach ($section as $data) {
                $tasksCalSub = asanaTask::with('detailTask')->where('section_id', $data['id'])->orderBy('ref', 'asc')->get();

                foreach ($tasksCalSub as $subtask) {
                    $updTask = asanaTask::with('detailTask', 'subTask')->find($subtask['id']);
                    if (count($updTask->subTask)) {
                        $progressSubtask = $updTask->subTask->avg('status') * 100 ?? 0;
                        $updTask->detailTask->progress =  $progressSubtask;
                        $updTask->detailTask->status = $progressSubtask == 100 ? 1 : 0;
                        $updTask->detailTask->save();
                    }
                }
                $tasks = asanaTask::with('detailTask')->where('section_id', $data['id'])->orderBy('ref', 'asc')->get();
                $totalTasks = $tasks->count();
                $completedTasks = $tasks->filter(function ($task) {
                    $detailTask = $task->detailTask;
                    return optional($detailTask)->status == 1;
                })->count();

                // Hitung persentase task yang complete
                $percentageComplete = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

                $updSection = asanaSection::find($data['id']);
                $updSection->start_on = $tasks->first()->detailTask->start_on
                    ?? $tasks->first()->detailTask->due_on
                    ?? null;
                $updSection->due_on = $tasks->last()->detailTask->due_on ?? null;
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
            $updProject->status = $status;
            $updProject->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
    public function handle()
    {
        $retryLimit = 3; // Batas percobaan
        $retryCount = 0; // Inisialisasi hitungan percobaan


        // while ($retryCount < $retryLimit) {
        $this->Log('Sync Data', 'Sync Data By Job Start', 'Sync Data Project By Job', $this->data);
        try {
            $this->GetDataProject($this->data);
            $this->Log('Sync Data', 'Sync Data Succesfully', 'Get Data Project By Job', $this->data);
            // break; // Berhenti jika berhasil
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
