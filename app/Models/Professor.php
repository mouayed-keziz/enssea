<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;

class Professor extends Authenticatable implements HasMedia, FilamentUser, HasAvatar
{
    use HasFactory, InteractsWithMedia, SoftDeletes, Notifiable;

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profilePicture;
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if ($panel->getId() !== "professor") {
            return false;
        }
        return true;
    }


    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profession',
        'profile_headline',
        'profile_details',
        'social_media',
        'education',
        'experience',
        'skills',
        'activities',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'activities' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'social_media' => 'array',
            'education' => 'array',
            'experience' => 'array',
            'skills' => 'array',
            'activities' => 'array',
            'password' => 'hashed',
        ];
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')
            ->singleFile();

        $this->addMediaCollection('cv')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();
    }

    public function getProfilePictureAttribute()
    {
        return $this->hasMedia('profile_picture') ? $this->getFirstMediaUrl('profile_picture') : null;
    }

    public function getCvUrlAttribute()
    {
        return $this->hasMedia('cv') ? $this->getFirstMediaUrl('cv') : null;
    }

    public function getRecordTitleAttribute(): string
    {
        return "Professeur: {$this->name}";
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
