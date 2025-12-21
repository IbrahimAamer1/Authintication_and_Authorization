<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('enrollments', 'course_id')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.unique' => __('lang.already_enrolled') ?? 'You are already enrolled in this course.',
        ];
    }

    public function attributes(): array
    {
        return [
            'course_id' => __('lang.course') ?? 'Course',
        ];
    }
}
