<?php

namespace App\Http\Controllers;

use App\Models\activityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class logController extends Controller
{
    public function jsonLogLogin(Request $request)
    {
        $dataa = activityLog::with('users.employee.roles')->orderBy('created_at', 'DESC');

        if ($request->roleFilter && $request->roleFilter != '#') {
            $dataa->whereHas('users.employee', function ($q) use ($request) {

                $q->where('role', '=', $request->roleFilter);
            });
        }
        if ($request->date_st != "#" && $request->date_st) {
            $dataa->whereDate('created_at', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        } else {
            $dataa->whereMonth('created_at', '=', date("m"));
        }

        $data = $dataa->get();

        return DataTables::of($data)
            ->toJson();
    }
}
