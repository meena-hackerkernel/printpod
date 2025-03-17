<?php

use App\Http\Controllers\Admin\DeliveryBoyController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ZipCodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Vendor Dashboard (for vendors)
Route::middleware('auth:vendor')->group(function () {
    Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])
        ->name('vendor.dashboard');
});
Route::get('/add-shopify-script', [ShopifyController::class, 'addScriptTag']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('zip-codes', ZipCodeController::class);
    Route::resource('vendors', VendorController::class);
    Route::post('vendors/{id}/status', [VendorController::class, 'changeStatus'])->name('vendors.status');
    Route::resource('delivery-boys', DeliveryBoyController::class);
    Route::post('delivery-boys/{id}/change-status', [DeliveryBoyController::class, 'changeStatus'])->name('delivery-boys.changeStatus');
});
require __DIR__ . '/auth.php';
