<?php

namespace App\Http\Controllers\Web\Back\Admins\Grades;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GradesController extends Controller
{
   public function index()
   {
    if (!Gate::allows('upload grades')) {
        return view('themes/default/back.permission-denied');
    }

    if (Gate::allows('access all courses')) {
        $courses = Course::where('is_active', 1)->get();
    } else {
        $courses = auth()->user()->userCourses()->where('is_active', 1)->get();
    }

    return view('themes.default.back.admins.grades.grades-list', compact('courses'));
   }


   public function show(Request $request)
   {
    $course = Course::findOrFail(decrypt($request->course_id));

    // استدعاء الطلاب مع العلاقة pivot بشكل صريح
    $students = $course->users()
        ->wherePivot('status', '!=', 'staff')
        ->withPivot(['quizzes', 'midterm', 'attendance', 'final', 'total', 'status'])
        ->get();

    // تحويل الدرجات إلى قيم رقمية (لأنها مخزنة كنصوص في قاعدة البيانات)
    $students->each(function ($student) {
        $student->pivot->quizzes = (float)$student->pivot->quizzes;
        $student->pivot->midterm = (float)$student->pivot->midterm;
        $student->pivot->attendance = (float)$student->pivot->attendance;
        $student->pivot->final = (float)$student->pivot->final;
        $student->pivot->total = (float)$student->pivot->total;
    });

    // الحصول على إحصائيات حالة الطلاب
    $totalStudents = $students->count();
    $passedStudents = $students->where('pivot.status', 'success')->count();
    $failedStudents = $students->where('pivot.status', 'fail')->count();
    $enrolledStudents = $students->where('pivot.status', 'enrolled')->count();

    // حساب نسبة النجاح من بين الممتحنين فقط (الذين لديهم حالة نجاح أو رسوب)
    $examinedStudents = $passedStudents + $failedStudents;
    $passRate = $examinedStudents > 0 ? round(($passedStudents / $examinedStudents) * 100) : 0;

    // حساب متوسطات الدرجات
    $avgQuizzes = $students->avg(function($student) {
        return (float)$student->pivot->quizzes;
    });

    $avgMidterm = $students->avg(function($student) {
        return (float)$student->pivot->midterm;
    });

    $avgAttendance = $students->avg(function($student) {
        return (float)$student->pivot->attendance;
    });

    $avgFinal = $students->avg(function($student) {
        return (float)$student->pivot->final;
    });

    $avgTotal = $students->avg(function($student) {
        return (float)$student->pivot->total;
    });

    return view('themes.default.back.admins.grades.grades-show', compact(
        'course',
        'students',
        'totalStudents',
        'passedStudents',
        'failedStudents',
        'enrolledStudents',
        'passRate',
        'avgQuizzes',
        'avgMidterm',
        'avgAttendance',
        'avgFinal',
        'avgTotal'
    ));
   }

