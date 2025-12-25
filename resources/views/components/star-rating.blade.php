@props([
    'rating' => 0,
    'size' => 'md', // sm, md, lg
    'showValue' => false,
    'interactive' => false,
    'name' => 'rating',
])

@php
    $sizeClasses = [
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-xl',
    ];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    
    $rating = (float) $rating;
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div class="star-rating {{ $sizeClass }} {{ $interactive ? 'interactive' : '' }}" 
     data-rating="{{ $rating }}"
     @if($interactive) data-name="{{ $name }}" @endif>
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $fullStars)
            <i class="bx bxs-star text-warning" data-star="{{ $i }}"></i>
        @elseif($i == $fullStars + 1 && $hasHalfStar)
            <i class="bx bxs-star-half text-warning" data-star="{{ $i }}"></i>
        @else
            <i class="bx bx-star text-muted" data-star="{{ $i }}"></i>
        @endif
    @endfor
    @if($showValue)
        <span class="ms-2 text-muted">{{ number_format($rating, 1) }}</span>
    @endif
</div>

