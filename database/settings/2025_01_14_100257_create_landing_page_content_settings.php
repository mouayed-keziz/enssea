<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Hero Section
        $this->migrator->add('website.hero_header', 'Welcome to ENSSEA');
        $this->migrator->add('website.hero_description', "The National Higher School of Statistics and Applied Economics (ENSSEA) in Algeria is a top-tier institution specializing in statistics and applied economics. It offers rigorous academic programs and hands-on training to prepare students for careers in analytics, finance, and public administration, playing a key role in Algeria's socio-economic growth.");

        // Contact Section
        $this->migrator->add('website.phone', '+123 400 123');
        $this->migrator->add('website.email', 'example@mail.com');
        $this->migrator->add('website.location', 'Praesent nulla massa, hendrerit vestibulum gravida in, feugiat auctor felis.');

        // Social Media Section
        $this->migrator->add('website.facebook_url', 'https://facebook.com');
        $this->migrator->add('website.linkedin_url', 'https://linkedin.com');
        $this->migrator->add('website.instagram_url', 'https://instagram.com');

        // About School Section
        $this->migrator->add('website.about_school', 'Lorem Ipsum has been them an industry printer took a galley make book.Lorem Ipsum has been them an industry printer took a galley make book.Lorem Ipsum has been them an industry printer took a galley make book.Lorem Ipsum has been them an industry printer took a galley make book.');
    }
};
