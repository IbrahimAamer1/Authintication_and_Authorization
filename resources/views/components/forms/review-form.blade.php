@props([
    'course' => null,
    'review' => null, // If provided, this is an edit form
    'action' => null, // Route for form submission
    'method' => 'POST', // POST for create, PUT for update
])

@php
    $isEdit = $review !== null;
    $rating = $review ? $review->rating : 0;
    $comment = $review ? $review->comment : '';
    $formId = $isEdit ? 'edit-review-form' : 'add-review-form';
    $submitText = $isEdit ? (__('lang.update_review') ?? 'Update Review') : (__('lang.submit_review') ?? 'Submit Review');
@endphp

<div class="card mb-4" id="{{ $formId }}-container">
    <div class="card-header">
        <h5 class="mb-0">
            {{ $isEdit ? (__('lang.edit_your_review') ?? 'Edit Your Review') : (__('lang.write_a_review') ?? 'Write a Review') }}
        </h5>
    </div>
    <div class="card-body">
        <form id="{{ $formId }}" 
              action="{{ $action ?? ($isEdit ? route('front.reviews.update', [$course, $review]) : route('front.reviews.store', $course)) }}" 
              method="POST">
            @if($isEdit)
                @method('PUT')
            @endif
            @csrf

            <!-- Star Rating Input -->
            <div class="form-group mb-3">
                <label class="form-label">
                    {{ __('lang.rating') ?? 'Rating' }}
                    <span class="text-danger">*</span>
                </label>
                <div class="star-rating-input" data-rating="{{ $rating }}">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bx {{ $i <= $rating ? 'bxs-star text-warning' : 'bx-star text-muted' }} star-icon" 
                           data-star="{{ $i }}"
                           style="font-size: 2rem; cursor: pointer; transition: all 0.2s;"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="{{ $rating }}" required>
                <div class="invalid-feedback d-block" id="rating-error" style="display: none !important;"></div>
            </div>

            <!-- Comment Textarea -->
            <div class="form-group mb-3">
                <label for="comment" class="form-label">
                    {{ __('lang.comment') ?? 'Comment' }}
                </label>
                <textarea 
                    name="comment" 
                    id="comment" 
                    rows="4" 
                    class="form-control" 
                    placeholder="{{ __('lang.write_your_review_here') ?? 'Write your review here...' }}"
                    maxlength="1000">{{ $comment }}</textarea>
                <small class="form-text text-muted">
                    <span id="char-count">{{ strlen($comment) }}</span>/1000 {{ __('lang.characters') ?? 'characters' }}
                </small>
                <div class="invalid-feedback d-block" id="comment-error" style="display: none !important;"></div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="submit-btn">
                    <i class="bx bx-check"></i> {{ $submitText }}
                </button>
                @if($isEdit)
                    <button type="button" class="btn btn-danger" id="delete-btn" data-review-id="{{ $review->id }}" data-course-slug="{{ $course->slug }}">
                        <i class="bx bx-trash"></i> {{ __('lang.delete_review') ?? 'Delete Review' }}
                    </button>
                @endif
                <button type="button" class="btn btn-secondary" id="cancel-btn" style="display: none;">
                    {{ __('lang.cancel') ?? 'Cancel' }}
                </button>
            </div>
        </form>
    </div>
</div>

