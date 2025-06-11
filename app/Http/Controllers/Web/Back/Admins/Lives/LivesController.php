<?php

namespace App\Http\Controllers\Web\Back\Admins\Lives;

use App\Http\Controllers\Controller;
use App\Models\Live;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;

class LivesController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('show lives')) {
            return view('themes/default/back/admins.permission-denied');
        }

        if ($request->course) {
            $lives = Live::where('course_id', decrypt($request->course))->orderBy('date', 'desc')->paginate(100);
            $course = Course::find(decrypt($request->course));
            return view('themes/default/back.admins.lives.lives-list', compact('lives', 'course'));
        } else {
            $courses = Course::get();
            return view('themes/default/back.admins.lives.lives-list', compact('courses'));
        }

    }

    public function store(Request $request)
    {
        if (!Gate::allows('add lives')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'link' => 'required|string',
        ]);

        $live = new Live();
        $live->name = $request->name;
        $live->course_id = $request->course_id;
        $live->date = $request->date;
        $live->link = $request->link;
        $live->save();

        return redirect()->back()->with('success', 'Live created successfully');
    }

    public function edit(Request $request)
    {
        if (!Gate::allows('edit lives')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $live = Live::find($id);
        if (!$live) {
            return redirect()->back()->with('error', 'Live dose not exist ');
        }

        return view('themes/default/back.admins.lives.lives-edit', compact('live'));
    }

    public function update(Request $request)
    {
        if (!Gate::allows('edit lives')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|string',
            'link' => 'required|string',
        ]);

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $live = Live::findOrFail($id);


        $live->name = $request->name;
        $live->date = $request->date;
        $live->link = $request->link;
        $live->save();

        return redirect()->back()->with('success', 'Live updated successfully.');
    }

    public function delete(Request $request)
    {
        if (!Gate::allows('delete lives')) {
            return view('themes/default/back/admins.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $live = Live::findOrFail($id);

        $live->delete();

        return redirect()->back()->with('success', 'Live deleted successfully');
    }
}