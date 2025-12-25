@extends('layouts.instructor.master')
@section('title', $course->title ?? 'Course Details')
@section('courses_active', 'active bg-light')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h2 class="h5 page-title">{{ $course->title ?? 'Course Details' }}</h2>
                <div>
                    <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-edit"></i> {{ __('lang.edit') ?? 'Edit' }}
                    </a>
                    <a href="{{ route('instructor.courses.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> {{ __('lang.back') ?? 'Back' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if($course->image)
                <img src="{{ $course->getImageUrl() }}" alt="{{ $course->title }}" class="img-fluid rounded mb-3">
            @else
                <div class="bg-light rounded p-5 text-center mb-3">
                    <i class="bx bx-image display-4 text-muted"></i>
                    <p class="text-muted mt-2">No Image</p>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">{{ __('lang.title') ?? 'Title' }}</th>
                    <td>{{ $course->title }}</td>
                </tr>
                <tr>
                    <th>{{ __('lang.slug') ?? 'Slug' }}</th>
                    <td>{{ $course->slug }}</td>
                </tr>
                <tr>
                    <th>{{ __('lang.category') ?? 'Category' }}</th>
                    <td>
                        @if($course->category)
                            <span class="badge bg-label-info">{{ $course->category->name }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ __('lang.instructor') ?? 'Instructor' }}</th>
                    <td>
                        @if($course->instructor)
                            {{ $course->instructor->name }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ __('lang.level') ?? 'Level' }}</th>
                    <td>
                        <span class="badge bg-label-{{ $course->level == 'beginner' ? 'success' : ($course->level == 'intermediate' ? 'warning' : 'danger') }}">
                            {{ ucfirst($course->level) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>{{ __('lang.price') ?? 'Price' }}</th>
                    <td>
                        @if($course->hasDiscount())
                            <span class="text-decoration-line-through text-muted">{{ $course->price }}</span>
                            <span class="text-danger fw-bold ms-2">{{ $course->getFinalPrice() }}</span>
                            <span class="badge bg-label-danger ms-2">{{ $course->getDiscountPercentage() }}% {{ __('lang.off') ?? 'Off' }}</span>
                        @else
                            <span class="fw-bold">{{ $course->getFinalPrice() }}</span>
                        @endif
                    </td>
                </tr>
                @if($course->duration)
                <tr>
                    <th>{{ __('lang.duration') ?? 'Duration' }}</th>
                    <td>{{ $course->getFormattedDuration() }}</td>
                </tr>
                @endif
                @if($course->language)
                <tr>
                    <th>{{ __('lang.language') ?? 'Language' }}</th>
                    <td>{{ strtoupper($course->language) }}</td>
                </tr>
                @endif
                <tr>
                    <th>{{ __('lang.status') ?? 'Status' }}</th>
                    <td>
                        @if($course->status == 'published')
                            <span class="badge bg-label-success">{{ __('lang.published') ?? 'Published' }}</span>
                        @else
                            <span class="badge bg-label-warning">{{ __('lang.draft') ?? 'Draft' }}</span>
                        @endif
                    </td>
                </tr>
                @if($course->description)
                <tr>
                    <th>{{ __('lang.description') ?? 'Description' }}</th>
                    <td>{{ $course->description }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    <!-- Course Lessons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        {{ __('lang.course_lessons') ?? 'Course Lessons' }} 
                        <span class="badge bg-label-primary">({{ $course->lessons->count() }})</span>
                    </h5>
                    <a href="{{ route('instructor.lessons.create') }}?course_id={{ $course->id }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus-circle"></i> {{ __('lang.add_new_lesson') ?? 'Add New Lesson' }}
                    </a>
                </div>
                <div class="card-body">
                    @if($course->lessons && $course->lessons->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>{{ __('lang.lesson_order') ?? 'Order' }}</th>
                                        <th>{{ __('lang.title') ?? 'Title' }}</th>
                                        <th>{{ __('lang.video') ?? 'Video' }}</th>
                                        <th>{{ __('lang.type') ?? 'Type' }}</th>
                                        <th>{{ __('lang.status') ?? 'Status' }}</th>
                                        <th width="15%">{{ __('lang.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->lessons as $lesson)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge bg-label-secondary">{{ $lesson->lesson_order }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-semibold">{{ $lesson->title }}</div>
                                                    @if($lesson->description)
                                                        <small class="text-muted">{{ Str::limit($lesson->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($lesson->video_file)
                                                    <span class="badge bg-label-success">
                                                        <i class="bx bx-video"></i> {{ __('lang.has_video') ?? 'Has Video' }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-label-secondary">{{ __('lang.no_video') ?? 'No Video' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($lesson->is_free)
                                                    <span class="badge bg-label-success">{{ __('lang.free') ?? 'Free' }}</span>
                                                @else
                                                    <span class="badge bg-label-warning">{{ __('lang.paid') ?? 'Paid' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($lesson->is_published)
                                                    <span class="badge bg-label-success">{{ __('lang.published') ?? 'Published' }}</span>
                                                @else
                                                    <span class="badge bg-label-warning">{{ __('lang.draft') ?? 'Draft' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('instructor.lessons.show', $lesson) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="{{ __('lang.view') ?? 'View' }}">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('instructor.lessons.edit', $lesson) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="{{ __('lang.edit') ?? 'Edit' }}">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger delete-btn" 
                                                            data-url="{{ route('instructor.lessons.destroy', $lesson) }}"
                                                            data-name="{{ $lesson->title }}"
                                                            title="{{ __('lang.delete') ?? 'Delete' }}">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-video display-4 text-muted"></i>
                            <p class="text-muted mt-2">{{ __('lang.no_lessons_available') ?? 'No lessons available for this course.' }}</p>
                            <a href="{{ route('instructor.lessons.create') }}?course_id={{ $course->id }}" class="btn btn-primary mt-2">
                                <i class="bx bx-plus-circle"></i> {{ __('lang.add_first_lesson') ?? 'Add First Lesson' }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Students Enrolled -->
    @if($course->enrollments && $course->enrollments->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('lang.enrolled_students') ?? 'Enrolled Students' }} ({{ $course->enrollments->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.student') ?? 'Student' }}</th>
                                    <th>{{ __('lang.enrolled_at') ?? 'Enrolled At' }}</th>
                                    <th>{{ __('lang.progress') ?? 'Progress' }}</th>
                                    <th>{{ __('lang.status') ?? 'Status' }}</th>
                                    <th>{{ __('lang.actions') ?? 'Actions' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->enrollments as $enrollment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        {{ substr($enrollment->user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $enrollment->user->name }}</div>
                                                    <small class="text-muted">{{ $enrollment->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $enrollment->enrolled_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $enrollment->progress_percentage }}%"
                                                     aria-valuenow="{{ $enrollment->progress_percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $enrollment->progress_percentage }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($enrollment->status == 'enrolled')
                                                <span class="badge bg-label-primary">{{ __('lang.enrolled') ?? 'Enrolled' }}</span>
                                            @elseif($enrollment->status == 'completed')
                                                <span class="badge bg-label-success">{{ __('lang.completed') ?? 'Completed' }}</span>
                                            @else
                                                <span class="badge bg-label-danger">{{ __('lang.cancelled') ?? 'Cancelled' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('instructor.students.show', ['user' => $enrollment->user, 'course' => $course]) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-show"></i> {{ __('lang.view') ?? 'View' }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Delete lesson functionality
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            let name = $(this).data('name');
            
            if (!confirm('{{ __("lang.are_you_sure_delete") ?? "Are you sure you want to delete" }} "' + name + '"?')) {
                return;
            }

            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('{{ __("lang.error_occurred") ?? "An error occurred" }}');
                    }
                },
                error: function(xhr) {
                    let errorMessage = '{{ __("lang.error_occurred") ?? "An error occurred" }}';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        });
    });
</script>
@endpush
