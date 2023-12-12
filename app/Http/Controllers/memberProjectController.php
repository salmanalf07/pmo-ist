<?php

namespace App\Http\Controllers;

use App\Models\division;
use App\Models\employee;
use App\Models\memberProject;
use App\Models\partnerProject;
use App\Models\Project;
use App\Models\roleEmployee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class memberProjectController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = memberProject::with('employees.divisis', 'roles')->where('projectId', $id)->orderBy('created_at')->get();
        $partner = partnerProject::with('roles')->where('projectId', $id)->orderBy('created_at')->get();
        $employee = employee::get();
        $divisi = division::get();
        $role = roleEmployee::get();
        $value = Project::with('customer')->find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($request->segment(2) == "changeProjMember") {
            if ($get) {
                $aksi = 'EditData';
            } else {
                $aksi = 'Add';
            }
            return view('project/projectMember', ['judul' => "Project", 'divisi' => $divisi, 'id' => $id, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName, "employee" => $employee, 'aksi' => $aksi, 'data' => $get, 'partner' => $partner, 'role' => $role, 'roleMember' => $role]);
        }
        if ($request->segment(2) == "json_projectMember") {
            $dataTable1 = DataTables::of($get)->toJson();
            $dataTable2 = DataTables::of($partner)->toJson();

            $response = array(
                'dataTable1' => $dataTable1,
                'dataTable2' => $dataTable2,
                // Tambahkan data lain jika diperlukan
            );

            return json_encode($response);
        }
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {

            $idMember = $request->idMember;
            $employee = collect($request->employee)->filter()->all();
            $role = collect($request->role)->filter()->all();
            $accesType = collect($request->accesType)->filter()->all();
            $startDate = collect($request->startDate)->filter()->all();
            $endDate = collect($request->endDate)->filter()->all();
            $planMandays = array_map(function ($value) {
                return $value !== null ? $value : 0;
            }, $request->planMandays);


            for ($count = 0; $count < count($employee); $count++) {
                if ($employee[$count] != "#") {
                    $postt = memberProject::findOrNew($idMember[$count]);
                    $postt->ProjectId = $id;
                    $postt->employee = $employee[$count];
                    $postt->role = $role[$count];
                    $postt->accesType = $accesType[$count];
                    $postt->startDate = date("Y-m-d", strtotime(str_replace('-', '-', $startDate[$count])));
                    $postt->endDate = date("Y-m-d", strtotime(str_replace('-', '-', $endDate[$count])));
                    $postt->planMandays = $planMandays[$count];

                    $postt->save();
                }
            }

            $idPartner = $request->idPartner;
            $partner = collect($request->partner)->filter()->all();
            $rolePartner = collect($request->rolePartner)->filter()->all();
            $accesPartner = collect($request->accesPartner)->filter()->all();
            $partnerCorp = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->partnerCorp);;
            $stdatePartner = collect($request->stdatePartner)->filter()->all();
            $eddatePartner = collect($request->eddatePartner)->filter()->all();
            $planManPartner = array_map(function ($value) {
                return $value !== null ? $value : 0;
            }, $request->planManPartner);


            for ($count = 0; $count < count($partner); $count++) {
                if ($partner[$count] != "#") {
                    $postt = partnerProject::findOrNew($idPartner[$count]);
                    $postt->ProjectId = $id;
                    $postt->partner = $partner[$count];
                    $postt->rolePartner = $rolePartner[$count];
                    $postt->accesPartner = $accesPartner[$count];
                    $postt->partnerCorp = $partnerCorp[$count];
                    $postt->stdatePartner = date("Y-m-d", strtotime(str_replace('-', '-', $stdatePartner[$count])));
                    $postt->eddatePartner = date("Y-m-d", strtotime(str_replace('-', '-', $eddatePartner[$count])));
                    $postt->planManPartner = $planManPartner[$count];


                    $postt->save();
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
        $post = memberProject::find($id);
        $post->delete();

        return response()->json($post);
    }

    public function destroyPartner($id)
    {
        $post = partnerProject::find($id);
        $post->delete();

        return response()->json($post);
    }

    function autoSave(Request $request, $id)
    {
        if ($request->type == "employee") {
            $postt = memberProject::with('employees.divisis')->findOrNew($request->idMember);
            $postt->ProjectId = $id;
            $postt->employee = $request->employee;
            $postt->role = $request->role;
            $postt->accesType = $request->accesType;
            $postt->startDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->startDate)));
            $postt->endDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->endDate)));
            $postt->planMandays = $request->planMandays == null ? 0 : $request->planMandays;

            $postt->save();

            return response()->json(['idMember' => $postt->id, 'division' => $postt->employees->divisi == "#" ? null : $postt->employees->divisis->division]);
        } else if ($request->type == "partner") {
            $postt = partnerProject::findOrNew($request->idPartner);
            $postt->ProjectId = $id;
            $postt->partner = $request->partner;
            $postt->rolePartner = $request->rolePartner;
            $postt->accesPartner = $request->accesPartner;
            $postt->partnerCorp = $request->partnerCorp;
            $postt->stdatePartner = date("Y-m-d", strtotime(str_replace('-', '-', $request->stdatePartner)));
            $postt->eddatePartner = date("Y-m-d", strtotime(str_replace('-', '-', $request->eddatePartner)));
            $postt->planManPartner = $request->planManPartner == null ? 0 : $request->planManPartner;
            $postt->save();

            return response()->json(['message' => "succes", 'idPartner' => $postt->id]);
        }
    }
}
