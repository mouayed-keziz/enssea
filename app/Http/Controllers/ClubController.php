<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ClubController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $clubsPaginated = Club::paginate($perPage);
            $mapped = $clubsPaginated->getCollection()->map(function ($club) {
                return [
                    'id' => $club->id,
                    'name' => $club->name,
                    'description' => $club->description,
                    'logo' => $club->logo,
                    'website_url' => $club->website_url,
                    'social_media_links' => $club->social_media_links,
                ];
            });
            $clubsPaginated->setCollection($mapped);
            return $this->successResponse($clubsPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des clubs');
        }
    }
}
