<?php

namespace App\Jobs;

use App\Models\asanaProject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncGetOwnerAsanaProject implements ShouldQueue
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
            $projects = asanaProject::chunk(100, function ($projects) {
                foreach ($projects as $project) {
                    $detailProject = Http::withHeaders([
                        'Authorization' => 'Bearer ' . env('TOKEN_ASANA'),
                    ])->get('https://app.asana.com/api/1.0/projects/' . $project->gid);

                    if ($detailProject->successful()) {
                        $dataProject = $detailProject->json();
                        $project->owner = $dataProject['data']['owner']['name'] ?? null;
                        $project->save();
                    }
                }
            });

            DB::commit();
            record('Sync Data', 'Sync Data Successfully', 'Get Owner Project');
        } catch (\Throwable $th) {
            DB::rollBack();
            record('Sync Data', 'Sync Projects Failed', $th->getMessage());
            throw $th;
        }
    }
}
