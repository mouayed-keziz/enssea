<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EventAnnouncement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventAnnouncement>
 */
class EventAnnouncementFactory extends Factory
{
    protected $model = EventAnnouncement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'date' => fake()->dateTimeBetween('now', '+1 year'),
            'location' => fake()->address(),
            'content' => fake()->paragraph(5),
        ];
    }

    public function withMedia()
    {
        return $this->afterCreating(function (EventAnnouncement $event_announcement) {
            try {
                $event_announcement->addMediaFromUrl('https://source.unsplash.com/random/800x600')
                    ->toMediaCollection('image');
            } catch (\Exception $e) {
                $event_announcement->addMediaFromUrl('https://picsum.photos/800/600')
                    ->toMediaCollection('image');
            }
        });
    }
}
