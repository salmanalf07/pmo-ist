<?php

namespace App\Http\Controllers;

use App\Models\asanaProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsanaAPIController extends Controller
{
    function extractNumber($name)
    {
        // Use regular expression to match the number after the dash
        if (preg_match('/-(\d+)/', $name, $matches)) {
            return $matches[1];
        }
        return null; // Return null if no match is found
    }

    public function getProjects(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => env('TOKEN_ASANA'),
        ])->get('https://app.asana.com/api/1.0/projects');

        if ($response->successful()) {
            $data = $response->json();

            // Filter data
            // $filteredData = array_filter($data['data'], function ($item) {
            //     return strpos($item['name'], '009') !== false;
            // });

            foreach ($data['data'] as &$project) {

                $asanaProject = asanaProject::firstOrNew(['gid' => $project['gid']]);
                $asanaProject->gid = $project['gid'];
                $asanaProject->projectName = $project['name'];
                $asanaProject->save();
            }
        }
        return $data;
    }
}
