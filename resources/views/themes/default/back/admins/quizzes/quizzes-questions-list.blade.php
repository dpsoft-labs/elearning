@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Quiz Questions') - {{ $quiz->title }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title">@lang('l.Quiz Questions') - {{ $quiz->title }}</h5>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">@lang('l.Questions List')</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                            <i class="fa fa-plus me-1"></i>@lang('l.Add Question')
                        </button>
                    </div>
                    <div class="card-body">
                        @foreach ($questions as $question)
                            <div class="question-card mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ $question->question_text }}</h6>
                                            <div>
                                                <a href="{{ route('dashboard.admins.quizzes.questions.edit', encrypt($question->id)) }}"
                                                   class="btn btn-sm btn-primary me-2">
                                                    <i class="fa fa-edit"></i> @lang('l.Edit')
                                                </a>
                                                <a href="{{ route('dashboard.admins.quizzes.questions.delete', encrypt($question->id)) }}"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('@lang('l.Are you sure you want to delete this question?')')">
                                                    <i class="fa fa-trash"></i> @lang('l.Delete')
                                                </a>
                                            </div>
                                        </div>

                                        @if ($question->question_image)
                                            <div class="mt-3">
                                                <img src="{{ asset($question->question_image) }}" class="img-fluid"
                                                    style="max-height: 200px;">
                                            </div>
                                        @endif

                                        <div class="mt-3">
                                            <span class="badge bg-label-primary me-2">@lang('l.Type'): {{ $question->type }}</span>
                                            <span class="badge bg-label-success">@lang('l.Points'): {{ $question->points }}</span>
                                        </div>

                                        @if ($question->type !== 'essay')
                                            <div class="answers mt-3">
                                                <h6 class="mb-2">@lang('l.Answers'):</h6>
                                                <ul class="list-group">
                                                    @foreach ($question->answers as $answer)
                                                        <li class="list-group-item {{ $answer->is_correct ? 'list-group-item-success' : '' }}">
                                                            {{ $answer->answer_text }}
                                                            @if ($answer->answer_image)
                                                                <div class="mt-2">
                                                                    <img src="{{ asset($answer->answer_image) }}"
                                                                        class="img-fluid" style="max-height: 100px;">
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Question Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('l.Add New Question')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dashboard.admins.quizzes.questions.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">@lang('l.Question Text')</label>
                                <textarea name="question_text" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">@lang('l.Question Image')</label>
                                <input type="file" name="question_image" class="form-control" accept="image/*">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">@lang('l.Question Type')</label>
                                <select name="type" class="form-select" id="questionType" required>
                                    <option value="multiple_choice">@lang('l.Multiple Choice')</option>
                                    <option value="true_false">@lang('l.True/False')</option>
                                    <option value="essay">@lang('l.Essay')</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">@lang('l.Points')</label>
                                <input type="number" name="points" class="form-control" min="1" required>
                            </div>

                            <div class="col-12" id="answersContainer">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label fw-bold mb-0">@lang('l.Answers')</label>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="addAnswerField(document.getElementById('answersList'))">
                                        <i class="fa fa-plus"></i> @lang('l.Add Answer')
                                    </button>
                                </div>
                                <div id="answersList">
                                    <!-- Answer fields will be added here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">@lang('l.Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('l.Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function addAnswerField(container, answerText = '', isCorrect = false, isReadOnly = false) {
            const answerCount = container.children.length + 1;
            const template = `
                <div class="answer-field mb-4">
                    <div class="mb-2">
                        <textarea name="answers[${answerCount}][text]" class="form-control w-100"
                                rows="3" required ${isReadOnly ? 'readonly' : ''}
                                style="resize: vertical;">${answerText}</textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="correct_answer"
                                   value="${answerCount-1}" id="correct_${answerCount}"
                                   onchange="updateCorrectAnswer(this)" ${isCorrect ? 'checked' : ''}>
                            <label class="form-check-label" for="correct_${answerCount}">
                                @lang('l.Correct Answer')
                            </label>
                        </div>

                        ${!isReadOnly ? `
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group" style="max-width: 300px;">
                                    <input type="file" name="answers[${answerCount}][image]"
                                           class="form-control" accept="image/*">
                                </div>
                                <button type="button" class="btn btn-icon btn-label-danger btn-sm remove-answer">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        ` : ''}

                        <input type="hidden" name="answers[${answerCount}][is_correct]"
                               value="${isCorrect ? '1' : '0'}">
                    </div>

                    <div class="current-answer-image mt-2"></div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
        }

        function updateCorrectAnswer(radio) {
            const answerFields = document.querySelectorAll('.answer-field');
            answerFields.forEach(field => {
                const hiddenInput = field.querySelector('input[name^="answers"][name$="[is_correct]"]');
                hiddenInput.value = field.querySelector('input[name="correct_answer"]').checked ? '1' : '0';
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-answer')) {
                e.target.closest('.answer-field').remove();
            }
        });

        // Initialize with two answer fields for multiple choice
        document.addEventListener('DOMContentLoaded', function() {
            const questionType = document.getElementById('questionType');
            const answersList = document.getElementById('answersList');
            const answersContainer = document.getElementById('answersContainer');

            function updateAnswerFields() {
                answersList.innerHTML = '';
                if (questionType.value === 'multiple_choice') {
                    answersContainer.style.display = 'block';
                    addAnswerField(answersList);
                    addAnswerField(answersList);
                } else if (questionType.value === 'true_false') {
                    answersContainer.style.display = 'block';
                    addAnswerField(answersList, '@lang("l.True")', false, true);
                    addAnswerField(answersList, '@lang("l.False")', false, true);
                } else {
                    answersContainer.style.display = 'none';
                }
            }

            questionType.addEventListener('change', updateAnswerFields);
            updateAnswerFields();
        });
    </script>
@endsection
