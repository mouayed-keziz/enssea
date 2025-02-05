<?php

namespace Database\Factories;

use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorFactory extends Factory
{
    protected $model = Sponsor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
        ];
    }


    public function withMedia()
    {
        return $this->afterCreating(function (Sponsor $sponsor) {
            try {
                $sponsor->addMediaFromUrl('https://source.unsplash.com/random/800x600')
                    ->toMediaCollection('sponsor_logo');
            } catch (\Exception $e) {
                $sponsor->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('sponsor_logo');
            }
        });
    }
}
