<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\memberProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class memberProjectController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = memberProject::where('projectId', $id)->get();
        $employee = employee::get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/projectMember', ['judul' => "Project", 'id' => $id, "employee" => $employee, 'aksi' => $aksi, 'data' => $get]);
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {

            $idMember = collect($request->idMember)->filter()->all();
            $employee = collect($request->employee)->filter()->all();
            $role = collect($request->role)->filter()->all();
            $startDate = collect($request->startDate)->filter()->all();
            $endDate = collect($request->endDate)->filter()->all();
            $planMandays = array_filter($request->planMandays, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });


            for ($count = 0; $count < count($employee); $count++) {
                if (count($idMember)) {
                    $postt = memberProject::find($idMember[$count]);
                } else {
                    $postt = new memberProject();
                }
                $postt->ProjectId = $id;
                $postt->employee = $employee[$count];
                $postt->role = $role[$count];
                $postt->startDate = date("Y-m-d", strtotime(str_replace('-', '-', $startDate[$count])));
                $postt->endDate = date("Y-m-d", strtotime(str_replace('-', '-', $endDate[$count])));
                $postt->planMandays = $planMandays[$count];

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
