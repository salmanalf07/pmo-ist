<?php

use App\Http\Controllers\AsanaAPIController;
use App\Http\Controllers\categoryOrderController;
use App\Http\Controllers\communityCategory;
use App\Http\Controllers\communityController;
use App\Http\Controllers\communityType;
use App\Http\Controllers\customerController;
use App\Http\Controllers\departmentController;
use App\Http\Controllers\divisionController;
use App\Http\Controllers\DocProjectController;
use App\Http\Controllers\doctypeController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\guideCategory;
use App\Http\Controllers\guideType;
use App\Http\Controllers\highAndNotesController;
use App\Http\Controllers\leesonLearnController;
use App\Http\Controllers\leesonStatusController;
use App\Http\Controllers\logController;
use App\Http\Controllers\memberProjectController;
use App\Http\Controllers\momController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\pipelineController;
use App\Http\Controllers\projBonus;
use App\Http\Controllers\projectController;
use App\Http\Controllers\riskIssuestController;
use App\Http\Controllers\roleEmployee as ControllersRoleEmployee;
use App\Http\Controllers\scopeProjectController;
use App\Http\Controllers\skillLevelController;
use App\Http\Controllers\solutionController;
use App\Http\Controllers\sowController;
use App\Http\Controllers\specializationController;
use App\Http\Controllers\taxController;
use App\Http\Controllers\tempGuideController;
use App\Http\Controllers\timelineController;
use App\Http\Controllers\topProjectController;
use App\Http\Controllers\userController;
use App\Http\Controllers\weeklyReportController;
use App\Models\asanaProject;
use App\Models\community;
use App\Models\communityCategory as ModelsCommunityCategory;
use App\Models\communityType as ModelsCommunityType;
use App\Models\Customer;
use App\Models\department;
use App\Models\division;
use App\Models\docType;
use App\Models\documentationProject;
use App\Models\employee;
use App\Models\guideCategory as ModelsGuideCategory;
use App\Models\guideType as ModelsGuideType;
use App\Models\issuesProject;
use App\Models\leesonStatus;
use App\Models\lessonLearned;
use App\Models\locationEmployee;
use App\Models\memberProject;
use App\Models\mom;
use App\Models\Order;
use App\Models\partnerProject;
use App\Models\pipeline;
use App\Models\Project;
use App\Models\projectSponsor;
use App\Models\roleEmployee;
use App\Models\skillLevel;
use App\Models\solution;
use App\Models\specialization;
use App\Models\tax;
use App\Models\tempAndGuide;
use App\Models\topProject;
use App\Models\typeProject;
use App\Models\weeklyReport;
use Google\Service\CloudSearch\Member;
use Google\Service\Docs\Request;
use Illuminate\Http\Request as RequestData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
//dashboard
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/resourcesDashboard', function () {
        $employeeByDept = employee::with('department')->select('department', DB::raw('COUNT(department) as totalDepartment'))->groupBy('department')->get();
        $projectMember = Project::with('customer', 'memberProject.roles', 'partnerProject.roles')->get();

        // Query untuk mendapatkan data proyek beserta anggota proyek dan peran mereka
        // $projectMember = Project::with('memberProject.roles', 'partnerProject.roles')->get();

        // Inisialisasi array untuk menyimpan rekap jumlah peran (role) di setiap proyek
        $projectRoleCounts = array();

        // Loop melalui data proyek dan anggota proyek
        foreach ($projectMember as $key => $project) {
            // Inisialisasi array untuk menyimpan rekap jumlah peran (role) di proyek saat ini
            $projectRoleCount = array();

            foreach ($project->memberProject as  $member) {
                // Check if the role exists and is an object
                if ($member->role != "#") {
                    $roleEmployee = $member->roles->roleEmployee;
                } else {
                    $roleEmployee = "#";
                }

                // Increment the role count for the current project
                if (isset($projectRoleCount[$roleEmployee])) {
                    $projectRoleCount[$roleEmployee]++;
                } else {
                    $projectRoleCount[$roleEmployee] = 1;
                }
            }

            foreach ($project->partnerProject as  $partner) {
                // Check if the role exists and is an object
                if ($partner->rolePartner != "#") {
                    $roleEmployee = $partner->roles->roleEmployee;
                } else {
                    $roleEmployee = "#";
                }

                // Increment the role count for the current project
                if (isset($projectRoleCount[$roleEmployee])) {
                    $projectRoleCount[$roleEmployee]++;
                } else {
                    $projectRoleCount[$roleEmployee] = 1;
                }
            }

            // Menambahkan informasi tambahan ke dalam array $projectRoleCount
            $projectRoleCount['customerName'] = $project->customer->company;
            $projectRoleCount['totalMembers'] = count($project->memberProject);
            $projectRoleCount['totalPartner'] = count($project->partnerProject);
            $projectRoleCount['projectName'] = $project->projectName;
            $projectRoleCount['projectId'] = $project->id;
            $projectRoleCount['overAllProg'] = $project->overAllProg;

            // Menambahkan rekap jumlah peran (role) di proyek saat ini ke dalam array $projectRoleCounts
            $projectRoleCounts[$key] = $projectRoleCount;
        }

        $totalLevel = employee::with('levels')->select('level', DB::raw('count(*) as totalLevel'))->groupBy('level')->get();

        $resultArray = [];

        // Loop setiap hasil dari kueri $salesRevenue
        foreach ($totalLevel as $totalLevell) {
            // Membuat array dengan format yang diinginkan
            if ($totalLevell->levels != null) {
                if ($totalLevell->levels->skillLevel == "Junior" || $totalLevell->levels->skillLevel == "Middle" || $totalLevell->levels->skillLevel == "Senior") {
                    //$level = $totalLevell->levels->skillLevel;
                    $resultArray[] = [
                        'name' => $totalLevell->levels->skillLevel,
                        'data' => $totalLevell->totalLevel,
                    ];
                }
            }
        }

        $role = employee::with('roles');
        $countRole = $role->count();
        $totalRole = $role->select('role', DB::raw('count(*) as totalRole'))->groupBy('role')->get();

        $resultRole = [];

        // Loop setiap hasil dari kueri $salesRevenue
        foreach ($totalRole as $totalRoles) {
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

        $totalRegion = employee::with('region')->select('penempatan', DB::raw('count(*) as totalregion'))->groupBy('penempatan')->get();
        return view('/dashboard/resourcesDashboard', ['employeeByDept' => $employeeByDept, 'projectMember' => $projectRoleCounts, 'totalLevel' => collect($resultArray)->sortBy('name')->values(), 'totalRole' => $resultRole, 'totalRegion' => $totalRegion]);
        //return collect($resultArray)->sortBy('name')->values();
    })->name('resourcesDashboard');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/get_chart_resource', [employeeController::class, 'chartResource']);
