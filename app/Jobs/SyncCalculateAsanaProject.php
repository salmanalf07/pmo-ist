<?php

namespace App\Jobs;

use App\Models\asanaSection;
use App\Models\asanaTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SyncCalculateAsanaProject implements ShouldQueue
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
        record('Sync Data', 'Sync Data Start', 'calculate Progress & get date');
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
            record('Sync Data', 'Sync Data Succesfully', 'calculate Progress & get date Success');
        } catch (\Throwable $th) {
            DB::rollBack();
            record('Sync Data', 'Sync Data Failed', $th->getMessage());
        }
    }
}
