<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'professor_id'
    ];

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    public function getRecordTitleAttribute(): string
    {
        return "Article : {$this->title}";
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function getImageAttribute()
    {
        return $this->hasMedia('image') ? $this->getFirstMediaUrl('image') : null;
    }
}
