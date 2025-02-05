<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ArticleController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $articlesPaginated = Article::with('professor')->paginate($perPage);
            $mapped = $articlesPaginated->getCollection()->map(function ($article) {
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
            $articlesPaginated->setCollection($mapped);
            return $this->successResponse($articlesPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des articles');
        }
    }

    public function show($slug)
    {
        try {
            $article = Article::where('slug', $slug)->with('professor')->firstOrFail();
            return $this->successResponse([
                'article' => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'content' => $article->content,
                    'slug' => $article->slug,
                    'professor' => [
                        'id' => $article->professor->id,
                        'name' => $article->professor->name,
                    ],
                    'created_at' => $article->created_at,
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Article non trouvé');
        }
    }
}
