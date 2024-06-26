<?php

namespace App\Http\Controllers;

use App\Exports\allEmployeeExport;
use App\Exports\employByAsanaExport;
use App\Exports\employByAsignExport;
use App\Exports\employByUnasignExport;
use App\Exports\partnerByAsignExport;
use App\Models\asanaSubTask2;
use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\employee;
use App\Models\memberProject;
use App\Models\partnerProject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class employeeController extends Controller
{
    public function json(Request $request)
    {
        $dataa = employee::with('divisi', 'manager', 'department', 'roles', 'typeProjects')->orderBy('created_at', 'DESC');
        // $dataa->where('company', '=', 'PT. Infosys Solusi Terpadu');
        if ($request->typeProject != "#" && $request->typeProject) {
            $dataa->where('typeProject', $request->typeProject);
        }
        // else {
        //     $dataa->where('typeProject', '789ab3ca-7ee5-4504-ad26-cb3290ff77c1');
        // }
        if ($request->location != "#" && $request->location) {
            $dataa->where('penempatan', '=', $request->location);
        }
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
        if ($request->levell != "#" && $request->levell) {
            $dataa->where('level', '=', $request->levell);
        }
        if ($request->special != "#" && $request->special) {
            $dataa->where('spesialisasi', '=', $request->special);
        }
        if ($request->statusFilter != "#" && $request->statusFilter) {
            $dataa->where('status', '=', $request->statusFilter);
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

            if ($request->customer != "#" && $request->customer) {
                $q->where('cust_id', '=', $request->customer);
            }
        });
        if ($request->name != "#" && $request->name) {
            $dataa->where('partner', '=', $request->name);
        }
        if ($request->partnerCorp != "#" && $request->partnerCorp) {
            $dataa->where('partnerCorp', '=', $request->partnerCorp);
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
        $dataa = memberProject::with('project.customer', 'employee.divisi', 'employee.department', 'roles');
        $dataa->whereHas('employee', function ($q) use ($request) {
            $q->where('company', '=', 'PT. Infosys Solusi Terpadu');
            if ($request->directManager && $request->directManager !== '#') {
                $q->where('direct_manager', $request->directManager);
            }
            if ($request->typeProject != "#" && $request->typeProject) {
                $q->where('typeProject', $request->typeProject);
            }
            // else {
            //     $q->where('typeProject', '789ab3ca-7ee5-4504-ad26-cb3290ff77c1');
            // }

            if ($request->status != "#" && $request->status) {
                $q->where('status', $request->status);
            }
            // else {
            //     $q->where('status', "ACTIVE");
            // }
            if ($request->location != "#" && $request->location) {
                $q->where('penempatan', '=', $request->location);
            }
            if ($request->levell != "#" && $request->levell) {
                $q->where('level', '=', $request->levell);
            }
            if ($request->role != "#" && $request->role) {
                $q->where('role', '=', $request->role);
            }
            if ($request->division != "#" && $request->division) {
                $q->where('divisi', '=', $request->division);
            }
            if ($request->department != "#" && $request->department) {
                $q->where('department', '=', $request->department);
            }
        });
        $dataa->whereHas('project', function ($q) use ($request) {
            if ($request->overAllProg != "#" && $request->overAllProg) {
                if ($request->overAllProg == "progress") {
                    $q->where('overAllProg', '<', 100);
                } elseif ($request->overAllProg == "completed") {
                    $q->where('overAllProg', '=', 100);
                }
            }
            if ($request->customer != "#" && $request->customer) {
                $q->where('cust_id', '=', $request->customer);
            }
        });
        // Periksa apakah request memiliki data untuk name
        if ($request->name != "#" && $request->name != null) {
            $names = explode(',', $request->name);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('employee', $names);
            }
        }

        if ($request->projectId != "#" && $request->projectId) {
            $dataa->where('projectId', '=', $request->projectId);
        }
        if ($request->availableAt != "01/01/1900" && $request->availableAt != "#" && $request->availableAt != null) {
            $dataa->whereNotExists(function ($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('member_projects as mp2')
                    ->whereColumn('mp2.employee', '=', 'member_projects.employee')
                    ->where('mp2.endDate', '>', date("Y-m-d", strtotime(str_replace('/', '-', $request->availableAt))));
            });
        }
        if ($request->activeAt != "01/01/1900" && $request->activeAt != "#" && $request->activeAt != null) {
            $dataa->where('endDate', '>', date("Y-m-d",  strtotime(str_replace('/', '-', $request->activeAt))));
        }
        $data = $dataa->get();
        return DataTables::of($data)
            ->toJson();
    }
    function jsonByAsana(Request $request)
    {
        $query = asanaSubTask2::with('assignees', 'section.asanaProject', 'parent.section.asanaProject', 'parent.parent.section.asanaProject')
            ->where('assignee', '!=', null)
            ->where(function ($query) use ($request) {
                if ($request->projectId != "#" && $request->projectId) {
                    $query->whereHas('section.asanaProject', function ($q) use ($request) {
                        $q->where('id', '=', $request->projectId);
                    })
                        ->orWhereHas('parent.section.asanaProject', function ($q)  use ($request) {
                            $q->where('id', '=', $request->projectId);
                        })
                        ->orWhereHas('parent.parent.section.asanaProject', function ($q)  use ($request) {
                            $q->where('id', '=', $request->projectId);
                        });
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->date_st != "#" && $request->date_st) {
                    $query->whereDate('start_on', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                        ->whereDate('start_on', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                } else {
                    $query->whereMonth('start_on', '=', date("m"))
                        ->whereYear('start_on', '=', date("Y"));
                }
            });

        // $data = $query->get();
        return DataTables::eloquent($query)
            ->addColumn('projectName', function ($query) {

                // Cek parent parent section
                if ($query->parent && $query->parent->parent && $query->parent->parent->section && $query->parent->parent->section->asanaProject) {
                    $project = $query->parent->parent->section->asanaProject->projectName;
                }

                // Cek parent section
                if ($query->parent && $query->parent->section && $query->parent->section->asanaProject) {
                    $project = $query->parent->section->asanaProject->projectName;
                }

                // Cek section
                if ($query->section && $query->section->asanaProject) {
                    $project = $query->section->asanaProject->projectName;
                }

                return '<div data-toggle="tooltip" title="' . $project . '">' . mb_substr($project, 0, 20, 'UTF-8')  . '</div>';
            })
            ->addColumn('sectionCol', function ($query) {

                // Cek parent parent section
                if ($query->parent && $query->parent->parent && $query->parent->parent->section) {
                    $section = $query->parent->parent->section->sectionName;
                }

                // Cek parent section
                if ($query->parent && $query->parent->section) {
                    $section = $query->parent->section->sectionName;
                }

                // Cek section
                if ($query->section) {
                    $section = $query->section->sectionName;
                }

                return '<div data-toggle="tooltip" title="' . $section . '">' . mb_substr($section, 0, 20, 'UTF-8')  . '</div>';
            })
            ->addColumn('typeTask', function ($query) {

                // Cek parent parent section
                if ($query->parent && $query->parent->parent && $query->parent->parent->section) {
                    $data = 'Sub Task 2';
                }

                // Cek parent section
                if ($query->parent && $query->parent->section) {
                    $data = 'Sub Task';
                }

                // Cek section
                if ($query->section) {
                    $data = 'Task';
                }

                return '<div data-toggle="tooltip" title="' . $data . '">' . mb_substr($data, 0, 20, 'UTF-8')  . '</div>';
            })
            ->addColumn('taskNames', function ($query) {
                return '<div data-toggle="tooltip" title="' . $query->taskName . '">' . mb_substr($query->taskName, 0, 20, 'UTF-8')  . '</div>';
            })
            ->rawColumns(['projectName', 'sectionCol', 'typeTask', 'taskNames'])
            ->make(true);
    }
    function exportByAssignment(Request $request)
    {
        $dataa = memberProject::with('project.customer', 'employees.divisis', 'employees.departments', 'employees.manager', 'employees.levels', 'employees.roles', 'employees.region', 'employees.specialization', 'employees.typeProjects');
        $dataa->whereHas('employee', function ($q) use ($request) {
            $q->where('company', '=', 'PT. Infosys Solusi Terpadu');
            if ($request->directManagerr && $request->directManagerr != '#') {
                $q->where('direct_manager', $request->directManagerr);
            }
            if ($request->typeProjectt != "#" && $request->typeProjectt) {
                $q->where('typeProject', $request->typeProjectt);
            }
            // else {
            //     $q->where('typeProject', '789ab3ca-7ee5-4504-ad26-cb3290ff77c1');
            // }

            if ($request->statuss != "#" && $request->statuss) {
                $q->where('status', $request->statuss);
            }
            // else {
            //     $q->where('status', "ACTIVE");
            // }
            if ($request->locations != "#" && $request->locations) {
                $q->where('penempatan', '=', $request->locations);
            }
            if ($request->levells != "#" && $request->levells) {
                $q->where('level', '=', $request->levells);
            }
            if ($request->rolee != "#" && $request->rolee) {
                $q->where('role', '=', $request->rolee);
            }
            if ($request->divisions != "#" && $request->divisions) {
                $q->where('divisi', '=', $request->divisions);
            }
            if ($request->departments != "#" && $request->departments) {
                $q->where('department', '=', $request->departments);
            }
        });
        // if ($request->dateChange == "true") {
        //     $dataa->whereDate('endDate', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
        //         ->whereDate('endDate', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        // }
        $dataa->whereHas('project', function ($q) use ($request) {
            if ($request->overAllProgs != "#" && $request->overAllProgs) {
                if ($request->overAllProgs == "progress") {
                    $q->where('overAllProg', '<', 100);
                } elseif ($request->overAllProgs == "completed") {
                    $q->where('overAllProg', '=', 100);
                }
            }
            if ($request->customerr != "#" && $request->customerr) {
                $q->where('cust_id', '=', $request->customerr);
            }
        });
        // Periksa apakah request memiliki data untuk name
        if ($request->namee != "#" && $request->namee != null) {
            $names = explode(',', $request->namee);
            // Periksa apakah 'name' adalah string '#' atau array kosong
            if (is_array($names) && count($names) > 0) {
                // Gunakan whereIn untuk mencocokkan multiple values
                $dataa->whereIn('employee', $names);
            }
        }
        if ($request->projectIdd != "#" && $request->projectIdd) {
            $dataa->where('projectId', '=', $request->projectIdd);
        }
        if ($request->availableAtt != "01/01/1900" && $request->availableAtt != "#" && $request->availableAtt != null) {
            $dataa->whereNotExists(function ($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('member_projects as mp2')
                    ->whereColumn('mp2.employee', '=', 'member_projects.employee')
                    ->where('mp2.endDate', '>', date("Y-m-d", strtotime(str_replace('/', '-', $request->availableAtt))));
            });
        }
        if ($request->activeAtt != "01/01/1900" && $request->activeAtt != "#" && $request->activeAtt != null) {
            $dataa->where('endDate', '>', date("Y-m-d",  strtotime(str_replace('/', '-', $request->activeAtt))));
        }
        $data = $dataa->get();

        //return $data;
        if ($request->segment(1) == "ExportEmpByAsign") {
            return Excel::download(new employByAsignExport($data), 'Employee_By_Assign.xlsx');
        }
        if ($request->segment(1) == "GanttEmpByAsign") {
            $gantt = [];
            $id = 1;
            foreach (collect($data)->sortBy('employees.name') as $item) {
                $gantt[] = [
                    'id' => $id++,
                    'nama' => $item->employees->name,
                    'text' => '',
                    'role' => $item->roles ? $item->roles->roleEmployee : '',
                    'level' => $item->employees->levels ? $item->employees->levels->skillLevel : "",
                    'direct_manager' => $item->employees->manager ? $item->employees->manager->name : "",
                    'customer' => $item->project->customer ? $item->project->customer->company : "",
                    'projectName' => $item->project->projectName,
                    'start_date' => date('d-m-Y', strtotime($item->startDate)),
                    'end_date' => date('d-m-Y', strtotime($item->endDate)),
                ];
            }
            return view('/gantt/emppProject', ['gantt' => $gantt]);
            // return $gantt;
            // return $request->all();
        }
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
        if ($request->typeProject != "#" && $request->typeProject) {
            $dataa->where('typeProject', $request->typeProject);
        }
        // else {
        //     $dataa->where('typeProject', '789ab3ca-7ee5-4504-ad26-cb3290ff77c1');
        // }

        if ($request->status != "#" && $request->status) {
            $dataa->where('status', $request->status);
        }
        if ($request->role != "#" && $request->role) {
            $dataa->where('role', '=', $request->role);
        }
        if ($request->divisii && $request->divisii != '#') {
            $dataa->where('divisi', '=', $request->divisii);
        }
        if ($request->departmentt && $request->departmentt != '#') {
            $dataa->where('department', '=', $request->departmentt);
        }
        if ($request->directManager && $request->directManager != '#') {
            $dataa->where('direct_manager', '=', $request->directManager);
        }
        if ($request->levell != "#" && $request->levell) {
            $dataa->where('level', '=', $request->levell);
        }
        if ($request->location != "#" && $request->location) {
            $dataa->where('penempatan', '=', $request->location);
        }

        $data = $dataa->get();

        return DataTables::of($data)
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => ['required', 'string', 'max:255', Rule::unique('employees')->whereNull('deleted_at')],
                'name' => ['required', 'string', 'max:255'],
            ]);

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
            if ($request->typeProjects != "#") {
                $post->typeProject = $request->typeProjects;
            } else {
                $post->typeProject = "789ab3ca-7ee5-4504-ad26-cb3290ff77c1";
            }
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

            $post = employee::with('memberProject')->find($id);
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
            if ($request->typeProjects != "#") {
                $post->typeProject = $request->typeProjects;
            }
            // else {
            //     $post->typeProject = "789ab3ca-7ee5-4504-ad26-cb3290ff77c1";
            // }
            if ($request->status != "#") {
                $post->status = $request->status;
            }
            // else {
            //     $post->status = "ACTIVE";
            // }
            $post->save();
            if ($request->status == "RESIGN") {
                $post->memberProject()->delete();
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
        $post = employee::with('memberProject')->find($id);
        $post->memberProject()->delete();
        $post->delete();

        $users = User::where('name', $post->id)->first();
        $users->status = "INACTIVE";
        $users->save();

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



    function exportEmpUnassigned(Request $request)
    {
        $dataa = employee::whereDoesntHave('memberProject')->with('divisi', 'department', 'manager', 'levels', 'roles', 'region', 'specialization', 'typeProjects');
        if ($request->typeProjectt != "#" && $request->typeProjectt) {
            $dataa->where('typeProject', $request->typeProjectt);
        }
        // else {
        //     $dataa->where('typeProject', '789ab3ca-7ee5-4504-ad26-cb3290ff77c1');
        // }

        if ($request->statuss != "#" && $request->statuss) {
            $dataa->where('status', $request->statuss);
        }
        if ($request->rolee != "#" && $request->rolee) {
            $dataa->where('role', '=', $request->rolee);
        }
        if ($request->divisi && $request->divisi != '#') {
            $dataa->where('divisi', '=', $request->divisi);
        }
        if ($request->department && $request->department != '#') {
            $dataa->where('department', '=', $request->department);
        }
        if ($request->directManagerr && $request->directManagerr != '#') {
            $dataa->where('direct_manager', '=', $request->directManagerr);
        }
        if ($request->locations != "#" && $request->locations) {
            $dataa->where('penempatan', '=', $request->locations);
        }
        if ($request->levells != "#" && $request->levells) {
            $dataa->where('level', '=', $request->levells);
        }
        $data = $dataa->get();

        //return $data;
        return Excel::download(new employByUnasignExport($data), 'Employee_Unassign.xlsx');
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

            if ($request->customerr != "#" && $request->customerr) {
                $q->where('cust_id', '=', $request->customerr);
            }
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
        $dataa = employee::with('divisis', 'departments', 'manager', 'levels', 'roles', 'region', 'specialization', 'typeProjects');

        if ($request->typeProjectt != "#" && $request->typeProjectt) {
            $dataa->where('typeProject', $request->typeProjectt);
        }
        // else {
        //     $dataa->where('typeProject', '789ab3ca-7ee5-4504-ad26-cb3290ff77c1');
        // }
        if ($request->locations != "#" && $request->locations) {
            $dataa->where('penempatan', '=', $request->locations);
        }
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
        if ($request->levells != "#" && $request->levells) {
            $dataa->where('level', '=', $request->levells);
        }
        if ($request->speciall != "#" && $request->speciall) {
            $dataa->where('spesialisasi', '=', $request->speciall);
        }
        if ($request->statusFilterr != "#" && $request->statusFilterr) {
            $dataa->where('status', '=', $request->statusFilterr);
        }
        $data = $dataa->get();

        //return $data;
        return Excel::download(new allEmployeeExport($data), 'Employee_All_Export.xlsx');
    }

    function exportByAsana(Request $request)
    {
        $query = asanaSubTask2::with('assignees', 'section.asanaProject', 'parent.section.asanaProject', 'parent.parent.section.asanaProject')
            ->where('assignee', '!=', null)
            ->where(function ($query) use ($request) {
                if ($request->projectId != "#" && $request->projectId) {
                    $query->whereHas('section.asanaProject', function ($q) use ($request) {
                        $q->where('id', '=', $request->projectId);
                    })
                        ->orWhereHas('parent.section.asanaProject', function ($q)  use ($request) {
                            $q->where('id', '=', $request->projectId);
                        })
                        ->orWhereHas('parent.parent.section.asanaProject', function ($q)  use ($request) {
                            $q->where('id', '=', $request->projectId);
                        });
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->date_st != "#" && $request->date_st) {
                    $query->whereDate('start_on', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                        ->whereDate('start_on', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
                } else {
                    $query->whereMonth('start_on', '=', date("m"))
                        ->whereYear('start_on', '=', date("Y"));
                }
            });


        $data = $query->get();
        $projectDetail = [];
        foreach ($data as  $project) {

            //Add Projectname
            if ($project->parent && $project->parent->parent && $project->parent->parent->section && $project->parent->parent->section->asanaProject) {
                $projectName = $project->parent->parent->section->asanaProject->projectName;
            }
            if ($project->parent && $project->parent->section && $project->parent->section->asanaProject) {
                $projectName = $project->parent->section->asanaProject->projectName;
            }
            if ($project->section && $project->section->asanaProject) {
                $projectName = $project->section->asanaProject->projectName;
            }
            //Add Projectname


            //Add Section
            if ($project->parent && $project->parent->parent && $project->parent->parent->section) {
                $section = $project->parent->parent->section->sectionName;
            }
            if ($project->parent && $project->parent->section) {
                $section = $project->parent->section->sectionName;
            }
            if ($project->section) {
                $section = $project->section->sectionName;
            }
            //Add Section

            //Add typeTask
            if ($project->parent && $project->parent->parent && $project->parent->parent->section) {
                $typeTask = 'Sub Task 2';
            }
            if ($project->parent && $project->parent->section) {
                $typeTask = 'Sub Task';
            }
            if ($project->section) {
                $typeTask = 'Task';
            }
            $projectDetail[] = [
                'employee' => $project->assignees->name,
                'projectName' => $projectName,
                'section' => $section,
                'typeTask' => $typeTask,
                'takName' => $project->taskName,
                'start_on' => date('d-m-Y', strtotime($project->start_on)),
                'due_on' => date('d-m-Y', strtotime($project->due_on)),
                'status' => $project->status == 1 ? 'Done' : 'Not Done',
            ];
        }
        return Excel::download(new employByAsanaExport($projectDetail), 'Employee_By_Asana.xlsx');
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
