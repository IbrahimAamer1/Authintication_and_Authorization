@props(['course', 'progress'])

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">{{ $course->title ?? 'Course Title' }}</h5>
            <span class="badge bg-label-primary">{{ $progress ?? 0 }}%</span>
        </div>
        <div class="progress mb-3" style="height: 8px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress ?? 0 }}%" aria-valuenow="{{ $progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">{{ $course->lessons_completed ?? 0 }} of {{ $course->total_lessons ?? 0 }} lessons completed</small>
            <a href="{{ route('student.courses.show', $course->id ?? '#') }}" class="btn btn-sm btn-outline-primary">Continue</a>
        </div>
    </div>
</div>

