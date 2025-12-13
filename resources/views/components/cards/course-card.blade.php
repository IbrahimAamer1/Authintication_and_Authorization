@props([
    'course',
    'showProgress' => false,
    'progress' => 0,
    'showEnrollButton' => true,
    'showPrice' => true
])

@php
    $image = $course->image ?? asset('assets-front/img/course-placeholder.jpg');
    $title = $course->title ?? 'Course Title';
    $description = $course->description ?? '';
    $price = $course->price ?? 0;
    $instructor = $course->instructor->name ?? 'Instructor';
    $rating = $course->average_rating ?? 0;
    $studentsCount = $course->enrollments_count ?? 0;
    $lessonsCount = $course->lessons_count ?? 0;
@endphp

<div class="card mb-4 course-card">
    <div class="card-img-top-wrapper">
        <img src="{{ $image }}" class="card-img-top" alt="{{ $title }}" style="height: 200px; object-fit: cover;">
        @if($showPrice)
            <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                @if($price > 0)
                    ${{ number_format($price, 2) }}
                @else
                    Free
                @endif
            </span>
        @endif
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ Str::limit($title, 50) }}</h5>
        <p class="card-text text-muted">{{ Str::limit($description, 100) }}</p>
        
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="text-muted">
                <i class="bx bx-user"></i> {{ $instructor }}
            </small>
            <div>
                @for($i = 1; $i <= 5; $i++)
                    <i class="bx {{ $i <= $rating ? 'bxs-star text-warning' : 'bx-star text-muted' }}"></i>
                @endfor
                <small class="text-muted ms-1">({{ $rating }})</small>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted">
                <i class="bx bx-group"></i> {{ $studentsCount }} students
            </small>
            <small class="text-muted">
                <i class="bx bx-book"></i> {{ $lessonsCount }} lessons
            </small>
        </div>

        @if($showProgress && $progress > 0)
            <div class="progress mb-3" style="height: 6px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">{{ $progress }}% Complete</small>
        @endif

        @if($showEnrollButton)
            <div class="mt-3">
                <a href="{{ route('student.courses.show', $course->id ?? '#') }}" class="btn btn-primary w-100">
                    @if($progress > 0)
                        Continue Learning
                    @else
                        View Course
                    @endif
                </a>
            </div>
        @endif
    </div>
</div>

