<?php

use App\Http\Controllers\api\auth\AuthAppController;
use App\Http\Controllers\api\FiliereController;
use App\Http\Controllers\api\GroupeController;
use App\Http\Controllers\api\SeanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\SalleController ;
use App\Http\Controllers\api\FormateurController ;
use Laravel\Sanctum\PersonalAccessToken;

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


    return response()->json([
        "user" => $request->user(),
        "token" => $request->user()->currentAccessToken(),
    ]);
});

// Auth middleware routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::apiResource('filieres', FiliereController::class);
    Route::apiResource('groupes', GroupeController::class);
    Route::apiResource('salles', SalleController::class);
    Route::apiResource('formateurs', FormateurController::class);
    Route::apiResource('seances', SeanceController::class);
    // print emploi
    Route::get('print-formateur-emploi/{id}',[ SeanceController::class, "print_formateur_emploi"]);
    Route::get('print-groupe-emploi/{id}',[ SeanceController::class, "print_groupe_emploi"]);
    // logout
    Route::delete('/logout', [AuthAppController::class, "logout"]);
    // global analysis
    Route::get("/seances-analysis", [SeanceController::class, "seances_analysis"]);
    Route::get("/export_emploi", [SeanceController::class, "export_emploi"]);
    Route::post("/import_emploi", [SeanceController::class, "import_emploi"]);

});


// Guest middleware routes
Route::group(['middleware' => ['guest:sanctum']], function () {
    Route::post('/login', [AuthAppController::class, "login"],);
    Route::post('/register', [AuthAppController::class, "register"],);
});


