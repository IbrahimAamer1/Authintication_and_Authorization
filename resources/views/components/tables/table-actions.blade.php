@props([
    'item',
    'showRoute' => null,
    'editRoute' => null,
    'deleteRoute' => null,
    'actions' => ['show', 'edit', 'delete'],
    'showPermission' => null,
    'editPermission' => null,
    'deletePermission' => null
])

<div class="btn-group">
    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('lang.actions') ?? 'Actions' }} <i class="mdi mdi-chevron-down"></i>
    </button>
    <div class="dropdown-menu">
        @if(in_array('show', $actions) && $showRoute && (!$showPermission || permission([$showPermission])))
            <a href="{{ $showRoute }}" 
               class="dropdown-item displayClass" 
               data-title="{{ __('lang.show') ?? 'Show' }}" 
               data-bs-toggle="modal" 
               data-bs-target="#mainModal">
                <span class="bx bx-show-alt"></span> {{ __('lang.show') ?? 'Show' }}
            </a>
        @endif
        
        @if(in_array('edit', $actions) && $editRoute && (!$editPermission || permission([$editPermission])))
            <a href="{{ $editRoute }}" 
               class="dropdown-item editClass" 
               data-title="{{ __('lang.edit') ?? 'Edit' }}" 
               data-bs-toggle="modal" 
               data-bs-target="#mainModal">
                <span class="bx bx-edit-alt"></span> {{ __('lang.edit') ?? 'Edit' }}
            </a>
        @endif
        
        @if(in_array('delete', $actions) && $deleteRoute && (!$deletePermission || permission([$deletePermission])))
            <a href="{{ $deleteRoute }}" 
               class="dropdown-item deleteClass" 
               data-title="{{ __('lang.delete') ?? 'Delete' }}">
                <span class="bx bx-trash-alt"></span> {{ __('lang.delete') ?? 'Delete' }}
            </a>
        @endif
    </div>
</div>

