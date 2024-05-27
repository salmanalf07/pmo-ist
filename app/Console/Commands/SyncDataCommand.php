<?php

namespace App\Console\Commands;

use App\Models\asanaProject;
use App\Models\asanaSection;
use App\Models\asanaTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncDataCommand extends Command
{
    protected $signature = 'sync:data';
    protected $description = 'Sync data from ASANA API';

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
        DB::beginTransaction();
        try {
            $response = Http::withHeaders([
                'Authorization' => env('TOKEN_ASANA'),
            ])->get('https://app.asana.com/api/1.0/projects');

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data['data'] as $project) {

                    $detailProject = Http::withHeaders([
                        'Authorization' => env('TOKEN_ASANA'),
                    ])->get('https://app.asana.com/api/1.0/projects/' . $project['gid']);
                    if ($detailProject->successful()) {
                        $deProject = $detailProject->json();

                        $startDate = $deProject['data']['start_on'];
                        $dueDate = $deProject['data']['due_date'];
                    }
                    $asanaProject = asanaProject::firstOrNew(['gid' => $project['gid']]);
                    $asanaProject->gid = $project['gid'];
                    $asanaProject->projectName = $project['name'];
                    $asanaProject->startDate = $startDate ?? null;
                    $asanaProject->dueDate = $dueDate ?? null;
                    $asanaProject->save();

                    $getSection = Http::withHeaders([
                        'Authorization' => env('TOKEN_ASANA'),
                    ])->get('https://app.asana.com/api/1.0/projects/' . $project['gid'] . '/sections');

                    if ($getSection->successful()) {
                        $dataSection = $getSection->json();
                        $ref = 1;
                        foreach ($dataSection['data'] as $section) {
                            $saveSection = asanaSection::firstOrNew(['gid' => $section['gid']]);
                            $saveSection->ref = $ref++;
                            $saveSection->asana_id = $asanaProject->id;
                            $saveSection->gid = $section['gid'];
                            $saveSection->sectionName = $section['name'];
                            $saveSection->save();

                            $getTask = Http::withHeaders([
                                'Authorization' => env('TOKEN_ASANA'),
                            ])->get('https://app.asana.com/api/1.0/sections/' . $section['gid'] . '/tasks');

                            if ($getTask->successful()) {
                                $dataTask = $getTask->json();
                                $refTask = 1;
                                foreach ($dataTask['data'] as $task) {
                                    $saveTask = asanaTask::firstOrNew(['gid' => $task['gid']]);
                                    $saveTask->ref = $refTask++;
                                    $saveTask->section_id = $saveSection->id;
                                    $saveTask->gid = $task['gid'];
                                    $saveTask->taskName = $task['name'];
                                    $saveTask->save();
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
            $this->Log('Sync Data', 'Sync Data Succesfully', 'Success');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->Log('Sync Data', 'Sync Data Failed', $th->getMessage());
        }
    }
}
