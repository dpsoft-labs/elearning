<?php

namespace App\Http\Controllers\Web\Back\Users\Registrations;

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
    public function index(Request $request)
    {
        $student = auth()->user();

        // المقررات المسجلة حالياً
        $enrolledCourses = $student->userCourses()
                            ->wherePivot('status', 'enrolled')
                            ->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')
                            ->get();

        // المقررات التي اجتازها الطالب
        $successCourses = $student->successCourses()->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')->get();

        // عدد ساعات المقررات التي اجتازها الطالب
        $totalSuccessHours = $student->totalSuccessHours();

        return view('themes.default.back.users.registrations.registrations-show', [
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
        $registration_status = Setting::where('option', 'registration_status')->first()->value;
        $registration_start_date = Setting::where('option', 'registration_start_date')->first()->value;
        $registration_end_date = Setting::where('option', 'registration_end_date')->first()->value;

        if ($registration_status == '0' || $registration_start_date > now() || $registration_end_date < now()) {
            return redirect()->route('dashboard.users.registrations')
                ->with('error', __('l.Registration is closed'));
        }

        $student = auth()->user();

        // الحصول على المقررات المتاحة للطالب
        $availableCourses = $student->availableCourses();

        return view('themes.default.back.users.registrations.available-courses', [
            'student' => $student,
            'availableCourses' => $availableCourses
        ]);
    }

    /**
     * تسجيل المقررات للطالب
     */
    public function store(Request $request)
    {
        $registration_status = Setting::where('option', 'registration_status')->first()->value;
        $registration_start_date = Setting::where('option', 'registration_start_date')->first()->value;
        $registration_end_date = Setting::where('option', 'registration_end_date')->first()->value;
        $min_hours = Setting::where('option', 'min_hours')->first()->value;
        $max_hours = Setting::where('option', 'max_hours')->first()->value;

        if ($registration_status == '0' || $registration_start_date > now() || $registration_end_date < now()) {
            return redirect()->route('dashboard.users.registrations')
                ->with('error', __('l.Registration is closed'));
        }

        $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id'
        ]);

        $student = auth()->user();
        $courseIds = $request->course_ids;

        // التحقق من صلاحية التسجيل لجميع المقررات المحددة
        $availableCourseIds = $student->availableCourses()->pluck('id')->toArray();
        $validCourseIds = array_intersect($courseIds, $availableCourseIds);

        $courses = Course::whereIn('id', $validCourseIds)->get();

        $totalHours = $courses->sum('hours');

        if ($totalHours < $min_hours || $totalHours > $max_hours) {
            return redirect()->route('dashboard.users.registrations')
                ->with('error', __('l.Invalid number of courses'));
        }

        // تسجيل الطالب في المقررات المحددة
        foreach ($validCourseIds as $courseId) {
            $student->userCourses()->attach($courseId, [
                'status' => 'enrolled',
            ]);
        }

        // انشاء فاتورة للطالب
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

        return redirect()->route('dashboard.users.registrations')
            ->with('success', __('l.Courses registered successfully'));
    }
}