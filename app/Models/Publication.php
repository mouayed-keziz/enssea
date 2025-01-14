<?php

namespace App\Models;

use App\Enums\PublicationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Publication extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'professor_id'
    ];

    protected $casts = [
        'type' => \App\Enums\PublicationType::class,
    ];

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pdf')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();
    }
}
