<?php

use App\Http\Controllers\customerController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\projectController;
use App\Models\Customer;
use App\Models\employee;
use App\Models\Project;
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
//project list
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/projectInfo', function () {
        return view('project/projectInfo', ['judul' => "Project"]);
    })->name('projectInfo');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/json_project', [projectController::class, 'json']);
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
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/detailOrder/{id}', function ($id) {
        return view('project/detailOrder', ['judul' => "Project", 'id' => $id]);
    })->name('detailOrder');
});
//TOP
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/top/{id}', function ($id) {
        return view('project/top', ['judul' => "Project", 'id' => $id]);
    })->name('top');
});
//Project Member
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/projectMember/{id}', function ($id) {
        $employee = employee::get();
        return view('project/projectMember', ['judul' => "Project", 'id' => $id, "employee" => $employee]);
    })->name('projectMember');
});
//scopeHighLevel
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/scopeHighLevel/{id}', function ($id) {
        return view('project/scopeHighLevel', ['judul' => "Project", 'id' => $id]);
    })->name('scopeHighLevel');
});
//riskIssues
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/project/riskIssues/{id}', function ($id) {
        return view('project/riskIssues', ['judul' => "Project", 'id' => $id]);
    })->name('riskIssues');
});
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
