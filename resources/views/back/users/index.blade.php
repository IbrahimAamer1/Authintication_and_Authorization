@extends('layouts.back.master')
@section('title', __('lang.users'))
@section('users_active', 'active bg-light')
@push('styles')
    @includeIf("$directory.pushStyles")
@endpush

@section('content')
    @include('components.tables.table-header', [
        'title' => __('lang.users'),
        'createRoute' => route('back.users.create'),
        'createTitle' => __('lang.add_new_user'),
        'showCreate' => permission(['add_user']),
        'permission' => 'add_user'
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
                            <th class="text-primary" width="11%">{{ __('lang.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data['data']) > 0)
                            @foreach ($data['data'] as $key => $item)
                                <tr>
                                    <td>{{ $data['data']->firstItem()+$loop->index }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email ?? '' }}</td>
                                    <td>
                                        @include('components.tables.table-actions', [
                                            'item' => $item,
                                            'showRoute' => route('back.users.show', ['user' => $item]),
                                            'editRoute' => route('back.users.edit', ['user' => $item]),
                                            'deleteRoute' => route('back.users.destroy', ['user' => $item]),
                                            'actions' => ['show', 'edit', 'delete'],
                                            'showPermission' => 'show_user',
                                            'editPermission' => 'edit_user',
                                            'deletePermission' => 'delete_user'
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">
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