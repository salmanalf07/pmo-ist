<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\scopeProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class timelineController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = scopeProject::where('projectId', $id)->orderByRaw('CONVERT(noRef, SIGNED) asc')->get();
        $overAllProg = Project::with('customer')->find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/projectTimeline', ['id' => $id, 'header' => $overAllProg->customer->company . ' - ' . $overAllProg->noContract . ' - ' . $overAllProg->projectName,  'aksi' => $aksi, 'data' => $get, 'overAllProg' => $overAllProg]);
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
            $remaks = array_filter($request->remaks, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

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