//end Dashboard
//PMO
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/profile', function () {
        $project = Project::with('pm')->where('overAllProg', '<', 100)->get()->sortBy('pm.name')->groupBy('pm.name');
        $data = [];
        foreach ($project as $pmName => $projects) {
            $projectValue = 0; // Inisialisasi ulang variabel $projectValue di setiap iterasi
            foreach ($projects as $projectData) {
                $projectValue += floatval($projectData->projectValue);
            }
            $data[] = [
                'name' => $pmName,
                'countProject' => count($projects),
                'valueProject' => $projectValue,
            ];
        }

        //return $data;
        return view('/profiles/profile', ['project' => $project, 'data' => $data]);
    })->name('profile');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/detail_pm', [projectController::class, 'detail_pm']);
    Route::get('/projectMethod', function () {
        return view('/profiles/projectMethod');
    })->name('projectMethod');
    Route::get('/tempGuide', function () {
        $tempGuide = tempAndGuide::with('categorys', 'types')->get()->sortBy('documentName');
        $typeId = ModelsGuideType::get()->sortBy('type');
        $category = ModelsGuideCategory::get()->sortBy('categori');

        return view('/profiles/tempGuide', ['tempGuide' => $tempGuide, 'category' => $category, 'typeId' => $typeId]);
    })->name('tempGuide');
    Route::get('/lessonLearned', function () {
        $leesonLearned = lessonLearned::with('statuss', 'pmNames')->get()->sortBy('pmNames.name');

        return view('/profiles/lessonLearned', ['leesonLearned' => $leesonLearned]);
    })->name('lessonLearned');
    Route::get('/linkComunity', function () {
        $community = community::with('categorys', 'types')->get();
        $category = ModelsCommunityCategory::get();

        return view('/profiles/linkComunity', ['community' => $community, 'category' => $category]);
    })->name('linkComunity');
});
//end profile
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::post('/get_executive_dashboard/{year}', function ($year) {

        if ($year != "#") {
            $years = $year;
        } else {
            $years = date('Y');
        }
        $kamus = [
            [
                "key" => "BankingNFinancialServicesIndustry",
                "value" => "Banking & Financial Services Industry",
            ],
            [
                "key" => "bumn",
                "value" => "BUMN",
            ],
            [
                "key" => "government",
                "value" => "Government",
            ],
            [
                "key" => "swasta",
                "value" => "Swasta",
            ],
        ];

        $projectOnGoing = Project::where('overAllProg', '<', 100)->count();
        $projectThisYear = Project::whereYear('contractDate', '=', $years)->count();
        $PotensialRevenue = topProject::whereYear('bastDate', '=', $years)->sum('termsValuePPN');
        $RevenueNewPo = Project::whereYear('contractDate', '=', $years)->sum('projectValuePPN');
        $invoiced = topProject::where('invMain', '=', 1)->whereYear('invDate', '=', $years)->sum('termsValuePPN');
        $projectByValue = Project::with('customer')->whereYear('contractDate', '=', $years)->orderByRaw('CONVERT(projectValuePPN, SIGNED) desc')->get();
        $salesRevenue = Project::with('saless')->select('sales', DB::raw('SUM(projectValuePPN) as totalRevenue'))->whereYear('contractDate', '=', $years)->groupBy('sales')->get();
        // Inisialisasi array hasil konversi
        $resultArray = [];

        // Loop setiap hasil dari kueri $salesRevenue
        foreach ($salesRevenue as $salesData) {
            // Membuat array dengan format yang diinginkan
            if ($salesData->saless != null) {
                $sales = $salesData->saless->name;
            } else {
                $sales = '';
            }
            $resultArray[] = [
                'name' => $sales,
                'initial' => getInitials($sales),
                'data' => round($salesData->totalRevenue / 1000000, 1),
                'revenue' => $salesData->totalRevenue
            ];
        }
        $custTypeRevenue = Project::select('customerType', DB::raw('SUM(projectValuePPN) as totalRevenue'))->whereYear('contractDate', '=', $years)->groupBy('customerType')->get();
        // Loop setiap hasil dari kueri $salesRevenue
        $resultCustTypeRevenue = [];
        foreach ($custTypeRevenue as $custTypeRevenuee) {

            $resultCustTypeRevenue[] = [
                'customerType' => vlookupInKamus($custTypeRevenuee->customerType, $kamus),
                'totalRevenue' => formatAngka($custTypeRevenuee->totalRevenue),
            ];
        }
        $summaryCustomer = Project::select(DB::raw('YEAR(contractDate) as year'), DB::raw('COUNT(DISTINCT cust_id) as unique_customers'))
            ->whereRaw('YEAR(contractDate) >= ?', [$years - 2])
            ->whereRaw('YEAR(contractDate) <= ?', [$years])
            ->groupBy('year')
            ->get();

        if ($years != date('Y')) {
            $month = 12;
        } else {
            $month = date('m');
        }
        $invByMonth = topProject::select(DB::raw('MONTH(invDate)'), DB::raw('SUM(termsValuePPN) as totalRevenue'))->where('invMain', '=', 1)->whereYear('invDate', '=', $years)->groupBy(DB::raw('MONTH(invDate)'))->get();
        $resultInvByMonth = [];
        for ($i = 0; $i <= ($month - 1); $i++) {
            if (isset($invByMonth[$i]['MONTH(invDate)']) && $invByMonth[$i]['MONTH(invDate)'] == $i + 1) {
                $resultInvByMonth[] = [
                    'MONTH(invDate)' => $i + 1,
                    'totalRevenue' => $invByMonth[$i]['totalRevenue'],
                ];
            } else {
                $resultInvByMonth[] = [
                    'MONTH(invDate)' => $i + 1,
                    'totalRevenue' => 0,
                ];
            }
        }
        $payByMonth = topProject::select(DB::raw('MONTH(payDate)'), DB::raw('SUM(termsValuePPN) as totalpayRevenue'))->where('payMain', '=', 1)->whereYear('payDate', '=', $years)->groupBy(DB::raw('MONTH(payDate)'))->get();
        $resultPayByMonth = [];
        for ($i = 0; $i <= ($month - 1); $i++) {
            if (isset($payByMonth[$i]['MONTH(payDate)']) && $payByMonth[$i]['MONTH(payDate)'] == $i + 1) {
                $resultPayByMonth[] = [
                    'MONTH(payDate)' => $i + 1,
                    'totalpayRevenue' => $payByMonth[$i]['totalpayRevenue'],
                ];
            } else {
                $resultPayByMonth[] = [
                    'MONTH(payDate)' => $i + 1,
                    'totalpayRevenue' => 0,
                ];
            }
        }

        return response()->json(['projectOnGoing' => $projectOnGoing, 'projectThisYear' => $projectThisYear, 'PotensialRevenue' => formatAngka($PotensialRevenue), 'invoiced' => formatAngka($invoiced), 'RevenueNewPo' => formatAngka($RevenueNewPo), 'projectByValue' => $projectByValue, 'salesRevenue' => $resultArray, 'custTypeRevenue' => $resultCustTypeRevenue, 'invByMonth' => $resultInvByMonth, 'payByMonth' => $resultPayByMonth, 'summaryCustomer' => $summaryCustomer]);
    })->name('get_executive_dashboard');
    Route::get('/dashboard', function () {

        return view('dashboard');
        //return $resultPayByMonth;
    })->name('dashboard');
    Route::post('/detailProjectDetail', function (RequestData $request) {
        $getData = Project::with('customer');
        if ($request->filter == "projectOnGoing") {
            $data = $getData->where('overAllProg', '<', 100)->get();
        }
        if ($request->filter == "projectThisYear") {
            $data = $getData->whereYear('contractDate', '=', $request->year)->get();
        }
        return response()->json($data);
    });
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/projectDashboard', function () {
        $projectOnGoing = Project::where('overAllProg', '<', 100)->count();
        $salesRevenue = Project::with('pm')->select('pmName', DB::raw('count(*) as totalProject'), DB::raw('SUM(projectValuePPN) as totalRevenue'))->where('overAllProg', '<', 100)->groupBy('pmName')->get();

        $numberOfProject = [];

        // Loop setiap hasil dari kueri $salesRevenue
        foreach ($salesRevenue as $salesData) {
            // Membuat array dengan format yang diinginkan
            if ($salesData->pm != null) {
                $sales = $salesData->pm->name;
            } else {
                $sales = '';
            }
            $numberOfProject[] = [
                'name' => $sales,
                'numberOfProject' => $salesData->totalProject,
                'persen' => round(($salesData->totalProject / $projectOnGoing) * 100, 1),
                'revenue' => $salesData->totalRevenue
            ];
        }
        $pm = project::with('pm')->select('pmName')->get();

        return view('/dashboard/projectDashboard', ['numberOfProject' => $numberOfProject, 'pm' => $pm]);
        //return $projectDetail;
    })->name('projectDashboard');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_projectDetail', [projectController::class, 'json_projectDetail']);
