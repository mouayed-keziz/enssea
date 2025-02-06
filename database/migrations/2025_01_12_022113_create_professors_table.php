<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('profile_headline')->nullable();
            $table->text('profile_details')->nullable();
            $table->text('bio')->nullable();
            $table->json('social_media')->nullable(); // Array of {provider, link}
            $table->json('education')->nullable(); // Array of {time, title, description}
            $table->json('experience')->nullable(); // Array of {time, title, description}
            $table->json('skills')->nullable(); // Array of {name, level}
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professors');
    }
};
