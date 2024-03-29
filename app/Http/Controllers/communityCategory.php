<?php

namespace App\Http\Controllers;

use App\Models\communityCategory as ModelsCommunityCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class communityCategory extends Controller
{
    public function json()
    {
        $data = ModelsCommunityCategory::orderBy('created_at', 'DESC');

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
                'categori' => ['required', 'string', 'max:255'],
            ]);

            $post = new ModelsCommunityCategory();
            $post->categori = $request->categori;
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
        $get = ModelsCommunityCategory::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'categori' => ['required', 'string', 'max:255'],
            ]);

            $post = ModelsCommunityCategory::find($id);
            $post->categori = $request->categori;
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
        $post = ModelsCommunityCategory::find($id);
        $post->delete();

        return response()->json($post);
    }
}
