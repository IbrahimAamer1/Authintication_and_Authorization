<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //casts
    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /////////////////////// SCOPES ///////////////////////

    // Get only approved reviews.
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Get reviews for specific course.
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    // Get reviews by specific user.
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /////////////////////// METHODS ///////////////////////

    /**
     * Check if review belongs to a specific user.
     * 
     * @param int $userId The user ID to check
     * @return bool True if review belongs to user, false otherwise
     */
    public function isOwnedBy($userId)
    {
        return $this->user_id == $userId;
    }
}
