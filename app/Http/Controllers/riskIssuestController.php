<?php

namespace App\Http\Controllers;

use App\Models\issuesProject;
use App\Models\riskProject;
use Illuminate\Http\Request;

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
        return view('project/scopeHighLevel', ['id' => $id, 'aksiRisk' => $aksiRisk, 'aksiIssues' => $aksiIssues, 'dataRisk' => $getRisk, 'dataIssues' => $getIssues]);
        //return $get;
    }
}
