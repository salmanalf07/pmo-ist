<?php

namespace App\Http\Controllers;

use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\employee;
use App\Models\memberProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class employeeController extends Controller
{
    public function json(Request $request)
    {
        $dataa = employee::with('divisi', 'manager', 'department')->orderBy('created_at', 'DESC');
        $dataa->where('company', '=', 'PT. Infosys Solusi Terpadu');
        if ($request->divisii && $request->divisii != '#') {
            $dataa->where('divisi', '=', $request->divisii);
        }
        if ($request->departmentt && $request->departmentt != '#') {
            $dataa->where('department', '=', $request->departmentt);
        }
        if ($request->directManager && $request->directManager != '#') {
            $dataa->where('direct_manager', '=', $request->directManager);
        }
        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="bi bi-pencil-square"></i></button>
                    <button id="delete" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                    <i class="bi bi-trash"></i></button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    function jsonByAssignment(Request $request)
    {
        $dataa = memberProject::with('project', 'employee.divisi', 'employee.department');
        $dataa->whereHas('employee', function ($q) {
            $q->where('company', '=', 'PT. Infosys Solusi Terpadu');
        });
        // if ($request->dateChange == "true") {
        //     $dataa->whereDate('endDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
        //         ->whereDate('endDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        // }
        if ($request->name != "#" && $request->name) {
            $dataa->where('employee', '=', $request->name);
        }
        if ($request->projectId != "#" && $request->projectId) {
            $dataa->where('projectId', '=', $request->projectId);
        }
        if ($request->availableAt != "01-01-1900" && $request->availableAt) {
            $dataa->where('endDate', '<', date("Y-m-d",  strtotime(str_replace('/', '-', $request->availableAt))));
        } else {

            $dataa->where('endDate', '>=', date("Y-m-d"));
        }
        $data = $dataa->get();
        return DataTables::of($data)
            ->toJson();
    }
    function jsonExtResources(Request $request)
    {
        $dataa = memberProject::with('project.customer', 'employee.divisi');
        if ($request->company != "#" && $request->company) {
            $dataa->whereHas('employee', function ($q) use ($request) {
                $q->where([
                    ['company', '!=', 'PT. Infosys Solusi Terpadu'],
                    ['company', '=', $request->company]
                ]);
            });
        } else {
            $dataa->whereHas('employee', function ($q) {
                $q->where('company', '!=', 'PT. Infosys Solusi Terpadu');
            });
        }

        $data = $dataa->get();
        return DataTables::of($data)
            ->toJson();
    }
    function jsonByUnassigned(Request $request)
    {
        $dataa = employee::whereDoesntHave('memberProject')->with('divisi', 'department', 'manager');
        if ($request->divisii && $request->divisii != '#') {
            $dataa->where('divisi', '=', $request->divisii);
        }
        if ($request->departmentt && $request->departmentt != '#') {
            $dataa->where('department', '=', $request->departmentt);
        }

        $data = $dataa->get();

        return DataTables::of($data)
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);

            $post = new employee();
            $post->employee_id = $request->employee_id;
            $post->name = $request->name;
            $post->level = $request->level;
            $post->divisi = $request->divisi;
            $post->company = $request->company;
            $post->department = $request->department;
            $post->penempatan = $request->penempatan;
            $post->direct_manager = $request->direct_manager;
            $post->role = $request->role;
            $post->spesialisasi = $request->spesialisasi;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = employee::with('divisi')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'employee_id' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);

            $post = employee::find($id);
            $post->employee_id = $request->employee_id;
            $post->name = $request->name;
            $post->level = $request->level;
            $post->divisi = $request->divisi;
            $post->company = $request->company;
            $post->department = $request->department;
            $post->penempatan = $request->penempatan;
            $post->direct_manager = $request->direct_manager;
            $post->role = $request->role;
            $post->spesialisasi = $request->spesialisasi;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = employee::find($id);
        $post->delete();

        return response()->json($post);
    }

    public function getSheetsData(Request $request)
    {
        $data = Sheets::spreadsheet(env('GOOGLE_SHEET_ID'))
            ->sheet('Employee') // Ganti 'Sheet1' dengan rentang yang benar
            ->all();

        //return response()->json($data);
        return view('sheets', compact('data'));
    }
}
