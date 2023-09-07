<?php

namespace App\Http\Controllers;

use App\Exports\allEmployeeExport;
use App\Exports\employByAsignExport;
use App\Exports\partnerByAsignExport;
use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\employee;
use App\Models\memberProject;
use App\Models\partnerProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class employeeController extends Controller
{
    public function json(Request $request)
    {
        $dataa = employee::with('divisi', 'manager', 'department', 'roles')->orderBy('created_at', 'DESC');
        // $dataa->where('company', '=', 'PT. Infosys Solusi Terpadu');
        if ($request->divisii && $request->divisii != '#') {
            $dataa->where('divisi', '=', $request->divisii);
        }
        if ($request->departmentt && $request->departmentt != '#') {
            $dataa->where('department', '=', $request->departmentt);
        }
        if ($request->directManager && $request->directManager != '#') {
            $dataa->where('direct_manager', '=', $request->directManager);
        }
        if ($request->roleFilter && $request->roleFilter != '#') {
            $dataa->where('role', '=', $request->roleFilter);
        }
        if ($request->special != "#" && $request->special) {
            $dataa->where('spesialisasi', '=', $request->special);
        }
        // $dataa->where('status', '=', "ACTIVE");
        $data = $dataa->get();
        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="bi bi-pencil-square"></i></button>
                    <button id="delete" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                    <i class="bi bi-trash"></i></button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    function jsonPartByAssignment(Request $request)
    {
        $dataa = partnerProject::with('project.customer');
        $dataa->whereHas('project', function ($q) use ($request) {
            $q->where('overAllProg', '<', 100);
        });
        if ($request->name != "#" && $request->name) {
            $dataa->where('partner', '=', $request->name);
        }

        if ($request->projectId != "#" && $request->projectId) {
            $dataa->where('projectId', '=', $request->projectId);
        }

        if ($request->role != "#" && $request->role) {
            $dataa->where('rolePartner', '=', $request->role);
        }

        if ($request->availableAt != "01/01/1900" && $request->availableAt) {
            $dataa->where('eddatePartner', '<', date("Y-m-d",  strtotime(str_replace('/', '-', $request->availableAt))));
        } // } else {

        //     $dataa->where('endDate', '>=', date("Y-m-d"));
        // }
        $data = $dataa->get();
        return DataTables::of($data)
            ->toJson();
    }
    function jsonByAssignment(Request $request)
    {
        $dataa = memberProject::with('project.customer', 'employee.divisi', 'employee.department');
        $dataa->whereHas('employee', function ($q) use ($request) {
            $q->where('company', '=', 'PT. Infosys Solusi Terpadu');
            if ($request->role != "#" && $request->role) {
                $q->where('role', '=', $request->role);
            }
        });
        $dataa->whereHas('project', function ($q) use ($request) {
            $q->where('overAllProg', '<', 100);
        });
        // if ($request->dateChange == "true") {
        //     $dataa->whereDate('endDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
        //         ->whereDate('endDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        // }
        if ($request->name != "#" && $request->name) {
            $dataa->where('employee', '=', $request->name);
        }

        if ($request->projectId != "#" && $request->projectId) {
            $dataa->where('projectId', '=', $request->projectId);
        }
        if ($request->availableAt != "01/01/1900" && $request->availableAt) {
            $dataa->where('endDate', '<', date("Y-m-d",  strtotime(str_replace('/', '-', $request->availableAt))));
        } // } else {

        //     $dataa->where('endDate', '>=', date("Y-m-d"));
        // }
        $data = $dataa->get();
        return DataTables::of($data)
            ->toJson();
    }
    function jsonExtResources(Request $request)
    {
        $dataa = memberProject::with('project.customer', 'employee.divisi');
        if ($request->company != "#" && $request->company) {
            $dataa->whereHas('employee', function ($q) use ($request) {
                $q->where([
                    ['company', '!=', 'PT. Infosys Solusi Terpadu'],
                    ['company', '=', $request->company]
                ]);
                if ($request->role != "#" && $request->role) {
                    $q->where('role', '=', $request->role);
                }
            });
        } else {
            $dataa->whereHas('employee', function ($q) {
                $q->where('company', '!=', 'PT. Infosys Solusi Terpadu');
            });
        }

        $data = $dataa->get();
        return DataTables::of($data)
            ->toJson();
    }
    function jsonByUnassigned(Request $request)
    {
        $dataa = employee::whereDoesntHave('memberProject')->with('divisi', 'department', 'manager');
        if ($request->role != "#" && $request->role) {
            $dataa->where('role', '=', $request->role);
        }
        if ($request->divisii && $request->divisii != '#') {
            $dataa->where('divisi', '=', $request->divisii);
        }
        if ($request->departmentt && $request->departmentt != '#') {
            $dataa->where('department', '=', $request->departmentt);
        }

        $data = $dataa->get();

        return DataTables::of($data)
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);
            $record = employee::where('employee_id', $request->employee_id)->first();
            if ($record) {
                $data = [["Employee Id has been registered"], "error"];
                return response($data);
            }
            $post = new employee();
            $post->employee_id = $request->employee_id;
            $post->name = $request->name;
            $post->level = $request->level;
            $post->divisi = $request->divisi;
            $post->company = $request->company;
            $post->department = $request->department;
            $post->penempatan = $request->penempatan;
            $post->direct_manager = $request->direct_manager;
            $post->role = $request->role;
            $post->spesialisasi = $request->spesialisasi;
            if ($request->status != "#") {
                $post->status = $request->status;
            } else {
                $post->status = "ACTIVE";
            }
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
        $get = employee::with('divisi')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'employee_id' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);

            $post = employee::find($id);
            $post->employee_id = $request->employee_id;
            $post->name = $request->name;
            $post->level = $request->level;
            $post->divisi = $request->divisi;
            $post->company = $request->company;
            $post->department = $request->department;
            $post->penempatan = $request->penempatan;
            $post->direct_manager = $request->direct_manager;
            $post->role = $request->role;
            $post->spesialisasi = $request->spesialisasi;
            $post->status = $request->status;
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
        $post = employee::find($id);
        $post->delete();

        return response()->json($post);
    }

    public function getSheetsData(Request $request)
    {
        $data = Sheets::spreadsheet(env('GOOGLE_SHEET_ID'))
            ->sheet('Employee') // Ganti 'Sheet1' dengan rentang yang benar
            ->all();

        //return response()->json($data);
        return view('sheets', compact('data'));
    }

    function exportByAssignment(Request $request)
    {
        $dataa = memberProject::with('project.customer', 'employees.divisis', 'employees.departments', 'employees.manager', 'employees.levels', 'employees.roles', 'employees.region', 'employees.specialization');
        $dataa->whereHas('employee', function ($q) {
            $q->where('company', '=', 'PT. Infosys Solusi Terpadu');
        });
        // if ($request->dateChange == "true") {
        //     $dataa->whereDate('endDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
        //         ->whereDate('endDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        // }
        $dataa->whereHas('project', function ($q) use ($request) {
            $q->where('overAllProg', '<', 100);
        });
        if ($request->namee != "#" && $request->namee) {
            $dataa->where('employee', '=', $request->namee);
        }
        if ($request->projectIdd != "#" && $request->projectIdd) {
            $dataa->where('projectId', '=', $request->projectIdd);
        }
        if ($request->availableAtt != "01/01/1900" && $request->availableAtt) {
            $dataa->where('endDate', '<', date("Y-m-d",  strtotime(str_replace('/', '-', $request->availableAtt))));
        }
        // } else {
        //     $dataa->where('endDate', '>=', date("Y-m-d"));
        // }
        $data = $dataa->get();

        //return $data;
        return Excel::download(new employByAsignExport($data), 'Employee_By_Assign.xlsx');
    }

    function exportPartByAssignment(Request $request)
    {
        $dataa = partnerProject::with('project', 'roles');
        // if ($request->dateChange == "true") {
        //     $dataa->whereDate('endDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
        //         ->whereDate('endDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        // }
        $dataa->whereHas('project', function ($q) use ($request) {
            $q->where('overAllProg', '<', 100);
        });
        if ($request->namee != "#" && $request->namee) {
            $dataa->where('partner', '=', $request->namee);
        }
        if ($request->projectIdd != "#" && $request->projectIdd) {
            $dataa->where('projectId', '=', $request->projectIdd);
        }
        if ($request->availableAtt != "01/01/1900" && $request->availableAtt) {
            $dataa->where('eddatePartner', '<', date("Y-m-d",  strtotime(str_replace('/', '-', $request->availableAtt))));
        }
        // } else {
        //     $dataa->where('endDate', '>=', date("Y-m-d"));
        // }
        $data = $dataa->get();

        //return $data;
        return Excel::download(new partnerByAsignExport($data), 'Partner_By_Assign.xlsx');
    }

    function exportAllEmployee(Request $request)
    {
        $dataa = employee::with('divisis', 'departments', 'manager', 'levels', 'roles', 'region', 'specialization');

        if ($request->divisiii != "#" && $request->divisiii) {
            $dataa->where('divisi', '=', $request->divisiii);
        }
        if ($request->departmenttt != "#" && $request->departmenttt) {
            $dataa->where('department', '=', $request->departmenttt);
        }
        if ($request->directManagerr != "#" && $request->directManagerr) {
            $dataa->where('direct_manager', '=', $request->directManagerr);
        }
        if ($request->roleFilterr && $request->roleFilterr != '#') {
            $dataa->where('role', '=', $request->roleFilterr);
        }
        if ($request->speciall != "#" && $request->speciall) {
            $dataa->where('spesialisasi', '=', $request->speciall);
        }
        $data = $dataa->get();

        //return $data;
        return Excel::download(new allEmployeeExport($data), 'Employee_All_Export.xlsx');
    }

    function chartResource(Request $request)
    {
        $role = employee::with('roles');
        $countRole = $role->count();
        $totalRole = $role->select('role', DB::raw('count(*) as totalRole'))->groupBy('role')->get();

        $resultRole = [];

        // Loop setiap hasil dari kueri $salesRevenue
        if ($request->filter == "#" || $request->filter == "asc") {
            $sort = collect($totalRole)->sortBy('totalRole');
        } else {
            $sort = collect($totalRole)->sortByDesc('totalRole');
        }
        foreach ($sort as $totalRoles) {
            // Membuat array dengan format yang diinginkan
            if ($totalRoles->roles != null) {
                //$level = $totalLevell->levels->skillLevel;
                $resultRole[] = [
                    'name' => $totalRoles->roles->roleEmployee,
                    'persen' => round(($totalRoles->totalRole / $countRole) * 100, 1),
                    'data' => $totalRoles->totalRole,
                    'color' => randomHexColor(),
                ];
            }
        }

        return response()->json($resultRole);
    }
}
