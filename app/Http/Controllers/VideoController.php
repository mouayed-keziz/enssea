<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VideoController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $videosPaginated = Video::with('professor')->paginate($perPage);
            $mapped = $videosPaginated->getCollection()->map(function ($video) {
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
            $videosPaginated->setCollection($mapped);
            return $this->successResponse($videosPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des vidéos');
        }
    }
}