//employe
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/employee', function () {
        $divisi = division::get();
        $department = department::get();
        $employee = employee::get();
        $location = locationEmployee::get();
        $specialization = specialization::get();
        $role = roleEmployee::get();
        $skill = skillLevel::get();
        $typeProject = typeProject::get();
        return view('employee/employee', ['judul' => "All Employee", 'skill' => $skill, 'role' => $role, 'specialization' => $specialization, 'location' => $location, 'divisi' => $divisi, 'department' => $department, 'employee' => $employee, 'typeProject' => $typeProject]);
    })->name('employees');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/exportAllEmpl', [employeeController::class, 'exportAllEmployee']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/empByAssignment', function () {
        $employee = employee::get();
        $project = Project::get();
        $role = roleEmployee::get();
        $typeProject = typeProject::get();
        $customer = Customer::get();
        $skill = skillLevel::get();
        $location = locationEmployee::get();
        $department = department::get();
        $division = division::get();
        return view('employee/byAssignment', ['judul' => "By Assignment", 'employee' => $employee, 'project' => $project, 'role' => $role, 'typeProject' => $typeProject, 'customer' => $customer, 'location' => $location, 'skill' => $skill, 'department' => $department, 'division' => $division]);
    })->name('empByAssignment');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/partByAssignment', function () {
        $employee = partnerProject::get();
        $project = Project::get();
        $role = roleEmployee::get();
        $customer = Customer::get();
        return view('employee/partnerByAssignment', ['judul' => "By Assignment", 'employee' => $employee, 'project' => $project, 'role' => $role, 'customer' => $customer]);
    })->name('partByAssignment');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/ExportPartByAsign', [employeeController::class, 'exportPartByAssignment']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/empExtResources', function () {
        $employee = employee::get();
        $company = employee::get();
        return view('employee/extResources', ['judul' => "External Resources", 'employee' => $employee, 'company' => $company]);
    })->name('empExtResources');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/empByUnassigned', function () {
        $divisi = division::get();
        $department = department::get();
        $employee = employee::get();
        $role = roleEmployee::get();
        $typeProject = typeProject::get();
        $skill = skillLevel::get();
        $location = locationEmployee::get();
        return view('employee/byUnassigned', ['judul' => "By Unassigned", 'divisi' => $divisi, 'department' => $department, 'employee' => $employee, 'role' => $role, 'typeProject' => $typeProject, 'location' => $location, 'skill' => $skill]);
    })->name('empByUnassigned');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/ExportEmpUnassigned', [employeeController::class, 'exportEmpUnassigned']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_employee', [employeeController::class, 'json']);
