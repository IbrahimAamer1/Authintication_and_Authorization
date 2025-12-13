@props([
    'name',
    'label' => null,
    'value' => null,
    'accept' => null,
    'required' => false,
    'disabled' => false,
    'class' => '',
    'id' => null,
    'help' => null,
    'error' => null,
    'multiple' => false,
    'preview' => false
])

@php
    $id = $id ?? $name;
    $error = $error ?? ($errors->first($name) ?? null);
    $hasError = $error ? 'is-invalid' : '';
    $accept = $accept ?? 'image/*';
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

    <input
        type="file"
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        id="{{ $id }}"
        accept="{{ $accept }}"
        class="form-control {{ $hasError }} {{ $class }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($multiple) multiple @endif
        {{ $attributes }}
    />

    @if($preview && $value)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $value) }}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
        </div>
    @endif

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif
</div>

