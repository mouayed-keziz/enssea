<?php

namespace Database\Factories;

use App\Models\Specialization;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialization>
 */
class SpecializationFactory extends Factory
{
    protected $model = Specialization::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }

    public function withMedia(): static
    {
        return $this->afterCreating(function (Specialization $article) {
            try {
                $article->addMediaFromUrl('https://source.unsplash.com/random/800x600')
                    ->toMediaCollection('image');
            } catch (\Exception $e) {
                $article->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('image');
            }
        });
    }

    public function withLevels(int $count = 3): static
    {
        return $this->afterCreating(function (Specialization $specialization) use ($count) {
            Level::factory()->count($count)->withSubjects(16)->create([
                'specialization_id' => $specialization->id,
            ]);
        });
    }
}