//byAssign
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_ByAssignment', [employeeController::class, 'jsonByAssignment']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/ExportEmpByAsign', [employeeController::class, 'exportByAssignment']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/GanttEmpByAsign', [employeeController::class, 'exportByAssignment']);
//byAssign
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_partByAssignment', [employeeController::class, 'jsonPartByAssignment']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_ExtResources', [employeeController::class, 'jsonExtResources']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_ByUnassigned', [employeeController::class, 'jsonByUnassigned']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_employee', [employeeController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_employee', [employeeController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_employee/{id}', [employeeController::class, 'update']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_employee/{id}', [employeeController::class, 'destroy']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/search_employee', [employeeController::class, 'edit']);
//project list
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectInfo', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        $pm = project::with('pm')->select('pmName')->get();
        $sales = Project::with('saless')->select('sales')->get();
        $sponsors = projectSponsor::with('employee')->get();
        return view('project/projectInfo', ['judul' => "Project All", 'customer' => $customer, 'employee' => $employee, 'pm' => $pm, 'sales' => $sales, 'sponsors' => $sponsors]);
        // return $pm;
    })->name('projectInfo');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectInfoByDate', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        $pm = project::with('pm')->select('pmName')->get();
        return view('project/projectInfoByDate', ['judul' => "Project By Date", 'customer' => $customer, 'employee' => $employee, 'pm' => $pm]);
    })->name('projectInfoByDate');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectByMainCon', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        $pm = project::with('pm')->select('pmName')->get();
        $mainContract = project::select('noPo')->where('noPo', '!=', null)->get();
        return view('project/projectByMainCon', ['judul' => "Project By Main Contract", 'customer' => $customer, 'employee' => $employee, 'pm' => $pm, 'mainContract' => $mainContract]);
    })->name('projectByMainCon');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_projMainCon', [projectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_project', [projectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->delete('/delete_project/{id}', [projectController::class, 'destroy']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/ExportProjByMain', [projectController::class, 'ExportProjByMain']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/projInfoByDateExport', [projectController::class, 'json']);
//summarry
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/summaryProject/{id}', function ($id) {

        $dataa = Project::where('id', $id);
        if (Auth::user()->hasRole('PM')) {
            $dataa->where(function ($query) {
                $query->where('pmName', Auth::user()->name)
                    ->orWhere('coPm', Auth::user()->name);
            });
        }
        $data = $dataa->first();
        if (!$data) {
            return view('/error', ['exception' => 'Project Not Allowed Access']);
        }
        $sumInv = topProject::where([
            ['projectId', '=', $id],
            ['invMain', '=', 1]
        ])->sum('termsValue');
        if ($sumInv > 0) {
            $invoiced = ($sumInv / $data->projectValue) * 100;
        } else {
            $invoiced = 0;
        }
        $sumPay = topProject::where([
            ['projectId', '=', $id],
            ['payMain', '=', 1]
        ])->sum('termsValue');
        if ($sumPay > 0) {
            $payment = ($sumPay / $data->projectValue) * 100;
        } else {
            $payment = 0;
        }
        $issueStopeer = issuesProject::where([
            ['projectId', '=', $id]
        ]);
        $issue = $issueStopeer->where('issuesOwner', 'Issue')->count('issuesOwner');
        $Stopper = $issueStopeer->where('issuesOwner', 'Stopper')->count('issuesOwner');

        if ($data->overAllProg == 0) {
            $color = "text-secondary";
            $status = "Not Yet Started";
        } elseif ($data->overAllProg > 0 && $data->overAllProg < 100 && $issue == 0 && $Stopper == 0) {
            $color = "text-succes";
            $status = "In Progress";
        } elseif ($data->overAllProg > 0 && $data->overAllProg < 100 && $issue > 0 && $Stopper == 0) {
            $color = "text-warning";
            $status = "In Progress with Issue(s)";
        } elseif ($data->overAllProg > 0 && $data->overAllProg < 100 && $issue > 0 && $Stopper > 0) {
            $color = "text-danger";
            $status = "In Progress with Stopper(s)";
        } elseif ($data->overAllProg == 100) {
            $color = "text-primary";
            $status = "Completed";
        } else {
            $color = "text-dark";
            $status = "Not Yet Started";
        }

        $employee = memberProject::with('employees')->where('projectId', '=', $id)->get();
        // dd($employee);
        return view('project/summaryProject', ['judul' => "Project", 'id' => $id, 'data' => $data, 'invoiced' => round($invoiced, 0), 'payment' =>  round($payment, 0), 'color' => $color, 'status' => $status, 'employee' => $employee->take(5), 'employeeCount' => count($employee) - 5]);
        //return $invoiced;
    })->name('summaryProject');
});
//projectinfo
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM|Finance|Sales'])->group(function () {
    Route::get('/project/inputProject', function () {
        $project = Project::select('noProject')->latest()->first();
        if (!$project) {
            $noProject = 1;
        } else {
            $noProject = $project->noProject + 1;
        }
        $customer = Customer::where('type', 'customer')->get();
        $partner = Customer::where('type', 'partner')->get();
        $employee = employee::get();
        $solution = solution::get();
        return view('project/inputProject', ['judul' => "Project", 'customer' => $customer, 'partner' => $partner, 'employee' => $employee, 'noProject' => $noProject, 'solution' => $solution]);
    })->name('inputProject');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_project', [projectController::class, 'store']);
//Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM|Finance|BOD'])->get('/project/inputProject/{id}', [projectController::class, 'edit'])->name('editProject');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/inputProject/{id}', [projectController::class, 'edit'])->name('editProject');
//Detail Order
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/detailOrder/{id}', [orderController::class, 'edit'])->name('detailOrder');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_detailOrder/{id}', [orderController::class, 'store'])->name('storeOrder');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->delete('/delete_detailOrder/{id}', [orderController::class, 'destroy'])->name('deleteOrder');
//TOP
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/top/{id}', [topProjectController::class, 'edit'])->name('top');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM|Finance'])->post('/store_top/{id}', [topProjectController::class, 'store'])->name('storeTop');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->delete('/delete_top/{id}', [topProjectController::class, 'destroy'])->name('deleteTop');
//Project Member
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/projectMember/{id}', function ($id) {
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
    return view('project/projectMemberDashboard', ['judul' => "Project Member", 'id' => $id, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName,]);
})->name('projectMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/json_projectMember/{id}', [memberProjectController::class, 'edit'])->name('json_projectMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|memberProject-editor'])->get('/project/changeProjMember/{id}', [memberProjectController::class, 'edit'])->name('changeProjMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|memberProject-editor'])->post('/store_projectMember/{id}', [memberProjectController::class, 'store'])->name('storeProjectMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|memberProject-editor'])->post('/store_autoMember/{id}', [memberProjectController::class, 'autoSave'])->name('storeAutoMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|memberProject-editor'])->delete('/delete_projectMember/{id}', [memberProjectController::class, 'destroy'])->name('deleteMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|memberProject-editor'])->delete('/delete_projectPartner/{id}', [memberProjectController::class, 'destroyPartner'])->name('deletePartner');
//TimeLine
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/projectTimeline/{id}', function ($id) {
    $file = documentationProject::where('projectId', $id)->where('type', 'TIMELINE')->get();
    $dataa = Project::with('customer')->where('id', $id);
    $getProjectAsana = asanaProject::where('projectId', null)->get();
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
    return view('project/projectTimelineDashboard', ['judul' => "Project Timeline", 'id' => $id, 'file' => $file, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName, 'getProjectAsana' => $getProjectAsana]);
})->name('projectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/json_projectTimeline/{id}', [timelineController::class, 'edit'])->name('json_projectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->get('/project/changeprojectTimeline/{id}', [timelineController::class, 'edit'])->name('projectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_projectTimeline/{id}', [timelineController::class, 'store'])->name('storeprojectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_connectProject/{id}', [timelineController::class, 'connectProject'])->name('storeconnectProject');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->delete('/delete_projectTimeline/{id}', [timelineController::class, 'destroy'])->name('deleteprojectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->delete('/disconnect_project/{id}', [timelineController::class, 'disconnectProject'])->name('disconnectProject');
//riskIssues
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/riskIssues/{id}', function ($id) {
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
    return view('project/riskIssuesDashboard', ['judul' => "Risk/Issues", 'id' => $id,  'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName,]);
})->name('riskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/json_riskIssues/{id}', [riskIssuestController::class, 'edit'])->name('json_riskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->get('/project/changeriskIssues/{id}', [riskIssuestController::class, 'edit'])->name('changeriskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_riskIssues/{id}', [riskIssuestController::class, 'store'])->name('storeRiskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->delete('/delete_projectMember/{table}/{id}', [riskIssuestController::class, 'destroy'])->name('deleteIssues');
//SOW
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/sow/{id}', [sowController::class, 'edit'])->name('projectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_sow/{id}', [sowController::class, 'store'])->name('storeSow');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->delete('/delete_projectSow/{table}/{id}', [sowController::class, 'destroy'])->name('deleteSow');
//mandays
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/mandays/{id}', function ($id) {
        return view('project/mandays', ['judul' => "Project", 'id' => $id]);
    })->name('mandays');
});
//Documentation Project
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/documentation/{id}', function ($id) {
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
        $doc = docType::get();
        return view('project/documentation', ['judul' => "Documentation", 'id' => $id, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName, 'doc' => $doc]);
    })->name('documentation');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_documentation/{id}', [DocProjectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_documentation/{id}', [DocProjectController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/edit_documentation/{id}', [DocProjectController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/update_documentation/{id}', [DocProjectController::class, 'update']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->delete('/delete_documentation/{id}', [DocProjectController::class, 'destroy']);
//Project Costing
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/costing/{id}', [projBonus::class, 'edit'])->name('projectCosting');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->post('/store_costing/{id}', [projBonus::class, 'store'])->name('storeCosting');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->delete('/delete_projectCosting/{id}', [projBonus::class, 'destroy_costing']);
//Project Highlight And Notes

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/highAndNotes/{id}', function ($id) {
    $project = Project::with('customer')->find($id);
    return view('project/highAndNotes', ['id' => $id, 'judul' => "Highlight And Notes", 'header' => $project->customer->company . ' - ' . $project->noContract . ' - ' . $project->projectName,]);
})->name('highAndNotes');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_highAndNotes/{id}', [highAndNotesController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/store_highAndNotes', [highAndNotesController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/edit_highAndNotes', [highAndNotesController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->post('/update_highAndNotes/{id}', [highAndNotesController::class, 'update']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|PM'])->delete('/delete_highAndNotes/{id}', [highAndNotesController::class, 'destroy']);
//MOM
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/moms/{id}', function ($id) {
    $dataa = Project::with('customer')->where('id', $id);
    if (Auth::user()->hasRole('PM')) {
        $dataa->where(function ($query) {
            $query->where('pmName', Auth::user()->name)
                ->orWhere('coPm', Auth::user()->name);
        });
    }
    $project = $dataa->first();
    if (!$project) {
        return view('/error', ['exception' => 'Project Not Allowed Access']);
    }
    return view('project/moms', ['id' => $id, 'judul' => "MOM", 'header' => $project->customer->company . ' - ' . $project->noContract . ' - ' . $project->projectName,]);
})->name('moms');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get(
    '/project/formMoms/{id}',
    [momController::class, 'edit']
)->name('formMoms');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_moms/{id}', [momController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_quill', [momController::class, 'store_quill']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/meeting_information/{id}', [momController::class, 'meeting_information']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/meeting_fu/{id}', [momController::class, 'meeting_fu']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/editMom/{id}', [momController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_participant/{id}', [momController::class, 'deleteParticipant']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_moms/{id}', [momController::class, 'deleteMom']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/exportPdf/{id}', [momController::class, 'exportMom']);
//WEEKLY REPORT
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->get('/project/weekly_report/{id}', function ($id) {
    $dataa = Project::with('customer')->where('id', $id);
    if (Auth::user()->hasRole('PM')) {
        $dataa->where(function ($query) {
            $query->where('pmName', Auth::user()->name)
                ->orWhere('coPm', Auth::user()->name);
        });
    }
    $project = $dataa->first();
    if (!$project) {
        return view('/error', ['exception' => 'Project Not Allowed Access']);
    }
    return view('project/weeklyReport', ['id' => $id, 'judul' => "MOM", 'header' => $project->customer->company . ' - ' . $project->noContract . ' - ' . $project->projectName,]);
})->name('weekly_report');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->get(
    '/project/formWeeklyReport/{id}',
    [weeklyReportController::class, 'edit']
)->name('formWeeklyReport');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_weeklyReport/{id}', [weeklyReportController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/project_information/{id}', [weeklyReportController::class, 'meeting_information']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->get('/editWeeklyReport/{id}', [weeklyReportController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/storeMilestone/{id}', [weeklyReportController::class, 'storeMilestone']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/storeWeekRisk/{id}', [weeklyReportController::class, 'storeWeekRisk']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/storeWeekIssue/{id}', [weeklyReportController::class, 'storeWeekIssue']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/storeProjectProgress', [weeklyReportController::class, 'storeProjectProgress']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_weeklyReport/{id}', [weeklyReportController::class, 'destroy']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/exportWeeklyReport/{id}', [weeklyReportController::class, 'exportWeekly']);
//gantt Cart
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/gantt_cart/{id}', function ($id) {
    $member = memberProject::with('employees.manager', 'employees.levels', 'roles', 'project.customer')->where('projectId', $id)->get();

    $gantt = [];
    $idd = 1;
    foreach ($member as $item) {
        $gantt[] = [
            'id' => $idd++,
            'name' => $item->employees->name,
            'text' => $item->roles ? $item->roles->roleEmployee : "",
            'role' => $item->roles ? $item->roles->roleEmployee : "",
            'level' => $item->employees->levels ? $item->employees->levels->skillLevel : "",
            'direct_manager' => $item->employees->manager ? $item->employees->manager->name : "",
            'customer' => $item->project->customer ? $item->project->customer->company : "",
            'start_date' => date('d-m-Y', strtotime($item->startDate)),
            'end_date' => date('d-m-Y', strtotime($item->endDate)),
        ];
    }
    return view('project/ganttCart', ['id' => $id, 'gantt' => $gantt]);
    // return $gantt;
})->name('gantt_cart');
//Finance
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeInfo', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('finance/financeInfo', ['judul' => "Finance Info", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeInfo');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeTermsStat', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = Project::with('saless')->select('sales')->get();

        return view('finance/financeTermsStat', ['judul' => "Term Status", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeTermsStat');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeByInvoice', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('finance/financeByInvoice', ['judul' => "By Invoice", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeByInvoice');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeByPayment', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('finance/financeByPayment', ['judul' => "By Payment", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeByPayment');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_finance', [topProjectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_financeByInvoice', [topProjectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_financeByPayment', [topProjectController::class, 'json']);
//end Finance
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/pipeline', [pipelineController::class, 'index'])->name('pipeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_pipeline', [pipelineController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_pipeline', [pipelineController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_pipeline/{id}', [pipelineController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_pipeline/{id}', [pipelineController::class, 'destroy']);
//end pipeline
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeReport', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('report/financeReport', ['judul' => "Finance", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeReport');
});


//Report
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/financeExport', [topProjectController::class, 'financeExport']);
//r_allProject
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/r_allProject', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        $spk = project::select('noContract')->distinct()->get();
        $sponsors = projectSponsor::with('employee')->get();
        return view('report/r_allProject', ['judul' => "Report All Project", 'customer' => $customer, 'employee' => $employee, 'spk' => $spk, 'sponsors' => $sponsors]);
    })->name('r_allProject');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/allProjectExport', [projectController::class, 'allProjectExport']);
//r_projectClose
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/r_projectClose', function () {
        $customer = Customer::where('type', 'customer')->get();
        $pm = Project::with('pm')->select('pmName')->get();
        $employee = employee::get();
        return view('report/r_projectClose', ['judul' => "Report Close Project", 'customer' => $customer, 'employee' => $employee, 'pm' => $pm]);
    })->name('r_projectClose');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/closeProjectExport', [projectController::class, 'closeProjectExport']);
