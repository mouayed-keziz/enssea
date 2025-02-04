<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Video extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'url',
        'professor_id',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile();
    }

    public function getThumbnailAttribute()
    {
        if ($this->hasMedia('thumbnail')) {
            return $this->getFirstMediaUrl('thumbnail');
        }
        if ($this->isYoutubeVideo()) {
            return $this->getYoutubeThumbnail();
        }
        return null;
    }

    public function getRecordTitleAttribute(): string
    {
        return "Video: {$this->title}";
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    private function isYoutubeVideo(): bool
    {
        return str_contains($this->url, 'youtube.com') || str_contains($this->url, 'youtu.be');
    }

    private function getYoutubeThumbnail(): string
    {
        $videoId = $this->getYoutubeVideoId();
        return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
    }

    private function getYoutubeVideoId(): string
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->url, $matches);
        return $matches[1] ?? '';
    }
}
