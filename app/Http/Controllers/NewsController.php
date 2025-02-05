<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NewsController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $newsPaginated = News::paginate($perPage);
            $mapped = $newsPaginated->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'url' => $item->url,
                    'cover_image' => $item->cover_image,
                    'date' => $item->date,
                ];
            });
            $newsPaginated->setCollection($mapped);
            return $this->successResponse($newsPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des actualités');
        }
    }
}