//r_invByMonth
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/r_invByMonth', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('report/r_invByMonth', ['judul' => "Report Invoice By Month", 'customer' => $customer, 'employee' => $employee,]);
    })->name('r_invByMonth');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/invByMonthExport', [projectController::class, 'invByMonthExport']);
//r_planInvhByCust
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/r_planInvhByCust', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('report/r_planInvhByCust', ['judul' => "Plan Invoice Monthly By Customer", 'customer' => $customer, 'employee' => $employee,]);
    })->name('r_planInvhByCust');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/planInvhByCustExport', [projectController::class, 'planInvhByCustExport']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/planInvhByCustPdf', [projectController::class, 'planInvhByCustExport']);
//r_statPayment
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/r_statPayment', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('report/r_statPayment', ['judul' => "Report Status Payment", 'customer' => $customer, 'employee' => $employee,]);
    })->name('r_statPayment');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/statPaymentExport', [projectController::class, 'statPaymentExport']);
//r_planBast
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm|BOD'])->group(function () {
    Route::get('/r_planBast', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('report/r_planBast', ['judul' => "Report Plan BAST", 'customer' => $customer, 'employee' => $employee,]);
    })->name('r_planBast');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/pdfPlanBAST', [topProjectController::class, 'pdfPlanBAST']);
