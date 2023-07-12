<?php

namespace App\Http\Controllers;

use App\Models\bonusProject;
use App\Models\Project;
use App\Models\scopeProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class projBonus extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = bonusProject::where('projectId', '=', $id)->first();
        $overAllProg = Project::with('customer')->find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/projectBonus', ['id' => $id, 'header' => $overAllProg->customer->company . ' - ' . $overAllProg->noContract . ' - ' . $overAllProg->projectName,  'aksi' => $aksi, 'data' => $get]);
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {
            $data = bonusProject::findOrNew($request->idBonus);
            $data->projectId = $id;
            $data->status = $request->status;
            $data->Subdate = date("Y-m-d", strtotime(str_replace('-', '-', $request->SubDate)));
            $data->status = $request->status;
            $data->pic = $request->pic;
            $data->save();
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function destroy($id)
    {
        $post = bonusProject::find($id);
        $post->delete();

        return response()->json($post);
    }
}
