@props([
    'title',
    'value',
    'icon' => 'bx-bar-chart',
    'color' => 'primary',
    'trend' => null,
    'trendValue' => null,
    'subtitle' => null
])

@php
    $colors = [
        'primary' => 'bg-label-primary',
        'success' => 'bg-label-success',
        'danger' => 'bg-label-danger',
        'warning' => 'bg-label-warning',
        'info' => 'bg-label-info',
    ];
    $colorClass = $colors[$color] ?? $colors['primary'];
@endphp

<div class="card mb-4">
    <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
                <span class="avatar-initial rounded {{ $colorClass }}">
                    <i class="bx {{ $icon }}"></i>
                </span>
            </div>
            @if($trend)
                <div class="dropdown">
                    <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    </div>
                </div>
            @endif
        </div>
        <span class="fw-semibold d-block mb-1">{{ $title }}</span>
        <h3 class="card-title mb-2">{{ $value }}</h3>
        @if($trend && $trendValue)
            <small class="text-{{ $trend === 'up' ? 'success' : 'danger' }} fw-semibold">
                <i class="bx bx-{{ $trend === 'up' ? 'up' : 'down' }}-arrow-alt"></i> {{ $trendValue }}
            </small>
        @endif
        @if($subtitle)
            <small class="text-muted d-block mt-1">{{ $subtitle }}</small>
        @endif
    </div>
</div>

