<?php

namespace App\Console\Commands;

use App\Models\asanaSection;
use App\Models\asanaTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateProjectAsana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:calculateProjectAsana';

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
        $this->Log('Sync Data', 'Sync Data Start', 'calculate Progress & get date');
        DB::beginTransaction();
        try {
            $section = asanaSection::all();
            foreach ($section as $data) {
                $tasks = asanaTask::with('detailTask')->where('section_id', $data['id'])->orderBy('ref', 'asc')->get();

                $totalTasks = $tasks->count();
                $completedTasks = $tasks->filter(function ($task) {
                    return optional($task->detailTask)->status == 1;
                })->count();

                // Hitung persentase task yang complete
                $percentageComplete = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

                $updSection = asanaSection::find($data['id']);
                $updSection->start_on = $tasks->first()->detailTask->start_on ?? null;
                $updSection->due_on = $tasks->last()->detailTask->due_on ?? null;
                $updSection->progress = round($percentageComplete, 2);
                $updSection->status = $percentageComplete == 100 ? 1 : 0;
                $updSection->save();
            }

            DB::commit();
            $this->Log('Sync Data', 'Sync Data Succesfully', 'calculate Progress & get date Success');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->Log('Sync Data', 'Sync Data Failed', $th->getMessage());
        }

        $this->finish();
    }
}
