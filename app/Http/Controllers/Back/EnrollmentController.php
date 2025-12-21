<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    const DIRECTORY = 'back.enrollments';

    function __construct()
    {
        // $this->middleware('check_permission:show_enrollment')->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $data = $this->getData($request->all());
        $users = User::all();
        $courses = Course::all();
        return view(self::DIRECTORY . ".index", \get_defined_vars())
            ->with('directory', self::DIRECTORY);
    }

    public function getData($data)
    {
        $order = $data['order'] ?? 'enrolled_at';
        $sort = $data['sort'] ?? 'desc';
        $perpage = $data['perpage'] ?? 10;
        $start = $data['start'] ?? null;
        $end = $data['end'] ?? null;
        $word = $data['word'] ?? null;
        $status = $data['status'] ?? null;
        $user_id = $data['user_id'] ?? null;
        $course_id = $data['course_id'] ?? null;

        $data = Enrollment::with(['user', 'course'])
            ->when($status !== null, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($user_id !== null, function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->when($course_id !== null, function ($q) use ($course_id) {
                $q->where('course_id', $course_id);
            })
            ->when($word != null, function ($q) use ($word) {
                $q->whereHas('user', function ($query) use ($word) {
                    $query->where('name', 'like', '%' . $word . '%')
                          ->orWhere('email', 'like', '%' . $word . '%');
                })->orWhereHas('course', function ($query) use ($word) {
                    $query->where('title', 'like', '%' . $word . '%');
                });
            })
            ->when($start != null, function ($q) use ($start) {
                $q->whereDate('enrolled_at', '>=', $start);
            })
            ->when($end != null, function ($q) use ($end) {
                $q->whereDate('enrolled_at', '<=', $end);
            })
            ->orderby($order, $sort)
            ->paginate($perpage);

        return \get_defined_vars();
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['user', 'course']);
        return view(self::DIRECTORY . ".show", \get_defined_vars());
    }
}
