<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthCenterController extends Controller
{
    public function getHealthCenterCode(Request $request)
    {
        // Authenticate client (you'll need to implement this)
        
        // Retrieve client's unique identifier (e.g., UUID) from the request
        $clientId = $request->input('client_id');

        // Construct path to the client's text file (adjust path as needed)
        $filePath = "/home/{$clientId}/health_center_code.txt";

        // Check if the file exists
        if (file_exists($filePath)) {
            // Read the health center code from the text file
            $healthCenterCode = file_get_contents($filePath);

            return response()->json(['health_center_code' => $healthCenterCode]);
        } else {
            return response()->json(['error' => 'Health center code not found'], 404);
        }
}
}