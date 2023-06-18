<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\employee;
use App\Models\pipeline;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class pipelineController extends Controller
{
    public function index()
    {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        $new = pipeline::with('customer', 'employee')->where('status', 'new')->get();
        $inProgress = pipeline::with('customer', 'employee')->where('status', 'inProgress')->get();
        $submitted = pipeline::with('customer', 'employee')->where('status', 'submitted')->get();
        $done = pipeline::with('customer', 'employee')->where('status', 'done')->get();
        return view('pipeline/pipeline', ['judul' => "Pipeline", 'customer' => $customer, 'employee' => $employee, 'new' => $new, 'inProgress' => $inProgress, 'submitted' => $submitted, 'done' => $done]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'projectName' => ['required', 'string', 'max:255'],
            ]);

            $post = pipeline::findOrNew($request->id);
            $post->projectName = $request->projectName;
            $post->customerId = $request->customerId;
            $post->description = $request->description;
            $post->value = str_replace(".", "", $request->value);
            $post->dueDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->dueDate)));
            $post->status = $request->status;
            $post->priority = $request->priority;
            $post->asignTo = $request->asignTo;
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
        $get = pipeline::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function destroy($id)
    {
        $post = pipeline::find($id);
        $post->delete();

        return response()->json($post);
    }
}