//SALES
Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified'], 'prefix' => 'r_sales'], function () {
    Route::get('/detailPoBySales', function () {
        $employee = Project::with('saless')->select('sales')->get();
        return view('report/sales/detailPoBySales', ['judul' => "PO RECEIVED PER SALES – DETAIL", 'employee' => $employee,]);
        //return $employee;
    })->name('detailPoBySales');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_detailPoBySales', [projectController::class, 'detailPoBySales']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/exportDetailPoBySales', [projectController::class, 'detailPoBySales']);
    Route::get('/summaryPoBySales', function () {
        $employee = Project::with('saless')->select('sales')->get();
        return view('report/sales/summaryPoBySales', ['judul' => "PO RECEIVED PER SALES – SUMMARY", 'employee' => $employee,]);
        //return $employee;
    })->name('summaryPoBySales');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_summaryPoBySales', [projectController::class, 'summaryPoBySales']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/exportSummaryPoBySales', [projectController::class, 'summaryPoBySales']);
    Route::get('/invoiceStatusSalesDetail', function () {
        $employee = Project::with('saless')->select('sales')->get();
        return view('report/sales/invoiceStatusSalesDetail', ['judul' => "INVOICE STATUS PER PO PER SALES – DETAIL", 'employee' => $employee,]);
        //return $employee;
    })->name('invoiceStatusSalesDetail');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_invoiceStatusSalesDetail', [topProjectController::class, 'invoiceStatusSalesDetail']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/exportInvoiceStatusSalesDetail', [topProjectController::class, 'invoiceStatusSalesDetail']);

    Route::get('/invoiceProgressPerSales', function () {
        $employee = Project::with('saless')->select('sales')->get();
        return view('report/sales/invoiceProgressPerSales', ['judul' => "Invoice Progress per PO Per Sales", 'employee' => $employee,]);
        //return $employee;
    })->name('invoiceProgressPerSales');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_invoiceProgressPerSales', [topProjectController::class, 'invoiceProgressPerSales']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/exportInvoiceProgressPerSales', [topProjectController::class, 'invoiceProgressPerSales']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/exportInvoiceSummaryPerSales', [topProjectController::class, 'invoiceSummaryPerSales']);
});
//END SALES
//PM
Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified'], 'prefix' => 'r_pm'], function () {
    Route::get('/pmAssigment', function () {
        $employee = Project::with('pm')->select('pmName')->get();
        return view('report/pm/pmAssigment', ['judul' => "PM Assignment – SUMMARY", 'employee' => $employee,]);
        //return $employee;
    })->name('pmAssigment');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_pmAssigment', [projectController::class, 'pmAssigment']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/exportpmAssigment', [projectController::class, 'pmAssigment']);
});
//END PM
//end Report



