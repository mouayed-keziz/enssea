<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;

Route::prefix('v1')->group(function () {
    Route::get("/news", [ContentController::class, 'getNews'])
        ->description('Get list of news items.')
        ->summary("List of news items");

    Route::get("/clubs", [ContentController::class, 'getClubs'])
        ->description('Get list of clubs.')
        ->summary("List of clubs");

    Route::get('/sponsors', [ContentController::class, 'getSponsors'])
        ->description('Get list of sponsors.')
        ->summary('List of sponsors');

    Route::get('/professors', [ContentController::class, 'getProfessors'])
        ->description('Get list of professors.')
        ->summary('List of professors');

    Route::get('/professors/{id}', [ContentController::class, 'getSingleProfessor'])
        ->description('Get detailed information about a specific professor.')
        ->summary('Single professor details');

    Route::get('/publications', [ContentController::class, 'getPublications'])
        ->description('Get paginated list of publications.')
        ->summary('List of publications');

    Route::get('/videos', [ContentController::class, 'getVideos'])
        ->description('Get paginated list of videos.')
        ->summary('List of videos');
});
