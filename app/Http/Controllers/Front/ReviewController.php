<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
   
    public function store(StoreReviewRequest $request, Course $course)
    {
        // Additional check: ensure user is enrolled
        if (!$course->isEnrolledBy(Auth::id())) {
            return response()->json([
                'error' => __('lang.must_be_enrolled_to_review') ?? 'You must be enrolled in this course to write a review.'
            ], 403);
        }

        // Additional check: ensure user doesn't already have a review
        if ($course->hasUserReviewed(Auth::id())) {
            return response()->json([
                'error' => __('lang.already_reviewed') ?? 'You have already reviewed this course. You can edit your existing review.'
            ], 422);
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        return response()->json([
            'success' => __('lang.review_submitted') ?? 'Review submitted successfully',
            'review' => $review->load('user'),
            'average_rating' => $course->fresh()->getAverageRating(),
            'reviews_count' => $course->fresh()->getReviewsCount(),
        ]);
    }

   
    public function update(UpdateReviewRequest $request, Course $course, Review $review)
    {
        // Additional check: ensure review belongs to course
        if ($review->course_id !== $course->id) {
            return response()->json([
                'error' => __('lang.invalid_review') ?? 'Invalid review for this course.'
            ], 422);
        }

        // Additional check: ensure user owns the review
        if (!$review->isOwnedBy(Auth::id())) {
            return response()->json([
                'error' => __('lang.unauthorized') ?? 'Unauthorized'
            ], 403);
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => __('lang.review_updated') ?? 'Review updated successfully',
            'review' => $review->fresh()->load('user'),
            'average_rating' => $course->fresh()->getAverageRating(),
            'reviews_count' => $course->fresh()->getReviewsCount(),
        ]);
    }

   
    public function destroy(Course $course, Review $review)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'error' => __('lang.unauthorized') ?? 'Unauthorized'
            ], 401);
        }

        // Additional check: ensure review belongs to course
        if ($review->course_id !== $course->id) {
            return response()->json([
                'error' => __('lang.invalid_review') ?? 'Invalid review for this course.'
            ], 422);
        }

        // Additional check: ensure user owns the review
        if (!$review->isOwnedBy(Auth::id())) {
            return response()->json([
                'error' => __('lang.unauthorized') ?? 'Unauthorized'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => __('lang.review_deleted') ?? 'Review deleted successfully',
            'average_rating' => $course->fresh()->getAverageRating(),
            'reviews_count' => $course->fresh()->getReviewsCount(),
        ]);
    }
}
