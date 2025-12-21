@extends('front.master')
@section('title', __('lang.courses') ?? 'Courses')

@push('styles')
    @includeIf("$directory.pushStyles")
@endpush

@section('content')
    <div class="container-xxl py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-2">{{ __('lang.courses') ?? 'Courses' }}</h2>
                <p class="text-muted">{{ __('lang.browse_all_courses') ?? 'Browse all available courses' }}</p>
            </div>
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3 mb-4">
                @include("$directory.filter", ['categories' => $categories ?? []])
            </div>

            <!-- Courses Grid -->
            <div class="col-lg-9">
                @if(isset($courses) && $courses->count() > 0)
                    <div class="row">
                        @foreach($courses as $course)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 course-card">
                                    @if($course->image)
                                        <img src="{{ $course->getImageUrl() }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bx bx-book display-4 text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        @if($course->category)
                                            <span class="badge bg-label-info mb-2">{{ $course->category->name }}</span>
                                        @endif
                                        <h5 class="card-title">{{ Str::limit($course->title, 50) }}</h5>
                                        <p class="card-text text-muted small flex-grow-1">
                                            {{ Str::limit($course->description ?? '', 100) }}
                                        </p>
                                        <div class="mb-2">
                                            @if($course->instructor)
                                                <small class="text-muted">
                                                    <i class="bx bx-user"></i> {{ $course->instructor->name }}
                                                </small>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <span class="badge bg-label-{{ $course->level == 'beginner' ? 'success' : ($course->level == 'intermediate' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($course->level) }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            @if($course->hasDiscount())
                                                <span class="text-decoration-line-through text-muted small">{{ $course->price }}</span>
                                                <span class="fw-bold text-danger ms-2">{{ $course->getFinalPrice() }}</span>
                                                <span class="badge bg-label-danger ms-1">{{ $course->getDiscountPercentage() }}%</span>
                                            @else
                                                <span class="fw-bold">{{ $course->getFinalPrice() == 0 ? __('lang.free') : $course->getFinalPrice() }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="bx bx-time"></i> {{ $course->getFormattedDuration() }}
                                            </small>
                                            <small class="text-muted ms-3">
                                                <i class="bx bx-group"></i> {{ $course->enrollments_count ?? 0 }} {{ __('lang.students') ?? 'students' }}
                                            </small>
                                        </div>
                                        <a href="{{ route('front.courses.show', $course) }}" class="btn btn-primary btn-sm mt-auto">
                                            {{ __('lang.view_details') ?? 'View Details' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-12">
                            {{ $courses->links() }}
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="bx bx-info-circle display-4"></i>
                        <h4 class="mt-3">{{ __('lang.no_courses_found') ?? 'No Courses Found' }}</h4>
                        <p>{{ __('lang.no_courses_message') ?? 'Try adjusting your filters or search criteria.' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @includeIf("$directory.pushScripts")
@endpush

