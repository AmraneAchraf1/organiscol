<?php

use App\Http\Controllers\api\auth\AuthAppController;
use App\Http\Controllers\api\FiliereController;
use App\Http\Controllers\api\GroupeController;
use App\Http\Controllers\api\SeanceController;
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


// Auth middleware routes
Route::group(['middleware' => ['guest:sanctum']], function () {

    Route::apiResource('filieres', FiliereController::class);
    Route::apiResource('groupes', GroupeController::class);
    Route::apiResource('salles', SalleController::class);
    Route::apiResource('formateurs', FormateurController::class);
    Route::apiResource('seances', SeanceController::class);
    // print emploi
    Route::post('print-formateur-emploi',[ SeanceController::class, "print_formateur_emploi"]);
    Route::post('print-groupe-emploi',[ SeanceController::class, "print_groupe_emploi"]);
    // logout
    Route::delete('/logout', [AuthAppController::class, "logout"]);
});



// Guest middleware routes
Route::group(['middleware' => ['guest:sanctum']], function () {
    Route::post('/login', [AuthAppController::class, "login"],);
    Route::post('/register', [AuthAppController::class, "register"],);
});


