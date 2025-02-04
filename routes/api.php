<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfessorController;

Route::prefix('v1')->group(function () {
    // Content routes
    Route::get("/news", [ContentController::class, 'getNews'])
        ->description('Get list of news items.')
        ->summary("List of news items");

    Route::get("/clubs", [ContentController::class, 'getClubs'])
        ->description('Get list of clubs.')
        ->summary("List of clubs");

    Route::get('/sponsors', [ContentController::class, 'getSponsors'])
        ->description('Get list of sponsors.')
        ->summary('List of sponsors');

    Route::get('/publications', [ContentController::class, 'getPublications'])
        ->description('Get paginated list of publications.')
        ->summary('List of publications');

    Route::get('/videos', [ContentController::class, 'getVideos'])
        ->description('Get paginated list of videos.')
        ->summary('List of videos');

    Route::get('/articles', [ContentController::class, 'getArticles'])
        ->description('Get paginated list of articles.')
        ->summary('List of articles');

    Route::get('/landing-page', [ContentController::class, 'getLandingPageContent'])
        ->description('Get landing page content and settings.')
        ->summary('Landing page content');

    // Professor routes
    Route::get('/professors', [ProfessorController::class, 'index'])
        ->description('Get list of professors.')
        ->summary('List of professors');

    Route::get('/professors/{id}', [ProfessorController::class, 'show'])
        ->description('Get detailed information about a specific professor.')
        ->summary('Single professor details');

    Route::get('/professors/{id}/videos', [ProfessorController::class, 'videos'])
        ->description('Get paginated list of videos for a specific professor.')
        ->summary('Professor videos');

    Route::get('/professors/{id}/publications', [ProfessorController::class, 'publications'])
        ->description('Get paginated list of publications for a specific professor.')
        ->summary('Professor publications');

    Route::get('/professors/{id}/articles', [ProfessorController::class, 'articles'])
        ->description('Get paginated list of articles for a specific professor.')
        ->summary('Professor articles');
});
