@extends('back.master')
@section('title', __('lang.categories') ?? 'Categories')
@section('categories_active', 'active bg-light')
@push('styles')
    @includeIf("$directory.pushStyles")
@endpush

@section('content')

    @include('components.tables.table-header', [
        'title' => __('lang.categories') ?? 'Categories',
        'createRoute' => route('back.categories.create'),
        'createTitle' => __('lang.add_new_category') ?? 'Add New Category',
        'showCreate' => true,
        'permission' => 'create_category'
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
                            <th class="text-primary">{{ __('lang.image') ?? 'Image' }}</th>
                            <th class="text-primary">{{ __('lang.name') ?? 'Name' }}</th>
                            <th class="text-primary">{{ __('lang.description') ?? 'Description' }}</th>
                            <th class="text-primary">{{ __('lang.sort_order') ?? 'Sort Order' }}</th>
                            <th class="text-primary">{{ __('lang.status') ?? 'Status' }}</th>
                            <th class="text-primary" width="11%">{{ __('lang.actions') ?? 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data['data']) > 0)
                            @foreach ($data['data'] as $key => $category)
                                <tr>
                                    <td>{{ $data['data']->firstItem()+$loop->index }}</td>
                                    <td>
                                        @if($category->image)
                                            <img src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <span class="badge bg-label-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description ?? '', 50) }}</td>
                                    <td>{{ $category->sort_order }}</td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-label-success">{{ __('lang.active') ?? 'Active' }}</span>
                                        @else
                                            <span class="badge bg-label-danger">{{ __('lang.inactive') ?? 'Inactive' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @include('components.tables.table-actions', [
                                            'item' => $category,
                                            'showRoute' => route('back.categories.show', ['category' => $category]),
                                            'editRoute' => route('back.categories.edit', ['category' => $category]),
                                            'deleteRoute' => route('back.categories.destroy', ['category' => $category]),
                                            'actions' => ['show', 'edit', 'delete'],
                                            'showPermission' => 'show_category',
                                            'editPermission' => 'edit_category',
                                            'deletePermission' => 'delete_category'
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

