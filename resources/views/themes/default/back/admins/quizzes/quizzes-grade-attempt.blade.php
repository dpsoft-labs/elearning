<div class="quiz-attempt-review">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">@lang('l.Student'): {{ $attempt->user->firstname }} {{ $attempt->user->lastname }}</h6>
                <div class="d-flex gap-3">
                    <span>@lang('l.Total Score'): <strong id="total-score-{{ $attempt->id }}">{{ $attempt->score }}</strong>/{{ $quiz->totalGrade() }}</span>
                    <span>@lang('l.Passing Score'): {{ $quiz->passing_score }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="questions-list">
        @foreach ($attempt->studentAnswers as $index => $answer)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">@lang('l.Question') {{ $index + 1 }}</h6>
                    <span class="badge bg-label-info">{{ $answer->question->points }} @lang('l.points')</span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="mb-2">@lang('l.Question Text')</h6>
                        <p class="mb-0">{{ $answer->question->question_text }}</p>
                        @if ($answer->question->question_image)
                            <div class="mt-3">
                                <img src="{{ asset($answer->question->question_image) }}" class="img-fluid"
                                    style="max-height: 200px">
                            </div>
                        @endif
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="{{$answer->question->type != 'essay' ? 'col-md-6' : 'col-md-12'}}">
                                    <h6 class="mb-3">@lang('l.Student Answer')</h6>
                                    @if ($answer->question->type == 'essay')
                                        <div class="p-3 bg-lighter rounded">
                                            {{ $answer->essay_answer }}
                                        </div>
                                    @else
                                        <div class="selected-answer">
                                            @if ($answer->answer)
                                                <div class="d-flex align-items-center">
                                                    <span>{{ $answer->answer->answer_text }}</span>
                                                </div>
                                                @if ($answer->answer->answer_image)
                                                    <div class="mt-3">
                                                        <img src="{{ asset($answer->answer->answer_image) }}" class="img-fluid"
                                                            style="max-height: 150px">
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">@lang('l.No Answer')</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                @if ($answer->question->type != 'essay')
                                    <div class="col-md-6">
                                        <h6 class="mb-3">@lang('l.Correct Answer')</h6>
                                        <div class="correct-answer">
                                            @php
                                                $correctAnswer = $answer->question->answers()->where('is_correct', true)->first();
                                            @endphp

                                            @if ($correctAnswer)
                                                <div class="d-flex align-items-center">
                                                    <span>{{ $correctAnswer->answer_text }}</span>
                                                </div>
                                                @if ($correctAnswer->answer_image)
                                                    <div class="mt-3">
                                                        <img src="{{ asset($correctAnswer->answer_image) }}" class="img-fluid"
                                                            style="max-height: 150px">
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">@lang('l.No Answer')</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">@lang('l.Points')</label>
                            <input type="number" class="form-control" value="{{ $answer->points_earned }}"
                                min="0" max="{{ $answer->question->points }}"
                                onchange="updateGrade({{ $answer->id }}, this.value, {{ $attempt->id }}, this)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">@lang('l.Status')</label>
                            <select class="form-select"
                                onchange="updateAnswerStatus({{ $answer->id }}, this.value, {{ $attempt->id }}, this)">
                                <option value="1" {{ $answer->is_correct ? 'selected' : '' }}>@lang('l.Correct')</option>
                                <option value="0" {{ !$answer->is_correct ? 'selected' : '' }}>@lang('l.Incorrect')</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.student-and-correct-answers {
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 5px;
}

.student-and-correct-answers .col-md-6 {
    padding: 15px;
}

@media (min-width: 768px) {
    .student-and-correct-answers .row {
        display: flex;
        flex-wrap: nowrap;
    }

    .student-and-correct-answers .col-md-6:first-child {
        border-right: 1px solid #eee;
    }
}

.selected-answer, .correct-answer {
    margin-top: 10px;
}
</style>
