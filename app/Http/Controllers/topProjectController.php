<?php

namespace App\Http\Controllers;

use App\Exports\financeExport;
use App\Models\Project;
use App\Models\topProject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class topProjectController extends Controller
{
    public function json(Request $request)
    {
        $dataa = topProject::with('project', 'project.customer')->orderBy('created_at', 'DESC');

        if ($request->segment(1) == "json_finance") {
            if ($request->date_st != "#" && $request->date_st) {
                $dataa->whereDate('bastDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('bastDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            } else {
                $dataa->whereMonth('bastDate', '=', date("m"))
                    ->whereYear('bastDate', '=', date("Y"));
            }
        }
        if ($request->segment(1) == "json_financeByInvoice") {
            if ($request->date_st != "#" && $request->date_st) {
                $dataa->whereDate('invDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('invDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            } else {
                $dataa->whereMonth('invDate', '=', date("m"))
                    ->whereYear('invDate', '=', date("Y"));
            }
            // $dataa->where('payMain', '=', 0);
        }
        if ($request->segment(1) == "json_financeByPayment") {
            if ($request->date_st != "#" && $request->date_st) {
                $dataa->whereDate('payDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('payDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            } else {
                $dataa->whereMonth('payDate', '=', date("m"))
                    ->whereYear('payDate', '=', date("Y"));
            }
        }

        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('projectNamee', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-0 fs-5"><a target="_blank" href="/project/top/' . $data->project['id'] . '" class="text-inherit">' . substr($data->project['projectName'], 0, 20) . '</a></h4>
                        </div>
                    </div>';
            })
            ->rawColumns(['projectNamee'])
            ->toJson();
    }
    public function edit(Request $request, $id)
    {
        $get = topProject::where('projectId', $id)->orderByRaw('CONVERT(noRef, SIGNED) asc')->get();
        $value = Project::with('customer')->find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if ($get) {
            $aksi = 'EditData';
        } else {
            $aksi = 'Add';
        }
        return view('project/top', ['id' => $id, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName, 'aksi' => $aksi, 'data' => $get, 'projectValue' => $value->projectValue]);
        //return $get;
    }

    public function store(Request $request, $id)
    {
        try {

            $idtop = $request->idtop;
            $termsName = collect($request->termsName)->filter()->all();
            $termsValue = collect($request->termsValue)->filter()->all();
            $bastDate = collect($request->bastDate)->filter()->all();
            $bastMain =  collect($request->bastMain)->filter()->all();
            $invDate = collect($request->invDate)->filter()->all();
            $invMain =  collect($request->invMain)->filter()->all();
            $payDate = collect($request->payDate)->filter()->all();
            $payMain =  collect($request->payMain)->filter()->all();
            $remaks = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->remaks);


            for ($count = 0; $count < count($termsName); $count++) {
                $postt = topProject::findOrNew($idtop[$count]);
                $postt->ProjectId = $id;
                $postt->noRef = $count + 1;
                $postt->termsName = $termsName[$count];
                $postt->termsValue = str_replace(".", "", $termsValue[$count]);
                $postt->bastDate = date("Y-m-d", strtotime(str_replace('-', '-', $bastDate[$count])));
                $postt->bastMain = isset($bastMain[$count]) ? $bastMain[$count] : 0;
                $postt->invDate = date("Y-m-d", strtotime(str_replace('-', '-', $invDate[$count])));
                $postt->invMain = isset($invMain[$count]) ? $invMain[$count] : 0;
                $postt->payDate = date("Y-m-d", strtotime(str_replace('-', '-', $payDate[$count])));
                $postt->payMain = isset($payMain[$count]) ? $payMain[$count] : 0;
                $postt->remaks = $remaks[$count];

                $postt->save();
            }
            $data = [$id];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function destroy($id)
    {
        $post = topProject::find($id);
        $post->delete();

        return response()->json($post);
    }

    public function financeExport(Request $request)
    {
        $dataa = topProject::with('project', 'project.customer')->orderBy('created_at', 'DESC');

        if ($request->date_st != "#" && $request->date_st) {
            $dataa->whereDate('bastDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('bastDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        } else {
            $dataa->whereMonth('bastDate', '=', date("m"))
                ->whereYear('bastDate', '=', date("Y"));
        }

        $data = $dataa->get();
        return Excel::download(new financeExport($data), 'Finance_Report.xlsx');
    }

    public function pdfPlanBAST(Request $request)
    {
        $namaBulan = [
            '#' => '',
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $title = $namaBulan[$request->monthh] . ' ' . $request->yearr != "#" ? $request->yearr : '';
        $dataa = topProject::with('project.customer');
        if ($request->monthh && $request->monthh != "#") {
            $dataa->whereMonth('bastDate', '=', date($request->monthh));
        }
        if ($request->yearr && $request->yearr != "#") {
            $dataa->whereYear('bastDate', '=', date($request->yearr));
        }

        $data = $dataa->get();
        $totalPlan = $dataa->where('invMain', '!=', 1)->sum('termsValue');
        $totalInv = $dataa->where('invMain', 1)->sum('termsValue');

        $pdf = PDF::loadView('pdf.planBAST', compact('title', 'data', 'totalPlan', 'totalInv'));
        // Mengubah orientasi menjadi lanskap
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('By Plan BAST Monthly.pdf');
    }
}
