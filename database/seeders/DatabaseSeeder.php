<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\Club;
use App\Models\EventAnnouncement;
use App\Models\News;
use App\Models\Professor;
use App\Models\User;
use App\Models\Level; // added for level factory
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

        Professor::factory()->withVideos(10)->withArticles(12)->withPublications(2)->create();
        Professor::factory()->withVideos(8)->withArticles(7)->withPublications(6)->create();
        Professor::factory()->withVideos(8)->withArticles(3)->withPublications(1)->create();
        Professor::factory()->withVideos(0)->withArticles(2)->withPublications(5)->create();
        // Professor::factory(3)->withMedia()->create();

        News::factory()->count(23)->create();
        Club::factory()->count(7)->create();
        Sponsor::factory()->count(11)->create();
        EventAnnouncement::factory(12)->create();

        //  News::factory()->withMedia()->create();
        // Club::factory()->withMedia()->create();
        // Sponsor::factory()->withMedia()->create();
        // EventAnnouncement::factory()->withMedia()->create();
        Level::factory(4)->withSubjects(16)->create();
    }
}
