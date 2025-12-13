@props([
    'title',
    'createRoute' => null,
    'createTitle' => null,
    'showCreate' => true,
    'permission' => null
])

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h2 class="h5 page-title">{{ $title }}</h2>
            @if($showCreate && $createRoute && (!$permission || permission([$permission])))
                <div class="page-title-right">
                    <a href="{{ $createRoute }}" 
                       data-title="{{ $createTitle ?? __('lang.add_new') }}" 
                       id="add_btn" 
                       class="btn btn-primary" 
                       data-bs-toggle="modal" 
                       data-bs-target="#mainModal">
                        {{ __('lang.add_new') ?? 'Add New' }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

