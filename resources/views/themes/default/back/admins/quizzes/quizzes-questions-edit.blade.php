@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Edit Question') - {{ $question->quiz->title }}
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <h5 class="card-title">@lang('l.Edit Question') - {{ $question->quiz->title }}</h5>
        </div>

        @if ($errors->any())
            <div class="col-12">
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            </div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.admins.quizzes.questions.update', encrypt($question->id)) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="question_id" value="{{ encrypt($question->id) }}">

                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label">@lang('l.Question Text')</label>
                                <textarea name="question_text" class="form-control" rows="4" required>{{ $question->question_text }}</textarea>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">@lang('l.Question Image')</label>
                                @if($question->question_image)
                                    <div class="mb-3">
                                        <img src="{{ asset($question->question_image) }}" class="img-fluid" style="max-height: 200px;">
                                    </div>
                                @endif
                                <input type="file" name="question_image" class="form-control" accept="image/*">
                            </div>

                            <div class="col-md-6 mb-4 d-none">
                                <label class="form-label">@lang('l.Question Type')</label>
                                <select name="type" class="form-control" required>
                                    <option value="multiple_choice" {{ $question->type == 'multiple_choice' ? 'selected' : '' }}>
                                        @lang('l.Multiple Choice')
                                    </option>
                                    <option value="true_false" {{ $question->type == 'true_false' ? 'selected' : '' }}>
                                        @lang('l.True/False')
                                    </option>
                                    <option value="essay" {{ $question->type == 'essay' ? 'selected' : '' }}>
                                        @lang('l.Essay')
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">@lang('l.Points')</label>
                                <input type="number" name="points" class="form-control" min="1"
                                       value="{{ $question->points }}" required>
                            </div>

                            @if($question->type !== 'essay')
                                <div class="col-12">
                                    <h6 class="mb-3">@lang('l.Answers')</h6>
                                    @foreach($question->answers as $index => $answer)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">@lang('l.Answer Text')</label>
                                                    <textarea name="answers[{{ $index }}][text]"
                                                              class="form-control" required>{{ $answer->answer_text }}</textarea>
                                                </div>

                                                <div class="form-check mb-3">
                                                    <input type="radio"
                                                           class="form-check-input"
                                                           name="correct_answer"
                                                           value="{{ $index }}"
                                                           id="correct_{{ $index }}"
                                                           {{ $answer->is_correct ? 'checked' : '' }}
                                                           onchange="updateCorrectAnswer(this)">
                                                    <label class="form-check-label" for="correct_{{ $index }}">
                                                        @lang('l.Correct Answer')
                                                    </label>
                                                    <input type="hidden"
                                                           name="answers[{{ $index }}][is_correct]"
                                                           value="{{ $answer->is_correct ? '1' : '0' }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">@lang('l.Answer Image')</label>
                                                    @if($answer->answer_image)
                                                        <div class="mb-3">
                                                            <img src="{{ asset($answer->answer_image) }}"
                                                                 class="img-fluid" style="max-height: 100px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="answers[{{ $index }}][image]"
                                                           class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">@lang('l.Update Question')</button>
                                    <a href="{{ route('dashboard.admins.quizzes-questions', encrypt($question->quiz_id)) }}"
                                       class="btn btn-label-secondary">@lang('l.Back')</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
function updateCorrectAnswer(radio) {
    document.querySelectorAll('input[name$="[is_correct]"]').forEach(input => {
        input.value = '0';
    });

    const selectedIndex = radio.value;
    document.querySelector(`input[name="answers[${selectedIndex}][is_correct]"]`).value = '1';
}

document.querySelector('form').addEventListener('submit', function(e) {
    const type = '{{ $question->type }}';
    if (type === 'true_false') {
        const correctAnswerSelected = document.querySelector('input[name="correct_answer"]:checked');
        if (!correctAnswerSelected) {
            e.preventDefault();
            alert('@lang("l.Please select one correct answer")');
        }
    }
});
</script>
@endsection