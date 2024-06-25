<?php

namespace App\Http\Controllers;

use App\Models\asanaSubTask2;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
