<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'sanctum',
    'prefix' => 'auth'

], function ($router) {
    //There should be login details
    // Route::post('/login', [DriverAuthController::class, 'login']);
    // Route::post('/logout', [DriverAuthController::class, 'logout']);
    // Route::post('/refresh', [DriverAuthController::class, 'refresh']);
    // Route::get('/user-profile', [DriverAuthController::class, 'userProfile']);     
});

Route::group([
    'middleware' => 'sanctum',
    'prefix' => 'details'
], function ($router) {
    Route::resource('category', CategoriesController::class);
    Route::resource('product', ProductsController::class);
    // Route::post('/login', [DriverAuthController::class, 'login']);
    // Route::post('/logout', [DriverAuthController::class, 'logout']);
    // Route::post('/refresh', [DriverAuthController::class, 'refresh']);
    // Route::get('/user-profile', [DriverAuthController::class, 'userProfile']);     
});