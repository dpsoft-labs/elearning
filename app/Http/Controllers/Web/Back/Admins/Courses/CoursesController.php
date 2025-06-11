<?php

namespace App\Http\Controllers\Web\Back\Admins\Courses;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class CoursesController extends Controller
{
    public function index()
    {
        if (!Gate::allows('show courses')) {
            return view('themes/default/back.permission-denied');
        }

        if (Gate::allows('access all courses')) {
            $courses = Course::orderBy('created_at', 'desc')->get();
        } else {
            $courses = auth()->user()->userCourses;
        }

        return view('themes.default.back.admins.courses.courses-list', ['courses' => $courses]);
    }

    public function show(Request $request)
    {
        if (!Gate::allows('show courses')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $course = Course::where('id', $id)->first();

        return view('themes.default.back.admins.courses.courses-show', ['course' => $course]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('add courses')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'college_id' => 'required|exists:colleges,id',
            'required1' => 'nullable|string|max:255',
            'required2' => 'nullable|string|max:255',
            'required3' => 'nullable|string|max:255',
            'required_hours' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        $image = upload_to_public($request->file('image'), 'images/courses');

        $course = Course::create([
            'name' => $request->name,
            'code' => $request->code,
            'hours' => $request->hours,
            'image' => $image,
            'college_id' => $request->college_id,
            'required1' => $request->required1,
            'required2' => $request->required2,
            'required3' => $request->required3,
            'required_hours' => $request->required_hours,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', __('l.Course created successfully'));

    }

    public function edit(Request $request)
    {
        if (!Gate::allows('edit courses')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $course = Course::findOrFail($id);

        return view('themes.default.back.admins.courses.courses-edit', ['course' => $course]);
    }

    public function update(Request $request)
    {
        if (!Gate::allows('edit courses')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'college_id' => 'required|exists:colleges,id',
            'required1' => 'nullable|string|max:255',
            'required2' => 'nullable|string|max:255',
            'required3' => 'nullable|string|max:255',
            'required_hours' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        $course = Course::findOrFail($request->id);

        $image = $course->image;
        if ($request->hasFile('image')) {
            if ($course->image) {
                delete_from_public($course->image);
            }

            $image = upload_to_public($request->file('image'), 'images/courses');
        }

        $course->update([
            'name' => $request->name,
            'code' => $request->code,
            'hours' => $request->hours,
            'image' => $image,
            'college_id' => $request->college_id,
            'required1' => $request->required1,
            'required2' => $request->required2,
            'required3' => $request->required3,
            'required_hours' => $request->required_hours,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', __('l.Course updated successfully'));
    }
    public function delete(Request $request)
    {
        if (!Gate::allows('delete courses')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $course = Course::findOrFail($id);

        if ($course->image) {
            delete_from_public($course->image);
        }

        $course->delete();

        return redirect()->back()->with('success', __('l.Course deleted successfully'));
    }

    public function deleteSelected(Request $request)
    {
        if (!Gate::allows('delete courses')) {
            return view('themes/default/back.permission-denied');
        }

        $ids = explode(',', $request->ids);
        $courses = Course::whereIn('id', $ids)->get();

        foreach ($courses as $course) {
            if ($course->image) {
                delete_from_public($course->image);
            }
            $course->delete();
        }

        return redirect()->back()->with('success', __('l.Courses deleted successfully'));
    }

    public function staff(Request $request)
    {
        if (!Gate::allows('edit courses')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $course = Course::findOrFail($id);

        // جلب المستخدمين الذين لديهم صلاحية رؤية الكورسات
        $availableStaff = User::whereHas('permissions', function($query) {
            $query->where('name', 'show courses');
        })->orWhereHas('roles.permissions', function($query) {
            $query->where('name', 'show courses');
        })->get();

        // جلب طاقم التعليم الحالي للمادة
        $currentStaff = $course->users()->wherePivot('status', 'staff')->get();

        return view('themes.default.back.admins.courses.courses-staff', [
            'course' => $course,
            'availableStaff' => $availableStaff,
            'currentStaff' => $currentStaff
        ]);
    }

    public function addStaff(Request $request)
    {
        if (!Gate::allows('edit courses')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $course = Course::findOrFail($request->course_id);

        // التحقق من عدم وجود المستخدم في طاقم المادة
        if (!$course->users()->where('user_id', $request->user_id)->exists()) {
            $course->users()->attach($request->user_id, ['status' => 'staff']);
            return redirect()->back()->with('success', __('l.Staff member added successfully'));
        }

        return redirect()->back()->with('error', __('l.Staff member already exists'));
    }

    public function removeStaff(Request $request)
    {
        if (!Gate::allows('edit courses')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $course = Course::findOrFail($id);
        $userId = $request->user_id;

        $course->users()->detach($userId);

        return redirect()->back()->with('success', __('l.Staff member removed successfully'));
    }
}
