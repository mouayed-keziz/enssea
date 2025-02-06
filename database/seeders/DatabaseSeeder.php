<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\Club;
use App\Models\EventAnnouncement;
use App\Models\News;
use App\Models\Professor;
use App\Models\User;
use App\Models\Article;
use App\Models\Publication;
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

        Professor::factory()
            ->withVideos(10)
            ->withArticles(12)->has(Article::factory(12)->withMedia())
            ->withPublications(2)->has(Publication::factory(2)->withMedia())
            ->withMedia()
            ->create();
        Professor::factory()
            ->withVideos(8)
            ->withArticles(7)->has(Article::factory(7)->withMedia())
            ->withPublications(6)->has(Publication::factory(6)->withMedia())
            ->withMedia()
            ->create();
        Professor::factory()
            ->withVideos(8)
            ->withArticles(3)->has(Article::factory(3)->withMedia())
            ->withPublications(1)->has(Publication::factory(1)->withMedia())
            ->withMedia()
            ->create();
        Professor::factory()
            ->withVideos(0)
            ->withArticles(2)->has(Article::factory(2)->withMedia())
            ->withPublications(5)->has(Publication::factory(5)->withMedia())
            ->withMedia()
            ->create();
        // Professor::factory(3)->withMedia()->create();

        News::factory()->count(23)->withMedia()->create();
        Club::factory()->count(7)->withMedia()->create();
        Sponsor::factory()->count(11)->withMedia()->create();
        EventAnnouncement::factory(12)->withMedia()->create();

        // News::factory()->withMedia()->create();
        // Club::factory()->withMedia()->create();
        // Sponsor::factory()->withMedia()->create();
        // EventAnnouncement::factory()->withMedia()->create();
    }
}
