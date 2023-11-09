<?php

namespace App\Http\Controllers;

use App\Exports\allProjectExport;
use App\Exports\closeProjectExport;
use App\Exports\ExportProjByMain;
use App\Exports\invByMonthExport;
use App\Exports\statPaymentExport;
use App\Models\Customer;
use App\Models\documentationProject;
use App\Models\employee;
use App\Models\issuesProject;
use App\Models\memberProject;
use App\Models\Order;
use App\Models\partnerProject;
use App\Models\Project;
use App\Models\riskProject;
use App\Models\scopeProject;
use App\Models\solution;
use App\Models\topProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class projectController extends Controller
{
    public function json(Request $request)
    {
        $dataa = Project::with('customer', 'pm', 'saless')->orderBy('created_at', 'DESC');

        if ($request->cust_id != "#" && $request->cust_id) {
            $dataa->where('cust_id', $request->cust_id);
        }
        if ($request->pmName != "#" && $request->pmName) {
            $dataa->where('pmName', $request->pmName);
        }
        if ($request->status != "#" && $request->status) {
            if ($request->status == "progress") {
                $dataa->where('overAllProg', '<', 100);
            } elseif ($request->status == "completed") {
                $dataa->where('overAllProg', '=', 100);
            }
        }
        if ($request->conStatus != "#" && $request->conStatus) {
            if ($request->conStatus == "active") {
                $dataa->where('contractEnd', '>', date("Y-m-d"));
            } elseif ($request->conStatus == "exp") {
                $dataa->where('contractEnd', '<=', date("Y-m-d"));
            } elseif ($request->conStatus == "none") {
                $dataa->where('noContract', '=', null);
            }
        }
        if ($request->mainContract != "#" && $request->mainContract) {
            $dataa->where('noPo', $request->mainContract);
        }

        if ($request->segment(1) == "json_projMainCon") {
            $dataa->where('po', '!=', null);
        }

        if (Auth::user()->hasRole('PM')) {
            $dataa->where('pmName', Auth::user()->name);
        }

        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('projectNamee', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-0 fs-5"><a href="/project/summaryProject/' . $data->id . '" class="text-inherit" target="_blank">' . mb_substr($data->projectName, 0, 25, 'UTF-8')  . '</a></h4>
                        </div>
                    </div>';
            })
            ->addColumn('progress', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div class="me-2"> <span>' . $data->overAllProg . '%</span></div>
                            <div class="progress flex-auto" style="height: 6px;">
                                <div class="progress-bar bg-primary " role="progressbar" style="width: ' . $data->overAllProg . '%;" aria-valuenow="' . $data->overAllProg . '" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn('aksi', function ($data) {
                return auth()->user()->can('bisa-hapus') ?
                    '<button id="delete" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                <i class="bi bi-trash"></i></button>' : "";
            })
            ->rawColumns(['projectNamee', 'progress', 'aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'noProject' => ['required', 'string', 'max:255'],
                'cust_id' => ['required', 'string', 'max:255'],
                'customerType' => ['required', 'string', 'max:255'],
                'projectName' => ['required', 'string', 'max:255'],
            ]);

            if ($request->id) {
                $post = Project::find($request->id);
            } else {
                $post = new Project();
            }
            $post->noProject = $request->noProject;
            $post->cust_id = $request->cust_id;
            $post->customerType = $request->customerType;
            $post->projectName = $request->projectName;
            $post->solution = $request->solution;
            $post->noContract = $request->noContract;
            $post->contractDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractDate)));
            $post->po = $request->po;
            $post->noPo = $request->noPo;
            $post->datePo = date("Y-m-d", strtotime(str_replace('-', '-', $request->datePo)));
            $post->dateStPo = date("Y-m-d", strtotime(str_replace('-', '-', $request->dateStPo)));
            $post->dateEdPo = date("Y-m-d", strtotime(str_replace('-', '-', $request->dateEdPo)));
            $post->poValue = str_replace(".", "", $request->poValue);
            $post->projectValue = str_replace(".", "", $request->projectValue);
            $post->overAllProg = 0;
            $post->projectType = $request->projectType;
            $post->partnerId = $request->partnerId;
            $post->sales = $request->sales;
            $post->pmName = $request->pmName;
            $post->coPm = $request->coPm;
            if ($request->sponsor) {
                $post->sponsor = implode(",", $request->sponsor);
            }
            $post->contractStart = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractStart)));
            $post->contractEnd = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractEnd)));
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
        $get = Project::find($id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        $customer = Customer::where('type', 'customer')->get();
        $partner = Customer::where('type', 'partner')->get();
        $employee = employee::get();
        $solution = solution::get();
        return view('project/inputProject', ['id' => $id, 'aksi' => "EditData", 'customer' => $customer, 'partner' => $partner, 'employee' => $employee, 'data' => $get, 'solution' => $solution]);
    }
    public function destroy($id)
    {
        $post = Project::find($id);
        $post->delete();
        //project
        Order::whereIn('projectId', [$id])->delete();
        topProject::whereIn('projectId', [$id])->delete();
        scopeProject::whereIn('projectId', [$id])->delete();
        memberProject::whereIn('projectId', [$id])->delete();
        partnerProject::whereIn('projectId', [$id])->delete();
        riskProject::whereIn('projectId', [$id])->delete();
        issuesProject::whereIn('projectId', [$id])->delete();
        documentationProject::whereIn('projectId', [$id])->delete();

        return response()->json();
    }

    function allProjectExport(Request $request)
    {
        $dataa = topProject::whereHas('project', function ($query) use ($request) {

            if ($request->cust_id != "#" && $request->cust_id) {
                $query->where('cust_id', $request->cust_id);
            }
            if ($request->pmName != "#" && $request->pmName) {
                $query->where('pmName', $request->pmName);
            }
            if ($request->sales != "#" && $request->sales) {
                $query->where('sales', $request->sales);
            }
            if ($request->spk != "#" && $request->spk == "noContract") {
                $query->where('noContract', null);
            } else if ($request->spk != "#" && $request->spk != "noContract") {
                $query->where('noContract', $request->spk);
            }
        })->with('project.customer', 'project.pm', 'project.coPm', 'project.sponsors', 'project.partner', 'project.saless');

        $data = $dataa
            ->orderBy('projectId')
            ->orderByRaw('CONVERT(noRef, SIGNED) asc')
            ->get();

        return Excel::download(new allProjectExport($data), 'allProjectExport.xlsx');

        //return $data;
    }
    function closeProjectExport(Request $request)
    {
        $dataa = topProject::with('project.customer', 'project.pm', 'project.coPm', 'project.sponsors', 'project.partner', 'project.saless');

        if ($request->pmNamee != "#" && $request->pmNamee) {
            $dataa->whereHas('project', function ($query) use ($request) {
                return $query->where('pmName', $request->pmNamee);
            });
        }
        if ($request->cust_idd != "#" && $request->cust_idd) {
            $dataa->whereHas('project', function ($query) use ($request) {
                return $query->where('cust_id', $request->cust_idd);
            });
        }
        if ($request->date_st != null && $request->date_st) {
            $dataa->whereDate('payDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('payDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        }
        $data = $dataa
            ->whereHas('project', function ($query) {
                return $query->where('overAllProg', 100);
            })
            ->orderBy('projectId')
            ->orderBy('noRef')
            ->get();

        return Excel::download(new closeProjectExport($data), 'closeProjectExport.xlsx');

        //return $data;
    }
    function invByMonthExport(Request $request)
    {
        $dataa = topProject::with('project');

        if ($request->date_st != null && $request->date_st) {
            $dataa->whereDate('invDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('invDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        }

        $data = $dataa
            ->orderBy('projectId')
            ->orderBy('noRef')
            ->get();

        return Excel::download(new invByMonthExport($data), 'invByMonthExport.xlsx');

        //return $data;
    }
    function statPaymentExport(Request $request)
    {
        $dataa = topProject::with('project');

        if ($request->date_st != null && $request->date_st) {
            $dataa->whereDate('payDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('payDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        }

        $data = $dataa
            ->orderBy('projectId')
            ->orderBy('noRef')
            ->get();

        return Excel::download(new statPaymentExport($data), 'statPaymentExport.xlsx');

        //return $data;
    }

    function json_projectDetail(Request $request)
    {
        $projects = Project::with('customer', 'pm')->where('overAllProg', '!=', 100);
        if ($request->pmName != "#" && $request->pmName) {
            $projects->where('pmName', '=', $request->pmName);
        }
        $project = $projects->get();

        $projectDetail = [];

        foreach ($project as $data) {
            $sumInv = topProject::where([
                ['projectId', '=', $data->id],
                ['invMain', '=', 1]
            ])->sum('termsValue');
            if ($sumInv > 0) {
                $invoiced = ($sumInv / $data->projectValue) * 100;
            } else {
                $invoiced = 0;
            }

            $sumPay = topProject::where([
                ['projectId', '=', $data->id],
                ['payMain', '=', 1]
            ])->sum('termsValue');
            if ($sumPay > 0) {
                $payment = ($sumPay / $data->projectValue) * 100;
            } else {
                $payment = 0;
            }
            $member = memberProject::where('projectId', '=', $data->id)->count();

            $projectDetail[] = [
                'customer' => $data->customer->company,
                'projectId' => $data->id,
                'projectName' => $data->projectName,
                'contractEnd' => $data->contractEnd,
                'progres' => $data->overAllProg == null ? "0" : $data->overAllProg,
                'invoiced' => round($invoiced, 0),
                'payment' => round($payment, 0),
                'team' => $member

            ];
        }
        return DataTables::of($projectDetail)
            ->addColumn('projectNamee', function ($projectDetail) {
                return
                    '<div class="d-flex align-items-center">
                    <div>
                        <h4 class="mb-0 fs-5"><a href="/project/summaryProject/' . $projectDetail['projectId'] . '" class="text-inherit" target="_blank">' . substr($projectDetail['projectName'], 0, 25) . '...</a></h4>
                    </div>
                </div>';
            })
            ->addColumn('progress', function ($projectDetail) {
                return
                    '<div class="d-flex align-items-center">
                        <div class="me-2"> <span>' . $projectDetail['progres'] . '%</span></div>
                            <div class="progress flex-auto" style="height: 6px;">
                                <div class="progress-bar bg-primary " role="progressbar" style="width: ' . $projectDetail['progres'] . '%;" aria-valuenow="' . $projectDetail['progres'] . '" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>';
            })
            ->rawColumns(['projectNamee', 'progress'])
            ->toJson();
    }

    function ExportProjByMain(Request $request)
    {
        $dataa = Project::with('pm', 'customer');

        if ($request->cust_idd != "#" && $request->cust_idd) {
            $dataa->where('cust_id', $request->cust_idd);
        }
        if ($request->pmNamee != "#" && $request->pmNamee) {
            $dataa->where('pmName', $request->pmNamee);
        }
        if ($request->mainContractt != "#" && $request->mainContractt) {
            $dataa->where('noPo', $request->mainContractt);
        }
        $dataa->where('noPo', '!=', null);

        $data = $dataa->get();
        return Excel::download(new ExportProjByMain($data), 'Project_By_Main_Contract.xlsx');
    }

    function detail_pm(Request $request)
    {
        $data = Project::with('pm', 'customer')->where('pmName', $request->id)->get();

        return response()->json($data);
    }

    function detailPoBySales(Request $request)
    {
        $dataa = Project::with('saless', 'customer', 'pm');
        if ($request->date_st != "#" && $request->date_st) {
            $dataa->whereDate('contractDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('contractDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        }
        if ($request->sales != "#" && $request->sales) {
            $names = explode(',', $request->sales);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('sales', $names);
            }
        }

        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('projectNamee', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-0 fs-5"><a target="_blank" href="/project/summaryProject/' . $data->id . '" class="text-inherit">' . substr($data->projectName, 0, 20) . '</a></h4>
                        </div>
                    </div>';
            })
            ->rawColumns(['projectNamee'])
            ->toJson();
    }
}
