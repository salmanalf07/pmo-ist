<?php

namespace App\Http\Controllers;

use App\Models\communityType as ModelsCommunityType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class communityType extends Controller
{
    public function json()
    {
        $data = ModelsCommunityType::orderBy('created_at', 'DESC');

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
                'type' => ['required', 'string', 'max:255'],
            ]);

            $post = new ModelsCommunityType();
            $post->type = $request->type;
            $post->keterangan = $request->keterangan;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error", 500];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsCommunityType::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'type' => ['required', 'string', 'max:255'],
            ]);

            $post = ModelsCommunityType::find($id);
            $post->type = $request->type;
            $post->keterangan = $request->keterangan;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error", 500];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = ModelsCommunityType::find($id);
        $post->delete();

        return response()->json($post);
    }
}
