<?php

namespace App\Console\Commands;

use App\Jobs\SyncProjectAsana;
use App\Jobs\SyncProjectAsanaRef2;
use App\Models\asanaDetailTask;
use App\Models\asanaProject;
use App\Models\asanaSection;
use App\Models\asanaSubTask;
use App\Models\asanaTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncDataCommand extends Command
{
    protected $signature = 'sync:newData';
    protected $description = 'Sync data from ASANA API';

    function Log($log, $description, $err)
    {
        $activity = activity()
            ->withProperties(['login_ip' => request()->ip(), 'status' => $err])
            ->log($description);
        $activity->log_name = $log; // Set log_name
        $activity->save(); // Simpan aktivitas dengan log_name yang telah ditetapkan
    }

    public function GetDataProject()
    {
        DB::beginTransaction();
        try {
            $response = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/projects');

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data['data'] as $project) {
                    $asanaProject = asanaProject::firstOrNew(['gid' => $project['gid']]);
                    if ($asanaProject->exists) {
                        continue;
                    }

                    $detailProject = Http::withHeaders([
                        'Authorization' => env('TOKEN_ASANA'),
                    ])->get('https://app.asana.com/api/1.0/projects/' . $project['gid']);
                    if ($detailProject->successful()) {
                        $deProject = $detailProject->json();

                        $startDate = $deProject['data']['start_on'];
                        $dueDate = $deProject['data']['due_date'];
                    }
                    $asanaProject->gid = $project['gid'];
                    $asanaProject->archived = $deProject['data']['archived'] ?? null;
                    $asanaProject->projectName = $project['name'];
                    $asanaProject->owner = $deProject['data']['owner']['gid'] ?? null;
                    $asanaProject->startDate = $startDate ?? null;
                    $asanaProject->dueDate = $dueDate ?? null;
                    $asanaProject->permalink_url = $deProject['data']['permalink_url'];
                    $asanaProject->save();

                    SyncProjectAsanaRef2::dispatch($project['gid']);
                }
            }
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

        while ($retryCount < $retryLimit) {
            $this->Log('Sync Data', 'Sync New Data Start', 'Get Data New Project');
            try {
                $this->GetDataProject();
                $this->Log('Sync Data', 'Sync New Data Succesfully', 'Get Data New Project');
                break; // Berhenti jika berhasil
            } catch (\Throwable $th) {
                $this->Log('Sync Data', 'Sync New Data Failed', $th->getMessage());
                $this->Log('Sync Data', 'Sync New Data Failed', 'Retry Get New Data Project');
                $retryCount++; // Menambah hitungan percobaan
            }
        }
    }
}
