<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use App\Models\asanaProject;
use App\Models\asanaSubTask;
use App\Models\asanaTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncAsanaDetailProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        record('Sync Data', 'Sync Data Start', 'Detail Project & Sub Task');
        DB::beginTransaction();
        try {
            $project = asanaProject::all();

            foreach ($project as $data) {
                $detailProject = Http::withHeaders([
                    'Authorization' => env('TOKEN_ASANA'),
                ])->get('https://app.asana.com/api/1.0/projects/' . $data['gid']);

                if ($detailProject->successful()) {
                    $dataProject = $detailProject->json();
                    $asanaProject = asanaProject::find($data['id']);
                    $asanaProject->owner = $dataProject['data']['owner']['name'] ?? null;
                    $asanaProject->save();
                }
            };

            $task = asanaTask::all();
            foreach ($task as $data) {
                $detailTask = Http::withHeaders([
                    'Authorization' => env('TOKEN_ASANA'),
                ])->get('https://app.asana.com/api/1.0/tasks/' . $data['gid'] . '/subtasks');

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
                            $asanaSubTask->task_id = $data['id'];
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
            DB::commit();
            record('Sync Data', 'Sync Data Succesfully', 'Detail Project & Sub Task Success');
            return redirect('/asana/calculateAsana');
        } catch (\Throwable $th) {
            DB::rollBack();
            record('Sync Data', 'Sync Data Failed', $th->getMessage());
        }
    }
}
