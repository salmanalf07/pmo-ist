<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncCalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:calculateProgress';

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
    function Log($log, $description, $err)
    {
        $activity = activity()
            ->withProperties(['login_ip' => request()->ip(), 'status' => $err])
            ->log($description);
        $activity->log_name = $log; // Set log_name
        $activity->save(); // Simpan aktivitas dengan log_name yang telah ditetapkan
    }
    public function handle()
    {

        $this->Log('SyncCalculate', 'Start Calculate', 'success');
        DB::beginTransaction();
        try {
            $project = Project::with('asana')->where('has_asana', 1)->get();

            foreach ($project as $data) {
                if ($data->asana->isNotEmpty()) {
                    $average = round($data->asana->avg('progress'), 0);
                } else {
                    $average = 0; // Atau nilai default lain jika tidak ada asanaSections terkait
                }

                $saveProgress = project::find($data->id);
                $saveProgress->overAllProg = $average;
                $saveProgress->save();
            }
            $this->Log('SyncCalculate', 'Success Calculate', 'success');
            DB::commit();
        } catch (\Throwable $th) {
            $this->Log('SyncCalculate', 'Failed Calculate', $th->getMessage());
            DB::rollBack();
        }
    }
}
