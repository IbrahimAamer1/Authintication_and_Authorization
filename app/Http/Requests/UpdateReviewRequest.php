<?php

namespace App\Http\Requests;

use App\Models\Review;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $review = $this->route('review');
        return auth()->check() && $review && $review->isOwnedBy(auth()->id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'comment' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $course = $this->route('course');
            $userId = auth()->id();

            // Check if user is enrolled in the course
            if ($course && !$course->isEnrolledBy($userId)) {
                $validator->errors()->add('course', __('lang.must_be_enrolled_to_review') ?? 'You must be enrolled in this course to write a review.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'rating.required' => __('lang.rating_required') ?? 'Please select a rating.',
            'rating.between' => __('lang.rating_between') ?? 'Rating must be between 1 and 5.',
            'comment.max' => __('lang.comment_max') ?? 'Comment cannot exceed 1000 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'rating' => __('lang.rating') ?? 'Rating',
            'comment' => __('lang.comment') ?? 'Comment',
        ];
    }
}
