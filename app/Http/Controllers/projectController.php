<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\employee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class projectController extends Controller
{
    public function json()
    {
        $data = Project::with('Customer', 'PM')->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('projectName', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div class="ms-3">
                            <h4 class="mb-0 fs-5"><a href="/project/inputProject/' . $data->id . '" class="text-inherit">' . $data->projectName . '</a></h4>
                        </div>
                    </div>';
            })
            ->addColumn('progress', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div class="me-2"> <span>80%</span></div>
                            <div class="progress flex-auto" style="height: 6px;">
                                <div class="progress-bar bg-primary " role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>';
            })
            ->rawColumns(['projectName', 'progress'])
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
                'noContract' => ['required', 'string', 'max:255'],
                'contractDate' => ['required', 'string', 'max:255'],
                'projectValue' => ['required', 'string', 'max:255'],
                'projectType' => ['required', 'string', 'max:255'],
                'partnerId' => ['required', 'string', 'max:255'],
                'sales' => ['required', 'string', 'max:255'],
                'pmName' => ['required', 'string', 'max:255'],
                'coPm' => ['required', 'string', 'max:255'],
                'contractStart' => ['required', 'string', 'max:255'],
                'contractEnd' => ['required', 'string', 'max:255'],
            ]);

            $post = new Project();
            $post->noProject = $request->noProject;
            $post->cust_id = $request->cust_id;
            $post->customerType = $request->customerType;
            $post->projectName = $request->projectName;
            $post->noContract = $request->noContract;
            $post->contractDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractDate)));
            $post->po = $request->po;
            $post->noPo = $request->noPo;
            $post->datePo = date("Y-m-d", strtotime(str_replace('-', '-', $request->datePo)));
            $post->projectValue = str_replace(".", "", $request->projectValue);
            $post->projectType = $request->projectType;
            $post->partnerId = $request->partnerId;
            $post->sales = $request->sales;
            $post->pmName = $request->pmName;
            $post->coPm = $request->coPm;
            $post->sponsor = implode(",", $request->sponsor);
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
        return view('project/inputProject', ['id' => $id, 'aksi' => "EditData", 'customer' => $customer, 'partner' => $partner, 'employee' => $employee, 'data' => $get]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'Project_id' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'level' => ['required', 'string', 'max:255'],
                'divisi' => ['required', 'string', 'max:255'],
                'company' => ['required', 'string', 'max:255'],
                'direct_manager' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string', 'max:255'],
                'pkwt_start' => ['required', 'string', 'max:255'],
                'pkwt_end' => ['required', 'string', 'max:255'],
                'email_ist' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255'],
            ]);

            $post = Project::find($id);
            $post->Project_id = $request->Project_id;
            $post->name = $request->name;
            $post->ktp = $request->ktp;
            $post->npwp = $request->npwp;
            $post->norek = $request->norek;
            $post->nohp = $request->nohp;
            $post->level = $request->level;
            $post->divisi = $request->divisi;
            $post->company = $request->company;
            $post->penempatan = $request->penempatan;
            $post->direct_manager = $request->direct_manager;
            $post->role = $request->role;
            $post->spesialisasi = $request->spesialisasi;
            $post->pkwt_start = date("Y-m-d", strtotime(str_replace('-', '-', $request->pkwt_start)));
            $post->pkwt_end = date("Y-m-d", strtotime(str_replace('-', '-', $request->pkwt_end)));
            $post->email_ist = $request->email_ist;
            $post->email = $request->email;
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
        $post = Project::find($id);
        $post->delete();

        return response()->json($post);
    }
}
