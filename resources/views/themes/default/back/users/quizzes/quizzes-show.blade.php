@extends('themes.default.layouts.back.master')

@section('title')
    {{ $attempt->quiz->title }}
@endsection

@section('css')
<style>
    .correct-answer {
        background-color: #d4edda !important;
        border-color: #c3e6cb !important;
    }

    .incorrect-answer {
        background-color: #f8d7da !important;
        border-color: #f5c6cb !important;
    }

    .student-answer {
        border-left: 4px solid #007bff;
    }

    .student-wrong-answer {
        background-color: #f8d7da !important;
        border-color: #f5c6cb !important;
        border-left: 4px solid #dc3545 !important;
    }

    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        transition: box-shadow .3s ease-in-out;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">@lang('l.Quiz Result Summary')</h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>@lang('l.Total Score'):</strong> {{ $attempt->score }} / {{ $attempt->quiz->totalGrade() }}</li>
                        <li class="mb-2"><strong>@lang('l.Passing Score'):</strong> {{ $attempt->quiz->passing_score }}</li>
                        <li class="mb-2">
                            <strong>@lang('l.Result'):</strong>
                            @if($attempt->is_passed)
                                <span class="badge bg-success">@lang('l.Passed')</span>
                            @else
                                <span class="badge bg-danger">@lang('l.Failed')</span>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>@lang('l.Started At'):</strong> {{ $attempt->started_at->format('Y-m-d H:i:s') }}</li>
                        <li class="mb-2"><strong>@lang('l.Completed At'):</strong> {{ $attempt->completed_at->format('Y-m-d H:i:s') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @foreach($attempt->quiz->questions as $index => $question)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-bold mb-0">@lang('l.Question') {{ $index + 1 }}</h5>
                    <div>
                        @php
                            $studentAnswer = $studentAnswersMap[$question->id] ?? null;
                        @endphp
                        @if($studentAnswer)
                            @if($studentAnswer->is_correct)
                                <span class="badge bg-success">@lang('l.Correct')</span>
                            @else
                                <span class="badge bg-danger">@lang('l.Incorrect')</span>
                            @endif
                            <span class="badge bg-info">@lang('l.Points'): {{ $studentAnswer->points_earned }}/{{ $question->points }}</span>
                        @else
                            <span class="badge bg-warning">@lang('l.Not Answered')</span>
                            <span class="badge bg-info">@lang('l.Points'): 0/{{ $question->points }}</span>
                        @endif
                    </div>
                </div>

                <p class="question-text">{{ $question->question_text }}</p>

                @if($question->question_image)
                    <div class="question-image-container text-center mb-3">
                        <img src="{{ asset($question->question_image) }}"
                             class="img-fluid rounded"
                             style="max-height: 300px; object-fit: contain;"
                             alt="Question Image">
                    </div>
                @endif

                @if($question->type == 'essay')
                    <div class="mt-4">
                        <h6 class="fw-bold">@lang('l.Your Answer'):</h6>
                        <div class="p-3 border rounded student-answer">
                            {{ $studentAnswer->essay_answer ?? __('l.Not Answered') }}
                        </div>
                    </div>
                @else
                    <div class="answers-container mt-4">
                        @foreach($question->answers as $answer)
                            <div class="form-check answer-option mb-3 p-3 border rounded
                                {{ $answer->is_correct ? 'correct-answer' : '' }}
                                {{ $studentAnswer && $studentAnswer->answer_id == $answer->id && !$studentAnswer->is_correct ? 'student-wrong-answer' : '' }}
                                {{ $studentAnswer && $studentAnswer->answer_id == $answer->id && $studentAnswer->is_correct ? 'student-answer correct-answer' : '' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="answer-text">{{ $answer->answer_text }}</span>
                                        @if($answer->is_correct)
                                            <span class="badge bg-success ms-2">@lang('l.Correct Answer')</span>
                                        @endif
                                        @if($studentAnswer && $studentAnswer->answer_id == $answer->id)
                                            <span class="badge {{ $studentAnswer->is_correct ? 'bg-success' : 'bg-danger' }} ms-2">@lang('l.Your Answer')</span>
                                        @endif
                                    </div>
                                </div>

                                @if($answer->answer_image)
                                    <div class="answer-image-container text-center mt-2">
                                        <img src="{{ asset($answer->answer_image) }}"
                                             class="img-fluid rounded"
                                             style="max-height: 200px; object-fit: contain;"
                                             alt="Answer Image">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('js')
@endsection
