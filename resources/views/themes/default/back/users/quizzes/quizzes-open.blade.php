@extends('themes.default.layouts.back.master')


@section('title')
    {{ $quiz->title }}
@endsection

@section('css')
    <style>
        #timer-container {
            position: fixed;
            top: 85px;
            z-index: 100000;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            @if (app()->getLocale() == 'ar')
                left: 50px;
            @else
                right: 50px;
            @endif
        }

        .warning {
            color: #f44336 !important;
        }

        .warning #timer {
            color: #f44336;
            font-weight: bold;
        }

        /* إزالة أي تداخل قد يمنع التفاعل مع العناصر */
        .swal2-container {
            z-index: 9999 !important;
        }

        .form-check-input, .form-check-label, button[type="submit"] {
            position: relative;
            z-index: 1;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="content-wrapper">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <h2>{{ $quiz->title }}</h2>
                        <div id="timer-container" class="alert alert-info">
                            @lang('l.Remaining Time'): <span id="timer"></span>
                        </div>

                        <form action="{{ route('dashboard.users.quizzes-submit') }}" method="POST" id="quizForm"
                            onsubmit="return validateForm(event)">
                            @csrf
                            <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

                            @foreach ($questions as $index => $question)
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title fw-bold mb-0">@lang('l.Question') {{ $index + 1 }}</h5>
                                            <span class="badge bg-primary px-3 py-2">
                                                <i class="fas fa-star me-1"></i>
                                                {{ $question->points }} @lang('l.Points')
                                            </span>
                                        </div>
                                        <p class="question-text">{{ $question->question_text }}</p>
                                        @if ($question->question_image)
                                            <div class="question-image-container text-center mb-3">
                                                <img src="{{ asset($question->question_image) }}"
                                                    class="img-fluid rounded question-image"
                                                    style="max-height: 300px; object-fit: contain;"
                                                    onclick="openImageModal(this.src)" alt="Question Image">
                                            </div>
                                        @endif

                                        @if ($question->type == 'essay')
                                            <div class="essay-answer mt-3">
                                                <textarea name="answers[{{ $question->id }}]" class="form-control answer-input" data-question="{{ $index + 1 }}"
                                                    rows="4" placeholder="@lang('l.Enter your answer here')"></textarea>
                                            </div>
                                        @else
                                            <div class="answers-container mt-3">
                                                @foreach ($question->answers as $answer)
                                                    <div
                                                        class="form-check answer-option mb-3 p-3 border rounded hover-shadow">
                                                        <input class="form-check-input answer-input" type="radio"
                                                            name="answers[{{ $question->id }}]"
                                                            value="{{ $answer->id }}"
                                                            data-question="{{ $index + 1 }}"
                                                            id="answer-{{ $answer->id }}">
                                                        <label class="form-check-label w-100"
                                                            for="answer-{{ $answer->id }}">
                                                            <span class="answer-text">{{ $answer->answer_text }}</span>
                                                            @if ($answer->answer_image)
                                                                <div class="answer-image-container text-center mt-2">
                                                                    <img src="{{ asset($answer->answer_image) }}"
                                                                        class="img-fluid rounded answer-image"
                                                                        style="max-height: 200px; object-fit: contain;"
                                                                        onclick="openImageModal(this.src)"
                                                                        alt="Answer Image">
                                                                </div>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary w-100">@lang('l.Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // استخدام بيانات الاختبار من قاعدة البيانات
        const quizStartTime = new Date('{{ $quiz->start_time->timezone('Africa/Cairo')->toIso8601String() }}').getTime();
        const quizEndTime = new Date('{{ $quiz->end_time->timezone('Africa/Cairo')->toIso8601String() }}').getTime();
        const quizDuration = {{ $quiz->duration * 60 }}; // تحويل الدقائق إلى ثواني

        // استخدام وقت Laravel مباشرة (بالميلي ثانية) مع المنطقة الزمنية للقاهرة
        const serverTime = {{ \Carbon\Carbon::now('Africa/Cairo')->timestamp * 1000 }};
        const pageLoadTime = Date.now();

        // حساب الوقت المتبقي للاختبار
        const timeElapsedSinceStart = Math.max(0, serverTime - quizStartTime);
        const remainingTime = Math.max(0, Math.floor((quizEndTime - serverTime) / 1000));

        let hasSubmitted = false; // لمنع الإرسال المتكرر

        console.log("Quiz Info :", {
            quizStartTime: new Date(quizStartTime).toLocaleString(),
            quizEndTime: new Date(quizEndTime).toLocaleString(),
            serverTime: new Date(serverTime).toLocaleString(),
            now: new Date().toLocaleString(),
            quizDuration: quizDuration + " seconds (" + (quizDuration / 60) + " minutes)",
            timeElapsedSinceStart: Math.floor(timeElapsedSinceStart / 1000) + " seconds",
            remainingTime: remainingTime + " seconds (" + Math.floor(remainingTime / 60) + " minutes)"
        });

        function updateTimer() {
            if (hasSubmitted) return; // تجنب تحديث المؤقت بعد الإرسال

            // حساب الوقت الحالي بناءً على وقت الخادم + الوقت المنقضي منذ تحميل الصفحة
            const elapsedSinceLoad = Date.now() - pageLoadTime;
            const now = serverTime + elapsedSinceLoad;

            // حساب الوقت المتبقي
            const timeLeft = Math.max(0, Math.floor((quizEndTime - now) / 1000));

            // تحديث المؤقت
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer').textContent =
                `${minutes}:${seconds.toString().padStart(2, '0')}`;

            // تسجيل القيم للتصحيح (كل 10 ثواني)
            if (window.logCounter === undefined) window.logCounter = 0;
            if (window.logCounter % 10 === 0) {
                console.log("Timer Update:", {
                    now: new Date(now).toLocaleString(),
                    timeLeft: timeLeft + " seconds (" + minutes + ":" + seconds + ")",
                });
            }
            window.logCounter++;

            // تغيير لون المؤقت عندما يقترب الوقت من النهاية
            if (timeLeft <= 180) {
                document.body.classList.add('warning');
                document.getElementById('timer-container').classList.remove('alert-info');
                document.getElementById('timer-container').classList.add('warning');
            }

            // إرسال النموذج فقط عندما ينتهي الوقت تماماً
            if (timeLeft <= 0 && !hasSubmitted) {
                console.log("Time is up! Submitting form...");
                hasSubmitted = true;
                Swal.fire({
                    title: '@lang('l.Time is up!')',
                    text: '@lang('l.Your quiz is being submitted automatically.')',
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    // document.getElementById('quizForm').submit();
                });
            }
        }

        // تحديث المؤقت كل ثانية
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer(); // تشغيل المؤقت فوراً

        // إيقاف المؤقت عند إرسال النموذج يدوياً
        document.getElementById('quizForm').addEventListener('submit', function() {
            hasSubmitted = true;
            clearInterval(timerInterval);
        });

        function validateForm(event) {
            event.preventDefault();

            const totalQuestions = {{ count($questions) }};
            const answeredQuestions = [];
            const unansweredQuestions = [];

            // Group inputs by question number
            const questionGroups = {};
            document.querySelectorAll('.answer-input').forEach(input => {
                const questionNumber = input.dataset.question;
                if (!questionGroups[questionNumber]) {
                    questionGroups[questionNumber] = [];
                }
                questionGroups[questionNumber].push(input);
            });

            // Check each question group
            for (const [questionNumber, inputs] of Object.entries(questionGroups)) {
                const isAnswered = inputs.some(input =>
                    (input.type === 'radio' && input.checked) ||
                    (input.type === 'textarea' && input.value.trim() !== '')
                );

                if (isAnswered) {
                    answeredQuestions.push(questionNumber);
                } else {
                    unansweredQuestions.push(questionNumber);
                }
            }

            Swal.fire({
                title: '@lang('l.Confirm Submission')',
                html: `
                    <p>@lang('l.Answered Questions'): ${answeredQuestions.length}</p>
                    <p>@lang('l.Unanswered Questions'): ${unansweredQuestions.length}</p>
                    ${unansweredQuestions.length > 0 ?
                        '<p class="text-danger">@lang('l.Unanswered Question Numbers'): ' + unansweredQuestions.join(', ') + '</p>'
                        : ''}
                    <p class="text-warning">@lang('l.Warning: You cannot modify your answers after submission')</p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang('l.Yes, submit')',
                cancelButtonText: '@lang('l.No, review answers')',
            }).then((result) => {
                if (result.isConfirmed) {
                    hasSubmitted = true;
                    clearInterval(timerInterval);
                    document.getElementById('quizForm').submit();
                }
            });

            return false;
        }
    </script>
@endsection
