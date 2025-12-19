<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Course;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    const DIRECTORY = 'back.lessons';

    function __construct()
    {
        // $this->middleware('check_permission:manage_lessons')->only(['index', 'getData']);
        // $this->middleware('check_permission:create_lesson')->only(['create', 'store']);
        // $this->middleware('check_permission:show_lesson')->only(['show']);
        // $this->middleware('check_permission:edit_lesson')->only(['edit', 'update']);
        // $this->middleware('check_permission:delete_lesson')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $data = $this->getData($request->all());
        $courses = Course::all();
        return view(self::DIRECTORY . ".index", \get_defined_vars())
            ->with('directory', self::DIRECTORY);
    }

    public function getData($data)
    {
        $order = $data['order'] ?? 'lesson_order';
        $sort = $data['sort'] ?? 'asc';
        $perpage = $data['perpage'] ?? 10;
        $start = $data['start'] ?? null;
        $end = $data['end'] ?? null;
        $word = $data['word'] ?? null;
        $is_published = $data['is_published'] ?? null;
        $course_id = $data['course_id'] ?? null;

        $data = Lesson::with(['course'])
            ->when($is_published !== null, function ($q) use ($is_published) {
                $q->where('is_published', $is_published);
            })
            ->when($course_id !== null, function ($q) use ($course_id) {
                $q->where('course_id', $course_id);
            })
            ->when($word != null, function ($q) use ($word) {
                $q->where('title', 'like', '%' . $word . '%')
                  ->orWhere('description', 'like', '%' . $word . '%');
            })
            ->when($start != null, function ($q) use ($start) {
                $q->whereDate('created_at', '>=', $start);
            })
            ->when($end != null, function ($q) use ($end) {
                $q->whereDate('created_at', '<=', $end);
            })
            ->orderby($order, $sort)
            ->paginate($perpage);

        return \get_defined_vars();
    }

    public function create()
    {
        $courses = Course::all();
        return view(self::DIRECTORY . ".create", get_defined_vars());
    }

    public function store(StoreLessonRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('video_file')) {
            $videoName = time() . '.' . $request->video_file->getClientOriginalName();
            $data['video_file'] = $request->file('video_file')->storeAs('lessons', $videoName, 'public');
        }
        Lesson::create($data);
        return redirect()->route(self::DIRECTORY . '.index')->with('success', __('messages.sent') ?? 'Lesson created successfully');
    }

    public function show(Lesson $lesson)
    {
        $lesson->load(['course']);
        return view(self::DIRECTORY . ".show", \get_defined_vars());
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::all();
        return view(self::DIRECTORY . ".edit", \get_defined_vars());
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $data = $request->validated();

        if ($request->hasFile('video_file')) {
            if ($lesson->video_file && Storage::disk('public')->exists($lesson->video_file)) {
                Storage::disk('public')->delete($lesson->video_file);
            }   
            $videoName = time() . '.' . $request->file('video_file')->getClientOriginalName();
            $data['video_file'] = $request->file('video_file')->storeAs('lessons', $videoName, 'public');
        }

        $lesson->update($data);

        return response()->json([
            'success' => __('messages.updated') ?? 'Lesson updated successfully'
        ]);
    }

    public function destroy(Lesson $lesson)
    {
        if ($lesson->video_file && Storage::disk('public')->exists($lesson->video_file)) {
            Storage::disk('public')->delete($lesson->video_file);
        }

        $lesson->delete();

        return response()->json([
            'success' => __('messages.deleted') ?? 'Lesson deleted successfully'
        ]);
    }
}
