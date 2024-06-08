<?php

namespace App\Console\Commands;

use App\Models\asanaUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncDataAsanaUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:asanaUsers';

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

    function Log($log, $description, $err)
    {
        $activity = activity()
            ->withProperties(['login_ip' => request()->ip(), 'status' => $err])
            ->log($description);
        $activity->log_name = $log; // Set log_name
        $activity->save(); // Simpan aktivitas dengan log_name yang telah ditetapkan
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function getAsanaUser()
    {
        DB::beginTransaction();
        try {
            $asanaUser = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/users');

            if ($asanaUser->successful()) {
                $resultUser = $asanaUser->json();
                foreach ($resultUser['data'] as $data) {
                    $getUser = Http::withHeaders([
                        'Authorization' => env('TOKEN_ASANA'),
                    ])->get('https://app.asana.com/api/1.0/users/' . $data['gid']);
                    $resultGetUser = $getUser->json();

                    $user = asanaUser::firstOrNew(['gid' => $data['gid']]);
                    $user->gid = $resultGetUser['data']['gid'];
                    $user->name = $resultGetUser['data']['name'];
                    $user->email = $resultGetUser['data']['email'];
                    $user->save();
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
        $this->Log('Sync Data', 'Sync Data Asana Users', 'Sync Data Asana Users', '');
        try {
            $this->getAsanaUser();
            $this->Log('Sync Data', 'Sync Data Succesfully', 'Get Data Asana Users', '');
            // break; // Berhenti jika berhasil
        } catch (\Throwable $th) {
            $this->Log('Sync Data', 'Sync Data Asana Users Failed', $th->getMessage(), '');
        }
    }
}
