<?php

namespace App\Jobs;

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

class SyncGetAsanaSubTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 18000;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $tasks = asanaTask::chunk(100, function ($tasks) {
                foreach ($tasks as $task) {
                    $detailTask = Http::withHeaders([
                        'Authorization' => 'Bearer ' . env('TOKEN_ASANA'),
                    ])->get('https://app.asana.com/api/1.0/tasks/' . $task->gid . '/subtasks');

                    if ($detailTask->successful()) {
                        $dataTask = $detailTask->json();
                        $refSubTask = 1;
                        foreach ($dataTask['data'] as $subtask) {
                            $getSubTask = Http::withHeaders([
                                'Authorization' => 'Bearer ' . env('TOKEN_ASANA'),
                            ])->get('https://app.asana.com/api/1.0/tasks/' . $subtask['gid']);

                            if ($getSubTask->successful()) {
                                $dataSubTask = $getSubTask->json();
                                $asanaSubTask = asanaSubTask::firstOrNew(['gid' => $dataSubTask['data']['gid']]);
                                $asanaSubTask->task_id = $task->id;
                                $asanaSubTask->gid = $dataSubTask['data']['gid'];
                                $asanaSubTask->ref = $refSubTask++;
                                $asanaSubTask->subTaskName = $dataSubTask['data']['name'];
                                $asanaSubTask->assignee = $dataSubTask['data']['assignee']['name'] ?? null;
                                $asanaSubTask->start_on = $dataSubTask['data']['start_on'] ?? null;
                                $asanaSubTask->due_on = $dataSubTask['data']['due_on'] ?? null;
                                $asanaSubTask->permalink_url = $dataSubTask['data']['permalink_url'];
                                $asanaSubTask->status = $dataSubTask['data']['completed'];
                                $asanaSubTask->save();
                            }
                        }
                    }
                }
            });

            DB::commit();
            record('Sync Data', 'Sync Data Successfully', 'Get Sub Task Asana');
        } catch (\Throwable $th) {
            DB::rollBack();
            record('Sync Data', 'Sync Tasks Failed', $th->getMessage());
            throw $th;
        }
    }
}
