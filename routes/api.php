<?php

use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaLocationController;
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

Route::prefix('guest')->group(function (){
    Route::prefix('investigation')->group(function (){
        Route::controller(InvestigationController::class)->group(function() {
            Route::get('/all', 'getAllInvestigations');
            Route::prefix('{investigationId}')->group(function () {
                Route::get('', 'getInvestigationById');
                Route::get('/medias', [MediaController::class,'getMediaByInvId']);
                Route::get('/mediaLocations', [MediaLocationController::class,'getMediaLocationsByInvestigationId']);
            });
        });
    });
});

Route::prefix('{userID}')->group(function (){
    Route::prefix('investigation')->group(function (){
        Route::controller(InvestigationController::class)->group(function() {
            Route::get('/all', 'getAllInvestigationsByUserId');
            Route::prefix('{investigationID}')->group(function () {
                Route::get('', 'getInvestigationByIdAndUserId');
                Route::get('/medias', [MediaController::class,'getMediasByInvAndUserId']);
                Route::get('/mediaLocations', [MediaLocationController::class,'getMediaLocationsByInvestigationIdAndUserId']);
            });
        });
    });
});

//Routes des investigations + completions
Route::controller(InvestigationController::class)->group(function(){
    Route::prefix('investigation')->group(function (){
        Route::get('/all', 'getAllInvestigations');
        Route::get('/{investigationId}', 'getInvestigationById');
//      Route::get('/byUser/{userId}','getInvestigationsByUserId');
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
Route::controller(MediaController::class)->group(function(){
    Route::prefix('media')->group(function (){
       Route::get('/{investigationId}', 'getMediaByInvId');
       Route::middleware('auth:sanctum')
           ->get('/byUser/{userId}/{investigationID}','getMediasByInvAndUserId');
       Route::middleware('auth:sanctum')
           ->put('/savePosition', 'updateMediaPositionOfUser');
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
        Route::middleware('auth:sanctum')
            ->get('/byUser/{userID}/{investigationID}','getMediaLocationsByInvestigationIdAndUserId');
    });
});