   public function upload(Request $request)
   {
    if (!Gate::allows('upload grades')) {
        return response()->json(['error' => __('l.You do not have permission to upload grades')], 403);
    }

    $validator = Validator::make($request->all(), [
        'course_id' => 'required',
        'grade_type' => 'required|in:quizzes,midterm,attendance,final',
        'excel_file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }

    try {
        $course = Course::findOrFail(decrypt($request->course_id));
        $type = $request->grade_type;

        // قراءة ملف الإكسل
        $spreadsheet = IOFactory::load($request->file('excel_file'));
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // التحقق من وجود بيانات في الملف
        if (count($rows) === 0) {
            return response()->json(['error' => __('l.The uploaded file is empty')], 422);
        }

        // التخطي للعنوان إذا كان موجودًا
        $startRow = 0;
        if (count($rows) > 0 && (strtolower($rows[0][0]) == 'sid' || strtolower($rows[0][0]) == 'id')) {
            $startRow = 1;
        }

        $processedCount = 0;
        $errors = [];
        $successCount = 0;

        // معالجة كل صف في الملف
        for ($i = $startRow; $i < count($rows); $i++) {
            if (empty($rows[$i][0]) || !isset($rows[$i][1])) {
                continue; // تخطي الصفوف الفارغة
            }

            $sid = trim($rows[$i][0]);
            $grade = trim($rows[$i][1]);

            // التحقق من أن القيمة ليست فارغة
            if (empty($sid) || $sid == "") {
                continue;
            }

            // استخراج ID الطالب الحقيقي من SID
            // إزالة أول رقمين (السنة) وإزالة الأصفار من اليسار
            $userId = ltrim(substr($sid, 2), '0');

            // البحث عن الطالب بواسطة ID
            $user = User::find($userId);

            if (!$user) {
                $errors[] = __('l.Student with SID :sid not found', ['sid' => $sid]);
                continue;
            }

            // التحقق من أن الطالب مسجل في الكورس
            $courseUser = $user->userCourses()->where('courses.id', $course->id)->first();
            if (!$courseUser) {
                $errors[] = __('l.Student :name with SID :sid is not enrolled in this course', ['name' => $user->firstname.' '.$user->lastname, 'sid' => $sid]);
                continue;
            }

            // التحقق من أن الدرجة هي قيمة رقمية وفي النطاق المسموح
            if (!is_numeric($grade)) {
                $errors[] = __('l.Invalid grade value :grade for student :name with SID :sid', ['grade' => $grade, 'name' => $user->firstname.' '.$user->lastname, 'sid' => $sid]);
                continue;
            }

            // التحقق من أن الدرجة في النطاق المسموح (0-100)
            $numericGrade = floatval($grade);
            if ($numericGrade < 0 || $numericGrade > 100) {
                $errors[] = __('l.Grade must be between 0 and 100 for student :name with SID :sid', ['name' => $user->firstname.' '.$user->lastname, 'sid' => $sid]);
                continue;
            }

            // تحديث درجة الطالب في عمود النوع المناسب
            $user->userCourses()->updateExistingPivot($course->id, [$type => $numericGrade]);

            // حساب المجموع الكلي وتحديث حالة النجاح/الرسوب
            $this->updateTotalAndStatus($user, $course, $type);

            $successCount++;
            $processedCount++;
        }

        if (count($errors) > 0) {
            return response()->json([
                'success' => __('l.Grades uploaded with some errors'),
                'processed' => $processedCount,
                'success_count' => $successCount,
                'error_count' => count($errors),
                'errors' => $errors
            ], 200);
        }

        return response()->json([
            'success' => __('l.Grades uploaded successfully for :count students', ['count' => $processedCount])
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error uploading grades: ' . $e->getMessage() . ' - File: ' . $e->getFile() . ' Line: ' . $e->getLine());
        return response()->json(['error' => __('l.An error occurred during file processing: :message', ['message' => $e->getMessage()])], 500);
    }
   }

   /**
    * حساب المجموع الكلي وتحديث حالة النجاح/الرسوب للطالب
    * @param User $user
    * @param Course $course
    * @param string $type نوع الدرجات المرفوعة
    * @return float
    */
   private function updateTotalAndStatus($user, $course, $type = null)
   {
        // الحصول على سجل الطالب والكورس بشكل مباشر من جدول العلاقات
        $pivotData = DB::table('courses_user')
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$pivotData) {
            return 0;
        }

        // تحويل القيم بشكل صريح إلى أرقام عشرية
        $quizzes = is_numeric($pivotData->quizzes) ? (float)$pivotData->quizzes : 0;
        $midterm = is_numeric($pivotData->midterm) ? (float)$pivotData->midterm : 0;
        $attendance = is_numeric($pivotData->attendance) ? (float)$pivotData->attendance : 0;
        $final = is_numeric($pivotData->final) ? (float)$pivotData->final : 0;

        // حساب المجموع الكلي بعد التحقق من صحة القيم
        $total = $quizzes + $midterm + $attendance + $final;

        // تجنب أي قيم تتجاوز 100
        $total = min(100, $total);

        // تحديث المجموع الكلي
        $user->userCourses()->updateExistingPivot($course->id, ['total' => $total]);

        // تحديث الحالة فقط عندما يكون النوع هو الامتحان النهائي
        if ($type === 'final') {
            Log::info('تحديث حالة الطالب بعد رفع درجة الامتحان النهائي', [
                'student_id' => $user->id,
                'course_id' => $course->id,
                'final_grade' => $final,
                'total' => $total
            ]);

            // التحقق من وجود درجة للامتحان النهائي
            if ($final > 0) {
                // تحديد حالة النجاح أو الرسوب (اجتياز المادة بـ 50% أو أكثر)
                $status = $total >= 50 ? 'success' : 'fail';

                // تحديث الحالة في قاعدة البيانات
                $user->userCourses()->updateExistingPivot($course->id, ['status' => $status]);
                Log::info('تم تحديث حالة الطالب إلى: ' . $status);

                // إذا كان الطالب ناجح، قم بتحديث GPA
                if ($status === 'success') {
                    $this->updateStudentGPA($user, $course, $total);
                    Log::info('تم تحديث GPA للطالب');
                }
            }
        }

        return $total;
   }

   /**
    * تحديث GPA للطالب
    * @param User $user
    * @param Course $course
    * @param float $total
    * @return void
    */
   private function updateStudentGPA($user, $course, $total)
   {
        // الحصول على إعدادات GPA
        $settings = \App\Models\Setting::whereIn('option', [
            'gpa_4', 'gpa_3_6', 'gpa_3_2', 'gpa_3_0',
            'gpa_2_7', 'gpa_2_5', 'gpa_2_2', 'gpa_2_0'
        ])->get()->pluck('value', 'option')->toArray();

        // حساب قيمة GPA للمادة الحالية
        $courseGPA = $this->calculateCourseGPA($total, $settings);

        // الحصول على المواد التي اجتازها الطالب سابقاً
        $passedCourses = $user->successCourses()->where('courses.id', '!=', $course->id)->get();

        // حساب مجموع (الساعات × GPA) للمواد المجتازة سابقاً
        $totalPoints = 0;
        $totalHours = 0;

        foreach ($passedCourses as $passedCourse) {
            $passedCourseGPA = $this->calculateCourseGPA($passedCourse->pivot->total, $settings);
            $totalPoints += $passedCourseGPA * $passedCourse->hours;
            $totalHours += $passedCourse->hours;
        }

        // إضافة المادة الحالية إلى الحساب
        $totalPoints += $courseGPA * $course->hours;
        $totalHours += $course->hours;

        // حساب GPA الكلي
        $cumulativeGPA = $totalHours > 0 ? round($totalPoints / $totalHours, 2) : 0;

        // تحديث GPA الكلي للطالب
        $user->gpa = $cumulativeGPA;
        $user->save();
   }

   /**
    * حساب GPA لمادة واحدة بناءً على الدرجة الكلية
    * @param float $total
    * @param array $settings
    * @return float
    */
   private function calculateCourseGPA($total, $settings)
   {
        if ($total >= (float)$settings['gpa_4']) {
            return 4.0;
        } elseif ($total >= (float)$settings['gpa_3_6']) {
            return 3.6;
        } elseif ($total >= (float)$settings['gpa_3_2']) {
            return 3.2;
        } elseif ($total >= (float)$settings['gpa_3_0']) {
            return 3.0;
        } elseif ($total >= (float)$settings['gpa_2_7']) {
            return 2.7;
        } elseif ($total >= (float)$settings['gpa_2_5']) {
            return 2.5;
        } elseif ($total >= (float)$settings['gpa_2_2']) {
            return 2.2;
        } elseif ($total >= (float)$settings['gpa_2_0']) {
            return 2.0;
        } else {
            return 0.0;
        }
   }

   /**
    * تحميل نموذج إكسل للدرجات
    */
   public function downloadTemplate(Request $request)
   {
    if (!Gate::allows('upload grades')) {
        return response()->json(['error' => __('l.You do not have permission to download template')], 403);
    }

    try {
        $course = Course::findOrFail(decrypt($request->course_id));

        // إنشاء ملف إكسل جديد
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // وضع العناوين
        $sheet->setCellValue('A1', 'SID');
        $sheet->setCellValue('B1', 'Grade');

        // الحصول على الطلاب المسجلين في الكورس
        $enrolledUsers = $course->users()->wherePivot('status', 'enrolled')->get();

        $row = 2;
        foreach ($enrolledUsers as $user) {
            // استخدام دالة getSidAttribute من نموذج User
            $sheet->setCellValue('A' . $row, $user->getSidAttribute());
            $sheet->setCellValue('B' . $row, '');
            $row++;
        }

        // تنسيق العمود الأول
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        // إنشاء ملف مؤقت للتنزيل
        $fileName = 'grades_template_' . $course->code . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        // تنزيل الملف
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();

    } catch (\Exception $e) {
        Log::error('Error creating template: ' . $e->getMessage());
        return response()->json(['error' => __('l.An error occurred while creating the template: :message', ['message' => $e->getMessage()])], 500);
    }
   }
}