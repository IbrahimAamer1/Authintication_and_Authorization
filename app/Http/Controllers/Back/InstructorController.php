<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    const DIRECTORY = 'back.instructors';

    function __construct()
    {
        // يمكنك إضافة permissions هنا لاحقاً
        // $this->middleware('check_permission:list_instructors')->only(['index', 'getData']);
        // $this->middleware('check_permission:show_instructor')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = $this->getData($request->all());
        return view(self::DIRECTORY . ".index", \get_defined_vars())
            ->with('directory', self::DIRECTORY);
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData($data)
    {
        $order   = $data['order'] ?? 'created_at';
        $sort    = $data['sort'] ?? 'desc';
        $perpage = $data['perpage'] ?? \config('app.paginate');
        $start   = $data['start'] ?? null;
        $end     = $data['end'] ?? null;
        $word    = $data['word'] ?? null;

        $data = User::where('type', 'instructor')
            ->when($word != null, function ($q) use ($word) {
                $q->where('name', 'like', '%' . $word . '%')
                    ->orWhere('email', 'like', '%' . $word . '%');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $instructor
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $instructor)
    {
        // التأكد من أن المستخدم instructor
        if ($instructor->type !== 'instructor') {
            abort(404);
        }

        // إحضار إحصائيات الانستراكتور
        $totalCourses = $instructor->getTotalCourses();
        $totalStudents = $instructor->getTotalStudents();
        $totalEnrollments = $instructor->getTotalEnrollments();
        $courses = $instructor->instructorCourses()->with('category')->latest()->get();

        return view(self::DIRECTORY . ".show", \get_defined_vars());
    }
}

