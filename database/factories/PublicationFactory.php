<?php

namespace Database\Factories;

use App\Enums\PublicationType;
use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    protected $model = Publication::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'type' => $this->faker->randomElement(PublicationType::cases()),
            'professor_id' => \App\Models\Professor::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Publication $publication) {
            try {
                $publication->addMediaFromUrl('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf')
                    ->toMediaCollection('pdf');
            } catch (\Exception $e) {
                // If PDF fetch fails, skip attachment
            }
        });
    }
}
