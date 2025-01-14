<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LandingPageContent extends Settings
{
    // Hero Section
    public string $hero_header;
    public string $hero_description;

    // Contact Section
    public string $phone;
    public string $email;
    public string $location;

    // Social Media Section
    public string $facebook_url;
    public string $linkedin_url;
    public string $instagram_url;

    // About School Section
    public string $about_school;

    public static function group(): string
    {
        return 'website';
    }
}
