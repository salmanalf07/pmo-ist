<?php

namespace App\Http\Controllers;

use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class employeeController extends Controller
{
    public function json()
    {
        $data = employee::orderBy('created_at', 'DESC');

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
        $get = employee::find($request->id);
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
