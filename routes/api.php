<?php

use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaLocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
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

//TODO : Add routes updateCompletionOfUser and updateMediaPositionOfUser

//Routes d'authentification
Route::controller(\App\Http\Controllers\AuthController::class)->group(function(){
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

//Route Administration
Route::controller(\App\Http\Controllers\AdminController::class)->group(function() {
    Route::prefix('admin')->group(function (){
        Route::middleware('auth:sanctum')->group(function (){
            Route::get('/checkIsAdmin', 'checkAdminStatus');
            //Route administration Investigation
            Route::prefix('investigation')->group(function (){
                Route::post('/new', 'addNewInvestigation');
                Route::put('/update/{investigationID}', 'updateInvestigation');
                Route::delete('/delete/{investigationID}', 'deleteInvestigation');
                Route::put('/{investigationID}/removeWebsite/{websiteID}', 'removeWebsiteFromInvestigation');
                Route::put('/{investigationID}/removeMedia/{mediaID}', 'removeMediaFromInvestigation');
            });
            //Route administration Website
            Route::prefix('website')->group(function (){
                Route::post('/new', 'addWebsite');
                Route::put('{websiteId}/link/{investigationID}', 'linkWebsiteToInvestigation');
                Route::delete('/delete/{websiteID}', 'deleteWebsite');
                Route::post('/update/{websiteID}', 'updateWebsite');
            });
            //Route administration Media
            Route::prefix('media')->group(function (){
                Route::post('/new', 'addMediaWithoutLink');
                Route::post('/{mediaId}/addLinkFile', 'addingLinkFileToMedia');
                Route::post('{mediaId}/link/{investigationID}', 'linkMediaToInvestigation');
                Route::delete('/delete/{mediaID}', 'deleteMedia');
                Route::post('/update/{mediaID}', 'updateMediaWithoutLink');
            });
            //Route administration User
            Route::prefix('user')->group(function (){
                Route::put('/block/{userID}', 'blockUser');
                Route::put('/unblock/{userID}', 'unblockUser');
                Route::delete('/delete/{userID}', 'deleteUser');
                Route::put('/promote/{userID}', 'promoteUser');
            });

        });
    });
});

// Route relatives aux utilisateurs non connectés
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

// Route relative aux utilisateurs
Route::prefix('user')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('', function (Request $request) { return $request->user(); });
        Route::prefix('investigation')->group(function () {
            Route::controller(InvestigationController::class)->group(function () {
                Route::get('/all', 'getAllInvestigationsForUser');
                Route::prefix('{investigationID}')->group(function () {
                    Route::get('', 'getInvestigationByIdForUser');
                    Route::get('/medias', [MediaController::class, 'getMediasByInvForUser']);
                    Route::put('/medias/save', [MediaController::class, 'updateMediasForUser']);
                    Route::get('/mediaLocations', [MediaLocationController::class, 'getMediaLocationsByInvestigationIdForUser']);
                    Route::put('/mediaLocations/save', [MediaLocationController::class, 'updateMediaLocationsForUser']);
                    Route::put('/complete', 'updateCompletionOfUser');
                });
            });
        });
    });
    Route::get('/all', [UserController::class, 'getALlUsers']);
    Route::get('/{userID}', [UserController::class, 'getUserById']);
});

Route::prefix('common')->group(function (){
    Route::prefix('investigation')->group(function (){
        Route::prefix('{investigationId}')->group(function () {
                Route::get('/websites', [WebsiteController::class,'getWebsiteByInvId']);
        });
    });
});

Route::prefix('media')->group(function (){
    Route::controller(MediaController::class)->group(function() {
        Route::get('/all', 'getAllMedias');
        Route::get('/{mediaID}', 'getMediaById');
    });
});

Route::prefix('website')->group(function (){
    Route::controller(WebsiteController::class)->group(function() {
        Route::get('/all', 'getAllWebsites');
        Route::get('/{websiteID}', 'getWebsiteById');
    });
});

Route::prefix('mediaLocation')->group(function (){
    Route::controller(MediaLocationController::class)->group(function() {
        Route::get('/all', 'getAllMediaLocations');
        Route::get('/{mediaLocationID}', 'getMediaLocationById');
    });
});
