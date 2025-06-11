<?php

namespace App\Http\Controllers\Web\Back\Users\Quizzes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\QuizStudentAnswer;

class QuizzesController extends Controller
{
    public function index(Request $request)
    {
        $enrolledCourses = Auth::user()->userCourses()
                            ->wherePivot('status', 'enrolled')
                            ->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')
                            ->get();
        $quizzes = Quiz::whereIn('course_id', $enrolledCourses->pluck('id'))->orderByDesc('id')->get();
        return view(theme('back.users.quizzes.quizzes-list'), ['quizzes' =>$quizzes]);
    }

    public function open(Request $request)
    {
        $quiz = Quiz::findOrFail(decrypt($request->quiz_id));
        $enrolledCourses = Auth::user()->userCourses()
                            ->wherePivot('status', 'enrolled')
                            ->withPivot('quizzes', 'midterm', 'attendance', 'final', 'total')
                            ->get();

        if (!$enrolledCourses->contains('id', $quiz->course_id)) {
            return redirect()->back()->with('error', 'You are not allowed to open this quiz');
        }

        if($quiz->start_time > now()){
            return redirect()->back()->with('error', 'This quiz is not started yet');
        }

        if($quiz->end_time < now()){
            return redirect()->back()->with('error', 'This quiz is ended');
        }

        // check if user has already started this quiz
        $userQuiz = QuizAttempt::where('user_id', Auth::user()->id)->where('quiz_id', $quiz->id)->first();
        if($userQuiz && $userQuiz->completed_at){
            return redirect()->back()->with('error', 'You have already taken this quiz');
        }
        if(!$userQuiz){
            $quizAttempt = new QuizAttempt();
            $quizAttempt->user_id = Auth::user()->id;
            $quizAttempt->quiz_id = $quiz->id;
            $quizAttempt->started_at = now();
            $quizAttempt->score = 0;
            $quizAttempt->is_passed = false;
            $quizAttempt->save();
        } else {
            $quizAttempt = $userQuiz;
        }

        // تحضير الأسئلة
        $questions = $quiz->questions()->with('answers')->get();
        if ($quiz->is_random_questions) {
            $questions = $questions->shuffle();
        }

        foreach ($questions as $question) {
            if ($quiz->is_random_answers) {
                $question->answers = $question->answers->shuffle();
            }
        }

        return view(theme('back.users.quizzes.quizzes-open'), [
            'quiz' => $quiz,
            'questions' => $questions,
            'attempt' => $quizAttempt
        ]);
    }

    public function submit(Request $request)
    {
        $attempt = QuizAttempt::findOrFail($request->attempt_id);

        if ($attempt->completed_at) {
            return redirect()->back()->with('error', 'You have already taken this quiz');
        }

        $totalPoints = 0;
        foreach ($request->answers as $questionId => $answer) {
            $question = QuizQuestion::findOrFail($questionId);

            $studentAnswer = new QuizStudentAnswer();
            $studentAnswer->quiz_attempt_id = $attempt->id;
            $studentAnswer->question_id = $questionId;

            if ($question->type == 'essay') {
                $studentAnswer->essay_answer = $answer;
                $studentAnswer->is_correct = false; // سيتم تصحيحه يدوياً
                $studentAnswer->points_earned = 0;
            } else {
                $studentAnswer->answer_id = $answer;
                $correctAnswer = QuizAnswer::where('question_id', $questionId)
                                         ->where('is_correct', true)
                                         ->first();

                $studentAnswer->is_correct = ($answer == $correctAnswer->id);
                $studentAnswer->points_earned = $studentAnswer->is_correct ? $question->points : 0;
                $totalPoints += $studentAnswer->points_earned;
            }

            $studentAnswer->save();
        }

        $attempt->score = $totalPoints;
        $attempt->completed_at = now();
        $attempt->is_passed = ($totalPoints >= $attempt->quiz->passing_score);
        $attempt->save();

        if ($attempt->quiz->show_result == 'after_submission') {
            return redirect()->route('dashboard.users.quizzes-show', ['attempt_id' => encrypt($attempt->id)]);
        }

        return redirect()->route('dashboard.users.quizzes')->with('success', 'You have successfully taken the quiz');
    }

    public function show(Request $request)
    {
        $attempt = QuizAttempt::with([
            'quiz.questions.answers',  // جلب جميع الأسئلة والإجابات الخاصة بالاختبار
            'studentAnswers'           // جلب إجابات الطالب
        ])->findOrFail(decrypt($request->attempt_id));

        if ($attempt->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'You are not allowed to view this quiz');
        }

        if ($attempt->quiz->show_result == 'manual') {
            return redirect()->back()->with('error', 'The result will be shown later by the supervisor');
        }

        if ($attempt->quiz->show_result == 'after_exam_end' && $attempt->quiz->end_time > now()) {
            return redirect()->back()->with('error', 'The result will be shown after the exam ends');
        }

        // تحويل إجابات الطالب إلى مصفوفة مفهرسة بواسطة question_id
        $studentAnswersMap = $attempt->studentAnswers->keyBy('question_id');

        return view(theme('back.users.quizzes.quizzes-show'), [
            'attempt' => $attempt,
            'studentAnswersMap' => $studentAnswersMap
        ]);
    }
}