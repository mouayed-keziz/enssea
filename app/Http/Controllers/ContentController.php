<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of news items.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNews()
    {
        $news = News::all();
        return $news->map(function ($news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'cover_image' => $news->cover_image,
            ];
        });
    }
}
