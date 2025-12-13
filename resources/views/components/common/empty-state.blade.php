@props([
    'message' => 'No data available',
    'icon' => 'bx-inbox',
    'action' => null,
    'actionLabel' => null
])

<div class="text-center py-5">
    <div class="mb-3">
        <i class="bx {{ $icon }} display-1 text-muted"></i>
    </div>
    <h5 class="text-muted">{{ $message }}</h5>
    @if($action && $actionLabel)
        <a href="{{ $action }}" class="btn btn-primary mt-3">{{ $actionLabel }}</a>
    @endif
</div>

