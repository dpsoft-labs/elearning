<?php

namespace App\Http\Controllers\Web\Back\Users\Lectures;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecture;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class LecturesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->course) {
            $lectures = Lecture::where('course_id', decrypt($request->course))->orderBy('id', 'desc')->paginate(100);
            $course = Course::find(decrypt($request->course));
            return view(theme('back.users.lectures.lectures-list'), ['lectures' => $lectures, 'course' => $course]);
        } else {
            $courses = Auth::user()->userCourses()
            ->wherePivot('status', 'enrolled')
            ->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')
            ->get();
            return view(theme('back.users.lectures.lectures-list'), ['courses' => $courses]);
        }
    }

    public function show(Request $request)
    {
        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $lecture = Lecture::findOrFail($id);

        return view(theme('back.users.lectures.lectures-show'), ['lecture' => $lecture]);
    }
}