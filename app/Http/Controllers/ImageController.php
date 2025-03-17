<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function fetchImage(Request $request)
    {
        $imageUrl = $request->query('url');

        if (!$imageUrl) {
            return response()->json(['error' => 'Image URL is required'], 400);
        }

        try {
            // Fetch the image using Laravel's HTTP client
            $response = Http::get($imageUrl);

            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch image'], 500);
            }

            // Convert the image to Base64
            $base64 = 'data:image/png;base64,' . base64_encode($response->body());

            return response()->json(['base64' => $base64]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
