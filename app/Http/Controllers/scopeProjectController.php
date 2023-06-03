<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\scopeProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class scopeProjectController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = scopeProject::where('projectId', $id)->get();
        $overAllProg = Project::find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/scopeHighLevel', ['id' => $id, 'aksi' => $aksi, 'data' => $get, 'overAllProg' => $overAllProg]);
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {

            $idScope = collect($request->idScope)->filter()->all();
            $scope = collect($request->scope)->filter()->all();
            $planStart = collect($request->planStart)->filter()->all();
            $planEnd = collect($request->planEnd)->filter()->all();
            $progProject = array_filter($request->progProject, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            $post = Project::find($id);
            $post->overAllProg = str_replace("%", "", $request->overAllProg);
            $post->save();

            for ($count = 0; $count < count($scope); $count++) {
                if (count($idScope)) {
                    $postt = scopeProject::find($idScope[$count]);
                } else {
                    $postt = new scopeProject();
                }
                $postt->ProjectId = $id;
                $postt->scope = $scope[$count];
                $postt->planStart = date("Y-m-d", strtotime(str_replace('-', '-', $planStart[$count])));
                $postt->planEnd = date("Y-m-d", strtotime(str_replace('-', '-', $planEnd[$count])));
                $postt->progProject = str_replace("%", "", $progProject[$count]);

                $postt->save();
            }
            $data = [$id];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
}