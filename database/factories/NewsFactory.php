<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (News $news) {
            try {
                // Try to add an image from Unsplash
                $news->addMediaFromUrl('https://source.unsplash.com/random/800x600')
                    ->toMediaCollection('news_cover');
            } catch (\Exception $e) {
                // Fallback to a placeholder image if Unsplash fails
                $news->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('news_cover');
            }
        });
    }
}
