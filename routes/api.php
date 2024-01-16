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
Route::get('/invetigationById/{investigationId}', [\App\Http\Controllers\InvestigationController::class, 'getInvestigationById']);
Route::get('/allInvestigation', [\App\Http\Controllers\InvestigationController::class, 'getAllInvestigation']);

//Routes Completion
Route::get('/completionByUserId/{userId}', [\App\Http\Controllers\InvestigationController::class, 'getCompletionByUserId']);
Route::get('/completionByUserId+InvId/{userId}/{investigationId}', [\App\Http\Controllers\InvestigationController::class, 'getCompletionByUserIdAndInvId']);

//Route Media
Route::get('/MediaByInvId/{investigationId}', [\App\Http\Controllers\MediaController::class, 'getMediaByInvId']);

//Route Website
Route::get('/WebsiteByInvId/{investigationId}', [\App\Http\Controllers\WebsiteController::class, 'getWebsiteByInvId']);

//Route MediaLocation
Route::get('/allMediaLoc', [\App\Http\Controllers\MediaLocationController::class, 'getAllMediaLocations']);
Route::get('/MediaLocByInvId/{investigationId}', [\App\Http\Controllers\MediaLocationController::class, 'getMediaLocationsByInvestigationId']);
