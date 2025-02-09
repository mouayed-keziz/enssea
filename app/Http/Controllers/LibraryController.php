<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Video;
use App\Models\Publication;
use App\Traits\ApiResponse;

class LibraryController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $articlesSearch = $request->query('articles_q', '');
            $videosSearch = $request->query('videos_q', '');

            // Pagination parameters for Articles
            $articlesPage = $request->query('articles_page', 1);
            $articlesPerPage = $request->query('articles_per_page', 10);

            // Pagination parameters for Videos
            $videosPage = $request->query('videos_page', 1);
            $videosPerPage = $request->query('videos_per_page', 10);

            // Pagination and search parameters for Publications
            $publicationsSearch = $request->query('publications_q', '');
            $publicationsPage = $request->query('publications_page', 1);
            $publicationsPerPage = $request->query('publications_per_page', 10);

            // Fetch paginated Articles with search
            $articlesPaginated = Article::with('professor')
                ->when($articlesSearch, function ($query) use ($articlesSearch) {
                    $query->where('title', 'like', "%{$articlesSearch}%");
                })
                ->paginate($articlesPerPage, ['*'], 'articles_page', $articlesPage);

            // Map Articles collection
            $articlesMapped = $articlesPaginated->getCollection()->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'image' => $article->image,
                    'professor' => [
                        'id' => $article->professor->id,
                        'name' => $article->professor->name,
                    ],
                    'created_at' => $article->created_at,
                ];
            });
            $articlesPaginated->setCollection($articlesMapped);

            // Fetch paginated Videos with search
            $videosPaginated = Video::with('professor')
                ->when($videosSearch, function ($query) use ($videosSearch) {
                    $query->where('title', 'like', "%{$videosSearch}%")
                        ->orWhere('description', 'like', "%{$videosSearch}%");
                })
                ->paginate($videosPerPage, ['*'], 'videos_page', $videosPage);

            // Map Videos collection
            $videosMapped = $videosPaginated->getCollection()->map(function ($video) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'description' => $video->description,
                    'url' => $video->url,
                    'thumbnail' => $video->thumbnail,
                    'professor' => [
                        'id' => $video->professor->id,
                        'name' => $video->professor->name,
                    ],
                ];
            });
            $videosPaginated->setCollection($videosMapped);

            // Fetch paginated Publications with search
            $publicationsPaginated = Publication::with('professor')
                ->when($publicationsSearch, function ($query) use ($publicationsSearch) {
                    $query->where('title', 'like', "%{$publicationsSearch}%");
                })
                ->paginate($publicationsPerPage, ['*'], 'publications_page', $publicationsPage);

            // Map Publications collection
            $publicationsMapped = $publicationsPaginated->getCollection()->map(function ($publication) {
                return [
                    'id' => $publication->id,
                    'title' => $publication->title,
                    'description' => $publication->description,
                    'type' => $publication->type,
                    'professor' => [
                        'id' => $publication->professor->id,
                        'name' => $publication->professor->name,
                    ],
                    'image' => $publication->image,
                    'pdf_url' => $publication->pdf,
                ];
            });
            $publicationsPaginated->setCollection($publicationsMapped);

            // Return combined response using successResponse
            return $this->successResponse([
                'data' => [
                    'articles' => $articlesPaginated->toArray(),
                    'videos' => $videosPaginated->toArray(),
                    'publications' => $publicationsPaginated->toArray(),
                ]
            ]);
        } catch (\Exception $e) {
            // Return error response using errorResponse
            return $this->errorResponse('Erreur lors de la récupération des données de la bibliothèque');
        }
    }
}
