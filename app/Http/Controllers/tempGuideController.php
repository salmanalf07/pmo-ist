<?php

namespace App\Http\Controllers;

use App\Models\tempAndGuide;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class tempGuideController extends Controller
{
    public function json()
    {
        $data = tempAndGuide::with('categorys', 'types')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
            ->addColumn('linkFile', function ($data) {
                return '<a target="_blank" href="' . $data->link . '" class="btn btn-ghost btn-icon btn-sm rounded-circle ms-3 texttooltip" data-template="six">
                    <i class="bi bi-link-45deg icon-lg"></i>
                </a>';
            })
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                <i class="bi bi-pencil-square"></i></button>
                <button id="delete" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                <i class="bi bi-trash"></i></button>';
            })
            ->rawColumns(['aksi', 'linkFile'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'categoryId' => ['required', 'string', 'max:255', 'not_equal_to:#'],
                'typeId' => ['required', 'string', 'max:255', 'not_equal_to:#'],
                'documentName' => ['required', 'string', 'max:255'],
                'link' => ['required', 'string', 'max:255'],
            ]);

            $post = new tempAndGuide();
            $post->categoryId = $request->categoryId;
            $post->typeId = $request->typeId;
            $post->documentName = $request->documentName;
            $post->link = $request->link;
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
        $get = tempAndGuide::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'categoryId' => ['required', 'string', 'max:255'],
                'typeId' => ['required', 'string', 'max:255'],
                'documentName' => ['required', 'string', 'max:255'],
                'link' => ['required', 'string', 'max:255'],
            ]);

            $post = tempAndGuide::find($id);
            $post->categoryId = $request->categoryId;
            $post->typeId = $request->typeId;
            $post->documentName = $request->documentName;
            $post->link = $request->link;
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
        $post = tempAndGuide::find($id);
        $post->delete();

        return response()->json($post);
    }
}
