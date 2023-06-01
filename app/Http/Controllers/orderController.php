<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class orderController extends Controller
{
    public function edit(Request $request, $id)
    {
        $get = Order::with('detailOrder')->where('projectId', $id)->first();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/detailOrder', ['id' => $id, 'aksi' => $aksi, 'data' => $get]);
    }

    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                'subTotalRev' => ['required', 'string', 'max:255'],
                'subTotalCogs' => ['required', 'string', 'max:255'],
                'grandTotal' => ['required', 'string', 'max:255'],
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
            $post->grandTotal = str_replace(".", "", $request->grandTotal);
            $post->save();

            $idor = collect($request->idor)->filter()->all();
            $item = collect($request->item)->filter()->all();
            $rev = collect($request->rev)->filter()->all();
            $cogs = collect($request->cogs)->filter()->all();
            $gp = collect($request->gp)->filter()->all();


            for ($count = 0; $count < count($item); $count++) {
                if (count($idor)) {
                    $postt = DetailOrder::find($idor[$count]);
                } else {
                    $postt = new DetailOrder();
                }
                $postt->orderId = $post->id;
                $postt->item = $item[$count];
                $postt->rev = str_replace(".", "", $rev[$count]);
                $postt->cogs = str_replace(".", "", $cogs[$count]);
                $postt->gp = $gp[$count];

                $postt->save();
            }
            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
}
