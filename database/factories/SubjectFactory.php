<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Professor;
use App\Models\Subject;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'subject_semester' => $this->faker->randomElement(['s1', 's2']),
            'professor_id' => Professor::inRandomOrder()->first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Subject $article) {
            try {
                $article->addMediaFromUrl('https://source.unsplash.com/random/800x600')
                    ->toMediaCollection('image');
            } catch (\Exception $e) {
                $article->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('image');
            }
        });
    }
}
