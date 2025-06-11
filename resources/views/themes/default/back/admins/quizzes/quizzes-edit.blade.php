@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Edit Quiz') - {{ $quiz->title }}
@endsection

@section('content')
    <div class="container mt-5">
        <div class="content-wrapper">
            @can('edit quizzes')
                <!-- Add Role Modal -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="addRoleModal" tabindex="-1" aria-hidden="false">
                    <div class=" modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <h3 class="role-title mb-2">@lang('l.Edit Quiz')</h3>
                                </div>
                                <!-- Add role form -->
                                <form id="editProductForm" method="post" class="row g-3"
                                    action="{{ route('dashboard.admins.quizzes-update') }}">
                                    @csrf
                                    @method('patch')

                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="title">@lang('l.Title')</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                            value="{{ $quiz->title }}" required />
                                    </div>

                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="description">@lang('l.Description')</label>
                                        <textarea id="description" name="description" class="form-control" placeholder="@lang('l.Enter quiz description')">{{ $quiz->description }}</textarea>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" for="duration">@lang('l.Duration') (@lang('l.minutes'))</label>
                                        <input type="number" id="duration" name="duration" class="form-control"
                                            value="{{ $quiz->duration }}" min="1" required onchange="updateEndTime()" />
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" for="passing_score">@lang('l.Passing Score')
                                            (@lang('l.points'))</label>
                                        <input type="number" id="passing_score" name="passing_score" class="form-control"
                                            value="{{ $quiz->passing_score }}" min="0" required />
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" for="start_time">@lang('l.Start Time')</label>
                                        <input type="datetime-local" id="start_time" name="start_time" class="form-control"
                                            value="{{ $quiz->start_time_for_input }}" required onchange="updateEndTime()" />
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" for="end_time">@lang('l.End Time')</label>
                                        <input type="datetime-local" id="end_time" name="end_time" class="form-control"
                                            value="{{ $quiz->end_time_for_input }}" readonly />
                                    </div>

                                    <div class="col-12 mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" id="is_random_questions" name="is_random_questions"
                                                class="form-check-input" {{ $quiz->is_random_questions ? 'checked' : '' }} />
                                            <label class="form-check-label" for="is_random_questions">
                                                @lang('l.Randomize Questions Order')
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" id="is_random_answers" name="is_random_answers"
                                                class="form-check-input" {{ $quiz->is_random_answers ? 'checked' : '' }} />
                                            <label class="form-check-label" for="is_random_answers">
                                                @lang('l.Randomize Answers Order')
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="show_result">@lang('l.Show Result')</label>
                                        <select id="show_result" name="show_result" class="form-control" required>
                                            <option value="after_submission"
                                                {{ $quiz->show_result == 'after_submission' ? 'selected' : '' }}>
                                                @lang('l.After Submission')
                                            </option>
                                            <option value="after_exam_end"
                                                {{ $quiz->show_result == 'after_exam_end' ? 'selected' : '' }}>
                                                @lang('l.After Exam End')
                                            </option>
                                            <option value="manual" {{ $quiz->show_result == 'manual' ? 'selected' : '' }}>
                                                @lang('l.Manual by Admin')
                                            </option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="id" value="{{ encrypt($quiz->id) }}" />
                                    <input type="hidden" name="course_id" value="{{ $quiz->course_id }}" />

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit"
                                            class="btn btn-secondary me-sm-3 me-1">@lang('l.Update')</button>
                                        <a href="{{ route('dashboard.admins.quizzes') }}?course={{ encrypt($quiz->course_id) }}"
                                            class="btn btn-label-secondary">@lang('l.Back')</a>
                                    </div>
                                </form>
                            </div>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('js')
    <script>
        function updateEndTime() {
            const startTime = document.getElementById('start_time').value;
            const duration = document.getElementById('duration').value;

            if (startTime && duration) {
                const startDate = new Date(startTime);
                const endDate = new Date(startDate.getTime() + duration * 60000);

                const endTimeString = endDate.getFullYear() + '-' +
                    String(endDate.getMonth() + 1).padStart(2, '0') + '-' +
                    String(endDate.getDate()).padStart(2, '0') + 'T' +
                    String(endDate.getHours()).padStart(2, '0') + ':' +
                    String(endDate.getMinutes()).padStart(2, '0');

                document.getElementById('end_time').value = endTimeString;
            }
        }

        // تحديث وقت الانتهاء عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateEndTime();
        });
    </script>
@endsection
