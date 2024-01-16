<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Routes d'authentification
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

//Routes des investigations
Route::post('/invetigationById', [\App\Http\Controllers\InvestigationController::class, 'getInvestigationById']);
Route::post('/allInvestigation', [\App\Http\Controllers\InvestigationController::class, 'getAllInvestigation']);

//Routes Completion
Route::post('/completionByUserId', [\App\Http\Controllers\InvestigationController::class, 'getCompletionByUserId']);
Route::post('/completionByUserId+InvId', [\App\Http\Controllers\InvestigationController::class, 'getCompletionByUserIdAndInvId']);

//Route Media
Route::post('/MediaByInvId', [\App\Http\Controllers\MediaController::class, 'getMediaByInvId']);

//Route Website
Route::post('/WebsiteByInvId', [\App\Http\Controllers\WebsiteController::class, 'getWebsiteByInvId']);

//Route MediaLocation
Route::post('/allMediaLoc', [\App\Http\Controllers\MediaLocationController::class, 'getAllMediaLocations']);
Route::post('/MediaLocByInvId', [\App\Http\Controllers\MediaLocationController::class, 'getMediaLocationsByInvestigationId']);
