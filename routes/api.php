<?php

use App\Http\Controllers\api\auth\AuthAppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\SalleController ;
use App\Http\Controllers\api\FormateurController ;

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
Route::apiResource("salles",SalleController::class);
Route::apiResource("formateurs",FormateurController::class);

Route::get('/login', [AuthAppController::class, "index"],);
