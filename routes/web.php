<?php

use App\Http\Controllers\customerController;
use App\Http\Controllers\employeeController;
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
        return view('profile');
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
