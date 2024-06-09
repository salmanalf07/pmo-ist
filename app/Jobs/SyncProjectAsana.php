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

class SyncProjectAsana implements ShouldQueue
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
        DB::beginTransaction();
        try {

            $detailProject = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/projects/' . $gid);
            if ($detailProject->successful()) {
                $deProject = $detailProject->json();

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
            $asanaProject->save();

            $getSection = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/projects/' . $gid . '/sections');

            if ($getSection->successful()) {
                $dataSection = $getSection->json();
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


                        $getTask = Http::withHeaders([
                            'Authorization' => env('TOKEN_ASANA'),
                        ])->get('https://app.asana.com/api/1.0/sections/' . $section['gid'] . '/tasks');

                        if ($getTask->successful()) {
                            $dataTask = $getTask->json();
                            $refTask = 1;
                            foreach ($dataTask['data'] as $task) {
                                $saveTask = asanaTask::firstOrNew(['gid' => $task['gid']]);
                                $saveTask->ref = $refTask++;
                                $saveTask->section_id = $saveSection->id;
                                $saveTask->gid = $task['gid'];
                                $saveTask->taskName = $task['name'];
                                $saveTask->save();

                                $getDetailTask = Http::withHeaders([
                                    'Authorization' => env('TOKEN_ASANA'),
                                ])->get('https://app.asana.com/api/1.0/tasks/' . $task['gid']);

                                if ($getDetailTask->successful()) {
                                    $dataDetailTask = $getDetailTask->json();
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
                                    $saveDetailTask->progress = $dataDetailTask['data']['custom_fields'][1]['number_value'] ?? 0;
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
            $this->calculate($gid);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function GetDataSubTask($gid, $taskId)
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
            $section = asanaSection::where('gid', $gid)->get();
            foreach ($section as $data) {
                $tasks = asanaTask::with('detailTask')->where('section_id', $data['id'])->orderBy('ref', 'asc')->get();

                $totalTasks = $tasks->count();
                $completedTasks = $tasks->filter(function ($task) {
                    return optional($task->detailTask)->status == 1;
                })->count();

                // Hitung persentase task yang complete
                $percentageComplete = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

                $updSection = asanaSection::find($data['id']);
                $updSection->start_on = $tasks->first()->detailTask->start_on
                    ?? $tasks->first()->detailTask->due_on
                    ?? null;
                $updSection->due_on = $tasks->last()->detailTask->due_on ?? null;
                $updSection->progress = round($percentageComplete, 2);
                $updSection->status = $percentageComplete == 100 ? 1 : 0;
                $updSection->save();
            }

            $project = asanaProject::where('gid', $gid)->first();

            $sections = asanaSection::where('asana_id', $project['id'])->orderBy('ref', 'asc')->get();
            $completedSections = $sections->filter(function ($section) {
                return $section->status == 1;
            })->count();

            $percentageSection = $sections->count() > 0 ? ($completedSections / $sections->count()) * 100 : 0;

            $startDate = $sections->first()->start_on
                ?? $sections->first()->due_on
                ?? null; // Misalkan null
            $dueDate = $sections->last()->due_on ?? null;
            $progressTask = round($percentageSection, 0); // Misalnya 70%

            $status = tentukanStatusProyek($startDate, $dueDate, $progressTask);

            $updProject = asanaProject::find($project['id']);
            $updProject->startDate = $startDate;
            $updProject->dueDate = $dueDate;
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