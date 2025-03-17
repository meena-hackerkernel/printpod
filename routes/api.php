<?php

use App\Http\Controllers\DalleController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\UpscaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/shopify/webhook', function (Request $request) {
    Log::info('🚀 Shopify Webhook Received!', $request->all());
    return response()->json(['status' => 'success'], 200);
});


