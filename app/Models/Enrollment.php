<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //casts
    protected $casts = [
        'progress_percentage' => 'integer',
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
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

    // Get only enrolled status.
    public function scopeEnrolled($query)
    {
        return $query->where('status', 'enrolled');
    }

    // Get only completed status.
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Get only cancelled status (for admin view only - students cannot cancel).
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Get enrollments by user.
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Get enrollments by course.
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    /////////////////////// METHODS ///////////////////////

    // Mark enrollment as completed.
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);
    }

    // Cancel enrollment (for admin only - students cannot cancel).
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }
}
