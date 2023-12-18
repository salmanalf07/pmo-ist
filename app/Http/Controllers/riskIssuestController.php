<?php

namespace App\Http\Controllers;

use App\Models\issuesProject;
use App\Models\Project;
use App\Models\riskProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class riskIssuestController extends Controller
{
    public function edit(Request $request, $id)
    {
        $getRisk = riskProject::where('projectId', $id)->orderBy('created_at')->get();
        $getIssues = issuesProject::where('projectId', $id)->orderBy('created_at')->get();
        $value = Project::with('customer')->find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data

        if ($request->segment(2) == "changeriskIssues") {
            if ($getRisk) {
                $aksiRisk = 'EditData';
            } else {
                $aksiRisk = 'Add';
            }
            if ($getIssues) {
                $aksiIssues = 'EditData';
            } else {
                $aksiIssues = 'Add';
            }
            return view('project/riskIssues', ['id' => $id, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName, 'aksiRisk' => $aksiRisk, 'aksiIssues' => $aksiIssues, 'dataRisk' => $getRisk, 'dataIssues' => $getIssues]);
        }
        if ($request->segment(2) == "json_riskIssues") {
            $dataTable1 = DataTables::of($getRisk)->toJson();
            $dataTable2 = DataTables::of($getIssues)->toJson();

            $response = array(
                'dataTable1' => $dataTable1,
                'dataTable2' => $dataTable2,
                // Tambahkan data lain jika diperlukan
            );

            return json_encode($response);
        }
        //return $getIssues;
    }

    public function store(Request $request, $id)
    {
        try {
            //start Risk
            $idRisk = $request->idRisk;
            $riskDesc = collect($request->riskDesc)->filter()->all();
            $trigerEvent = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->trigerEvent);
            $riskResponse = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->riskResponse);
            $contiPlan = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->contiPlan);
            $riskOwner = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->riskOwner);
            $statRisk = collect($request->statRisk)->filter()->all();



            for ($count = 0; $count < count($riskDesc); $count++) {
                $postt = riskProject::findOrNew($idRisk[$count]);
                $postt->ProjectId = $id;
                $postt->riskDesc = $riskDesc[$count];
                $postt->trigerEvent = $trigerEvent[$count];
                $postt->riskResponse = $riskResponse[$count];
                $postt->contiPlan = $contiPlan[$count];
                $postt->riskOwner = $riskOwner[$count];
                $postt->statRisk = $statRisk[$count];


                $postt->save();
            }
            //end Risk
            //start issues
            $idIssues = $request->idIssues;
            $issuesDesc = collect($request->issuesDesc)->filter()->all();
            $projectImpact = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->projectImpact);
            $actionPlan = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->actionPlan);
            $issuesOwner = collect($request->issuesOwner)->filter()->all();
            $resolvedDate = collect($request->resolvedDate)->filter()->all();
            $statIssues = collect($request->statIssues)->filter()->all();



            for ($count = 0; $count < count($issuesDesc); $count++) {
                $postt = issuesProject::findOrNew($idIssues[$count]);
                $postt->ProjectId = $id;
                $postt->issuesDesc = $issuesDesc[$count];
                $postt->projectImpact = $projectImpact[$count];
                $postt->actionPlan = $actionPlan[$count];
                $postt->issuesOwner = $issuesOwner[$count];
                $postt->resolvedDate = date("Y-m-d", strtotime(str_replace('-', '-', $resolvedDate[$count])));
                $postt->statIssues = $statIssues[$count];


                $postt->save();
            }
            //end Risk
            $data = [$id];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function destroy($table, $id)
    {
        if ($table == "risk") {
            $post = riskProject::find($id);
        }
        if ($table == "issues") {
            $post = issuesProject::find($id);
        }
        $post->delete();

        return response()->json($post);
    }
}
