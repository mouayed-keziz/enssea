<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    protected $model = Club::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'website_url' => $this->faker->url,
            'social_media_links' => [
                'facebook' => $this->faker->url,
                'twitter' => $this->faker->url,
                'instagram' => $this->faker->url,
            ],
        ];
    }

    public function withMedia()
    {
        return $this->afterCreating(function (Club $club) {
            try {
                $club->addMediaFromUrl('https://source.unsplash.com/random/800x600')
                    ->toMediaCollection('club_logo');
            } catch (\Exception $e) {
                $club->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('club_logo');
            }
        });
    }
}
