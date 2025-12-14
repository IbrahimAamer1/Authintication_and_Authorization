<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the image URL.
     *
     * @return string|null
     */
    public function getImageUrl()
    {
        if ($this->image) {
            // If image doesn't start with 'categories/', assume it's just a filename
            // and prepend 'categories/' to it
            $imagePath = $this->image;
            if (!str_starts_with($imagePath, 'categories/')) {
                $imagePath = 'categories/' . $imagePath;
            }
            return asset('storage/' . $imagePath);
        }
        return null;
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the courses for the category.
     * Note: Course model will be created in the next phase
     */
    public function courses()
    {
        // Using string to avoid error until Course model exists
        // Will be updated when Course model is created
        return $this->hasMany('App\Models\Course');
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->sort_order = self::max('sort_order') + 1;
        });
    }
}

