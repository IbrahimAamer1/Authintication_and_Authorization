@props([
    'reviews' => null,
    'course' => null,
])

@if($reviews && $reviews->count() > 0)
    <div class="reviews-list">
        @foreach($reviews as $review)
            <div class="card mb-3 review-item" data-review-id="{{ $review->id }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-2">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    {{ substr($review->user->name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $review->user->name }}</div>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        @auth
                            @if($review->isOwnedBy(auth()->id()))
                                <div class="review-actions">
                                    <button class="btn btn-sm btn-outline-primary edit-review-btn" 
                                            data-review-id="{{ $review->id }}"
                                            data-rating="{{ $review->rating }}"
                                            data-comment="{{ $review->comment }}">
                                        <i class="bx bx-edit"></i> {{ __('lang.edit') ?? 'Edit' }}
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>
                    
                    <div class="mb-2">
                        <x-star-rating :rating="$review->rating" :size="'sm'" />
                    </div>
                    
                    @if($review->comment)
                        <p class="mb-0">{{ $review->comment }}</p>
                    @else
                        <p class="text-muted mb-0"><em>{{ __('lang.no_comment') ?? 'No comment provided.' }}</em></p>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reviews->links('components.common.pagination', ['paginator' => $reviews]) }}
        </div>
    </div>
@else
    <div class="text-center py-4">
        <i class="bx bx-star display-4 text-muted"></i>
        <p class="text-muted mt-2">{{ __('lang.no_reviews_yet') ?? 'No reviews yet. Be the first to review this course!' }}</p>
    </div>
@endif

