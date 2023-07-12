<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\Isset_;

class orderController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = Order::with('detailOrder')->where('projectId', $id)->orderByRaw('CONVERT(noRef, SIGNED) asc')->first();
        $value = Project::with('customer')->find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/detailOrder', ['id' => $id, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName, 'aksi' => $aksi, 'data' => $get, 'projectValue' => $value->projectValue]);
    }

    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                'subTotalRev' => ['required', 'string', 'max:255'],
                'subTotalCogs' => ['required', 'string', 'max:255'],
                'totalGpp' => ['required', 'string', 'max:255'],
            ]);

            if ($request->id) {
                $post = Order::find($request->id);
            } else {
                $post = new Order();
            }
            $post->projectId = $id;
            $post->subTotalRev = str_replace(".", "", $request->subTotalRev);
            $post->subTotalCogs = str_replace(".", "", $request->subTotalCogs);
            $post->subTotalGp = str_replace(".", "", $request->subTotalGp);
            $post->totalGpp = str_replace("%", "", $request->totalGpp);
            $post->save();

            $idor = $request->idor;
            $item = collect($request->item)->filter()->all();
            $qty = array_map(function ($value) {
                return $value !== null ? $value : 0;
            }, $request->qty);
            $unit = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->unit);
            $rev = array_map(function ($value) {
                return $value !== null ? $value : 0;
            }, $request->rev);
            $cogs = array_map(function ($value) {
                return $value !== null ? $value : 0;
            }, $request->cogs);
            $gp = array_map(function ($value) {
                return $value !== "NaN%" ? $value : 100;
            }, $request->gp);


            for ($count = 0; $count < count($item); $count++) {
                $postt = DetailOrder::findOrNew($idor[$count]);
                $postt->orderId = $post->id;
                $postt->noRef = $count + 1;
                $postt->item = $item[$count];
                $postt->qty = $qty[$count];
                $postt->unit = $unit[$count];
                $postt->rev = str_replace(".", "", $rev[$count]);
                $postt->cogs = str_replace(".", "", $cogs[$count]);
                $postt->gp = str_replace("%", "", $gp[$count]);

                $postt->save();
            }
            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function destroy($id)
    {
        $post = DetailOrder::find($id);
        $post->delete();

        return response()->json($post);
    }
}
