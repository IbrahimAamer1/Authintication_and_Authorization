<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class Course extends Model
{
    use HasFactory, HasSlug;

   
    protected $guarded = ['id'];

   //casts
   protected $casts = [
    'price' => 'decimal:2',
    'discount_price' => 'decimal:2',
    'duration' => 'integer',
    'sort_order' => 'integer',
   
];
    
   // get image url
    public function getImageUrl()
    {
        if ($this->image) {
            // If image doesn't start with 'courses/', assume it's just a filename
            // and prepend 'courses/' to it
            $imagePath = $this->image;
            if (!str_starts_with($imagePath, 'courses/')) {
                $imagePath = 'courses/' . $imagePath;
            }
            return asset('storage/' . $imagePath);
        }
        return null;
    }


    // relationships
    public function instructor()
    {
        return $this->belongsTo(Admin::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
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


    // get final price

    public function getFinalPrice()
    {
        return $this->discount_price ?? $this->price;
    }

    // check if course has discount
    public function hasDiscount()
    {
        return $this->discount_price !== null 
            && $this->discount_price < $this->price;
    }

    // get discount percentage
    public function getDiscountPercentage()
    {
        if ($this->hasDiscount()) {
            $discount = $this->price - $this->discount_price;
            return round(($discount / $this->price) * 100);
        }
        return 0;
    }
    
 
      /////////////////////// SCOPES ///////////////////////

    // Get only published courses.
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Get courses by category.
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }   



    // Get formatted duration.
    public function getFormattedDuration()
    {
        if (!$this->duration) {
            return 'N/A';
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours} hours {$minutes} minutes";
        } elseif ($hours > 0) {
            return "{$hours} hours";
        } else {
            return "{$minutes} minutes";
        }
    }




}
