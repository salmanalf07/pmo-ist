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
                            <h4 class="mb-0 fs-5"><a href="/project/inputProject/' . $data->id . '" class="text-inherit">' . substr($data->projectName, 0, 30) . '</a></h4>
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
