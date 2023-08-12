<?php

namespace App\Http\Controllers;

use App\Models\documentationProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class DocProjectController extends Controller
{
    public function json($id)
    {
        $data = documentationProject::with('user', 'document')
            ->where([
                ['projectId', $id],
                ['type', '!=', "SOW"],
            ])->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
            ->addColumn('namaFile', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                    <div class="icon-shape icon-lg rounded-3 bg-primary-soft">
                        <a href="#!">
                            <i class="bi bi-file-earmark-spreadsheet icon-lg text-primary"></i>
                        </a>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">' . $data->nameFile . '</h5>
                    </div>
                    </div>';
            })
            ->addColumn('linkFile', function ($data) {
                return '<a target="_blank" href="' . $data->link . '" class="btn btn-ghost btn-icon btn-sm rounded-circle ms-3 texttooltip" data-template="six">
                            <i class="bi bi-link-45deg icon-lg"></i>
                        </a>';
            })
            ->addColumn('aksi', function ($data) {
                return auth()->user()->can('bisa-hapus') ?
                    ' <span class="dropdown dropstart">
                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#!" id="DropdownOne" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <span class="dropdown-menu" aria-labelledby="DropdownOne">' .
                    '<button id="edit" data-id="' . $data->id . '" class="dropdown-item d-flex align-items-center">Edit</button>' .
                    '<button id="delete" data-id="' . $data->id . '" class="dropdown-item d-flex align-items-center">Delete</button>'
                    . '</span>
                    </span>' : "";
            })
            ->rawColumns(['namaFile', 'linkFile', 'aksi'])
            ->toJson();
    }

    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                'type' => ['required', 'string', 'max:255'],
                'link' => ['required', 'string', 'max:255'],
            ]);

            $post = new documentationProject();
            $post->projectId = $id;
            $post->type = $request->type;
            $post->link = $request->link;
            $post->userId = Auth::user()->id;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function edit(Request $request, $id)
    {
        $get = documentationProject::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'type' => ['required', 'string', 'max:255'],
                'link' => ['required', 'string', 'max:255'],
            ]);

            $post = documentationProject::find($id);
            $post->nameFile = "-";
            $post->type = $request->type;
            $post->link = $request->link;
            $post->userId = Auth::user()->id;
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
        $post = documentationProject::find($id);
        $post->delete();

        return response()->json($post);
    }
}
