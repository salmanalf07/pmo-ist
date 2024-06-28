<?php

namespace App\Http\Controllers;

use App\Exports\financeExport;
use App\Exports\invoiceStatusSalesDetail;
use App\Models\Project;
use App\Models\topProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class topProjectController extends Controller
{
    public function json(Request $request)
    {
        $dataa = topProject::with('project.sponsors', 'project.customer')->orderBy('projectId', 'ASC')->orderBy('noRef', 'ASC')
            ->where(function ($query) use ($request) {
                if ($request->segment(1) == "json_finance") {
                    if ($request->date_st != "#" && $request->date_st) {
                        $query->whereDate('bastDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                            ->whereDate('bastDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                    } else {
                        $query->whereMonth('bastDate', '=', date("m"))
                            ->whereYear('bastDate', '=', date("Y"));
                    }
                    if ($request->statBASTs != "#" && $request->statBASTs) {
                        $bastMain = $request->statBASTs == 'done' ? 1 : 0;
                        $query->where('bastMain', '=', $bastMain);
                    }
                }
                if ($request->segment(1) == "json_financeByInvoice") {
                    if ($request->date_st != "#" && $request->date_st) {
                        $query->whereDate('invDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                            ->whereDate('invDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                    } else {
                        $query->whereMonth('invDate', '=', date("m"))
                            ->whereYear('invDate', '=', date("Y"));
                    }
                    // $query->where('payMain', '=', 0);
                }
                if ($request->segment(1) == "json_financeByPayment") {
                    if ($request->date_st != "#" && $request->date_st) {
                        $query->whereDate('payDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                            ->whereDate('payDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                    } else {
                        $query->whereMonth('payDate', '=', date("m"))
                            ->whereYear('payDate', '=', date("Y"));
                    }
                }
                if ($request->segment(1) == "json_financeUnschduled") {
                    $query->whereDate('bastDate', '1990-01-01')
                        ->orWhereDate('bastDate', '1900-01-01');
                }
            })
            ->whereHas('project', function ($query) use ($request) {
                if ($request->salesId != "#" && $request->salesId) {
                    $names = explode(',', $request->salesId);
                    // Periksa apakah 'name' adalah string '#' atau array kosong
                    if (is_array($names) && count($names) > 0) {
                        // Gunakan whereIn untuk mencocokkan multiple values
                        $query->whereIn('sales', $names);
                    }
                }
                if (Auth::user()->hasRole('PM')) {
                    $query->where('pmName', Auth::user()->name)
                        ->orWhere('coPm', Auth::user()->name);
                }
            })
            ->whereHas('project.sponsors', function ($query) use ($request) {
                if ($request->sponsors != "#" && $request->sponsors) {
                    $names = explode(',', $request->sponsors);
                    // Periksa apakah 'name' adalah string '#' atau array kosong
                    if (is_array($names) && count($names) > 0) {
                        // Gunakan whereIn untuk mencocokkan multiple values
                        $query->where('sponsorId', $names);
                    }
                }
            });

        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('projectNamee', function ($data) {
                return
                    '<div class="d-flex align-items-center" data-toggle="tooltip" title="' . $data->project['projectName'] . '">
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
        $dataa = Project::with('customer')->where('id', $id);
        if (Auth::user()->hasRole('PM')) {
            $dataa->where(function ($query) {
                $query->where('pmName', Auth::user()->name)
                    ->orWhere('coPm', Auth::user()->name);
            });
        }
        $value = $dataa->first();
        if (!$value) {
            return view('/error', ['exception' => 'Project Not Allowed Access']);
        }
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        if (count($get) > 0) {
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
                $postt->termsValuePPN = ceil(str_replace(".", "", $termsValue[$count])  / (1 + Session::get("ppn") / 100));
                if ($bastDate) {
                    $postt->bastDate = date("Y-m-d", strtotime(str_replace('-', '-', $bastDate[$count])));
                }
                if (!Auth::user()->hasRole(["Finance", "PM"])) {
                    $postt->bastMain = isset($bastMain[$count]) ? $bastMain[$count] : 0;
                }
                if (!Auth::user()->hasRole("PM")) {
                    $postt->invDate = date("Y-m-d", strtotime(str_replace('-', '-', $invDate[$count])));
                    $postt->invMain = isset($invMain[$count]) ? $invMain[$count] : 0;
                    $postt->payDate = date("Y-m-d", strtotime(str_replace('-', '-', $payDate[$count])));
                    $postt->payMain = isset($payMain[$count]) ? $payMain[$count] : 0;
                }
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

    public function finance(Request $request)
    {
    }

    public function financeExport(Request $request)
    {
        $dataa = topProject::with('project.saless', 'project.sponsors.employee', 'project.customer')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($request) {
                if ($request->segment(1) == "financeUnschduledExport") {
                    $query->whereDate('bastDate', '1990-01-01')
                        ->orWhereDate('bastDate', '1900-01-01');
                }
                if ($request->segment(1) == 'financeExport' || $request->segment(1) == 'financeTermsStatExport') {
                    if ($request->date_st != "#" && $request->date_st) {
                        $query->whereDate('bastDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                            ->whereDate('bastDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                    } else {
                        $query->whereMonth('bastDate', '=', date("m"))
                            ->whereYear('bastDate', '=', date("Y"));
                    }
                    if ($request->statBASTs != "#" && $request->statBASTs) {
                        $bastMain = $request->statBASTs == 'done' ? 1 : 0;
                        $query->where('bastMain', '=', $bastMain);
                    }
                }

                if ($request->segment(1) == 'financeByInvoiceExport') {
                    if ($request->date_st != "#" && $request->date_st) {
                        $query->whereDate('invDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                            ->whereDate('invDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                    } else {
                        $query->whereMonth('invDate', '=', date("m"))
                            ->whereYear('invDate', '=', date("Y"));
                    }
                }

                if ($request->segment(1) == 'financeByPaymentExport') {
                    if ($request->date_st != "#" && $request->date_st) {
                        $query->whereDate('payDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                            ->whereDate('payDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                    } else {
                        $query->whereMonth('payDate', '=', date("m"))
                            ->whereYear('payDate', '=', date("Y"));
                    }
                }
            })
            ->whereHas('project.sponsors', function ($query) use ($request) {
                if ($request->sponsorId != "#" && $request->sponsorId) {
                    $names = explode(',', $request->sponsorId);
                    // Periksa apakah 'name' adalah string '#' atau array kosong
                    if (is_array($names) && count($names) > 0) {
                        // Gunakan whereIn untuk mencocokkan multiple values
                        $query->whereIn('sponsorId', $names);
                    }
                }
            })
            ->whereHas('project', function ($query) use ($request) {
                if ($request->salesId != "#" && $request->salesId) {
                    $names = explode(',', $request->salesId);
                    // Periksa apakah 'name' adalah string '#' atau array kosong
                    if (is_array($names) && count($names) > 0) {
                        // Gunakan whereIn untuk mencocokkan multiple values
                        $query->whereIn('sales', $names);
                    }
                }
                if (Auth::user()->hasRole('PM')) {
                    $query->where('pmName', Auth::user()->name)
                        ->orWhere('coPm', Auth::user()->name);
                }
            });

        $data = $dataa->get()->sortBy(['projectId', 'noRef']);

        if ($request->segment(1) == "financeTermsStatExport" || $request->segment(1) == "financeUnschduledExport") {
            $projectDetail = [];
            foreach ($data as  $project) {
                $sponsorData = [];

                // Loop foreach untuk mengakses nama karyawan dan menyimpannya dalam array
                foreach ($project->project->sponsors as $sponsor) {
                    $sponsorName = $sponsor->employee->name ?? "";
                    $sponsorData[] = $sponsorName;
                }

                $projectDetail[] = [
                    'noProject' => $project->project->noProject,
                    'company' => $project->project->customer->company,
                    'sales' => $project->project->saless->name,
                    'sponsors' => implode(', ', $sponsorData) ?? '',
                    'projectName' => $project->project->projectName,
                    'noContract' => $project->project->noContract,
                    'termsName' => $project->termsName,
                    'termsValuePPN' => $project->termsValuePPN,
                    'bastDate' => $project->bastDate,
                    'bastMonth' => date('m', strtotime($project->bastDate)),
                    'bastYear' => date('Y', strtotime($project->bastDate)),
                    'bastMain' => $project->bastMain == 1 ? 'Done' : '',
                    'invDate' => $project->invDate,
                    'invMain' => $project->invMain == 1 ? 'Done' : '',
                    'payDate' => $project->payDate,
                    'payMain' => $project->payMain == 1 ? 'Done' : '',

                ];
            }
            $data = $projectDetail;
        }

        return Excel::download(new financeExport($data, $request->segment(1)), 'Finance_Report.xlsx');
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

        $title = $namaBulan[$request->monthh] . ' ' . ($request->yearr != "#" ? $request->yearr : '');
        $dataa = topProject::with('project.customer');
        if ($request->monthh && $request->monthh != "#") {
            $dataa->whereMonth('bastDate', '=', date($request->monthh));
        }
        if ($request->yearr && $request->yearr != "#") {
            $dataa->whereYear('bastDate', '=', date($request->yearr));
        }

        if (Auth::user()->hasRole('PM')) {
            $dataa->whereHas('project', function ($query) use ($request) {
                $query->where('pmName', Auth::user()->name)
                    ->orWhere('coPm', Auth::user()->name);
            });
        }

        $data = $dataa->orderBy('bastDate')->get();
        $totalPlan = $data->sum('termsValuePPN');
        $totalInv = $data->where('invMain', 1)->sum('termsValuePPN');

        $pdf = PDF::loadView('pdf.planBAST', compact('title', 'data', 'totalPlan', 'totalInv'));
        // Mengubah orientasi menjadi lanskap
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('By Plan BAST Monthly.pdf');
    }

    public function invoiceStatusSalesDetail(Request $request)
    {
        $dataa = topProject::with('project.saless', 'project.customer')->orderBy('created_at', 'DESC');

        $dataa->whereHas('project', function ($query) use ($request) {
            if ($request->salesId != "#" && $request->salesId) {
                $names = explode(',', $request->salesId);
                // Periksa apakah 'name' adalah string '#' atau array kosong
                if (is_array($names) && count($names) > 0) {
                    // Gunakan whereIn untuk mencocokkan multiple values
                    $query->whereIn('sales', $names);
                }
            }
        });
        if ($request->date_st != "#" && $request->date_st) {
            $dataa->whereDate('invDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('invDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        } else {
            $dataa->whereMonth('invDate', '=', date("m"))
                ->whereYear('invDate', '=', date("Y"));
        }
        $data = $dataa->get();

        if ($request->segment(2) == "json_invoiceStatusSalesDetail") {
            return DataTables::of($data)->toJson();
        }
        if ($request->segment(2) == "exportInvoiceStatusSalesDetail") {
            $date_st = $request->date_st != "#" ? $request->date_st : date("01/m/Y");
            $date_ot = $request->date_ot != "#" ? $request->date_ot : date("t/m/Y");

            $salesData = [];

            // Pengelompokkan berdasarkan sales
            $groupedData = $data->sortBy('project.saless.name')->groupBy('project.noContract', 'projectId');

            $sum = 0;
            foreach ($groupedData as $number) {
                foreach ($number as $terms) {
                    $sum += $terms->termsValue;
                }
            }

            $pdf = PDF::loadView('pdf.exportInvoiceStatusSalesDetail', compact('groupedData', 'sum',  'date_st', 'date_ot'));
            // Mengubah orientasi menjadi lanskap
            $pdf->setPaper('a4', 'lanscape');

            //return view('pdf.exportInvoiceStatusSalesAll', compact('groupedData', 'sum', 'status'));
            return $pdf->download('INVOICE STATUS PER PO PER SALES – DETAIL.pdf');
            // return $sum;
        }
        if ($request->segment(2) == "exportExcelInvoiceStatusSalesDetail") {
            $dataExport = $data->sortBy(['projectId', 'noRef', 'project.saless.name']);
            //return $dataExport;

            return Excel::download(new invoiceStatusSalesDetail($dataExport), 'invoiceStatusSalesDetail.xlsx');
        }
    }

    public function invoiceProgressPerSales(Request $request)
    {
        $dataa = topProject::with('project.saless')->orderBy('created_at', 'DESC');

        $dataa->whereHas('project', function ($query) use ($request) {
            if ($request->salesId != "#" && $request->salesId) {
                $names = explode(',', $request->salesId);
                // Periksa apakah 'name' adalah string '#' atau array kosong
                if (is_array($names) && count($names) > 0) {
                    // Gunakan whereIn untuk mencocokkan multiple values
                    $query->whereIn('sales', $names);
                }
            }
            if ($request->date_st != "#" && $request->date_st) {
                $query->whereDate('contractDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('contractDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            } else {
                $query->whereMonth('contractDate', '=', date("m"))
                    ->whereYear('contractDate', '=', date("Y"));
            }
        });

        $data = $dataa->get();
        // Pengelompokkan berdasarkan sales
        $groupedData = $data->sortBy('project.saless.name')->groupBy('project.noContract', 'projectId');

        $sumArray = [];
        $sum = 0;

        foreach ($groupedData as $groupKey => $groupItems) {
            $summ = 0;
            $shortProjectName = '';
            $sales = '';
            $customer = '';
            $contractDate = '';
            $noContract = '';
            $projectValuePPN = '';
            $projectId = '';
            foreach ($groupItems as $item) {
                $shortProjectName = $item->project->shortProjectName;
                $sales = $item->project->saless->name;
                $contractDate = $item->project->contractDate;
                $customer = $item->project->customer->company;
                $noContract = $item->project->noContract;
                $projectValuePPN = preg_replace('/[^0-9]/', '', $item->project->projectValuePPN);
                $projectId = $item->project->id;
                if ($item->invMain == 1) {
                    $sum += $item->termsValuePPN;
                    $summ += $item->termsValuePPN;
                }
            }
            $sumArray[$groupKey] = [
                'projectId' => $projectId,
                'sales' => $sales,
                'shortProjectName' => $shortProjectName,
                'customer' => $customer,
                'contractDate' => $contractDate,
                'noContract' => $noContract,
                'projectValuePPN' => $projectValuePPN,
                'invoiced' => $summ,
                'progresPercen' => round(($summ / $projectValuePPN) * 100, 0),
                'outstanding' => $projectValuePPN - $summ

            ];
        }
        $finishData = array_filter($sumArray, function ($item) use ($request) {
            if ($request->statusId != "#" && $request->statusId) {
                if ($request->statusId == "progress") {
                    return ($item['progresPercen'] < 100); // Ubah kondisi filter sesuai kebutuhan
                } elseif ($request->statusId == "completed") {
                    return ($item['progresPercen'] >= 100); // Ubah kondisi filter sesuai kebutuhan
                }
            }
            return true;
        });

        if ($request->segment(2) == "json_invoiceProgressPerSales") {
            return DataTables::of($finishData)
                ->addColumn('projectNamee', function ($finishData) {
                    return
                        '<div class="d-flex align-items-center" data-toggle="tooltip" title="' . $finishData['shortProjectName'] . '">
                        <div>
                            <h4 class="mb-0 fs-5"><a target="_blank" href="/project/top/' . $finishData['projectId'] . '" class="text-inherit">' . substr($finishData['shortProjectName'], 0, 20) . '</a></h4>
                        </div>
                    </div>';
                })
                ->rawColumns(['projectNamee'])
                ->toJson();
        }
        if ($request->segment(2) == "exportInvoiceProgressPerSales") {
            $statusId = $request->statusId != "#" ? $request->statusId : 'ALL';
            $date_st = $request->date_st != "#" ? $request->date_st : date("01/m/Y");
            $date_ot = $request->date_ot != "#" ? $request->date_ot : date("t/m/Y");
            $salesData = [];


            //return $finishData;
            $pdf = PDF::loadView('pdf.exportInvoiceProgressPerSales', compact('finishData', 'sum', 'statusId', 'date_st', 'date_ot'));
            // Mengubah orientasi menjadi lanskap
            $pdf->setPaper('a4', 'lanscape');

            //return view('pdf.exportInvoiceStatusSalesAll', compact('groupedData', 'sum',  'date_st', 'date_ot', 'sumArray'));
            return $pdf->download('INVOICE STATUS PER PO PER SALES – DETAIL.pdf');
            // return $sum;
        }
    }

    function invoiceSummaryPerSales(Request $request)
    {
        $dataa = Project::with('saless', 'customer', 'topProject');
        if ($request->date_st != "#" && $request->date_st) {
            $dataa->whereDate('contractDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('contractDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        } else {
            $dataa->whereMonth('contractDate', '=', date("m"))
                ->whereYear('contractDate', '=', date("Y"));
        }
        if ($request->salesId != "#" && $request->salesId) {
            $names = explode(',', $request->salesId);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('sales', $names);
            }
        }

        $data = $dataa->get()->groupBy('sales');

        $sumArray = [];
        $sum = 0;
        $summ = 0;
        $projectValuePPN = 0;

        $lastItem = '';

        foreach ($data as $groupKey => $groupItems) {
            foreach ($groupItems->sortBy('cust_id') as $item) {

                if ($lastItem != $item->cust_id) {
                    $summ = 0;
                    $projectValuePPN = 0;
                    $sales = $item->saless->name;
                    $customer = $item->customer->company;
                    $projectId = $item->id;
                }

                // Tambahan: Menambahkan projectValuePPN dari setiap item
                $projectValuePPN += preg_replace('/[^0-9]/', '', $item->projectValuePPN);

                foreach ($item->topProject as $top) {
                    if ($top->invMain == 1) {
                        $sum += $top->termsValuePPN;
                        $summ += $top->termsValuePPN;
                    }
                }

                if ($lastItem != $item->cust_id) {
                    $sumArray[$projectId] = [
                        'projectId' => $projectId,
                        'sales' => $sales,
                        'customer' => $customer,
                        'projectValuePPN' => $projectValuePPN,
                        'invoiced' => $summ,
                        'progresPercen' => round(($summ / $projectValuePPN) * 100, 0),
                        'outstanding' => $projectValuePPN - $summ
                    ];
                } else {
                    // Update record jika lastItem sama dengan item->cust_id
                    $sumArray[$projectId]['projectValuePPN'] = $projectValuePPN;
                    $sumArray[$projectId]['invoiced'] = $summ;
                    $sumArray[$projectId]['progresPercen'] = round(($summ / $projectValuePPN) * 100, 0);
                    $sumArray[$projectId]['outstanding'] = $projectValuePPN - $summ;
                }

                $lastItem = $item->cust_id;
            }
        }


        $finishData = array_filter($sumArray, function ($item) use ($request) {
            if ($request->statusId != "#" && $request->statusId) {
                if ($request->statusId == "progress") {
                    return ($item['progresPercen'] < 100); // Ubah kondisi filter sesuai kebutuhan
                } elseif ($request->statusId == "completed") {
                    return ($item['progresPercen'] >= 100); // Ubah kondisi filter sesuai kebutuhan
                }
            }
            return true;
        });

        $statusId = $request->statusId != "#" ? $request->statusId : 'ALL';
        $date_st = $request->date_st != "#" ? $request->date_st : date("01/m/Y");
        $date_ot = $request->date_ot != "#" ? $request->date_ot : date("t/m/Y");

        $pdf = PDF::loadView('pdf.exportInvoiceSummaryPerSales', compact('finishData', 'sum', 'statusId', 'date_st', 'date_ot'));
        // Mengubah orientasi menjadi lanskap
        $pdf->setPaper('a4', 'lanscape');

        //return view('pdf.exportInvoiceStatusSalesAll', compact('groupedData', 'sum',  'date_st', 'date_ot', 'sumArray'));
        return $pdf->download('INVOICE SUMMARY PER PO PER SALES – DETAIL.pdf');
    }
}
