<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\Club;
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

        // Create professors with videos and publications
        // Professor::factory()->withVideos(3)->withPublications(2)->create();
        // Professor::factory()->withVideos(5)->withPublications(4)->create();
        // Professor::factory()->withVideos(2)->withPublications(3)->create();
        Professor::factory(3)->create();

        // News::factory()->count(3)->create();
        // Club::factory()->count(3)->create();
        // Sponsor::factory()->count(3)->create();
    }
}
