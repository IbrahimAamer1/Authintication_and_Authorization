@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'rows' => 4,
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

<div class="form-group mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="form-control {{ $hasError }} {{ $class }}"
        @if($required) required @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif
        {{ $attributes }}
    >{{ $value }}</textarea>

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif
</div>

