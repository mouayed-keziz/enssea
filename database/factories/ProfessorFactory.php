<?php

namespace Database\Factories;

use App\Models\Professor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ProfessorFactory extends Factory
{
    protected $model = Professor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Default password
            'bio' => $this->faker->paragraph,
            'social_media' => [
                'facebook' => $this->faker->url,
                'twitter' => $this->faker->url,
                'instagram' => $this->faker->url,
            ],
            'education' => [
                ['time' => '2008 - 2012', 'title' => 'Bachelor of Science', 'description' => 'University of XYZ'],
                ['time' => '2012 - 2014', 'title' => 'Master of Science', 'description' => 'University of ABC'],
            ],
            'experience' => [
                ['time' => '2014 - 2016', 'title' => 'Software Engineer', 'description' => 'Company A'],
                ['time' => '2016 - Present', 'title' => 'Senior Software Engineer', 'description' => 'Company B'],
            ],
            'skills' => [
                ['name' => 'PHP', 'level' => 90],
                ['name' => 'JavaScript', 'level' => 85],
            ],
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Professor $professor) {
            try {
                // Add a random profile picture
                $professor->addMediaFromUrl('https://source.unsplash.com/random/800x600')
                    ->toMediaCollection('profile_picture');
            } catch (\Exception $e) {
                // Fallback to a placeholder image if Unsplash fails
                $professor->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('profile_picture');
            }

            try {
                // Add a random CV file (PDF)
                $professor->addMediaFromUrl('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf')
                    ->toMediaCollection('cv');
            } catch (\Exception $e) {
                // If PDF fetch fails, skip CV attachment
            }
        });
    }
}
