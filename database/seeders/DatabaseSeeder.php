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

        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.dev',
        //     'password' => bcrypt('admin'),
        // ]);

        // Create professors with different numbers of videos
        Professor::factory()->withVideos(3)->create(); // professor with 3 videos
        Professor::factory()->withVideos(5)->create(); // professor with 5 videos
        Professor::factory()->withVideos(2)->create(); // professor with 2 videos

        // News::factory()->count(3)->create();
        // Club::factory()->count(3)->create();
        // Sponsor::factory()->count(3)->create();
        // Professor::factory()->count(3)->create();
    }
}
