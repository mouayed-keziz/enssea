<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    private array $youtubeUrls = [
        "https://www.youtube.com/watch?v=SlT4Qt7FLvQ",
        "https://www.youtube.com/watch?v=8rrvYn-2GfA",
        "https://www.youtube.com/watch?v=0NcPkQsKZSQ",
        "https://www.youtube.com/watch?v=BNiTVsAlzlc",
        "https://www.youtube.com/watch?v=v8w_P9Am2x8",
        "https://www.youtube.com/watch?v=M0dwYm_BQ5c",
        "https://www.youtube.com/watch?v=phpjcP2fAvw",
    ];

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'url' => $this->faker->randomElement($this->youtubeUrls),
            'professor_id' => \App\Models\Professor::factory(),
        ];
    }
}
