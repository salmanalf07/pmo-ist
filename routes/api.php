<?php

use App\Http\Controllers\departmentController;
use App\Models\department;
use App\Models\division;
use App\Models\employee;
use App\Models\locationEmployee;
use App\Models\roleEmployee;
use App\Models\skillLevel;
use App\Models\specialization;
use App\Models\typeProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.key')->get('/data', function (Request $request) {
    $department = department::all();
    $division = division::all();
    $location = locationEmployee::all();
    $roleEmployee = roleEmployee::all();
    $typeProject = typeProject::all();
    $skillLevel = skillLevel::all();
    $specialization = specialization::all();
    $employee = employee::all();


    return response()->json(['department' => $department, 'division' => $division, 'location' => $location, 'roleEmployee' => $roleEmployee, 'skillLevel' => $skillLevel, 'specialization' => $specialization, 'employee' => $employee, 'typeProject' => $typeProject]);
});
