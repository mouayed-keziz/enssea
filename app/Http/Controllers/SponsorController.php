<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SponsorController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $sponsorsPaginated = Sponsor::paginate($perPage);
            $mapped = $sponsorsPaginated->getCollection()->map(function ($sponsor) {
                return [
                    'id' => $sponsor->id,
                    'name' => $sponsor->name,
                    'description' => $sponsor->description,
                    'url' => $sponsor->url,
                    'logo' => $sponsor->logo,
                ];
            });
            $sponsorsPaginated->setCollection($mapped);
            return $this->successResponse($sponsorsPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des sponsors');
        }
    }
}
