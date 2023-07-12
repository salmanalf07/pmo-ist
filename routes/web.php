<?php

use App\Http\Controllers\customerController;
use App\Http\Controllers\DocProjectController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\memberProjectController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\pipelineController;
use App\Http\Controllers\projBonus;
use App\Http\Controllers\projectController;
use App\Http\Controllers\riskIssuestController;
use App\Http\Controllers\scopeProjectController;
use App\Http\Controllers\sowController;
use App\Http\Controllers\timelineController;
use App\Http\Controllers\topProjectController;
use App\Models\Customer;
use App\Models\department;
use App\Models\division;
use App\Models\docType;
use App\Models\documentationProject;
use App\Models\employee;
use App\Models\issuesProject;
use App\Models\locationEmployee;
use App\Models\memberProject;
use App\Models\Order;
use App\Models\pipeline;
use App\Models\Project;
use App\Models\roleEmployee;
use App\Models\skillLevel;
use App\Models\specialization;
use App\Models\topProject;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectDashboard', function () {
        return view('/dashboard/projectDashboard');
    })->name('projectDashboard');
});
//end Dashboard
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/profile', function () {
        return view('/profiles/profile');
    })->name('profile');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectMethod', function () {
        return view('/profiles/projectMethod');
    })->name('projectMethod');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/tempGuide', function () {
        return view('/profiles/tempGuide');
    })->name('tempGuide');
});
//end profile
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//customer
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/customers', function () {
        return view('project/customers', ['judul' => "Customers"]);
    })->name('customers');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_customer', [customerController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_customer', [customerController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_customer', [customerController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_customer/{id}', [customerController::class, 'update']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_customer/{id}', [customerController::class, 'destroy']);
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
        return view('employee/employee', ['judul' => "Employees", 'skill' => $skill, 'role' => $role, 'specialization' => $specialization, 'location' => $location, 'divisi' => $divisi, 'department' => $department, 'employee' => $employee]);
    })->name('employees');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/empByAssignment', function () {
        return view('employee/byAssignment', ['judul' => "Employee By Assigment"]);
    })->name('empByAssignment');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/empExtResources', function () {
        $employee = employee::get();
        $company = employee::get();
        return view('employee/extResources', ['judul' => "Employee External Resources", 'employee' => $employee, 'company' => $company]);
    })->name('empExtResources');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_employee', [employeeController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_ByAssignment', [employeeController::class, 'jsonByAssignment']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_ExtResources', [employeeController::class, 'jsonExtResources']);
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
        return view('project/projectInfo', ['judul' => "Project", 'customer' => $customer, 'employee' => $employee,]);
    })->name('projectInfo');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectInfoByDate', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('project/projectInfoByDate', ['judul' => "Project", 'customer' => $customer, 'employee' => $employee,]);
    })->name('projectInfoByDate');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectByMainCon', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('project/projectByMainCon', ['judul' => "Project", 'customer' => $customer, 'employee' => $employee,]);
    })->name('projectByMainCon');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_project', [projectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_project/{id}', [projectController::class, 'destroy']);
//summarry
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/summaryProject/{id}', function ($id) {

        $data = Project::find($id);
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

        return view('project/summaryProject', ['judul' => "Project", 'id' => $id, 'data' => $data, 'invoiced' => round($invoiced, 0), 'payment' =>  round($payment, 0), 'color' => $color, 'status' => $status]);
        //return $invoiced;
    })->name('summaryProject');
});
//projectinfo
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
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
        return view('project/inputProject', ['judul' => "Project", 'customer' => $customer, 'partner' => $partner, 'employee' => $employee, 'noProject' => $noProject]);
    })->name('inputProject');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_project', [projectController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/inputProject/{id}', [projectController::class, 'edit'])->name('editProject');
//Detail Order
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/detailOrder/{id}', [orderController::class, 'edit'])->name('detailOrder');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_detailOrder/{id}', [orderController::class, 'store'])->name('storeOrder');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_detailOrder/{id}', [orderController::class, 'destroy'])->name('deleteOrder');
//TOP
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/top/{id}', [topProjectController::class, 'edit'])->name('top');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_top/{id}', [topProjectController::class, 'store'])->name('storeTop');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_top/{id}', [topProjectController::class, 'destroy'])->name('deleteTop');
//Project Member
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/projectMember/{id}', [memberProjectController::class, 'edit'])->name('projectMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_projectMember/{id}', [memberProjectController::class, 'store'])->name('storeProjectMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_projectMember/{id}', [memberProjectController::class, 'destroy'])->name('deleteMember');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_projectPartner/{id}', [memberProjectController::class, 'destroyPartner'])->name('deletePartner');
//TimeLine
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/projectTimeline/{id}', [timelineController::class, 'edit'])->name('projectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_projectTimeline/{id}', [timelineController::class, 'store'])->name('storeprojectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_projectTimeline/{id}', [timelineController::class, 'destroy'])->name('deleteprojectTimeline');
//riskIssues
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/riskIssues/{id}', [riskIssuestController::class, 'edit'])->name('riskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_riskIssues/{id}', [riskIssuestController::class, 'store'])->name('storeRiskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_projectMember/{table}/{id}', [riskIssuestController::class, 'destroy'])->name('deleteIssues');
//SOW
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/sow/{id}', [sowController::class, 'edit'])->name('projectTimeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_sow/{id}', [sowController::class, 'store'])->name('storeSow');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_projectSow/{table}/{id}', [sowController::class, 'destroy'])->name('deleteSow');
//mandays
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/mandays/{id}', function ($id) {
        return view('project/mandays', ['judul' => "Project", 'id' => $id]);
    })->name('mandays');
});
//Documentation Project
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/documentation/{id}', function ($id) {
        $value = Project::with('customer')->find($id);
        $doc = docType::get();
        return view('project/documentation', ['judul' => "Documentation", 'id' => $id, 'header' => $value->customer->company . ' - ' . $value->noContract . ' - ' . $value->projectName, 'doc' => $doc]);
    })->name('documentation');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_documentation/{id}', [DocProjectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_documentation/{id}', [DocProjectController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_documentation/{id}', [DocProjectController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_documentation/{id}', [DocProjectController::class, 'update']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_documentation/{id}', [DocProjectController::class, 'destroy']);
//Project Bonus
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/bonus/{id}', [projBonus::class, 'edit'])->name('projectBonus');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_bonus/{id}', [projBonus::class, 'store'])->name('storeBonus');
//Finance
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeInfo', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('finance/financeInfo', ['judul' => "Finance", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeInfo');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeTermsStat', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('finance/financeTermsStat', ['judul' => "Finance", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeTermsStat');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_finance', [topProjectController::class, 'json']);
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
//end Report

//test google sheet
Route::get('/google/auth', [employeeController::class, 'auth']);
Route::get('/google/callback', [employeeController::class, 'callback']);
Route::get('/googleSheet', [employeeController::class, 'getSheetsData']);
