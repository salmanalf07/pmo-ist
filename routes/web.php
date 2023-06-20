<?php

use App\Http\Controllers\customerController;
use App\Http\Controllers\DocProjectController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\memberProjectController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\pipelineController;
use App\Http\Controllers\projectController;
use App\Http\Controllers\riskIssuestController;
use App\Http\Controllers\scopeProjectController;
use App\Http\Controllers\topProjectController;
use App\Models\Customer;
use App\Models\documentationProject;
use App\Models\employee;
use App\Models\memberProject;
use App\Models\Order;
use App\Models\pipeline;
use App\Models\Project;
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
        return view('employee/employee', ['judul' => "Employees"]);
    })->name('employees');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_employee', [employeeController::class, 'json']);
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
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_project', [projectController::class, 'json']);
//summarry
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/summaryProject/{id}', function ($id) {

        $data = Project::find($id);
        $sumInv = topProject::where([
            ['projectId', '=', $id],
            ['invMain', '=', 1]
        ])->sum('termsValue');
        $invoiced = ($sumInv / $data->projectValue) * 100;
        $sumPay = topProject::where([
            ['projectId', '=', $id],
            ['payMain', '=', 1]
        ])->sum('termsValue');
        $payment = ($sumPay / $data->projectValue) * 100;
        return view('project/summaryProject', ['judul' => "Project", 'id' => $id, 'data' => $data, 'invoiced' => $invoiced, 'payment' =>  $payment]);
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
//scopeHighLevel
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/scopeHighLevel/{id}', [scopeProjectController::class, 'edit'])->name('scopeHighLevel');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_scopeHighLevel/{id}', [scopeProjectController::class, 'store'])->name('storescope');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_scopeHighLevel/{id}', [scopeProjectController::class, 'destroy'])->name('deletescope');
//riskIssues
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/project/riskIssues/{id}', [riskIssuestController::class, 'edit'])->name('riskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_riskIssues/{id}', [riskIssuestController::class, 'store'])->name('storeRiskIssues');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_projectMember/{table}/{id}', [riskIssuestController::class, 'destroy'])->name('deleteIssues');
//projectTimline
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/projectTimeline/{id}', function ($id) {
        return view('project/projectTimeline', ['judul' => "Project", 'id' => $id]);
    })->name('projectTimeline');
});
//mandays
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/mandays/{id}', function ($id) {
        return view('project/mandays', ['judul' => "Project", 'id' => $id]);
    })->name('mandays');
});
//Documentation Project
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/documentation/{id}', function ($id) {
        return view('project/documentation', ['judul' => "Documentation", 'id' => $id]);
    })->name('documentation');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_documentation/{id}', [DocProjectController::class, 'json']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_documentation/{id}', [DocProjectController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_documentation/{id}', [DocProjectController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_documentation/{id}', [DocProjectController::class, 'update']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_documentation/{id}', [DocProjectController::class, 'destroy']);
//Finance
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/financeInfo', function () {
        $customer = Customer::where('type', 'customer')->get();
        $employee = employee::get();
        return view('finance/financeInfo', ['judul' => "Finance", 'customer' => $customer, 'employee' => $employee,]);
    })->name('financeInfo');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_finance', [topProjectController::class, 'json']);
//end Finance
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/pipeline', [pipelineController::class, 'index'])->name('pipeline');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/store_pipeline', [pipelineController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/edit_pipeline', [pipelineController::class, 'edit']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->post('/update_pipeline/{id}', [pipelineController::class, 'store']);
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->delete('/delete_pipeline/{id}', [pipelineController::class, 'destroy']);
//end pipeline
//test google sheet
Route::get('/google/auth', [employeeController::class, 'auth']);
Route::get('/google/callback', [employeeController::class, 'callback']);
Route::get('/googleSheet', [employeeController::class, 'getSheetsData']);
