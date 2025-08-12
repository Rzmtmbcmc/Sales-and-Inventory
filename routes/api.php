<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;



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
Route::apiResource('brands', BrandController::class);
Route::apiResource('brands.branches', BranchController::class);
Route::apiResource('products', ProductController::class);

Route::get('orders/final-summary', [OrderController::class, 'finalSummary']);
Route::get('orders/statistics', [OrderController::class, 'statistics']);
Route::apiResource('orders', OrderController::class);
Route::get('branches', function() {
    return response()->json([
        'data' => \App\Models\Branch::with('brand')->get()->map(function($branch) {
            return [
                'id' => $branch->id,
                'name' => $branch->name,
                'brand_name' => $branch->brand->name
            ];
        })
    ]);
});
Route::get('products', function() {
    return response()->json([
        'data' => \App\Models\Product::all(['id', 'name', 'price'])
    ]);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
