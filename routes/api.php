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
Route::controller(\App\Http\Controllers\AuthController::class)->group(function(){
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

//Routes des investigations + completions
Route::controller(\App\Http\Controllers\InvestigationController::class)->group(function(){
    Route::prefix('investigation')->group(function (){
        Route::get('/byUser/{userId}','getInvestigationsByUserId');
        Route::get('/id/{investigationId}', 'getInvestigationById');
        Route::get('/all', 'getAllInvestigation');
    });

    Route::prefix('completion')->group(function (){
       Route::get('/{userId}', 'getCompletionByUserId');
       Route::get('/{userId}/{investigationId}', 'getCompletionByUserIdAndInvId');

       //Save progession (update Completion table)
       Route::middleware('auth:sanctum')
           ->put('/saveProgress', 'updateCompletionOfUser');
    });
});

//Route Media
Route::controller(\App\Http\Controllers\MediaController::class)->group(function(){
    Route::prefix('media')->group(function (){
       Route::get('/{investigationId}', 'getMediaByInvId');
       Route::get('/byUser/{userId}/{investigationID}','getMediasByInvAndUserId');
    });
});

//Route Website
Route::controller(\App\Http\Controllers\WebsiteController::class)->group(function(){
    Route::prefix('website')->group(function (){
        Route::get('/{investigationId}','getWebsiteByInvId');
    });
});

//Route MediaLocation
Route::controller(\App\Http\Controllers\MediaLocationController::class)->group(function(){
    Route::prefix('mediaLocation')->group(function (){
        Route::get('/all', 'getAllMediaLocations');
        Route::get('/id/{investigationId}', 'getMediaLocationsByInvestigationId');
        Route::get('/byUser/{userID}/{investigationID}','getMediaLocationsByInvestigationIdAndUserId');
    });
});
