@extends('back.master')
@section('title', __('lang.instructors') ?? 'Instructors')
@section('instructors_active', 'active bg-light')
@push('styles')
    @includeIf("$directory.pushStyles")
@endpush

@section('content')
    @include('components.tables.table-header', [
        'title' => __('lang.instructors') ?? 'Instructors',
        'createRoute' => null, // Read-only
        'createTitle' => null,
        'showCreate' => false,
    ])

    {{-- Filteration --}}
    @includeIf("$directory.filter")

    {{-- Table --}}
    <div class="card" id="mainCont">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap font-size-14">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-primary" width="5%">#</th>
                            <th class="text-primary">{{ __('lang.name') }}</th>
                            <th class="text-primary">{{ __('lang.email') }}</th>
                            <th class="text-primary">Total Courses</th>
                            <th class="text-primary">Total Students</th>
                            <th class="text-primary" width="11%">{{ __('lang.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data['data']) > 0)
                            @foreach ($data['data'] as $key => $instructor)
                                <tr>
                                    <td>{{ $data['data']->firstItem()+$loop->index }}</td>
                                    <td>{{ $instructor->name }}</td>
                                    <td>{{ $instructor->email ?? '' }}</td>
                                    <td>{{ $instructor->getTotalCourses() }}</td>
                                    <td>{{ $instructor->getTotalStudents() }}</td>
                                    <td>
                                        @include('components.tables.table-actions', [
                                            'item' => $instructor,
                                            'showRoute' => route('back.instructors.show', ['instructor' => $instructor]),
                                            'editRoute' => null,
                                            'deleteRoute' => null,
                                            'actions' => ['show'],
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">
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

