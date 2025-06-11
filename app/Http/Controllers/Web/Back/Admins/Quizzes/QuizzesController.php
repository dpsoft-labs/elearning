<?php

namespace App\Http\Controllers\Web\Back\Admins\Quizzes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\QuizQuestion;
use App\Models\QuizStudentAnswer;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Log;

class QuizzesController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('show quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        if ($request->course) {
            $quizzes = Quiz::where('course_id', decrypt($request->course))
                ->orderBy('id', 'desc')->get();
            $course = Course::findOrFail(decrypt($request->course));

            return view('themes/default/back.admins.quizzes.quizzes-list', compact('quizzes', 'course'));
        }

        if (Gate::allows('access all courses')) {
            $courses = Course::orderBy('created_at', 'desc')->get();
        } else {
            $courses = auth()->user()->userCourses;
        }

        return view('themes/default/back.admins.quizzes.quizzes-list', compact('courses'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('add quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0',
            'start_time' => 'required|date',
            'show_result' => 'required|in:after_submission,after_exam_end,manual',
            'course_id' => 'required|exists:courses,id'
        ]);

        $timezone = config('app.timezone');

        $startTime = Carbon::parse($request->start_time)
            ->timezone($timezone);

        $duration = (int) $request->duration;

        $endTime = $startTime->copy()
            ->addMinutes($duration);

        Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $duration,
            'passing_score' => (int) $request->passing_score,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_random_questions' => $request->has('is_random_questions') ? true : false,
            'is_random_answers' => $request->has('is_random_answers') ? true : false,
            'show_result' => $request->show_result,
            'course_id' => $request->course_id,
            'is_active' => true
        ]);

        return redirect()->back()->with('success', __('l.Quiz added successfully'));
    }

    public function edit(Request $request)
    {
        if (!Gate::allows('edit quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $quiz = Quiz::findOrFail($id);

        return view('themes/default/back.admins.quizzes.quizzes-edit', ['quiz' => $quiz]);
    }

    public function update(Request $request)
    {
        if (!Gate::allows('edit quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0',
            'start_time' => 'required|date',
            'show_result' => 'required|in:after_submission,after_exam_end,manual',
            'id' => 'required'
        ]);

        $id = decrypt($request->id);
        $quiz = Quiz::findOrFail($id);

        $timezone = config('app.timezone');

        $startTime = Carbon::parse($request->start_time)
            ->timezone($timezone);

        $duration = (int) $request->duration;

        $endTime = $startTime->copy()
            ->addMinutes($duration);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $duration,
            'passing_score' => (int) $request->passing_score,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_random_questions' => $request->has('is_random_questions') ? true : false,
            'is_random_answers' => $request->has('is_random_answers') ? true : false,
            'show_result' => $request->show_result
        ]);

        return redirect()->back()->with('success', __('l.Quiz updated successfully.'));
    }

    public function delete(Request $request)
    {
        if (!Gate::allows('delete quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $encryptedId = $request->id;
        $id = decrypt($encryptedId);

        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        // حذف جميع الصور المرتبطة بأسئلة الاختبار وإجاباتها
        foreach ($quiz->questions as $question) {
            // حذف صورة السؤال إذا وجدت
            if ($question->question_image && file_exists(public_path($question->question_image))) {
                unlink(public_path($question->question_image));
            }

            // حذف صور الإجابات إذا وجدت
            foreach ($question->answers as $answer) {
                if ($answer->answer_image && file_exists(public_path($answer->answer_image))) {
                    unlink(public_path($answer->answer_image));
                }
            }
        }

        // حذف الاختبار (سيتم حذف اسئلة والإجابات تلقائياً بسبب العلاقات)
        $quiz->delete();

        return redirect()->back()->with('success', __('l.Quiz deleted successfully'));
    }

    public function questions($id)
    {
        if (!Gate::allows('show quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $quiz = Quiz::findOrFail(decrypt($id));
        $questions = $quiz->questions()->with('answers')->get();

        return view('themes/default/back.admins.quizzes.quizzes-questions-list', compact('quiz', 'questions'));
    }

    public function storeQuestion(Request $request)
    {
        if (!Gate::allows('add quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:multiple_choice,true_false,essay',
            'points' => 'required|integer|min:1',
            'answers' => 'required_unless:type,essay|array|min:2',
            'answers.*.text' => 'required|string',
            'answers.*.is_correct' => 'required_unless:type,essay|boolean',
            'answers.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $quiz = Quiz::findOrFail($request->quiz_id);

        // معالجة صورة السؤال
        $questionImage = null;
        if ($request->hasFile('question_image')) {
            $file = $request->file('question_image');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = 'images/quizzes/questions/' . $fileName;
            $file->move(public_path('images/quizzes/questions'), $fileName);
            $questionImage = $filePath;
        }

        $question = $quiz->questions()->create([
            'question_text' => $request->question_text,
            'question_image' => $questionImage,
            'type' => $request->type,
            'points' => $request->points
        ]);

        // معالجة الإجابات
        if ($request->type !== 'essay') {
            foreach ($request->answers as $answer) {
                $answerImage = null;
                if (isset($answer['image']) && $answer['image']) {
                    $file = $answer['image'];
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $filePath = 'images/quizzes/answers/' . $fileName;
                    $file->move(public_path('images/quizzes/answers'), $fileName);
                    $answerImage = $filePath;
                }

                $question->answers()->create([
                    'answer_text' => $answer['text'],
                    'answer_image' => $answerImage,
                    'is_correct' => $answer['is_correct'] ?? false
                ]);
            }
        }

        if ($request->type === 'true_false') {
            // التأكد من وجود إجابة صحيحة واحدة فقط
            $correctAnswers = collect($request->answers)->filter(function ($answer) {
                return isset($answer['is_correct']) && $answer['is_correct'] == '1';
            });

            if ($correctAnswers->count() !== 1) {
                return redirect()->back()->with('error', __('l.True/False questions must have exactly one correct answer'));
            }
        }

        return redirect()->back()->with('success', __('l.Question added successfully'));
    }

    public function editQuestion($id)
    {
        if (!Gate::allows('edit quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $question = QuizQuestion::with('answers')->findOrFail(decrypt($id));

        return view('themes/default/back.admins.quizzes.quizzes-questions-edit', compact('question'));
    }

    public function updateQuestion(Request $request)
    {
        if (!Gate::allows('edit quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $request->validate([
            'question_id' => 'required', // حذفنا exists:quizzes_questions,id لأننا نتعامل مع قيمة مشفرة
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:multiple_choice,true_false,essay',
            'points' => 'required|integer|min:1',
            'answers' => 'required_unless:type,essay|array|min:2',
            'answers.*.text' => 'required|string',
            'answers.*.is_correct' => 'required_unless:type,essay|boolean',
            'answers.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $question = QuizQuestion::findOrFail(decrypt($request->question_id));

        // معالجة صورة السؤال
        $questionImage = $question->question_image; // الاحتفاظ بالصورة القديمة كقيمة افتراضية
        if ($request->hasFile('question_image')) {
            // حذف الصورة القديمة فقط إذا تم تحميل صورة جديدة
            if ($question->question_image && file_exists(public_path($question->question_image))) {
                unlink(public_path($question->question_image));
            }

            $file = $request->file('question_image');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = 'images/quizzes/questions/' . $fileName;
            $file->move(public_path('images/quizzes/questions'), $fileName);
            $questionImage = $filePath;
        }

        $question->update([
            'question_text' => $request->question_text,
            'question_image' => $questionImage, // تحديث الصورة سواء كانت جديدة أو قديمة
            'type' => $request->type,
            'points' => $request->points
        ]);

        // معالجة الإجابات
        if ($request->type !== 'essay') {
            foreach ($request->answers as $index => $answerData) {
                $answer = $question->answers[$index] ?? null;
                $answerImage = null;

                if (isset($answerData['image']) && $answerData['image']) {
                    // إذا تم تحميل صورة جديدة
                    $file = $answerData['image'];
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $filePath = 'images/quizzes/answers/' . $fileName;
                    $file->move(public_path('images/quizzes/answers'), $fileName);
                    $answerImage = $filePath;

                    // حذف الصورة القديمة إذا وجدت
                    if ($answer && $answer->answer_image && file_exists(public_path($answer->answer_image))) {
                        unlink(public_path($answer->answer_image));
                    }
                } else {
                    // الاحتفاظ بالصورة القديمة إذا وجدت
                    $answerImage = $answer ? $answer->answer_image : null;
                }

                // تحديد الإجابة الصحيحة
                $isCorrect = (string)$index === (string)$request->correct_answer;

                if ($answer) {
                    // تحديث الإجابة الموجودة
                    $answer->update([
                        'answer_text' => $answerData['text'],
                        'answer_image' => $answerImage,
                        'is_correct' => $isCorrect
                    ]);
                } else {
                    // إنشاء إجابة جديدة
                    $question->answers()->create([
                        'answer_text' => $answerData['text'],
                        'answer_image' => $answerImage,
                        'is_correct' => $isCorrect
                    ]);
                }

                // تحديث درجات الطلاب الذين اختاروا الإجابة الجديدة كإجابة صحيحة
                if ($isCorrect) {
                    QuizStudentAnswer::where('question_id', $question->id)
                        ->where('answer_id', $answer->id)
                        ->update(['is_correct' => true, 'points_earned' => $question->points]);
                }
            }

            // تحديث الإجابات القديمة إلى حالة خاطئة
            QuizStudentAnswer::where('question_id', $question->id)
                ->where('is_correct', true)
                ->whereNotIn('answer_id', $question->answers()->where('is_correct', true)->pluck('id'))
                ->update(['is_correct' => false, 'points_earned' => 0]);

            if ($request->type === 'true_false') {
                $correctCount = $question->answers()->where('is_correct', true)->count();
                if ($correctCount !== 1) {
                    return redirect()->back()->with('error', __('l.True/False questions must have exactly one correct answer'));
                }
            }
        }

        // إعادة حساب الدرجات الإجمالية لكل محاولة
        $attempts = QuizAttempt::whereHas('studentAnswers', function ($query) use ($question) {
            $query->where('question_id', $question->id);
        })->get();

        foreach ($attempts as $attempt) {
            $totalPoints = $attempt->studentAnswers->sum('points_earned');
            $attempt->score = $totalPoints;
            $attempt->is_passed = ($totalPoints >= $attempt->quiz->passing_score);
            $attempt->save();
        }

        return redirect()->back()->with('success', __('l.Question updated successfully'));
    }

    public function deleteQuestion($id)
    {
        if (!Gate::allows('delete quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $question = QuizQuestion::findOrFail(decrypt($id));

        // حذف صورة السؤال
        if ($question->question_image && file_exists(public_path($question->question_image))) {
            unlink(public_path($question->question_image));
        }

        // حذف صور الإجابات
        if ($question->answers) {
            foreach ($question->answers as $answer) {
                if ($answer->answer_image && file_exists(public_path($answer->answer_image))) {
                    unlink(public_path($answer->answer_image));
                }
            }
        }

        $question->delete();

        return redirect()->back()->with('success', __('l.Question deleted successfully'));
    }

    public function grade($id)
    {
        if (!Gate::allows('edit quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $quiz = Quiz::with([
            'attempts' => function ($query) {
                $query->with(['user', 'studentAnswers' => function ($q) {
                    $q->with(['question', 'answer']);
                }]);
            }
        ])->findOrFail(decrypt($id));

        return view('themes/default/back.admins.quizzes.quizzes-grade', [
            'quiz' => $quiz
        ]);
    }

    public function getAttempt($id)
    {
        if (!Gate::allows('edit quizzes')) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        $attempt = QuizAttempt::with([
            'user',
            'quiz',
            'studentAnswers' => function ($query) {
                $query->with(['question', 'answer']);
            }
        ])->findOrFail($id);

        return view('themes/default/back/admins/quizzes/quizzes-grade-attempt', [
            'attempt' => $attempt,
            'quiz' => $attempt->quiz
        ]);
    }

    public function updateGrade(Request $request)
    {
        try {
            if (!Gate::allows('edit quizzes')) {
                return response()->json([
                    'success' => false,
                    'message' => 'غير مصرح لك بهذا الإجراء'
                ], 403);
            }

            $request->validate([
                'answer_id' => 'required|exists:quizzes_student_answers,id',
                'points' => 'nullable|numeric|min:0',
                'is_correct' => 'nullable|boolean',
            ]);

            $studentAnswer = QuizStudentAnswer::findOrFail($request->answer_id);

            // تحديث البيانات المرسلة فقط
            if ($request->has('points')) {
                if ($request->points > $studentAnswer->question->points) {
                    return response()->json([
                        'success' => false,
                        'message' => __('l.The grade cannot be greater than the allowed grade')
                    ], 400);
                }
                $studentAnswer->points_earned = $request->points;
            }

            if ($request->has('is_correct')) {
                $studentAnswer->is_correct = $request->is_correct == "1";
            }

            $studentAnswer->save();

            // إعادة حساب مجموع درجات المحاولة
            $attempt = $studentAnswer->quizAttempt;
            $totalPoints = $attempt->studentAnswers->sum('points_earned');
            $attempt->score = $totalPoints;
            $attempt->is_passed = ($totalPoints >= $attempt->quiz->passing_score);
            $attempt->save();

            return response()->json([
                'success' => true,
                'message' => __('l.Grade updated successfully'),
                'new_total' => $totalPoints
            ]);

        } catch (\Exception $e) {
            Log::error('Error in updateGrade: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('l.An error occurred while updating the grade: ') . $e->getMessage()
            ], 500);
        }
    }

    public function statistics($id, Request $request)
    {
        if (!Gate::allows('show quizzes')) {
            return view('themes/default/back.permission-denied');
        }

        $quiz = Quiz::with(['attempts' => function ($query) {
            $query->with('user');
        }])->findOrFail(decrypt($id));

        // إحصائيات عامة
        $totalAttempts = $quiz->attempts->count();
        if(!$request->has('no')){
            $Attempts = $quiz->attempts()->paginate(100);
            $no = 0;
        }else{
            $Attempts = $quiz->notAttemptedStudents()->paginate(100);
            $no = 1;
        }
        // return $Attempts;
        $highestScore = $quiz->attempts->max('score');
        $statistics = [
            'total_students' => $quiz->course->students()->count(),
            'total_attempts' => $totalAttempts,
            'completed_attempts' => $quiz->attempts->where('completed_at', '!=', null)->count(),
            'passed_students' => $quiz->attempts->where('is_passed', true)->count(),
            'average_score' => $quiz->attempts->avg('score'),
            'highest_score' => $highestScore,
            'lowest_score' => $quiz->attempts->min('score'),
        ];

        // تحديد النطاقات بناءً على أعلى درجة
        $scoreDistribution = [];
        if ($highestScore > 0) {
            $rangeStep = max(1, ceil($highestScore / 5)); // ضمان أن الخطوة لا تقل عن 1
            for ($i = 0; $i <= $highestScore; $i += $rangeStep) {
                $rangeLabel = $i . '-' . min($i + $rangeStep - 1, $highestScore);
                $scoreDistribution[$rangeLabel] = $quiz->attempts->whereBetween('score', [$i, min($i + $rangeStep - 1, $highestScore)])->count();
            }
        } else {
            $scoreDistribution['0'] = $quiz->attempts->where('score', 0)->count();
        }

        return view('themes/default/back.admins.quizzes.quizzes-statistics', [
            'quiz' => $quiz,
            'statistics' => $statistics,
            'scoreDistribution' => $scoreDistribution,
            'Attempts' => $Attempts,
            'no' => $no
        ]);
    }
}
