<?php

namespace App\Http\Controllers;

use App\Models\issuesProject;
use App\Models\riskProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class riskIssuestController extends Controller
{
    public function edit(Request $request, $id)
    {
        $getRisk = riskProject::where('projectId', $id)->get();
        $getIssues = issuesProject::where('projectId', $id)->get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
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
        return view('project/riskIssues', ['id' => $id, 'aksiRisk' => $aksiRisk, 'aksiIssues' => $aksiIssues, 'dataRisk' => $getRisk, 'dataIssues' => $getIssues]);
        //return $getIssues;
    }

    public function store(Request $request, $id)
    {
        try {
            //start Risk
            $idRisk = collect($request->idRisk)->filter()->all();
            $riskDesc = collect($request->riskDesc)->filter()->all();
            $trigerEvent = collect($request->trigerEvent)->filter()->all();
            $riskResponse = collect($request->riskResponse)->filter()->all();
            $contiPlan = collect($request->contiPlan)->filter()->all();
            $riskOwner = collect($request->riskOwner)->filter()->all();
            $statRisk = collect($request->statRisk)->filter()->all();



            for ($count = 0; $count < count($riskDesc); $count++) {
                if (count($idRisk)) {
                    $postt = riskProject::find($idRisk[$count]);
                } else {
                    $postt = new riskProject();
                }
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
            $idIssues = collect($request->idIssues)->filter()->all();
            $issuesDesc = collect($request->issuesDesc)->filter()->all();
            $projectImpact = collect($request->projectImpact)->filter()->all();
            $actionPlan = collect($request->actionPlan)->filter()->all();
            $issuesOwner = collect($request->issuesOwner)->filter()->all();
            $resolvedDate = collect($request->resolvedDate)->filter()->all();
            $statIssues = collect($request->statIssues)->filter()->all();



            for ($count = 0; $count < count($issuesDesc); $count++) {
                if (count($idIssues)) {
                    $postt = issuesProject::find($idIssues[$count]);
                } else {
                    $postt = new issuesProject();
                }
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
}
