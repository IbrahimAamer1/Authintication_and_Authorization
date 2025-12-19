<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Lesson extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = ['id'];

    //casts
    protected $casts = [
        'lesson_order' => 'integer',
        'is_free' => 'boolean',
        'is_published' => 'boolean',
    ];

    // get video url
    public function getVideoUrl()
    {
        if ($this->video_file) {
            // If video_file doesn't start with 'lessons/', assume it's just a filename
            // and prepend 'lessons/' to it
            $videoPath = $this->video_file;
            if (!str_starts_with($videoPath, 'lessons/')) {
                $videoPath = 'lessons/' . $videoPath;
            }
            return asset('storage/' . $videoPath);
        }
        return null;
    }

    // relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // slug options
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    // get route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /////////////////////// SCOPES ///////////////////////

    // Get only published lessons.
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Get free lessons.
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    // Get lessons by course.
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }
}
