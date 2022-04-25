<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResources([
        "status" => \App\Http\Controllers\Api\Common\StatusController::class, 
        "users" => \App\Http\Controllers\Api\Modules\UserController::class, 
        "companies" => \App\Http\Controllers\Api\Modules\CompanyController::class, 
        "employees" => \App\Http\Controllers\Api\Modules\EmployeeController::class, 
    ]);
    Route::get("common-auth-call", [\App\Http\Controllers\CommonController::class, 'getBasicAuthData']);
});
Route::post('/login',[\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::post('/logout',[\App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);