<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Notifications\Notifiable;

class Professor extends Authenticatable implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'social_media',
        'education',
        'experience',
        'skills',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'social_media' => 'array',
            'education' => 'array',
            'experience' => 'array',
            'skills' => 'array',
            'password' => 'hashed',
        ];
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')
            ->singleFile();

        $this->addMediaCollection('cv')
            ->singleFile();
    }

    public function getProfilePictureAttribute()
    {
        return $this->getFirstMediaUrl('profile_picture');
    }

    public function getCvUrlAttribute()
    {
        return $this->getFirstMediaUrl('cv');
    }

    public function getRecordTitleAttribute(): string
    {
        return "Professeur: {$this->name}";
    }
}
