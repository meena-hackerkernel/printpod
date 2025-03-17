<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DalleController extends Controller
{
    public function generateImage(Request $request)
    {
        // Validate input
        $request->validate([
            'prompt' => 'required|string|max:255',
            'size' => 'nullable|in:256x256,512x512,1024x1024',
            'n' => 'nullable|integer|min:1|max:4' // Allow defining the number of images (1-4)
        ]);
    
        $prompt = $request->input('prompt');
        $size = $request->input('size', '1024x1024'); // Default image size
        $n = $request->input('n', 1); // Default to 2 images
        $quality = $request->input('quality');

        $client = new Client();
        $apiKey = env('OPENAI_API_KEY');
    
        try {
            $response = $client->post('https://api.openai.com/v1/images/generations', [
                'headers' => [
                    'Authorization' => "Bearer $apiKey",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'dall-e-3', // Ensure access to this model
                    'prompt' => $prompt,
                    'n' => 1, // Number of images to generate
                    'size' => $size,
                    "quality" => "standard"
                ],
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            if (isset($data['data']) && count($data['data']) > 0) {
                $imageUrls = array_map(fn($image) => $image['url'], $data['data']);
    
                return response()->json([
                    'success' => true,
                    'image_urls' => $imageUrls // Return all generated image URLs
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'No image generated'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
