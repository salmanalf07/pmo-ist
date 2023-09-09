<?php

namespace App\Http\Controllers;

use App\Models\bonusProject;
use App\Models\Project;
use App\Models\projectCosting;
use App\Models\scopeProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class projBonus extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = bonusProject::where('projectId', '=', $id)->first();
        $costing = projectCosting::where('projectId', '=', $id)->get();
        $overAllProg = Project::with('customer')->find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get || $costing) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/projectCosting', ['id' => $id, 'header' => $overAllProg->customer->company . ' - ' . $overAllProg->noContract . ' - ' . $overAllProg->projectName,  'aksi' => $aksi, 'data' => $get, 'costing' => $costing]);
        //return $get;
    }

    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $idCosting = $request->idCosting;
            $description = collect($request->description)->filter()->all();
            $orderDate = array_filter($request->orderDate, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $poNumber = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->poNumber);
            $picCosting = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->picCosting);
            $amount = array_map(function ($value) {
                return $value !== null ? $value : 0;
            }, $request->amount);

            for ($count = 0; $count < count($description); $count++) {
                $projCosting = projectCosting::findOrNew($idCosting[$count]);
                $projCosting->projectId = $id;
                $projCosting->description = $description[$count];
                $projCosting->orderDate = date("Y-m-d", strtotime(str_replace('-', '-', $orderDate[$count])));
                $projCosting->poNumber = $poNumber[$count];
                $projCosting->pic = $picCosting[$count];
                $projCosting->amount = str_replace(".", "", $amount[$count]);

                $projCosting->save();
            }
            if ($request->idBonus != null) {
                $data = bonusProject::findOrNew($request->idBonus);
                $data->projectId = $id;
                $data->status = $request->status;
                $data->Subdate = date("Y-m-d", strtotime(str_replace('-', '-', $request->SubDate)));
                $data->status = $request->status;
                $data->pic = $request->pic;
                $data->mandays = $request->mandays;
                $data->valueBonus = str_replace('.', '', $request->valueBonus);
                $data->save();
            }


            DB::commit();
            return response()->json($data);
        } catch (ValidationException $error) {
            DB::rollback();
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

    public function destroy_costing($id)
    {
        $post = projectCosting::find($id);
        $post->delete();

        return response()->json($post);
    }
}
