<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\Club;
use App\Models\EventAnnouncement;
use App\Models\News;
use App\Models\Professor;
use App\Models\User;
use App\Models\Level; // added for level factory
use App\Models\Specialization; // added for specialization factory
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

        // Professor::factory()->withVideos(10)->withArticles(12)->withPublications(2)->withMedia()->create();
        // Professor::factory()->withVideos(8)->withArticles(7)->withPublications(6)->withMedia()->create();
        // Professor::factory()->withVideos(8)->withArticles(3)->withPublications(1)->withMedia()->create();
        // Professor::factory()->withVideos(0)->withArticles(2)->withPublications(5)->withMedia()->create();
        // Professor::factory(3)->withMedia()->create();

        // News::factory()->count(23)->withMedia()->create();
        // Club::factory()->count(7)->withMedia()->create();
        // Sponsor::factory()->count(11)->withMedia()->create();
        // EventAnnouncement::factory(12)->withMedia()->create();

        // Remove: Level::factory(5)->withSubjects(16)->create();

        // Create 2 specializations:
        // Specialization::factory()->withMedia()->withLevels(2)->create();
        // Specialization::factory()->withMedia()->withLevels(3)->create();
    }
}
