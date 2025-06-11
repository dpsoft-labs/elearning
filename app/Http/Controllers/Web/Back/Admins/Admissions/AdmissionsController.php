<?php

namespace App\Http\Controllers\Web\Back\Admins\Admissions;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;
use Illuminate\Support\Facades\Gate;

class AdmissionsController extends Controller
{
    public function index()
    {
        if (!Gate::allows('show admissions')) {
            return view('themes/default/back.permission-denied');
        }

        $admissions = Admission::orderBy('created_at', 'desc')->get();

        return view('themes.default.back.admins.admissions.admissions-list', ['admissions' => $admissions]);
    }

    public function show(Request $request)
    {
        if (!Gate::allows('show admissions')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $admission = Admission::where('id', $id)->first();

        return view('themes.default.back.admins.admissions.admissions-show', ['admission' => $admission]);
    }

    public function update(Request $request)
    {
        if (!Gate::allows('edit admissions')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'status' => 'required|string|in:pending,accepted,rejected',
        ]);

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $admission = Admission::findOrFail($id);

        $admission->status = $request->input('status');
        $admission->save();

        return redirect()->back()->with('success', __('l.Admission updated successfully'));
    }

    public function delete(Request $request)
    {
        if (!Gate::allows('delete admissions')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $admission = Admission::findOrFail($id);

        if ($admission->student_photo != '') {
            $filePath = public_path($admission->student_photo);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($admission->certificate_photo != '') {
            $filePath = public_path($admission->certificate_photo);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($admission->national_id_photo != '') {
            $filePath = public_path($admission->national_id_photo);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($admission->parent_national_id_photo != '') {
            $filePath = public_path($admission->parent_national_id_photo);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $admission->delete();

        return redirect()->back()->with('success', __('l.Admission deleted successfully'));
    }

    public function deleteSelected(Request $request)
    {
        if (!Gate::allows('delete admissions')) {
            return view('themes/default/back.permission-denied');
        }

        $ids = explode(',', $request->ids);
        $admissions = Admission::whereIn('id', $ids)->get();

        foreach ($admissions as $admission) {
            if ($admission->student_photo != '') {
                $filePath = public_path($admission->student_photo);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            if ($admission->certificate_photo != '') {
                $filePath = public_path($admission->certificate_photo);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            if ($admission->national_id_photo != '') {
                $filePath = public_path($admission->national_id_photo);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            if ($admission->parent_national_id_photo != '') {
                $filePath = public_path($admission->parent_national_id_photo);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $admission->delete();
        }

        return redirect()->back()->with('success', __('l.Admissions deleted successfully'));
    }
}
