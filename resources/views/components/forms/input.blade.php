@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'class' => '',
    'id' => null,
    'help' => null,
    'error' => null
])

@php
    $id = $id ?? $name;
    $value = $value ?? old($name);
    $error = $error ?? ($errors->first($name) ?? null);
    $hasError = $error ? 'is-invalid' : '';
    $placeholder = $placeholder ?? __('lang.please_enter') . ' ' . ($label ?? $name);
@endphp

@php
    $colClass = '';
    if(str_contains($class, 'col-')) {
        $colClass = $class;
        $class = str_replace(['col-12', 'col-md-6', 'col-md-4', 'col-md-3', 'col-md-8', 'col-md-9'], '', $class);
        $class = trim($class);
    }
@endphp

<div class="form-group mb-3 {{ $colClass }}">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="form-control {{ $hasError }} {{ $class }}"
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        {{ $attributes }}
    />

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif
</div>

