<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpscaleController extends Controller
{
    public function upscaleImage(Request $request)
    {
    
        // Validate the request (ensure an image file is uploaded)
        $request->validate([
            'image' => 'required|image|max:10240', // Max 10MB image
        ]);
        // print_r($request->all());
        // die;

        // Get the uploaded image file
        $image = $request->file('image');
      
        // Prepare the request for Stability AI
        $response = Http::withHeaders([
            'Authorization' => 'Bearer sk-6j1AEAhQPp7lOVRGYOdMw4MQ5q4MwNpADHd40jZTI2oEjRa3', // Replace with your actual API key
            'Accept' => 'image/*',
        ])->attach(
            'image', file_get_contents($image->getRealPath()), $image->getClientOriginalName()
        )->post('https://api.stability.ai/v2beta/stable-image/upscale/conservative', [
            'prompt' => 'Upscale this image',
            'output_format' => 'webp'
        ]);

        // print_r($response->json());
        // die;
        // Handle the response
        if ($response->successful()) {
            $filename = 'upscaled_' . time() . '.webp';
            Storage::put('public/upscaled/' . $filename, $response->body());

            return response()->json([
                'message' => 'Image upscaled successfully',
                'url' => asset('storage/upscaled/' . $filename)
            ]);
        } else {
            return response()->json(['error' => $response->json()], 400);
        }
    }
}
