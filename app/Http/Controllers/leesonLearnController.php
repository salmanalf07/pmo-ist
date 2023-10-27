<?php

namespace App\Http\Controllers;

use App\Models\lessonLearned;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class leesonLearnController extends Controller
{
    public function json()
    {
        $data = lessonLearned::with('pmNames', 'statuss')->orderBy('created_at', 'DESC');

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
                'pmName' => ['required', 'string', 'max:255', 'not_equal_to:#'],
                'leesonLearned' => ['string', 'max:255'],
                'uploadDate' => ['string', 'max:255'],
                'status' => ['required', 'string', 'max:255', 'not_equal_to:#'],
            ]);

            $post = new lessonLearned();
            $post->pmName = $request->pmName;
            $post->uploadDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->uploadDate)));
            $post->leesonLearned = $request->leesonLearned;
            $post->status = $request->status;
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
        $get = lessonLearned::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'pmName' => ['required', 'string', 'max:255', 'not_equal_to:#'],
                'leesonLearned' => ['string', 'max:255'],
                'uploadDate' => ['string', 'max:255'],
                'status' => ['required', 'string', 'max:255', 'not_equal_to:#'],
            ]);

            $post = lessonLearned::find($id);
            $post->pmName = $request->pmName;
            $post->uploadDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->uploadDate)));
            $post->leesonLearned = $request->leesonLearned;
            $post->status = $request->status;
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
        $post = lessonLearned::find($id);
        $post->delete();

        return response()->json($post);
    }
}
