<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Settings\LandingPageContent;

class ContentController
{
    use ApiResponse;

    public function getLandingPageContent()
    {
        try {
            $settings = app(LandingPageContent::class);

            $data = [
                'hero' => [
                    'header' => $settings->hero_header,
                    'description' => $settings->hero_description,
                ],
                'contact' => [
                    'phone' => $settings->phone,
                    'email' => $settings->email,
                    'location' => $settings->location,
                ],
                'social_media' => [
                    'facebook' => $settings->facebook_url,
                    'linkedin' => $settings->linkedin_url,
                    'instagram' => $settings->instagram_url,
                ],
                'about' => $settings->about_school,
            ];

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération du contenu de la page d\'accueil');
        }
    }
}
