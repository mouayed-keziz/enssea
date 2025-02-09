<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventAnnouncementController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\SubjectController;

Route::prefix('v1')->group(function () {
    // Content routes
    Route::get("/news", [NewsController::class, 'index'])
        ->description('Get list of news items.')
        ->summary("List of news items");

    Route::get("/clubs", [ClubController::class, 'index'])
        ->description('Get list of clubs.')
        ->summary("List of clubs");

    Route::get('/sponsors', [SponsorController::class, 'index'])
        ->description('Get list of sponsors.')
        ->summary('List of sponsors');

    Route::get('/publications', [PublicationController::class, 'index'])
        ->description('Get paginated list of publications.')
        ->summary('List of publications');

    Route::get('/publications/{id}', [PublicationController::class, 'show'])
        ->description('Get detailed information about a specific publication.')
        ->summary('Single publication details');

    Route::get('/videos', [VideoController::class, 'index'])
        ->description('Get paginated list of videos.')
        ->summary('List of videos');

    Route::get('/articles', [ArticleController::class, 'index'])
        ->description('Get paginated list of articles.')
        ->summary('List of articles');

    Route::get('/articles/{id}', [ArticleController::class, 'getById'])
        ->description('Get article by ID.')
        ->summary('Get article by ID');

    Route::get('/articles/slug/{slug}', [ArticleController::class, 'show'])
        ->description('Get detailed information about a specific article.')
        ->summary('Single article details');

    Route::get('/landing-page', [ContentController::class, 'getLandingPageContent'])
        ->description('Get landing page content and settings.')
        ->summary('Landing page content');

    // Event Announcement routes
    Route::get('/event-announcements', [EventAnnouncementController::class, 'index'])
        ->description('Get paginated list of event announcements.')
        ->summary('List of event announcements');

    Route::get('/event-announcements/{id}', [EventAnnouncementController::class, 'show'])
        ->description('Get detailed information about a specific event.')
        ->summary('Single event details');

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

    // Library routes
    Route::get('/library', [LibraryController::class, 'index'])
        ->description('Get paginated list of articles, videos, and publications for the library. Has query params: articles_q, articles_page, articles_per_page, videos_q, videos_page, videos_per_page, publications_q, publications_page, publications_per_page.')
        ->summary('Library content');

    // Subject routes
    Route::get('/subjects', [SubjectController::class, 'index'])
        ->description('Get list of subjects.')
        ->summary('List of subjects');
    Route::get('/subjects/paginated', [SubjectController::class, 'index2'])
        ->description('Get paginated list of levels with subjects. Query parameters: per_page, page for levels; subjects_per_page, subjects_page for subjects.')
        ->summary('Paginated subjects');
});
