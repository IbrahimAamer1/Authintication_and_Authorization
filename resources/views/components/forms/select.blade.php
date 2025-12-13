@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'Select an option',
    'required' => false,
    'disabled' => false,
    'class' => '',
    'id' => null,
    'help' => null,
    'error' => null,
    'multiple' => false
])

@php
    $id = $id ?? $name;
    $value = $value ?? old($name);
    $error = $error ?? ($errors->first($name) ?? null);
    $hasError = $error ? 'is-invalid' : '';
    $selectedValue = is_array($value) ? $value : [$value];
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

    <select
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        id="{{ $id }}"
        class="form-select {{ $hasError }} {{ $class }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($multiple) multiple @endif
        {{ $attributes }}
    >
        @if(!$multiple)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $optionValue => $optionLabel)
            @if(is_array($optionLabel))
                <optgroup label="{{ $optionValue }}">
                    @foreach($optionLabel as $subValue => $subLabel)
                        <option value="{{ $subValue }}" @selected(in_array($subValue, $selectedValue))>
                            {{ $subLabel }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{ $optionValue }}" @selected(in_array($optionValue, $selectedValue))>
                    {{ $optionLabel }}
                </option>
            @endif
        @endforeach
    </select>

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif
</div>

