<?php

namespace App\Jobs;

use App\Models\asanaDetailTask;
use App\Models\asanaProject;
use App\Models\asanaSection;
use App\Models\asanaStatus;
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
            'timeout'  => 300.0,  // Set timeout to 300 seconds
        ]);

        DB::beginTransaction();
        try {
            $detailProject = $this->fetchAsanaData($client, "projects/$gid");
            if ($detailProject && $detailProject->getStatusCode() == 200) {
                $deProject = json_decode($detailProject->getBody(), true);
                $startDate = $deProject['data']['start_on'] ?? null;
                $dueDate = $deProject['data']['due_date'] ?? null;

                if ($deProject['data']['current_status'] != null) {
                    $getStatus = asanaStatus::where('color', $deProject['data']['current_status']['color'])->first();
                    $currentStatus = $getStatus->code;
                } else {
                    $currentStatus = null;
                }

                $asanaProject = asanaProject::firstOrNew(['gid' => $gid]);
                $asanaProject->fill([
                    'gid' => $gid,
                    'archived' => $deProject['data']['archived'] ?? null,
                    'projectName' => $deProject['data']['name'],
                    'owner' => $deProject['data']['owner']['gid'] ?? null,
                    'startDate' => $startDate ?? null,
                    'dueDate' => $dueDate ?? null,
                    'status' => $currentStatus,
                    'sync_today' => null,
                ]);
                $asanaProject->save();

                $sections = $this->fetchAsanaData($client, "projects/$gid/sections");
                if ($sections && $sections->getStatusCode() == 200) {
                    $dataSections = json_decode($sections->getBody(), true)['data'];
                    $this->processSections($client, $dataSections, $asanaProject);
                }

                $this->calculate($asanaProject->id);
                $asanaProject->sync_today = 1;
                $asanaProject->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    private function fetchAsanaData($client, $endpoint)
    {
        try {
            return $client->request('GET', $endpoint, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => env('TOKEN_ASANA'),
                ],
            ]);
        } catch (\Exception $e) {
            return null;  // Handle the error appropriately
        }
    }

    private function processSections($client, $sections, $asanaProject)
    {
        $ref = 1;
        $returnedGids = array_column($sections, 'gid');

        // Cari gid yang ada di database tetapi tidak ada di data yang di-return dan hapus
        $sectionToDelete =  asanaSection::where('asana_id', $asanaProject->id)
            ->whereNotIn('gid', $returnedGids)
            ->get();

        // Hapus setiap task beserta relasinya
        $sectionToDelete->each(function ($task) {
            // Hapus task utama
            $task->delete();
        });
        foreach ($sections as $section) {
            $existingSection = asanaSection::withTrashed()->where('gid', $section['gid'])->first();
            if (!$existingSection || ($existingSection && is_null($existingSection->deleted_at))) {
                $saveSection = asanaSection::firstOrNew(['gid' => $section['gid']]);
                $saveSection->fill([
                    'ref' => $ref++,
                    'asana_id' => $asanaProject->id,
                    'gid' => $section['gid'],
                    'sectionName' => $section['name']
                ]);
                $saveSection->save();

                $tasks = $this->fetchAsanaData($client, "sections/{$section['gid']}/tasks");
                if ($tasks && $tasks->getStatusCode() == 200) {
                    $dataTasks = json_decode($tasks->getBody(), true)['data'];
                    $this->processTasks($client, $dataTasks, $saveSection);
                }
            }
        }
    }

    private function processTasks($client, $tasks, $saveSection)
    {
        $refTask = 1;
        $GidsTask = array_column($tasks, 'gid');

        // Cari gid yang ada di database tetapi tidak ada di data yang di-return dan hapus
        $tasksToDelete = asanaTask::with('detailTask', 'subTask')
            ->where('section_id', $tasks)
            ->whereNotIn('gid', $GidsTask)
            ->get();
        // Hapus setiap task beserta relasinya
        $tasksToDelete->each(function ($task) {
            // Hapus task utama
            $task->delete();
        });
        foreach ($tasks as $task) {
            $saveTask = asanaTask::firstOrNew(['gid' => $task['gid']]);
            $saveTask->fill([
                'ref' => $refTask++,
                'section_id' => $saveSection->id,
                'gid' => $task['gid'],
                'taskName' => $task['name']
            ]);
            $saveTask->save();

            $taskDetail = $this->fetchAsanaData($client, "tasks/{$task['gid']}");
            if ($taskDetail && $taskDetail->getStatusCode() == 200) {
                $dataDetailTask = json_decode($taskDetail->getBody(), true)['data'];
                $saveDetailTask = asanaDetailTask::firstOrNew(['gid' => $dataDetailTask['gid']]);
                $saveDetailTask->fill([
                    'gid' => $dataDetailTask['gid'],
                    'ref' => 1,
                    'task_id' => $saveTask->id,
                    'assignee' => $dataDetailTask['assignee']['gid'] ?? null,
                    'start_on' => $dataDetailTask['start_on'] ?? null,
                    'due_on' => $dataDetailTask['due_on'] ?? null,
                    'permalink_url' => $dataDetailTask['permalink_url'],
                    'progress' => $this->getProgressFromCustomFields($dataDetailTask['custom_fields']),
                    'status' => $dataDetailTask['completed']
                ]);
                $saveDetailTask->save();

                $this->GetDataSubTask($task['gid'], $saveTask->id);
            }
        }
    }

    private function getProgressFromCustomFields($customFields)
    {
        foreach ($customFields as $field) {
            if ($field['gid'] === "1206277209339208") {
                return $field['number_value'] ?? 0;
            }
        }
        return 0;
    }

    public function GetDataSubTask($gid, $taskId)
    {
        $client = new Client([
            'base_uri' => 'https://app.asana.com/api/1.0/',
            'timeout'  => 300,  // Set timeout to 300 seconds
        ]);
        DB::beginTransaction();
        try {
            $detailTask = $this->fetchAsanaData($client, "tasks/$gid/subtasks");
            if ($detailTask && $detailTask->getStatusCode() == 200) {
                $dataTasks = json_decode($detailTask->getBody(), true)['data'];

                $GidsSubTask = array_column($dataTasks['data'], 'gid');

                $subTasksToDelete = asanaSubTask::where('task_id', $taskId)
                    ->whereNotIn('gid', $GidsSubTask)
                    ->get();
                // Hapus setiap task beserta relasinya
                $subTasksToDelete->each(function ($task) {
                    // Hapus task utama
                    $task->delete();
                });
                $this->processSubTasks($client, $dataTasks, $taskId);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    private function processSubTasks($client, $subTasks, $taskId)
    {
        $refSubTask = 1;
        foreach ($subTasks as $subTask) {
            $subTaskDetail = $this->fetchAsanaData($client, "tasks/{$subTask['gid']}");
            if ($subTaskDetail && $subTaskDetail->getStatusCode() == 200) {
                $dataSubTask = json_decode($subTaskDetail->getBody(), true)['data'];
                $asanaSubTask = asanaSubTask::firstOrNew(['gid' => $dataSubTask['gid']]);
                $asanaSubTask->fill([
                    'task_id' => $taskId,
                    'gid' => $dataSubTask['gid'],
                    'ref' => $refSubTask++,
                    'subTaskName' => $dataSubTask['name'],
                    'assignee' => $dataSubTask['assignee']['gid'] ?? null,
                    'start_on' => $dataSubTask['start_on'] ?? null,
                    'due_on' => $dataSubTask['due_on'] ?? null,
                    'permalink_url' => $dataSubTask['permalink_url'],
                    'status' => $dataSubTask['completed']
                ]);
                $asanaSubTask->save();
            }
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
