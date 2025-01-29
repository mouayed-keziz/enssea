<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Sponsor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'url',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('sponsor_logo')
            ->singleFile();
    }

    public function getLogoAttribute()
    {
        return $this->hasMedia('sponsor_logo') ? $this->getFirstMediaUrl('sponsor_logo') : null;
    }
    public function getRecordTitleAttribute(): string
    {
        return "Sponsor: {$this->name}";
    }
}
