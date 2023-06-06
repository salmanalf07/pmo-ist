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
    public function json(Request $request)
    {
        $dataa = Project::with('customer', 'pm')->orderBy('created_at', 'DESC');

        if ($request->cust_id != "#" && $request->cust_id) {
            $dataa->where('cust_id', $request->cust_id);
        }
        if ($request->pmName != "#" && $request->pmName) {
            $dataa->where('pmName', $request->pmName);
        }

        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('projectNamee', function ($data) {
                return
                    '<div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-0 fs-5"><a href="/project/summaryProject/' . $data->id . '" class="text-inherit">' . substr($data->projectName, 0, 30) . '</a></h4>
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
            ->rawColumns(['projectNamee', 'progress'])
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
            $post->noContract = $request->noContract;
            $post->contractDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->contractDate)));
            $post->po = $request->po;
            $post->noPo = $request->noPo;
            $post->datePo = date("Y-m-d", strtotime(str_replace('-', '-', $request->datePo)));
            $post->dateStPo = date("Y-m-d", strtotime(str_replace('-', '-', $request->dateStPo)));
            $post->dateEdPo = date("Y-m-d", strtotime(str_replace('-', '-', $request->dateEdPo)));
            $post->poValue = str_replace(".", "", $request->poValue);
            $post->projectValue = str_replace(".", "", $request->projectValue);
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
        return view('project/inputProject', ['id' => $id, 'aksi' => "EditData", 'customer' => $customer, 'partner' => $partner, 'employee' => $employee, 'data' => $get]);
    }
    public function destroy($id)
    {
        $post = Project::find($id);
        $post->delete();

        return response()->json($post);
    }
}
