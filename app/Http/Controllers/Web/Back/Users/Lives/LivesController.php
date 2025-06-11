<?php

namespace App\Http\Controllers\Web\Back\Users\Lives;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Live;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class LivesController extends Controller
{
    public function index(Request $request)
    {
        $courses = Auth::user()->userCourses()
            ->wherePivot('status', 'enrolled')
            ->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')
            ->get();

        $lives = Live::whereIn('course_id', $courses->pluck('id'))->orderBy('id', 'desc')->paginate(100);
        return view(theme('back.users.lives.lives-list'), ['lives' => $lives]);
    }
}
