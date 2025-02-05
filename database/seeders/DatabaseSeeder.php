<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\Club;
use App\Models\EventAnnouncement;
use App\Models\News;
use App\Models\Professor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.dev',
            'password' => bcrypt('admin'),
        ]);

        Professor::factory()->withVideos(5)->withArticles(2)->withPublications(4)->create();
        Professor::factory()->withVideos(2)->withArticles(3)->withPublications(3)->create();
        Professor::factory(3)->create();

        News::factory()->count(17)->create();
        Club::factory()->count(6)->create();
        Sponsor::factory()->count(10)->create();
        EventAnnouncement::factory(12)->create();

        // News::factory()->withMedia()->create();
        // Club::factory()->withMedia()->create();
        // Sponsor::factory()->withMedia()->create();
        // EventAnnouncement::factory()->withMedia()->create();
    }
}
