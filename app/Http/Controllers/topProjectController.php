<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\topProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class topProjectController extends Controller
{
    public function json(Request $request)
    {
        $dataa = topProject::with('project', 'project.customer')->orderBy('created_at', 'DESC');

        if ($request->date_st != "#" && $request->date_st) {
            $dataa->whereDate('bastDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('bastDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        }

        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('projectNamee', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-0 fs-5"><a href="/project/top/' . $data->project['id'] . '" class="text-inherit">' . substr($data->project['projectName'], 0, 30) . '</a></h4>
                        </div>
                    </div>';
            })
            ->rawColumns(['projectNamee'])
            ->toJson();
    }
    public function edit(Request $request, $id)
    {
        $get = topProject::where('projectId', $id)->orderBy('created_at')->get();
        $value = Project::find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/top', ['id' => $id, 'aksi' => $aksi, 'data' => $get, 'projectValue' => $value->projectValue]);
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {

            $idtop = $request->idtop;
            $termsName = collect($request->termsName)->filter()->all();
            $termsValue = collect($request->termsValue)->filter()->all();
            $bastDate = collect($request->bastDate)->filter()->all();
            $invDate = collect($request->invDate)->filter()->all();
            $payDate = collect($request->payDate)->filter()->all();
            $remaks = collect($request->remaks)->filter()->all();


            for ($count = 0; $count < count($termsName); $count++) {
                $postt = topProject::findOrNew($idtop[$count]);
                $postt->ProjectId = $id;
                $postt->termsName = $termsName[$count];
                $postt->termsValue = str_replace(".", "", $termsValue[$count]);
                $postt->bastDate = date("Y-m-d", strtotime(str_replace('-', '-', $bastDate[$count])));
                $postt->invDate = date("Y-m-d", strtotime(str_replace('-', '-', $invDate[$count])));
                $postt->payDate = date("Y-m-d", strtotime(str_replace('-', '-', $payDate[$count])));
                $postt->remaks = $remaks[$count];

                $postt->save();
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
        $post = topProject::find($id);
        $post->delete();

        return response()->json($post);
    }
}
