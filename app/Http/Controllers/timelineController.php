<?php

namespace App\Http\Controllers;

use App\Models\documentationProject;
use App\Models\Project;
use App\Models\scopeProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class timelineController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = scopeProject::where('projectId', $id)->orderByRaw('CONVERT(noRef, SIGNED) asc')->get();
        $file = documentationProject::where('projectId', $id)->where('type', 'TIMELINE')->get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($request->segment(2) == "changeprojectTimeline") {
            $dataa = Project::with('customer')->where('id', $id);
            if (Auth::user()->hasRole('PM')) {
                $dataa->where(function ($query) {
                    $query->where('pmName', Auth::user()->name)
                        ->orWhere('coPm', Auth::user()->name);
                });
            }
            $overAllProg = $dataa->first();
            if (!$overAllProg) {
                return view('/error', ['exception' => 'Project Not Allowed Access']);
            }
            if ($get) {
                $aksi = 'EditData';
            } else {
                $aksi = 'Add';
            }
            if ($file) {
                $aksiFile = 'EditData';
            } else {
                $aksiFile = 'Add';
            }
            return view('project/projectTimeline', ['id' => $id, 'header' => $overAllProg->customer->company . ' - ' . $overAllProg->noContract . ' - ' . $overAllProg->projectName,  'aksi' => $aksi, 'data' => $get, 'overAllProg' => $overAllProg, 'aksiFile' => $aksiFile, 'file' => $file]);
        }
        if ($request->segment(2) == "json_projectTimeline") {
            $dataTable1 = DataTables::of($get)->toJson();

            $response = array(
                'dataTable1' => $dataTable1,
                // Tambahkan data lain jika diperlukan
            );

            return json_encode($response);
        }
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {

            $idScope = $request->idScope;
            $scope = collect($request->scope)->filter()->all();
            $planStart = collect($request->planStart)->filter()->all();
            $planEnd = collect($request->planEnd)->filter()->all();
            $actStart = collect($request->actStart)->filter()->all();
            $actEnd = collect($request->actEnd)->filter()->all();
            $progProject = array_filter($request->progProject, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $remaks = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->remaks);

            $post = Project::find($id);
            $post->overAllProg = str_replace("%", "", $request->overAllProg);
            $post->save();

            for ($count = 0; $count < count($scope); $count++) {
                $postt = scopeProject::findOrNew($idScope[$count]);
                $postt->ProjectId = $id;
                $postt->noRef = $count + 1;
                $postt->scope = $scope[$count];
                $postt->planStart = date("Y-m-d", strtotime(str_replace('-', '-', $planStart[$count])));
                $postt->planEnd = date("Y-m-d", strtotime(str_replace('-', '-', $planEnd[$count])));
                $postt->actStart = date("Y-m-d", strtotime(str_replace('-', '-', $actStart[$count])));
                $postt->actEnd = date("Y-m-d", strtotime(str_replace('-', '-', $actEnd[$count])));
                $postt->progProject = str_replace("%", "", $progProject[$count]);
                $postt->remaks = $remaks[$count];

                $postt->save();
            }
            //documentation

            for ($fileTimeline = 0; $fileTimeline < count($request->nameFile); $fileTimeline++) {
                if ($request->idFile[$fileTimeline] != '#' || $request->nameFile[$fileTimeline] != null) {
                    $file = documentationProject::findOrNew($request->idFile[$fileTimeline]);
                    $file->ProjectId = $id;
                    $file->nameFile = $request->nameFile[$fileTimeline];
                    $file->type = "TIMELINE";
                    $file->link = $request->link[$fileTimeline];
                    $file->userId = Auth::user()->id;
                    $file->save();
                }
            }

            $data = [$id];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function destroy($id)
    {
        $post = scopeProject::find($id);
        $post->delete();

        return response()->json($post);
    }
}
