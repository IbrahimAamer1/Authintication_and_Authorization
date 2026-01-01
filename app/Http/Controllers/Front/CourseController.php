<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Helpers\CacheHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{
    const DIRECTORY = 'front.courses';

    public function index(Request $request)
    {
        // Cache categories (rarely changes, longer TTL)
        $categories = Cache::remember(
            CacheHelper::CATEGORIES_ACTIVE,
            CacheHelper::TTL_VERY_LONG,
            function () {
                return Category::active()->get();
            }
        );
        
        // Cache courses list based on filters
        $cacheKey = CacheHelper::coursesListKey($request->all());
        $data = Cache::remember(
            $cacheKey,
            CacheHelper::TTL_MEDIUM,
            function () use ($request) {
                return $this->getData($request->all());
            }
        );
        
        $courses = $data['courses'];
        return view(self::DIRECTORY . ".index", \get_defined_vars())
            ->with('directory', self::DIRECTORY);
    }

    private function getData($data)
    {
        $perpage = $data['perpage'] ?? 12;
        $word = $data['word'] ?? null;
        $category_id = $data['category_id'] ?? null;
        $level = $data['level'] ?? null;
        $price = $data['price'] ?? null; // free, paid
        $sort = $data['sort'] ?? 'latest'; // latest, price_low, price_high, popular

        $query = Course::published()
            ->with(['category', 'instructor'])
            ->withCount('enrollments')
            ->when($category_id !== null, function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            })
            ->when($level !== null, function ($q) use ($level) {
                $q->where('level', $level);
            })
            ->when($price === 'free', function ($q) {
                $q->where('price', 0);
            })
            ->when($price === 'paid', function ($q) {
                $q->where('price', '>', 0);
            })
            ->when($word != null, function ($q) use ($word) {
                $q->where('title', 'like', '%' . $word . '%')
                  ->orWhere('description', 'like', '%' . $word . '%');
            });

        // Apply sorting
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'popular':
                $query->orderBy('enrollments_count', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $courses = $query->paginate($perpage);

        return [
            'courses' => $courses,
            'data' => $courses, // For compatibility with views that use $data['data']
        ];
    }

    public function show(Course $course)
    {
        // Only show published courses
        if ($course->status !== 'published') {
            abort(404);
        }

        // Load course relationships
        $course->load(['category', 'instructor', 'lessons' => function ($query) {
            $query->published()->orderBy('lesson_order', 'asc');
        }]);

        // Cache course statistics (rating, reviews count, distribution)
        $cacheKey = CacheHelper::courseDetailsKey($course->id) . '_stats';
        $courseStats = Cache::remember(
            $cacheKey,
            CacheHelper::TTL_MEDIUM,
            function () use ($course) {
                return [
                    'averageRating' => $course->getAverageRating(),
                    'reviewsCount' => $course->getReviewsCount(),
                    'ratingDistribution' => $course->getRatingDistribution(),
                ];
            }
        );
        
        $averageRating = $courseStats['averageRating'];
        $reviewsCount = $courseStats['reviewsCount'];
        $ratingDistribution = $courseStats['ratingDistribution'];

        // Load reviews with user relationship (paginated, 10 per page)
        // Reviews are not cached as they change frequently
        $reviews = $course->reviews()
            ->approved()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get user's review if authenticated and enrolled
        $userReview = null;
        if (auth()->check()) {
            $userReview = $course->getUserReview(auth()->id());
        }

        // Cache related courses
        $relatedCacheKey = CacheHelper::relatedCoursesKey($course->id);
        $relatedCourses = Cache::remember(
            $relatedCacheKey,
            CacheHelper::TTL_LONG,
            function () use ($course) {
                return Course::published()
                    ->where('category_id', $course->category_id)
                    ->where('id', '!=', $course->id)
                    ->with(['category', 'instructor'])
                    ->limit(4)
                    ->get();
            }
        );

        // Check if user is enrolled (if authenticated)
        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = $course->isEnrolledBy(auth()->id());
        }

        return view(self::DIRECTORY . ".show", \get_defined_vars());
    }
}
