<?php

namespace App\Http\Controllers;

use App\Models\highAndNote;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class highAndNotesController extends Controller
{
    public function json()
    {
        $data = highAndNote::with('users')->orderBy('created_at', 'DESC');

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
                'highAndNote' => ['required', 'string'],
            ]);

            $post = new highAndNote();
            $post->projectId = $request->projectId;
            $post->highAndNote = $request->highAndNote;
            $post->user = auth()->user()->id;
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
        $get = highAndNote::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'highAndNote' => ['required', 'string'],
            ]);

            $post = highAndNote::find($id);
            $post->projectId = $request->projectId;
            $post->highAndNote = $request->highAndNote;
            $post->user = auth()->user()->id;
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
        $post = highAndNote::find($id);
        $post->delete();

        return response()->json($post);
    }
}
