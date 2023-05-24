<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class customerController extends Controller
{
    public function json()
    {
        $data = Customer::orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-primary">Edit</button>
                    <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'radio' => ['required', 'string', 'max:255'],
                'company' => ['required', 'string', 'max:255'],
                'industry' => ['required', 'string', 'max:255'],
            ]);

            $post = new Customer();
            $post->type = $request->radio;
            $post->company = $request->company;
            $post->addres = $request->addres;
            $post->city = $request->city;
            $post->npwp = $request->npwp;
            $post->pic = $request->pic;
            $post->telppic = $request->telppic;
            $post->industry = $request->industry;
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
        $get = Customer::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'radio' => ['required', 'string', 'max:255'],
                'company' => ['required', 'string', 'max:255'],
                'industry' => ['required', 'string', 'max:255'],
            ]);

            $post = Customer::find($id);
            $post->type = $request->radio;
            $post->company = $request->company;
            $post->addres = $request->addres;
            $post->city = $request->city;
            $post->npwp = $request->npwp;
            $post->pic = $request->pic;
            $post->telppic = $request->telppic;
            $post->industry = $request->industry;
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
        $post = Customer::find($id);
        $post->delete();

        return response()->json($post);
    }
}
