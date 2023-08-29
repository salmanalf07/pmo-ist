<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class userController extends Controller
{
    public function json()
    {
        $data = User::with("roles")->get();

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
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'digits:8'],
                'role.*' => ['required', 'string'],
            ]);

            $post = new User();
            $post->name = $request->name;
            $post->username = $request->username;
            $post->password = Hash::make($request->password);
            $post->status = "ACTIV";

            $post->save();

            $user = User::find($post->id);
            // Ambil peran-peran dari input role[]
            $selectedRoles = $request->input('role', []);
            // Sync peran-peran baru ke pengguna
            $user->syncRoles($selectedRoles);


            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = User::with("roles")->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'username' => ['required', 'string', 'max:255'],
                'role.*' => ['required', 'string'],
            ]);

            $post = User::find($id);
            $post->name = $request->name;
            $post->username = $request->username;
            if ($request->password != null && $post->password != Hash::make($request->password)) {
                $post->password = Hash::make($request->password);
            }
            $post->status = "ACTIV";

            $post->save();
            // Ambil peran-peran dari input role[]
            $selectedRoles = $request->input('role', []);
            // Sync peran-peran baru ke pengguna
            $post->syncRoles($selectedRoles);

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = User::find($id);
        $post->delete();

        return response()->json($post);
    }
}
