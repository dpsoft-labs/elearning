<?php

namespace App\Http\Controllers\Web\Back\Admins\Colleges;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\College;
use Illuminate\Support\Facades\Gate;

class CollegesController extends Controller
{
    public function index()
    {
        if (!Gate::allows('show colleges')) {
            return view('themes/default/back.permission-denied');
        }

        $colleges = College::orderBy('created_at', 'desc')->get();

        return view('themes.default.back.admins.colleges.colleges-list', ['colleges' => $colleges]);
    }

    public function show(Request $request)
    {
        if (!Gate::allows('show colleges')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $college = College::where('id', $id)->first();

        return view('themes.default.back.admins.colleges.colleges-show', ['college' => $college]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('add colleges')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $college = College::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', __('l.College created successfully'));

    }

    public function edit(Request $request)
    {
        if (!Gate::allows('edit colleges')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $college = College::findOrFail($id);

        return view('themes.default.back.admins.colleges.colleges-edit', ['college' => $college]);
    }

    public function update(Request $request)
    {
        if (!Gate::allows('edit colleges')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $college = College::findOrFail($request->id);

        $college->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', __('l.College updated successfully'));
    }
    public function delete(Request $request)
    {
        if (!Gate::allows('delete colleges')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $college = College::findOrFail($id);

        $college->delete();

        return redirect()->back()->with('success', __('l.College deleted successfully'));
    }

    public function deleteSelected(Request $request)
    {
        if (!Gate::allows('delete colleges')) {
            return view('themes/default/back.permission-denied');
        }

        $ids = explode(',', $request->ids);
        $colleges = College::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', __('l.Colleges deleted successfully'));
    }
}
