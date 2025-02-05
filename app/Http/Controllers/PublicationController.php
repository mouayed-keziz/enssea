<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PublicationController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $publicationsPaginated = Publication::with('professor')->paginate($perPage);
            $mapped = $publicationsPaginated->getCollection()->map(function ($publication) {
                return [
                    'id' => $publication->id,
                    'title' => $publication->title,
                    'description' => $publication->description,
                    'type' => $publication->type,
                    'professor' => [
                        'id' => $publication->professor->id,
                        'name' => $publication->professor->name,
                    ],
                    'pdf_url' => $publication->pdf,
                ];
            });
            $publicationsPaginated->setCollection($mapped);
            return $this->successResponse($publicationsPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des publications');
        }
    }
}
