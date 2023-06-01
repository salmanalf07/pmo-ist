<?php

namespace App\Http\Controllers;

use App\Models\topProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class topProjectController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = topProject::where('projectId', $id)->get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/top', ['id' => $id, 'aksi' => $aksi, 'data' => $get]);
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {

            $idtop = collect($request->idtop)->filter()->all();
            $termsName = collect($request->termsName)->filter()->all();
            $termsValue = collect($request->termsValue)->filter()->all();
            $bastDate = collect($request->bastDate)->filter()->all();
            $invDate = collect($request->invDate)->filter()->all();
            $payDate = collect($request->payDate)->filter()->all();


            for ($count = 0; $count < count($termsName); $count++) {
                if (count($idtop)) {
                    $postt = topProject::find($idtop[$count]);
                } else {
                    $postt = new topProject();
                }
                $postt->ProjectId = $id;
                $postt->termsName = $termsName[$count];
                $postt->termsValue = str_replace(".", "", $termsValue[$count]);
                $postt->bastDate = date("Y-m-d", strtotime(str_replace('-', '-', $bastDate[$count])));
                $postt->invDate = date("Y-m-d", strtotime(str_replace('-', '-', $invDate[$count])));
                $postt->payDate = date("Y-m-d", strtotime(str_replace('-', '-', $payDate[$count])));

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
