<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    // Cache Keys Constants
    const COURSES_LIST = 'courses_list';
    const COURSE_DETAILS = 'course_details';
    const CATEGORIES_ACTIVE = 'categories_active';
    const RELATED_COURSES = 'related_courses';
    
    // Cache TTL (Time To Live) - بالثواني
    const TTL_SHORT = 300;      // 5 دقائق
    const TTL_MEDIUM = 1800;    // 30 دقيقة
    const TTL_LONG = 3600;      // ساعة
    const TTL_VERY_LONG = 7200; // ساعتين
    
    /**
     * Get cache key for courses list
     * 
     * @param array $filters
     * @return string
     */
    public static function coursesListKey(array $filters = []): string
    {
        return self::COURSES_LIST . '_' . md5(json_encode($filters));
    }
    
    /**
     * Get cache key for course details
     * 
     * @param int $courseId
     * @return string
     */
    public static function courseDetailsKey(int $courseId): string
    {
        return self::COURSE_DETAILS . '_' . $courseId;
    }
    
    /**
     * Get cache key for related courses
     * 
     * @param int $courseId
     * @return string
     */
    public static function relatedCoursesKey(int $courseId): string
    {
        return self::RELATED_COURSES . '_' . $courseId;
    }
    
    /**
     * Clear all course-related cache
     * 
     * @param int $courseId
     * @param int|null $categoryId
     * @return void
     */
    public static function clearCourseCache(int $courseId, ?int $categoryId = null): void
    {
        // Clear specific course cache
        Cache::forget(self::courseDetailsKey($courseId));
        Cache::forget(self::courseDetailsKey($courseId) . '_stats');
        Cache::forget(self::relatedCoursesKey($courseId));
        
        // Clear courses list cache (all variations)
        // Note: For file cache, we can't efficiently clear only courses_list
        // For Redis/Memcached, tags would be better but we'll use pattern-based approach
        self::clearCoursesListCache();
    }
    
    /**
     * Clear courses list cache (all filters)
     * 
     * Note: This clears all cache keys starting with courses_list
     * For file cache, this will flush all cache (less efficient)
     * For Redis, we could use patterns but Laravel doesn't support it directly
     * 
     * @return void
     */
    public static function clearCoursesListCache(): void
    {
        // For Redis/Memcached with tags support (if implemented)
        if (config('cache.default') === 'redis' || config('cache.default') === 'memcached') {
            try {
                // Try to use tags if available
                Cache::tags(['courses_list'])->flush();
            } catch (\Exception $e) {
                // If tags not supported, flush all cache
                // This is less ideal but necessary for compatibility
                Cache::flush();
            }
        } else {
            // For file cache, we need to flush all cache
            // This is less efficient but necessary for file cache
            // In production, Redis is strongly recommended
            Cache::flush();
        }
    }
}

