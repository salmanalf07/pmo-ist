<?php

namespace App\Console\Commands;

use App\Models\asanaDetailTask;
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

                                    $getDetailTask = Http::withHeaders([
                                        'Authorization' => env('TOKEN_ASANA'),
                                    ])->get('https://app.asana.com/api/1.0/tasks/' . $task['gid']);

                                    if ($getDetailTask->successful()) {
                                        $dataDetailTask = $getDetailTask->json();
                                        $refDetailTask = 1;
                                        // foreach ($dataDetailTask['data'] as $detailTask) {
                                        $saveDetailTask = asanaDetailTask::firstOrNew(['gid' => $dataDetailTask['data']['gid']]);
                                        $saveDetailTask->gid = $dataDetailTask['data']['gid'];
                                        $saveDetailTask->ref = $refDetailTask;
                                        $saveDetailTask->task_id = $saveTask->id;
                                        $saveDetailTask->assignee = $dataDetailTask['data']['assignee']['name'] ?? null;
                                        $saveDetailTask->start_on = $dataDetailTask['data']['start_on'];
                                        $saveDetailTask->due_on = $dataDetailTask['data']['due_on'];
                                        $saveDetailTask->permalink_url = $dataDetailTask['data']['permalink_url'];
                                        $saveDetailTask->progress = $dataDetailTask['data']['custom_fields'][1]['number_value'] ?? 0;
                                        $saveDetailTask->status = $dataDetailTask['data']['completed'];
                                        $saveDetailTask->save();
                                        // }
                                    }
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
