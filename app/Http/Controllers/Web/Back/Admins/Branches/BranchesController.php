<?php

namespace App\Http\Controllers\Web\Back\Admins\Branches;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Gate;

class BranchesController extends Controller
{
    public function index()
    {
        if (!Gate::allows('show branches')) {
            return view('themes/default/back.permission-denied');
        }

        $branches = Branch::orderBy('created_at', 'desc')->get();

        return view('themes.default.back.admins.branches.branches-list', ['branches' => $branches]);
    }

    public function show(Request $request)
    {
        if (!Gate::allows('show branches')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $branch = Branch::where('id', $id)->first();

        return view('themes.default.back.admins.branches.branches-show', ['branch' => $branch]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('add branches')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $branch = Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', __('l.Branch created successfully'));

    }

    public function edit(Request $request)
    {
        if (!Gate::allows('edit branches')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $branch = Branch::findOrFail($id);

        return view('themes.default.back.admins.branches.branches-edit', ['branch' => $branch]);
    }

    public function update(Request $request)
    {
        if (!Gate::allows('edit branches')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $branch = Branch::findOrFail($request->id);

        $branch->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', __('l.Branch updated successfully'));
    }
    public function delete(Request $request)
    {
        if (!Gate::allows('delete branches')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $branch = Branch::findOrFail($id);

        $branch->delete();

        return redirect()->back()->with('success', __('l.Branch deleted successfully'));
    }

    public function deleteSelected(Request $request)
    {
        if (!Gate::allows('delete branches')) {
            return view('themes/default/back.permission-denied');
        }

        $ids = explode(',', $request->ids);
        $branches = Branch::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', __('l.Branches deleted successfully'));
    }
}
