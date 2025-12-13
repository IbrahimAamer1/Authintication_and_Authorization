@props([
    'lesson',
    'showDuration' => true,
    'showPreview' => false,
    'isCompleted' => false
])

@php
    $title = $lesson->title ?? 'Lesson Title';
    $description = $lesson->description ?? '';
    $duration = $lesson->video_duration ?? '0:00';
    $order = $lesson->order ?? 0;
    $isPreview = $lesson->is_preview ?? false;
@endphp

<div class="card mb-3 lesson-card {{ $isCompleted ? 'border-success' : '' }}">
    <div class="card-body">
        <div class="d-flex align-items-start">
            <div class="flex-shrink-0 me-3">
                @if($isCompleted)
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded-circle bg-success">
                            <i class="bx bx-check text-white"></i>
                        </span>
                    </div>
                @else
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            {{ $order }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="card-title mb-0">{{ $title }}</h6>
                    @if($isPreview)
                        <span class="badge bg-label-info">Preview</span>
                    @endif
                </div>
                @if($description)
                    <p class="card-text text-muted small">{{ Str::limit($description, 100) }}</p>
                @endif
                <div class="d-flex justify-content-between align-items-center">
                    @if($showDuration)
                        <small class="text-muted">
                            <i class="bx bx-time"></i> {{ $duration }}
                        </small>
                    @endif
                    <a href="{{ route('student.lessons.show', $lesson->id ?? '#') }}" class="btn btn-sm btn-outline-primary">
                        @if($isCompleted)
                            Review
                        @else
                            Start Lesson
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

