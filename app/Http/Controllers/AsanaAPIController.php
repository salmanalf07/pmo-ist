<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsanaAPIController extends Controller
{

    public function getProjects(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => env('TOKEN_ASANA'),
        ])->get('https://app.asana.com/api/1.0/projects');

        if ($response->successful()) {
            $data = $response->json();

            // Filter data
            $filteredData = array_filter($data['data'], function ($item) {
                return strpos($item['name'], '170') !== false;
            });

            // Encode filtered data back to JSON
            $filteredJsonData = json_encode(array('data' => $filteredData), JSON_PRETTY_PRINT);
        }
        return $filteredJsonData;
    }
}
