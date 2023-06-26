<?php

namespace App\Http\Controllers;

use App\Models\inScope;
use App\Models\outScope;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class sowController extends Controller
{
    public function edit(Request $request, $id)
    {
        $getInScope = inScope::where('projectId', $id)->orderBy('created_at')->get();
        $getOutScope = outScope::where('projectId', $id)->orderBy('created_at')->get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($getInScope) {
            $aksiInScope = 'EditData';
        } else {
            $aksiInScope = 'Add';
        }
        if ($getOutScope) {
            $aksiOutScope = 'EditData';
        } else {
            $aksiOutScope = 'Add';
        }
        return view('project/Sow', ['id' => $id, 'aksiInScope' => $aksiInScope, 'aksiOutScope' => $aksiOutScope, 'dataInScope' => $getInScope, 'dataOutScope' => $getOutScope]);
        //return $getOutScope;
    }

    public function store(Request $request, $id)
    {
        try {
            //start Risk
            $idInScope = $request->idInScope;
            $inScope = collect($request->inScope)->filter()->all();



            for ($count = 0; $count < count($inScope); $count++) {
                $postt = inScope::findOrNew($idInScope[$count]);
                $postt->ProjectId = $id;
                $postt->inScope = $inScope[$count];

                $postt->save();
            }
            //end Risk
            //start issues
            $idOutScope = $request->idOutScope;
            $outOfScope = collect($request->outOfScope)->filter()->all();



            for ($count = 0; $count < count($outOfScope); $count++) {
                $postt = outScope::findOrNew($idOutScope[$count]);
                $postt->ProjectId = $id;
                $postt->outOfScope = $outOfScope[$count];

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
        if ($table == "InScope") {
            $post = inScope::find($id);
        }
        if ($table == "OutScope") {
            $post = outScope::find($id);
        }
        $post->delete();

        return response()->json($post);
    }
}
