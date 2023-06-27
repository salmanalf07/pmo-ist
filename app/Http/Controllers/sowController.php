<?php

namespace App\Http\Controllers;

use App\Models\documentationProject;
use App\Models\inScope;
use App\Models\outScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class sowController extends Controller
{
    public function edit(Request $request, $id)
    {
        $getInScope = inScope::where('projectId', $id)->orderBy('created_at')->get();
        $getOutScope = outScope::where('projectId', $id)->orderBy('created_at')->get();
        $file = documentationProject::where('projectId', $id)->where('type', 'SOW')->first();
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
        if ($file) {
            $aksiFile = 'EditData';
        } else {
            $aksiFile = 'Add';
        }
        return view('project/Sow', ['id' => $id, 'aksiInScope' => $aksiInScope, 'aksiOutScope' => $aksiOutScope, 'dataInScope' => $getInScope, 'dataOutScope' => $getOutScope, 'aksiFile' => $aksiFile, 'file' => $file]);
        //return $getOutScope;
    }

    public function store(Request $request, $id)
    {
        try {
            //start Risk
            $idInScope = $request->idInScope;
            $inScope = collect($request->inScope)->filter()->all();
            $remaksIn = collect($request->remaksIn)->filter()->all();


            for ($count = 0; $count < count($inScope); $count++) {
                $postt = inScope::findOrNew($idInScope[$count]);
                $postt->ProjectId = $id;
                $postt->inScope = $inScope[$count];
                $postt->remaks = $remaksIn[$count];

                $postt->save();
            }
            //end Risk
            //start issues
            $idOutScope = $request->idOutScope;
            $outOfScope = collect($request->outOfScope)->filter()->all();
            $remaksOut = collect($request->remaksOut)->filter()->all();

            for ($count = 0; $count < count($outOfScope); $count++) {
                $postt = outScope::findOrNew($idOutScope[$count]);
                $postt->ProjectId = $id;
                $postt->outOfScope = $outOfScope[$count];
                $postt->remaks = $remaksOut[$count];

                $postt->save();
            }
            //documentation
            $file = documentationProject::findOrNew($request->idFile);
            $file->ProjectId = $id;
            $file->nameFile = $request->nameFile;
            $file->type = "SOW";
            $file->link = $request->link;
            $file->userId = Auth::user()->id;
            $file->save();


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
