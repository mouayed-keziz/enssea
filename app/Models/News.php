<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'content',
        'date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news_cover')
            ->singleFile();
    }

    public function getCoverImageAttribute()
    {
        return $this->hasMedia('news_cover') ? $this->getFirstMediaUrl('news_cover') : null;
    }
    public function getRecordTitleAttribute(): string
    {
        return "News: {$this->title}";
    }
}
