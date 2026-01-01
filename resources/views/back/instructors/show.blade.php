@extends('back.master')
@section('title', __('lang.instructor_details') ?? 'Instructor Details')
@section('instructors_active', 'active bg-light')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h2 class="h5 page-title">{{ __('lang.instructor_details') ?? 'Instructor Details' }}</h2>
                <div class="page-title-right">
                    <a href="{{ route('back.instructors.index') }}" class="btn btn-primary">
                        <i class="bx bx-arrow-back"></i> {{ __('lang.back') ?? 'Back' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $instructor->avatar_url }}" alt="{{ $instructor->name }}" 
                         class="rounded-circle mb-3" width="120" height="120">
                    <h4>{{ $instructor->name }}</h4>
                    <p class="text-muted">{{ $instructor->email }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <ul class="list-unstyled">
                        <li><strong>Total Courses:</strong> {{ $totalCourses }}</li>
                        <li><strong>Total Students:</strong> {{ $totalStudents }}</li>
                        <li><strong>Total Enrollments:</strong> {{ $totalEnrollments }}</li>
                        <li><strong>Joined:</strong> {{ $instructor->created_at->format('Y-m-d') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Courses</h5>
                    @if($courses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ $course->category->name ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $course->status === 'published' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($course->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No courses yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

