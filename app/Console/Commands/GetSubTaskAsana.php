<?php

namespace App\Console\Commands;

use App\Models\asanaSubTask;
use App\Models\asanaTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GetSubTaskAsana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:getAsanaSubtask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
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

        $this->finish();
    }
}
