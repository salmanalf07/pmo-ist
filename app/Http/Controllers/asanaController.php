<?php

namespace App\Http\Controllers;

use App\Models\asanaProject;
use App\Models\asanaSubTask2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class asanaController extends Controller
{
    public function getMaindays()
    {
        // Mengambil semua task dari database
        $tasks = asanaSubTask2::all();

        // Mengonversi data ke format array yang diperlukan untuk perhitungan
        $taskArray = $tasks->map(function ($task) {
            return [
                'start_on' => $task->start_on,
                'due_on' => $task->due_on,
            ];
        })->toArray();

        // Panggil fungsi calculateMandays dengan data tugas
        $totalMandays = $this->calculateMandays($taskArray);

        return response()->json([
            'total_mandays' => $totalMandays
        ]);
    }

    public function calculateMandays($tasks)
    {
        // Konversi data ke dalam format yang diperlukan untuk perhitungan
        $intervals = collect($tasks)->map(function ($task) {
            return [
                new Carbon($task['start_on']),
                new Carbon($task['due_on']),
            ];
        })->toArray();

        // Gabungkan interval yang tumpang tindih
        $mergedIntervals = $this->mergeIntervals($intervals);

        // Hitung total hari unik
        $totalDays = 0;
        foreach ($mergedIntervals as $interval) {
            $totalDays += $interval[1]->diffInDays($interval[0]) + 1;
        }

        return $totalDays;
    }

    private function mergeIntervals($intervals)
    {
        usort($intervals, function ($a, $b) {
            return $a[0]->lt($b[0]) ? -1 : 1;
        });

        $merged = [];
        foreach ($intervals as $current) {
            if (empty($merged) || $merged[count($merged) - 1][1]->lt($current[0]->copy()->subDay())) {
                $merged[] = $current;
            } else {
                $merged[count($merged) - 1][1] = $merged[count($merged) - 1][1]->max($current[1]);
            }
        }
        return $merged;
    }

    function asanaDashboard(Request $request, $year)
    {
        $imcompleteCon = asanaProject::whereNotNull('projectId')->where('status', '!=', ['complete', 'on_hold'])->whereYear('startDate', '<=', $year)->count();
        $completeCon = asanaProject::whereNotNull('projectId')->where('status', 'complete')->count();
        $overDueCon = asanaProject::whereNotNull('projectId')->where('status', '!=', ['complete', 'on_hold'])->where('dueDate', '<', Carbon::now()->toDateString())->count();
        $upcomingEdCon = asanaProject::whereNotNull('projectId')->where('status', '!=', ['complete', 'on_hold'])->whereBetween('dueDate', [Carbon::now()->toDateString(), Carbon::now()->addMonth()->toDateString()])->count();

        $projByPM = asanaProject::where('status', '!=', ['complete', 'on_hold'])->whereYear('startDate', $year)
            ->whereNotNull('projectId')
            ->with('pm') // Mengambil relasi manager
            ->select('owner', DB::raw('count(*) as total_projects'))
            ->groupBy('owner')
            ->get()
            ->map(function ($project) {
                return [
                    'pm' => $project->pm ? $project->pm->name : 'Unknown', // Jika manajer tidak ditemukan, tampilkan 'Unknown'
                    'total_projects' => $project->total_projects,
                ];
            });
        $projBySales = asanaProject::where('status', '!=', ['complete', 'on_hold'])->whereYear('startDate', $year)
            ->whereNotNull('projectId')
            ->with('saless') // Mengambil relasi manager
            ->select('sales', DB::raw('count(*) as total_projects'))
            ->groupBy('sales')
            ->get()
            ->map(function ($project) {
                return [
                    'sales' => $project->saless ? $project->saless->name : 'Unknown', // Jika manajer tidak ditemukan, tampilkan 'Unknown'
                    'total_projects' => $project->total_projects,
                ];
            });
        $projByCust = asanaProject::where('status', '!=', ['complete', 'on_hold'])->whereYear('startDate', $year)
            ->whereNotNull('projectId')
            ->join('projects', 'asana_projects.projectId', '=', 'projects.id')
            ->join('customers', 'projects.cust_id', '=', 'customers.id')
            ->select('customers.company as customer_name', DB::raw('count(*) as total_projects'))
            ->groupBy('customers.id', 'customers.company')
            ->get()
            ->map(function ($project) {
                return [
                    'customer' => $project->customer_name,
                    'total_projects' => $project->total_projects,
                ];
            });
        $projByStatus = asanaProject::whereYear('startDate', $year)
            ->whereNotNull('projectId')
            ->with('statuss')
            ->select('status', DB::raw('count(*) as total_projects'))
            ->groupBy('status')
            ->get()
            ->map(function ($project) {
                return [
                    'status' => $project->statuss ? $project->statuss->name : 'Unknown', // Jika manajer tidak ditemukan, tampilkan 'Unknown'
                    'total_projects' => $project->total_projects,
                ];
            });

        $totAssigeByEmp = asanaSubTask2::with('assignees', 'project')
            ->whereHas('project', function ($query) use ($year) {
                $query->whereYear('startDate', $year);
            })
            ->select('assignee', DB::raw('count(*) as total_tasks'))
            ->groupBy('assignee')
            ->orderByDesc('total_tasks')
            ->get()
            ->map(function ($project) {
                return [
                    'emp' => $project->assignees ? $project->assignees->name : 'Unknown',
                    'total_tasks' => $project->total_tasks,
                ];
            });


        return response()->json([
            'incompleteProject' => $imcompleteCon,
            'completeProject' => $completeCon,
            'overdueProject' => $overDueCon,
            'upcomingEndProject' => $upcomingEdCon,
            'projectByPM' => $projByPM,
            'projectBySales' => $projBySales,
            'projectByCust' => $projByCust,
            'projectByStatus' => $projByStatus,
            'totAssigeByEmp' => $totAssigeByEmp

        ]);
    }
}
