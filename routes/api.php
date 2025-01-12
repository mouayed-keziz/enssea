<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;


Route::get("/news", [ContentController::class, 'getNews'])
    ->description('Get list of news items.')
    ->summary("List of news items");

Route::get("/clubs", [ContentController::class, 'getClubs'])
    ->description('Get list of clubs.')
    ->summary("List of clubs");
