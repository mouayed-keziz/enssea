<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Subject extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'subject_semester',
        'level_id',
        'professor_id'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
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
