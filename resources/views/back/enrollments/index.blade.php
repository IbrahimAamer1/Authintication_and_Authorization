@extends('back.master')
@section('title', __('lang.enrollments') ?? 'Enrollments')
@section('enrollments_active', 'active bg-light')
@push('styles')
    @includeIf("$directory.pushStyles")
@endpush

@section('content')
    @include('components.tables.table-header', [
        'title' => __('lang.enrollments') ?? 'Enrollments',
        'showCreate' => false,
    ])

    @includeIf("$directory.filter")

    <div class="card" id="mainCont">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap font-size-14">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-primary" width="5%">#</th>
                            <th class="text-primary">{{ __('lang.user') ?? 'User' }}</th>
                            <th class="text-primary">{{ __('lang.course') ?? 'Course' }}</th>
                            <th class="text-primary">{{ __('lang.status') ?? 'Status' }}</th>
                            <th class="text-primary">{{ __('lang.progress') ?? 'Progress' }}</th>
                            <th class="text-primary">{{ __('lang.enrolled_at') ?? 'Enrolled At' }}</th>
                            <th class="text-primary" width="11%">{{ __('lang.actions') ?? 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data['data']) > 0)
                            @foreach ($data['data'] as $key => $enrollment)
                                <tr>
                                    <td>{{ $data['data']->firstItem()+$loop->index }}</td>
                                    <td>
                                        @if($enrollment->user)
                                            <div>
                                                <strong>{{ $enrollment->user->name }}</strong><br>
                                                <small class="text-muted">{{ $enrollment->user->email }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($enrollment->course)
                                            <span class="badge bg-label-info">{{ $enrollment->course->title }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
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
                                        <div class="d-flex align-items-center">
                                            <div class="progress" style="width: 100px; height: 20px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%" aria-valuenow="{{ $enrollment->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ $enrollment->progress_percentage }}%
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $enrollment->enrolled_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @include('components.tables.table-actions', [
                                            'item' => $enrollment,
                                            'showRoute' => route('back.enrollments.show', ['enrollment' => $enrollment]),
                                            'actions' => ['show'],
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    <x-empty-state message="{{ __('lang.no_data_available') ?? 'No data available' }}" />
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        
            @include('components.common.pagination', ['paginator' => $data['data']])
        </div>
    </div>
@endsection

@push('scripts')
    @includeIf("$directory.pushScripts")
@endpush

