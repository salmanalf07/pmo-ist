<?php

namespace App\Http\Controllers;

use App\Models\scopeProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class scopeProjectController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = scopeProject::where('projectId', $id)->get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/scopeHighLevel', ['id' => $id, 'aksi' => $aksi, 'data' => $get]);
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
                $postt->progProject = $progProject[$count];

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