//MASTER DATA
Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:Manage|PM']], function () {
    //search data
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/search_project', function (RequestData $request) {
        $project = Project::where('cust_id', $request->cust_id)->get();
        return response()->json($project);
    });
    //customer
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|customers-editor'])->group(function () {
        Route::get('/customers', function () {
            return view('masterData/customers', ['judul' => "Customers"]);
        })->name('customers');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_customer', [customerController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_customer', [customerController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_customer', [customerController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_customer/{id}', [customerController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_customer/{id}', [customerController::class, 'destroy']);
    //department
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|departments-editor'])->group(function () {
        Route::get('/departments', function () {
            return view('masterData/departments', ['judul' => "Department"]);
        })->name('departments');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_department', [departmentController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_department', [departmentController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_department', [departmentController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_department/{id}', [departmentController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_department/{id}', [departmentController::class, 'destroy']);
    //division
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|divisions-editor'])->group(function () {
        Route::get('/divisions', function () {
            return view('masterData/divisions', ['judul' => "Division"]);
        })->name('divisions');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_division', [divisionController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_division', [divisionController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_division', [divisionController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_division/{id}', [divisionController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_division/{id}', [divisionController::class, 'destroy']);
    //Document Type
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|doctypes-editor'])->group(function () {
        Route::get('/doctypes', function () {
            return view('masterData/doctypes', ['judul' => "Document Type"]);
        })->name('doctypes');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_doctypes', [doctypeController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_doctypes', [doctypeController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_doctypes', [doctypeController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_doctypes/{id}', [doctypeController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_doctypes/{id}', [doctypeController::class, 'destroy']);
    //Skill Level
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|skilllevels-editor'])->group(function () {
        Route::get('/skilllevels', function () {
            return view('masterData/skilllevels', ['judul' => "Skill Level"]);
        })->name('skilllevels');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_skilllevels', [skillLevelController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_skilllevels', [skillLevelController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_skilllevels', [skillLevelController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_skilllevels/{id}', [skillLevelController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_skilllevels/{id}', [skillLevelController::class, 'destroy']);
    //Solution
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|solutions-editor'])->group(function () {
        Route::get('/solutions', function () {
            return view('masterData/solutions', ['judul' => "Solution"]);
        })->name('solutions');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_solutions', [solutionController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_solutions', [solutionController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_solutions', [solutionController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_solutions/{id}', [solutionController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_solutions/{id}', [solutionController::class, 'destroy']);
    //Specialization
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'multi_role:SuperAdm,Manage'])->group(function () {
        Route::get('/specializations', function () {
            return view('masterData/specializations', ['judul' => "Specialization"]);
        })->name('specializations');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_specializations', [specializationController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_specializations', [specializationController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_specializations', [specializationController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_specializations/{id}', [specializationController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_specializations/{id}', [specializationController::class, 'destroy']);
    //Role
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|roles-editor'])->group(function () {
        Route::get('/roles', function () {
            return view('masterData/roles', ['judul' => "Role"]);
        })->name('roles');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_roles', [ControllersRoleEmployee::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_roles', [ControllersRoleEmployee::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_roles', [ControllersRoleEmployee::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_roles/{id}', [ControllersRoleEmployee::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_roles/{id}', [ControllersRoleEmployee::class, 'destroy']);
    //User
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|users-editor'])->group(function () {
        Route::get('/users', function () {
            $role = Role::all();
            $employee = employee::all();
            return view('masterData/users', ['judul' => "User", 'role' => $role, 'employee' => $employee]);
        })->name('users');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_users', [userController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_users', [userController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_users', [userController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_users/{id}', [userController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_users/{id}', [userController::class, 'destroy']);
    //Taxes
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|taxes-editor'])->group(function () {
        Route::get('/taxes', function () {
            return view('masterData/tax', ['judul' => "Taxes"]);
        })->name('taxes');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_taxes', [taxController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_taxes', [taxController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_taxes', [taxController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_taxes/{id}', [taxController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_taxes/{id}', [taxController::class, 'destroy']);
    //LogSession
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:SuperAdm'])->group(function () {
        Route::get('/logHistory', function () {
            $role = roleEmployee::get();
            return view('masterData/logHistory', ['judul' => "Log History", 'role' => $role]);
        })->name('logHistory');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_logLogin', [logController::class, 'jsonLogLogin']);
    //categoryDetailOrder
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role_or_permission:SuperAdm|customers-editor'])->group(function () {
        Route::get('/categoryOrder', function () {
            return view('masterData/categoryDetailOrder', ['judul' => "Category Detail Order"]);
        })->name('categoryOrder');
    });
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_categoryOrder', [categoryOrderController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_categoryOrder', [categoryOrderController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_categoryOrder', [categoryOrderController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_categoryOrder/{id}', [categoryOrderController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_categoryOrder/{id}', [categoryOrderController::class, 'destroy']);
});
//PMO-MASTER
Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified'], 'prefix' => 'pmo'], function () {
    //guide category
    Route::get('/guideCategory', function () {
        return view('masterData/pmo/guideCategory', ['judul' => "Category",]);
    })->name('guideCategory');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_guide', [guideCategory::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_guide', [guideCategory::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_guide', [guideCategory::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_guide/{id}', [guideCategory::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_guide/{id}', [guideCategory::class, 'destroy']);
    //guide type
    Route::get('/guideType', function () {
        return view('masterData/pmo/guideType', ['judul' => "Type",]);
    })->name('guideType');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_guideType', [guideType::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_guideType', [guideType::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_guideType', [guideType::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_guideType/{id}', [guideType::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_guideType/{id}', [guideType::class, 'destroy']);
    //tempAndGuide
    Route::get('/tempGuide', function () {
        $category = ModelsGuideCategory::get();
        $type = ModelsGuideType::get();
        return view('masterData/pmo/tempGuide', ['judul' => "Template & Guidelines", 'category' => $category, 'type' => $type]);
    })->name('tempGuide');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_tempGuide', [tempGuideController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_tempGuide', [tempGuideController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_tempGuide', [tempGuideController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_tempGuide/{id}', [tempGuideController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_tempGuide/{id}', [tempGuideController::class, 'destroy']);
    //community category
    Route::get('/communityCategory', function () {
        return view('masterData/pmo/communityCategory', ['judul' => "Category",]);
    })->name('communityCategory');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_commCategory', [communityCategory::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_commCategory', [communityCategory::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_commCategory', [communityCategory::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_commCategory/{id}', [communityCategory::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_commCategory/{id}', [communityCategory::class, 'destroy']);
    //community type
    Route::get('/communityType', function () {
        return view('masterData/pmo/communityType', ['judul' => "Type",]);
    })->name('communityType');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_commType', [communityType::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_commType', [communityType::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_commType', [communityType::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_commType/{id}', [communityType::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_commType/{id}', [communityType::class, 'destroy']);
    //community
    Route::get('/community', function () {
        $category = ModelsCommunityCategory::get();
        $type = ModelsCommunityType::get();
        return view('masterData/pmo/community', ['judul' => "Template & Guidelines", 'category' => $category, 'type' => $type]);
    })->name('community');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_community', [communityController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_community', [communityController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_community', [communityController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_community/{id}', [communityController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_community/{id}', [communityController::class, 'destroy']);
    //leeson status
    Route::get('/statusLeeson', function () {
        return view('masterData/pmo/statusLeeson', ['judul' => "Status",]);
    })->name('statusLeeson');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_statsLeeson', [leesonStatusController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_statsLeeson', [leesonStatusController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_statsLeeson', [leesonStatusController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_statsLeeson/{id}', [leesonStatusController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_statsLeeson/{id}', [leesonStatusController::class, 'destroy']);
    //leeson learned
    Route::get('/leesonLearned', function () {
        $pmName = employee::get();
        $status = leesonStatus::get();

        return view('masterData/pmo/leesonLearned', ['judul' => "leeson learned", 'pmName' => $pmName, 'status' => $status]);
    })->name('leesonLearned');
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_leesonLearned', [leesonLearnController::class, 'json']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_leesonLearned', [leesonLearnController::class, 'store']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_leesonLearned', [leesonLearnController::class, 'edit']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_leesonLearned/{id}', [leesonLearnController::class, 'update']);
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_leesonLearned/{id}', [leesonLearnController::class, 'destroy']);
});

//END MASTER DATA


Route::group(['middleware' => ['auth:sanctum', 'verified'], 'prefix' => 'asana'], function () {
    Route::get('/getProjects', [AsanaAPIController::class, 'getProjects'])->name('getProjects');
    Route::post('/store', [AsanaAPIController::class, 'store'])->name('storeRole');
});

//test google sheet
Route::get('/gantt', function () {
    $member = memberProject::with('employees', 'roles')->where('projectId', '090bb0f5-dc99-4324-bbab-fe70091b5952')->get();

    $gantt = [];
    $id = 1;
    foreach ($member as $item) {
        $gantt[] = [
            'id' => $id++,
            'nama' => $item->employees->name,
            'text' => $item->roles->roleEmployee,
            'role' => $item->roles->roleEmployee,
            'start_date' => date('d-m-Y', strtotime($item->startDate)),
            'end_date' => date('d-m-Y', strtotime($item->endDate)),
        ];
    }
    return view('/gantt/project', ['gantt' => $gantt]);
    // return $gantt;
});


//ASANA


//END ASANA


Route::get('/google/auth', [employeeController::class, 'auth']);
Route::get('/google/callback', [employeeController::class, 'callback']);
Route::get('/googleSheet', [employeeController::class, 'getSheetsData']);

Route::get('/getSponsor', function () {
    $projects = Project::all();

    // Menampilkan informasi semua proyek beserta sponsor-sponsor mereka
    $resultArray = [];

    foreach ($projects as $project) {
        $projectArray = $project->toArray();

        // Menampilkan informasi proyek dan sponsor-sponsor mereka
        $resultArray[] = [
            'project' => $projectArray,
            'sponsors' => $project->sponsor ? $project->sponsor->toArray() : 'No sponsors', // Perubahan di sini
        ];
    }

    // Output hasil dalam bentuk array
    print_r($resultArray);
});
route::get(
    '/counttaxes',
    function () {
        $data = [
            'efba6e8b-1b4c-4e2b-962d-6d471f616316',
            'f072f215-ceb9-44a9-8c6a-0584b88d8486',

        ];
        for ($i = 0; $i < count($data); $i++) {
            $dataa = topProject::find($data[$i]);
            if ($dataa) {
                $dataa->termsValuePPN = ceil(str_replace(".", "", $dataa->termsValue)  / (1 + 11 / 100));
                $dataa->save();
            };
            // return $data[$i];
        }
        return count($data);
    }
);
