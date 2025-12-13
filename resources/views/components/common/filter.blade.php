@props([
    'filters' => [],
    'action' => null
])

@php
    $action = $action ?? request()->url();
@endphp

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ $action }}" id="filterForm">
            <div class="row">
                @foreach($filters as $filter)
                    <div class="col-md-{{ $filter['col'] ?? 3 }} mb-3">
                        <label class="form-label">{{ $filter['label'] ?? '' }}</label>
                        @if($filter['type'] === 'text' || $filter['type'] === 'date')
                            <input 
                                type="{{ $filter['type'] }}" 
                                name="{{ $filter['name'] }}" 
                                class="form-control" 
                                placeholder="{{ $filter['placeholder'] ?? '' }}"
                                value="{{ request()->input($filter['name']) }}"
                            >
                        @elseif($filter['type'] === 'select')
                            <select name="{{ $filter['name'] }}" class="form-select">
                                <option value="">{{ $filter['placeholder'] ?? 'Select...' }}</option>
                                @foreach($filter['options'] ?? [] as $value => $label)
                                    <option value="{{ $value }}" @selected(request()->input($filter['name']) == $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                @endforeach
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">{{ __('lang.filter') ?? 'Filter' }}</button>
                    <a href="{{ $action }}" class="btn btn-secondary">{{ __('lang.reset') ?? 'Reset' }}</a>
                </div>
            </div>
        </form>
    </div>
</div>

