<?php

namespace App\Http\Controllers;

use App\Exports\allProjectByDate;
use App\Exports\allProjectExport;
use App\Exports\closeProjectExport;
use App\Exports\dataSowExport;
use App\Exports\ExportProjByMain;
use App\Exports\invByMonthExport;
use App\Exports\planInvhByCustExport;
use App\Exports\statPaymentExport;
use App\Models\asanaProject;
use App\Models\Customer;
use App\Models\documentationProject;
use App\Models\employee;
use App\Models\inScope;
use App\Models\issuesProject;
use App\Models\memberProject;
use App\Models\Order;
use App\Models\partnerProject;
use App\Models\Project;
use App\Models\projectSponsor;
use App\Models\riskProject;
use App\Models\scopeProject;
use App\Models\solution;
use App\Models\topProject;
use Google\Service\Vault\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Ramsey\Uuid\Uuid;
use PDF;

class projectController extends Controller
{
    public function json(Request $request)
    {
        $dataa = Project::with('topProject', 'customer', 'pm', 'saless', 'sponsors')->orderBy('contractDate', 'DESC');

        if ($request->cust_id != "#" && $request->cust_id) {
            $names = explode(',', $request->cust_id);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('cust_id', $names);
            }
        }
        if ($request->pmName != "#" && $request->pmName) {
            $names = explode(',', $request->pmName);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('pmName', $names);
            }
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
        if ($request->salesId != "#" && $request->salesId) {
            $names = explode(',', $request->salesId);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('sales', $names);
            }
        }

        if ($request->sponsors != "#" && $request->sponsors) {
            $names = explode(',', $request->sponsors);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                $dataa->whereHas('sponsors', function ($query) use ($names) {
                    // Gunakan whereIn untuk mencocokkan multiple values
                    $query->whereIn('sponsorId', $names);
                });
            }
        }
        if ($request->hasAsana != "#" && $request->hasAsana) {
            if ($request->hasAsana == "yes") {
                $dataa->where('has_asana', '=', 1);
            }
            if ($request->hasAsana == "no") {
                $dataa->where('has_asana', '=', 0);
            }
        }

        if ($request->segment(1) == "json_projMainCon") {
            $dataa->where('po', '!=', null);
        }

        if (Auth::user()->hasRole('PM')) {
            $dataa->where(function ($query) {
                $query->where('pmName', Auth::user()->name)
                    ->orWhere('coPm', Auth::user()->name);
            });
        }

        $data = $dataa->get();
        if ($request->segment(1) == "projInfoByDateExport") {
            $dataExport = [];
            foreach ($data as  $datas) {
                $sponsorData = [];

                // Loop foreach untuk mengakses nama karyawan dan menyimpannya dalam array
                foreach ($datas->sponsors as $sponsor) {
                    $sponsorName = $sponsor->employee->name ?? "";
                    $sponsorData[] = $sponsorName;
                }
                $dataExport[] = [
                    'noProject' => $datas->noProject,
                    'customer' => $datas->customer->company,
                    'saless' => $datas->saless->name,
                    'projectName' => $datas->projectName,
                    'noContract' => $datas->noContract,
                    'contractStart' => $datas->contractStart,
                    'contractEnd' => $datas->contractEnd,
                    'pm' => $datas->pm->name ?? "",
                    'sponsors' => implode(', ', $sponsorData),
                    'overAllProg' => $datas->overAllProg
                ];
            }

            return Excel::download(new allProjectByDate($dataExport), 'projInfoByDateExport.xlsx');
        }
        return DataTables::of($data)
            ->addColumn('projectNamee', function ($data) {
                return
                    '<div class="d-flex align-items-center" data-toggle="tooltip" title="' . $data->projectName . '">
                        <div>
                            <h4 class="mb-0 fs-5"><a href="/project/summaryProject/' . $data->id . '" class="text-inherit" target="_blank">' . mb_substr($data->projectName, 0, 25, 'UTF-8')  . '</a></h4>
                        </div>
                    </div>';
            })
            ->addColumn('progress', function ($data) {
                // return
                //     '<div class="d-flex align-items-center">
                //         <div class="me-2"> <span>' . $data->overAllProg . '%</span></div>
                //             <div class="progress flex-auto" style="height: 6px;">
                //                 <div class="progress-bar bg-primary " role="progressbar" style="width: ' . $data->overAllProg . '%;" aria-valuenow="' . $data->overAllProg . '" aria-valuemin="0" aria-valuemax="100">
                //             </div>
                //         </div>
                //     </div>';
                return $data->overAllProg . '%';
            })
            ->addColumn('progressInv', function ($data) {
                $sumInv = topProject::where([
                    ['projectId', '=', $data->id],
                    ['invMain', '=', 1]
                ])->sum('termsValue');

                if ($sumInv > 0) {
                    return $invoiced = round(($sumInv / $data->projectValue) * 100, 0) . '%';
                } else {
                    return $invoiced = '0%';
                }
            })
            ->addColumn('aksi', function ($data) {
                return auth()->user()->can('bisa-hapus') ?
                    '<button id="delete" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                <i class="bi bi-trash"></i></button>' : "";
            })
            ->rawColumns(['projectNamee', 'progress', 'progressInv', 'aksi'])
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
                'shortProjectName' => ['required', 'string', 'max:255'],
            ]);

            if ($request->id) {
                $post = Project::find($request->id);
            } else {
                $post = new Project();
                $post->overAllProg = 0;
            }
            $post->noProject = $request->noProject;
            if ($request->hasAsana) {
                $asana = asanaProject::where('projectId', $request->id)->get();
                $post->has_asana = 1;
                $post->overAllProg = $asana->avg('progress') ?? 0;
            } else {
                $timeline = scopeProject::where('projectId', $request->id)->get();
                $post->has_asana = 0;
                $post->overAllProg = $timeline->avg('progProject') ?? 0;
            }
            $post->cust_id = $request->cust_id;
            $post->customerType = $request->customerType;
            $post->projectName = $request->projectName;
            $post->shortProjectName = $request->shortProjectName;
            $post->solution = $request->solution;
            $post->noContract = $request->noContract;
            $post->contractDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractDate)));
            $post->po = $request->po;
            $post->noPo = $request->noPo;
            $post->datePo = date("Y-m-d", strtotime(str_replace('-', '-', $request->datePo)));
            $post->dateStPo = date("Y-m-d", strtotime(str_replace('-', '-', $request->dateStPo)));
            $post->dateEdPo = date("Y-m-d", strtotime(str_replace('-', '-', $request->dateEdPo)));
            $post->poValue = str_replace(".", "", $request->poValue);
            $post->projectValuePPN = $request->projectValue == null ? 0 : ceil(str_replace(".", "", $request->projectValue)  / (1 + Session::get("ppn") / 100));
            $post->projectValue = $request->projectValue == null ? 0 : str_replace(".", "", $request->projectValue);
            $post->projectType = $request->projectType;
            $post->partnerId = $request->partnerId;
            $post->sales = $request->sales;
            $post->pmName = $request->pmName;
            $post->coPm = $request->coPm;
            $post->contractStart = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractStart)));
            $post->contractEnd = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractEnd)));
            $post->planMandays = $request->planMandays;
            $post->mandaysPlan = str_replace(".", "", $request->mandaysPlan);
            $post->save();


            if ($request->sponsor) {
                $post->sponsor()->detach();
                // Membuat array dari UUID sponsors yang diterima dari form
                $sponsorIds = $request->input('sponsor');

                foreach ($sponsorIds as $sponsorId) {
                    $pivotId = Uuid::uuid4()->toString();
                    $post->sponsor()->attach([$sponsorId => ['id' => $pivotId]]);
                }
            }

            if ($request->managerCharge) {
                $post->managerCharge()->detach();
                // Membuat array dari UUID managerCharges yang diterima dari form
                $managerIds = $request->input('managerCharge');

                foreach ($managerIds as $managerId) {
                    $pivotId = Uuid::uuid4()->toString();
                    $post->managerCharge()->attach([$managerId => ['id' => $pivotId]]);
                }
            }

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request, $id)
    {
        $dataa = Project::with('sponsors.employee', 'managerCharges.employee')->where('id', $id);
        if (Auth::user()->hasRole('PM')) {
            $dataa->where(function ($query) {
                $query->where('pmName', Auth::user()->name)
                    ->orWhere('coPm', Auth::user()->name);
            });
        }
        $get = $dataa->first();
        // return $get;
        if (!$get) {
            return view('/error', ['exception' => 'Project Not Allowed Access']);
        }
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
        $post->sponsors()->delete();
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
        $delAsana = asanaProject::where('projectId', '=', $id)->first();
        if ($delAsana) {
            $delAsana->projectId = null;
            $delAsana->save();
        }

        return response()->json();
    }

    function allProjectExport(Request $request)
    {
        $dataa = Project::with('customer', 'pm', 'coPm', 'sponsors.employee', 'partner', 'saless', 'topProject', 'inScope', 'outScope');

        if ($request->cust_id != "#" && $request->cust_id) {
            $dataa->where('cust_id', $request->cust_id);
        }
        if ($request->pmName != "#" && $request->pmName) {
            $dataa->where('pmName', $request->pmName);
        }
        if ($request->sales != "#" && $request->sales) {
            $dataa->where('sales', $request->sales);
        }
        if ($request->spk != "#" && $request->spk == "noContract") {
            $dataa->where('noContract', null);
        } else if ($request->spk != "#" && $request->spk != "noContract") {
            $dataa->where('noContract', $request->spk);
        }
        if ($request->statusId != "#" && $request->statusId) {
            if ($request->statusId == "progress") {
                $dataa->where('overAllProg', '<', 100);
            } elseif ($request->statusId == "completed") {
                $dataa->where('overAllProg', '=', 100);
            }
        }
        if ($request->sponsor != "#" && $request->sponsor) {
            $names = explode(',', $request->sponsor);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                $dataa->whereHas('sponsors', function ($query) use ($names) {
                    // Gunakan whereIn untuk mencocokkan multiple values
                    $query->whereIn('sponsorId', $names);
                });
            }
        }

        $data = $dataa
            ->get();

        $projectDetail = [];
        $inScope = [];
        $outScope = [];

        foreach ($data as  $project) {
            $sponsorData = [];

            // Loop foreach untuk mengakses nama karyawan dan menyimpannya dalam array
            foreach ($project->sponsors as $sponsor) {
                $sponsorName = $sponsor->employee->name ?? "";
                $sponsorData[] = $sponsorName;
            }
            if (isset($project->topProject[0])) {
                foreach ($project->topProject as $topProject) {
                    // Inisialisasi array untuk menyimpan nama karyawan
                    $projectDetail[] = [
                        'noProject' => $project->noProject,
                        'customerType' => $project->customerType,
                        'customerName' => $project->customer->company,
                        'projectName' => $project->projectName,
                        'noContract' => $project->noContract,
                        'contractDate' => date("d-m-Y", strtotime($project->contractDate)),
                        'po' => $project->po,
                        'noPo' => $project->noPo,
                        'datePo' => date("d-m-Y", strtotime($project->datePo)),
                        'dateStPo' => date("d-m-Y", strtotime($project->dateStPo)),
                        'dateEdPo' => date("d-m-Y", strtotime($project->dateEdPo)),
                        'poValue' => $project->poValue,
                        'projectValue' => $project->projectValue,
                        'planMandays' => $project->planMandays,
                        'mandaysPlan' => $project->mandaysPlan,
                        'overAllProg' => $project->overAllProg,
                        'projectType' => $project->projectType,
                        'partnerCompany' => isset($project->partner->company) ? $project->partner->company : "",
                        'saless' => $project->saless->name,
                        'pm' => isset($project->pm->name) ? $project->pm->name : "",
                        'co_pm' => isset($project->coPm->name) ? $project->coPm->name : "",
                        'sponsors' => implode(', ', $sponsorData) ?? "",
                        'contractStart' => date("d-m-Y", strtotime($project->contractStart)),
                        'contractEnd' => date("d-m-Y", strtotime($project->contractEnd)),
                        'termsName' => $topProject->termsName,
                        'termsValue' => $topProject->termsValue,
                        'bastDate' => date("d-m-Y", strtotime($topProject->bastDate)),
                        'invDate' => date("d-m-Y", strtotime($topProject->invDate)),
                        'payDate' =>  date("d-m-Y", strtotime($topProject->payDate)),
                        'remaks' => $topProject->remaks,
                    ];
                }
            } else {
                $projectDetail[] = [
                    'noProject' => $project->noProject,
                    'customerType' => $project->customerType,
                    'customerName' => $project->customer->company,
                    'projectName' => $project->projectName,
                    'noContract' => $project->noContract,
                    'contractDate' => date("d-m-Y", strtotime($project->contractDate)),
                    'po' => $project->po,
                    'noPo' => $project->noPo,
                    'datePo' => date("d-m-Y", strtotime($project->datePo)),
                    'dateStPo' => date("d-m-Y", strtotime($project->dateStPo)),
                    'dateEdPo' => date("d-m-Y", strtotime($project->dateEdPo)),
                    'poValue' => $project->poValue,
                    'projectValue' => $project->projectValue,
                    'planMandays' => $project->planMandays,
                    'mandaysPlan' => $project->mandaysPlan,
                    'overAllProg' => $project->overAllProg,
                    'projectType' => $project->projectType,
                    'partnerCompany' => isset($project->partner->company) ? $project->partner->company : "",
                    'saless' => $project->saless->name,
                    'pm' => isset($project->pm->name) ? $project->pm->name : "",
                    'co_pm' => isset($project->coPm->name) ? $project->coPm->name : "",
                    'sponsors' => implode(', ', $sponsorData) ?? "",
                    'contractStart' => date("d-m-Y", strtotime($project->contractStart)),
                    'contractEnd' => date("d-m-Y", strtotime($project->contractEnd)),
                    'termsName' => '',
                    'termsValue' => '',
                    'bastDate' => '',
                    'invDate' => '',
                    'payDate' => '',
                    'remaks' => '',
                ];
            }

            if (count($project->inScope) > 0) {
                foreach ($project->inScope as $key => $value) {
                    // Tambahkan nilai baru ke setiap nilai dalam array
                    $inScope[] = [
                        'noProject' => $project->noProject,
                        'projectName' => $project->projectName,
                        'inScope' => $value->inScope,
                        'remaks' => $value->remaks,
                    ];
                }
            }

            if (count($project->outScope) > 0) {
                foreach ($project->outScope as $key => $value) {
                    // Tambahkan nilai baru ke setiap nilai dalam array
                    $outScope[] = [
                        'noProject' => $project->noProject,
                        'projectName' => $project->projectName,
                        'outScope' => $value->outOfScope,
                        'remaks' => $value->remaks,
                    ];
                }
            }
        }
        $dataExport = ["projectDetail" => $projectDetail, "inScope" => $inScope, "outScope" => $outScope];
        // return $dataExport;
        return Excel::download(new allProjectExport($dataExport), 'allProjectExport.xlsx');
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
        $dataa = topProject::with('project', 'project.customer');

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
        $dataa = topProject::with('project.customer');

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
                $invoiced = $data->projectValue != 0 ? ($sumInv / $data->projectValue) * 100 : 0;
            } else {
                $invoiced = 0;
            }

            $sumPay = topProject::where([
                ['projectId', '=', $data->id],
                ['payMain', '=', 1]
            ])->sum('termsValue');
            if ($sumPay > 0) {
                $payment = $data->projectValue != 0 ? ($sumPay / $data->projectValue) * 100 : 0;;
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
                    '<div class="d-flex align-items-center" data-toggle="tooltip" title="' . $projectDetail['projectName'] . '">
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

        $data = $dataa->get();
        if ($request->segment(2) == "json_detailPoBySales") {
            return DataTables::of($data)
                ->addColumn('projectNamee', function ($data) {
                    return
                        '<div class="d-flex align-items-center" data-toggle="tooltip" title="' . $data->projectName . '">
                        <div>
                            <h4 class="mb-0 fs-5"><a target="_blank" href="/project/summaryProject/' . $data->id . '" class="text-inherit">' . substr($data->projectName, 0, 20) . '</a></h4>
                        </div>
                    </div>';
                })
                ->rawColumns(['projectNamee'])
                ->toJson();
        }
        if ($request->segment(2) == "exportDetailPoBySales") {
            $date_st = $request->date_st != "#" ? $request->date_st : date("01/m/Y");
            $date_ot = $request->date_ot != "#" ? $request->date_ot : date("t/m/Y");

            $sum = 0;
            foreach ($data as $number) {
                $sum += $number->projectValue;
            }

            $pdf = PDF::loadView('pdf.exportDetailPoBySales', compact('data', 'date_st', 'date_ot', 'sum'));
            // Mengubah orientasi menjadi lanskap
            $pdf->setPaper('a4', 'landscape');

            return $pdf->download('SALES REPORT – PO RECEIVED PER SALES – DETAIL.pdf');
        }
    }

    function summaryPoBySales(Request $request)
    {
        $dataa = Project::with('saless', 'customer', 'pm');
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

        // $data = $dataa->select('sales', DB::raw('SUM(projectValue) as totalProjectValue'))->groupBy('sales')->get();
        $data = $dataa->select('cust_id', 'sales', DB::raw('SUM(projectValuePPN) as totalProjectValue'))->groupBy('cust_id', 'sales')->get();
        if ($request->segment(2) == "json_summaryPoBySales") {
            return DataTables::of($data)
                ->addColumn('projectNamee', function ($data) {
                    return
                        '<div class="d-flex align-items-center" data-toggle="tooltip" title="' . $data->projectName . '">
                        <div>
                            <h4 class="mb-0 fs-5"><a target="_blank" href="/project/summaryProject/' . $data->id . '" class="text-inherit">' . substr($data->projectName, 0, 20) . '</a></h4>
                        </div>
                    </div>';
                })
                ->rawColumns(['projectNamee'])
                ->toJson();
        }
        if ($request->segment(2) == "exportSummaryPoBySales") {
            $date_st = $request->date_st != "#" ? $request->date_st : date("01/m/Y");
            $date_ot = $request->date_ot != "#" ? $request->date_ot : date("t/m/Y");

            $sum = 0;
            foreach ($data as $number) {
                $sum += $number->totalProjectValue;
            }

            $salesData = [];

            // Pengelompokkan berdasarkan sales
            $groupedData = $data->sortBy('saless.name')->groupBy('sales');

            foreach ($groupedData as $sales => $items) {
                $salesName = $items->first()->saless->name ?? '';

                $customerData = [];

                foreach ($items as $item) {
                    $customer = $item->customer->company ?? '';
                    $totalPOValue = $item->totalProjectValue;

                    $customerData[] = compact('customer', 'totalPOValue');
                }

                $salesData[] = [
                    'salesName' => $salesName,
                    'customers' => $customerData,
                ];
            }
            $pdf = PDF::loadView('pdf.exportSummaryPoBySales', compact('salesData', 'date_st', 'date_ot', 'sum'));
            // // Mengubah orientasi menjadi lanskap
            $pdf->setPaper('a4');

            //return view('pdf.exportSummaryPoBySales', compact('salesData', 'date_st', 'date_ot', 'sum'));
            return $pdf->download('SALES REPORT – PO RECEIVED PER SALES – SUMMARY.pdf');
            //return $salesData;
        }
    }
    function pmAssigment(Request $request)
    {
        $dataa = Project::with('saless', 'customer', 'pm');
        if ($request->pmId != "#" && $request->pmId) {
            $names = explode(',', $request->pmId);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('pmName', $names);
            }
        }
        if ($request->statuss != "#" && $request->statuss) {
            if ($request->statuss == "progress") {
                $dataa->where('overAllProg', '<', 100);
            } elseif ($request->statuss == "completed") {
                $dataa->where('overAllProg', '=', 100);
            }
        }

        // $data = $dataa->select('sales', DB::raw('SUM(projectValue) as totalProjectValue'))->groupBy('sales')->get();
        $data = $dataa->select('pmName', 'cust_id', 'projectName', 'projectValue', 'overAllProg')->get();
        if ($request->segment(2) == "json_pmAssigment") {
            return DataTables::of($data)
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
                ->rawColumns(['progress'])
                ->toJson();
        }
        if ($request->segment(2) == "exportpmAssigment") {

            $sum = 0;
            foreach ($data as $number) {
                $sum += $number->projectValue;
            }

            $pmData = [];

            // Pengelompokkan berdasarkan sales
            $groupedData = $data->sortBy(['pm.name', 'cust_id'])->groupBy('pmName');

            foreach ($groupedData as $sales => $items) {
                $pmName = $items->first()->pm->name ?? '';

                $customerData = [];

                foreach ($items as $item) {
                    $customer = $item->customer->company ?? '';
                    $projectName = $item->projectName ?? '';
                    $progress =
                        '<div class="d-flex align-items-center">
                    <div class="me-2"> <span>' . $item->overAllProg . '%</span></div>
                        <div class="progress flex-auto" style="height: 6px;">
                            <div class="progress-bar bg-primary " role="progressbar" style="width: ' . $item->overAllProg . '%;" aria-valuenow="' . $item->overAllProg . '" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>';
                    $totalPOValue = $item->projectValue;

                    $customerData[] = compact('customer', 'projectName', 'progress', 'totalPOValue');
                }

                $pmData[] = [
                    'pmName' => $pmName,
                    'customers' => $customerData,
                ];
            }
            $pdf = PDF::loadView('pdf.exportPMAssign', compact('pmData', 'sum'));
            // Mengubah orientasi menjadi lanskap
            $pdf->setPaper('a4');

            //return view('pdf.exportPMAssign', compact('pmData', 'sum'));
            return $pdf->download('PM REPORT – PM ASSIGNMENT – SUMMARY.pdf');
            // return $pmData;
        }
    }

    function planInvhByCustExport(Request $request)
    {
        $st_date = date($request->booking_year . '-01-01');
        $ed_date = date($request->booking_year . '-12-31');
        $dataa = topProject::with('project.memberProject');
        // $dataa->whereHas('topProject', function ($query) use ($request, $st_date, $ed_date) {
        if ($request->booking_year != "#" && $request->booking_year) {
            $dataa->whereDate('bastDate', '>=', $st_date)
                ->whereDate('bastDate', '<=', $ed_date);
        }
        // });

        $data = $dataa->get()
            ->groupBy('project.customer.company');
        // Inisialisasi array bulan
        $months = array();

        // Loop untuk setiap bulan dari tanggal awal ke tanggal akhir
        $current_date = date("Y-m-01", strtotime($st_date));
        while ($current_date <= date("Y-m-01", strtotime($ed_date))) {
            $month = date("F Y", strtotime($current_date));
            $months[] = $month;

            // Tambahkan 1 bulan ke tanggal
            $current_date = date("Y-m-d", strtotime($current_date . ' + 1 month'));
        }
        $result = array();
        $dataMember = array();
        foreach ($data as $custId => $projects) {
            foreach ($projects as $datas) {
                $dataMember[$custId][] = $datas->projectId;
                $result[$custId]['customer'] = $custId;
                $bastDate = date('F-Y', strtotime($datas->bastDate));

                $bastDateTimestamp = date('Y-m-d', strtotime($datas->bastDate));

                if ($bastDateTimestamp >= $st_date && $bastDateTimestamp <= $ed_date) {
                    // Jika belum ada array untuk bulan tersebut, inisialisasi
                    if (!isset($result[$custId]['top'][$bastDate])) {
                        $result[$custId]['top'][$bastDate] = [
                            'month' => $bastDate,
                            'totalValue' => 0,
                        ];
                    }

                    // Akumulasi nilai 'termsValue' per bulan
                    $result[$custId]['top'][$bastDate]['totalValue'] += (int)$datas->termsValuePPN;
                }
            }

            // Mengurutkan array 'top' berdasarkan bulan
            usort($result[$custId]['top'], function ($a, $b) {
                $dateA = strtotime($a['month']);
                $dateB = strtotime($b['month']);

                return $dateA - $dateB;
            });
        }
        foreach ($dataMember as $key => $value) {
            $uniqueValues = array_values(array_unique($value));
            $dataMember[$key] = $uniqueValues;
            $result[$key]['countProject'] = count($uniqueValues);
        }


        if ($request->segment(1) == "planInvhByCustPdf") {
            $pdf = PDF::loadView('pdf.planInvhByCust', compact('result', 'months'), ["year" => $request->booking_year]);
            // Mengubah orientasi menjadi lanskap
            $pdf->setPaper('a4', 'landscape');

            return $pdf->download('Plan Invoice Monthly By Customer.pdf');
        }

        return Excel::download(new planInvhByCustExport($result), 'planInvhByCustExport.xlsx');


        // return view('pdf.planInvhByCust', compact('result', 'months'));
        return $result;
    }
}
