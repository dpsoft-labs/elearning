<?php

namespace App\Http\Controllers\Web\Back\Admins\Lectures;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;

class LecturesController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('show lectures')) {
            return view('themes/default/back/admins.permission-denied');
        }

        if ($request->course) {
            $lectures = Lecture::where('course_id', decrypt($request->course))->orderBy('id', 'desc')->paginate(100);
            $course = Course::find(decrypt($request->course));
            return view('themes/default/back.admins.lectures.lectures-list', compact('lectures', 'course'));
        } else {
            $courses = Course::get();
            return view('themes/default/back.admins.lectures.lectures-list', compact('courses'));
        }

    }

    public function store(Request $request)
    {
        if (!Gate::allows('add lectures')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'video' => 'required|string',
            'files' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048',
        ]);

        $files = null;
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $filename = time() . mt_rand() . '.' . $files->getClientOriginalExtension();
            $files->move(public_path('files/lectures'), $filename);
            $files = 'files/lectures/' . $filename;
        }

        $lecture = new Lecture();
        $lecture->name = $request->name;
        $lecture->course_id = $request->course_id;
        $lecture->description = $request->description;
        $lecture->video = $request->video;
        $lecture->files = $files;
        $lecture->save();

        return redirect()->back()->with('success', 'Lecture created successfully');
    }

    public function edit(Request $request)
    {
        if (!Gate::allows('edit lectures')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $lecture = Lecture::findOrFail($id);

        return view('themes/default/back.admins.lectures.lectures-edit', compact('lecture'));
    }

    public function update(Request $request)
    {
        if (!Gate::allows('edit lectures')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|string',
            'files' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048',
        ]);

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $lecture = Lecture::findOrFail($id);

        $files = $lecture->files;
        if ($request->hasFile('files')) {
            if (!empty($files) && file_exists(public_path($files))) {
                unlink(public_path($files));
            }

            $filesFile = $request->file('files');
            $filename = time() . mt_rand() . '.' . $filesFile->getClientOriginalExtension();
            $filesFile->move(public_path('files/lectures'), $filename);
            $files = 'files/lectures/' . $filename;
        }

        $lecture->name = $request->name;
        $lecture->description = $request->description;
        $lecture->video = $request->video;
        $lecture->files = $files;
        $lecture->save();

        return redirect()->back()->with('success', 'Lecture updated successfully.');
    }

    public function delete(Request $request)
    {
        if (!Gate::allows('delete lectures')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $lecture = Lecture::findOrFail($id);

        $files = $lecture->files;
        if (!empty($files) && file_exists(public_path($files))) {
            unlink(public_path($files));
        }

        $lecture->delete();

        return redirect()->back()->with('success', 'Lecture deleted successfully');
    }
}