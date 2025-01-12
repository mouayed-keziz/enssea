<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Club extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'website_url',
        'social_media_links',
    ];

    protected $casts = [
        'social_media_links' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('club_logo')
            ->singleFile();
    }

    public function getLogoAttribute()
    {
        return $this->getFirstMediaUrl('club_logo');
    }
    public function getRecordTitleAttribute(): string
    {
        return "Club: {$this->name}";
    }
}
