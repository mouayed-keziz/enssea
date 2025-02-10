<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => $this->faker->word,
        ];
    }

    public function withSubjects(int $count)
    {
        return $this->afterCreating(function ($level) use ($count) {
            $s1Count = intdiv($count, 2);
            $s2Count = $count - $s1Count;
            for ($i = 0; $i < $s1Count; $i++) {
                Subject::factory()->create([
                    'level_id' => $level->id,
                    'subject_semester' => 's1',
                ]);
            }
            for ($i = 0; $i < $s2Count; $i++) {
                Subject::factory()->create([
                    'level_id' => $level->id,
                    'subject_semester' => 's2',
                ]);
            }
        });
    }
}
