<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Professor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(3, true),
            'professor_id' => Professor::factory(),
        ];
    }

    public function withMedia()
    {
        return $this->afterCreating(function (Article $article) {
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
