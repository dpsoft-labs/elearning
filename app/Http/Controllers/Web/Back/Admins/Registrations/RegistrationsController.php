<?php

namespace App\Http\Controllers\Web\Back\Admins\Registrations;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Nafezly\Payments\Classes\KashierPayment;

class RegistrationsController extends Controller
{
    /**
     * عرض المقررات المسجلة للطالب والمقررات المتاحة
     */
    public function show(Request $request)
    {
        if (!Gate::allows('show registrations')) {
            return view('themes/default/back.permission-denied');
        }

        $student_id = decrypt($request->student_id);
        $student = User::findOrFail($student_id);

        // المقررات المسجلة حالياً
        $enrolledCourses = $student->userCourses()
                            ->wherePivot('status', 'enrolled')
                            ->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')
                            ->get();

        // المقررات التي اجتازها الطالب
        $successCourses = $student->successCourses()->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')->get();

        // عدد ساعات المقررات التي اجتازها الطالب
        $totalSuccessHours = $student->totalSuccessHours();

        return view('themes.default.back.admins.registrations.registrations-show', [
            'student' => $student,
            'enrolledCourses' => $enrolledCourses,
            'successCourses' => $successCourses,
            'totalSuccessHours' => $totalSuccessHours
        ]);
    }

    /**
     * عرض المقررات المتاحة للتسجيل
     */
    public function availableCourses(Request $request)
    {
        if (!Gate::allows('show registrations')) {
            return view('themes/default/back.permission-denied');
        }

        $student_id = $request->student_id;
        $student = User::findOrFail($student_id);

        // الحصول على المقررات المتاحة للطالب
        $availableCourses = $student->availableCourses();

        return view('themes.default.back.admins.registrations.available-courses', [
            'student' => $student,
            'availableCourses' => $availableCourses
        ]);
    }

    /**
     * تسجيل المقررات للطالب
     */
    public function store(Request $request)
    {
        if (!Gate::allows('add registrations')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id'
        ]);

        $student = User::findOrFail($request->student_id);
        $courseIds = $request->course_ids;

        // التحقق من صلاحية التسجيل لجميع المقررات المحددة
        $availableCourseIds = $student->availableCourses()->pluck('id')->toArray();
        $validCourseIds = array_intersect($courseIds, $availableCourseIds);

        // تسجيل الطالب في المقررات المحددة
        foreach ($validCourseIds as $courseId) {
            $student->userCourses()->attach($courseId, [
                'status' => 'enrolled',
            ]);
        }

        // انشاء فاتورة للطالب
        $courses = Course::whereIn('id', $validCourseIds)->get();
        $totalHours = $courses->sum('hours');
        $hoursPrice = Setting::where('option', 'hour_price')->first()->value;
        $totalHoursPrice = $totalHours * $hoursPrice;

        $taxes = Tax::where('is_default', true)->get();
        $taxAmount = 0;
        $taxesDetails = [];

        // حساب مجموع الضرائب
        foreach ($taxes as $tax) {
            $currentTaxAmount = 0;
            if ($tax->type == 'percentage') {
                $currentTaxAmount = $totalHoursPrice * $tax->rate / 100;
            } else {
                $currentTaxAmount = $tax->rate;
            }

            // إضافة قيمة الضريبة الحالية إلى المجموع
            $taxAmount += $currentTaxAmount;

            // تخزين بيانات الضريبة الحالية
            $taxesDetails[] = [
                'tax_id' => $tax->id,
                'tax_name' => $tax->name,
                'tax_rate' => $tax->rate,
                'tax_type' => $tax->type,
                'tax_amount' => $currentTaxAmount
            ];
        }

        $totalPrice = $totalHoursPrice + $taxAmount;

        // إنشاء مصفوفة التفاصيل
        $details = [
            'student_info' => [
                'id' => $student->id,
                'name' => $student->fullName(),
                'email' => $student->email,
            ],
            'courses' => [],
            'hours_info' => [
                'total_hours' => $totalHours,
                'hour_price' => $hoursPrice,
                'total_hours_price' => $totalHoursPrice
            ],
            'taxes_info' => $taxesDetails,
            'total_tax_amount' => $taxAmount,
            'total_price' => $totalPrice
        ];

        // إضافة تفاصيل المقررات المسجلة
        foreach ($courses as $course) {
            $details['courses'][] = [
                'id' => $course->id,
                'name' => $course->name,
                'code' => $course->code,
                'hours' => $course->hours,
                'price' => $course->hours * $hoursPrice
            ];
        }

        $payment = new KashierPayment();
        $response = $payment
            ->setAmount($totalPrice)
            ->setSource('card,bank_installments,wallet,fawry')
            ->pay();

        $invoice = new Invoice();
        $invoice->user_id = $student->id;
        $invoice->details = $details;
        $invoice->amount = $totalPrice;
        $invoice->payment_method = 'kashier';
        $invoice->status = 'pending';
        $invoice->pid = $response['payment_id'] ?? 'NAN';
        $invoice->link = $response['html'] ?? 'NAN';
        $invoice->save();

        return redirect()->route('dashboard.admins.registrations-show', ['student_id' => encrypt($student->id)])
            ->with('success', __('l.Courses registered successfully'));
    }

    /**
     * حذف تسجيل مقرر للطالب
     */
    public function delete(Request $request)
    {
        if (!Gate::allows('delete registrations')) {
            return view('themes/default/back.permission-denied');
        }

        $student_id = $request->student_id;
        $course_id = $request->course_id;

        $student = User::findOrFail($student_id);
        $student->userCourses()->detach($course_id);

        return redirect()->route('dashboard.admins.registrations-show', ['student_id' => encrypt($student->id)])
            ->with('success', __('l.Course registration deleted successfully'));
    }

    /**
     * حذف تسجيل مقررات متعددة للطالب
     */
    public function deleteSelected(Request $request)
    {
        if (!Gate::allows('delete registrations')) {
            return view('themes/default/back.permission-denied');
        }

        $student_id = $request->student_id;
        $course_ids = explode(',', $request->ids);

        $student = User::findOrFail($student_id);
        $student->userCourses()->detach($course_ids);

        return redirect()->back()
            ->with('success', __('l.Course registrations deleted successfully'));
    }
}