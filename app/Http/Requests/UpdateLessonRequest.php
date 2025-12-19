<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255|unique:lessons,title,' . $this->lesson->id,
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,mov,avi|max:50000',
            'lesson_order' => 'nullable|integer|min:0',
            'is_free' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => __('lang.title') ?? 'Title',
            'course_id' => __('lang.course') ?? 'Course',
            'description' => __('lang.description') ?? 'Description',
            'video_file' => __('lang.video_file') ?? 'Video File',
            'lesson_order' => __('lang.lesson_order') ?? 'Lesson Order',
            'is_free' => __('lang.is_free') ?? 'Is Free',
            'is_published' => __('lang.is_published') ?? 'Is Published',
        ];
    }
}
