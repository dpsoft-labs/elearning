@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Quizzes List')
@endsection

@section('css')
@endsection

@section('keywords')
@endsection
@section('description')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            @if (isset($courses))
                <div class="row">
                    @forelse ($courses as $course)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $course->name }}</h4>
                                    <div class="stats mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>@lang('l.Students')</span>
                                            <span class="badge bg-primary">{{ $course->students()->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>@lang('l.Quizzes')</span>
                                            <span class="badge bg-info">{{ $course->quizzes()->count() }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('dashboard.admins.quizzes') }}?course={{ encrypt($course->id) }}"
                                        class="btn btn-primary btn-block mt-3">
                                        @lang('l.View Quizzes')
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">@lang('l.No Courses Found')</h4>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            @else
                @can('show quizzes')
                    <!-- Add Quiz Button -->
                    @can('add quizzes')
                        <div class="col-12 mb-4">
                            <div class="text-end">
                                <a href="#" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn btn-primary">
                                    <i class="fa fa-plus me-1"></i>@lang('l.Add new Quiz')
                                </a>
                            </div>
                        </div>
                    @endcan

                    @if ($errors->any())
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Quiz List Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('l.Title')</th>
                                                <th>@lang('l.Duration')</th>
                                                <th>@lang('l.Start Time')</th>
                                                <th>@lang('l.End Time')</th>
                                                <th>@lang('l.Passing Score')</th>
                                                <th>@lang('l.Created At')</th>
                                                <th>@lang('l.Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quizzes as $quiz)
                                                <tr>
                                                    <td class="capital">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="capital">{{ $quiz->title }}</td>
                                                    <td class="capital">{{ $quiz->duration }} @lang('l.minutes')</td>
                                                    <td class="capital">{{ $quiz->start_time->format('d/m/Y H:i') }}</td>
                                                    <td class="capital">{{ $quiz->end_time->format('d/m/Y H:i') }}</td>
                                                    <td class="capital">{{ $quiz->passing_score }} @lang('l.points')</td>
                                                    <td class="capital">{{ $quiz->created_at->format('d/m/Y H:i') }}</td>
                                                    <td class="capital">
                                                        @can('show quizzes')
                                                            <a href="{{ route('dashboard.admins.quizzes-questions', encrypt($quiz->id)) }}"
                                                                data-bs-toggle="tooltip" title="@lang('l.Questions and Answers')"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fa fa-question"></i>
                                                            </a>
                                                        @endcan
                                                        @can('edit quizzes')
                                                            <a href="{{ route('dashboard.admins.quizzes-grade', encrypt($quiz->id)) }}"
                                                                data-bs-toggle="tooltip" title="grade" class="btn btn-success btn-sm">
                                                                <i class="fa fa-pen"></i>
                                                            </a>
                                                        @endcan
                                                        @can('show quizzes')
                                                            <a href="{{ route('dashboard.admins.quizzes-statistics', encrypt($quiz->id)) }}"
                                                                data-bs-toggle="tooltip" title="statistics" class="btn btn-dark btn-sm">
                                                                <i class="fa fa-chart-bar"></i>
                                                            </a>
                                                        @endcan
                                                        @can('edit quizzes')
                                                            <a href="{{ route('dashboard.admins.quizzes-edit') }}?id={{ encrypt($quiz->id) }}"
                                                                data-bs-toggle="tooltip" title="edit" class="btn btn-warning btn-sm">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('delete quizzes')
                                                            <a class="delete-quiz btn btn-danger btn-sm" href="javascript:void(0);"
                                                                data-bs-toggle="tooltip" title="delete quiz"
                                                                data-quiz-id="{{ encrypt($quiz->id) }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Quiz Modal -->
                    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        <h3 class="role-title mb-2">@lang('l.Add new Quiz')</h3>
                                    </div>
                                    <form id="addLectureForm" class="row g-3" method="post" enctype="multipart/form-data"
                                        action="{{ route('dashboard.admins.quizzes-store') }}">
                                        @csrf
                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="title">@lang('l.Title')</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                placeholder="@lang('l.Enter a quiz title')" required />
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="description">@lang('l.Description')</label>
                                            <textarea id="description" name="description" class="form-control" placeholder="@lang('l.Enter quiz description')"></textarea>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="duration">@lang('l.Duration')
                                                (@lang('l.minutes'))</label>
                                            <input type="number" id="duration" name="duration" class="form-control"
                                                min="1" required onchange="updateEndTime()" />
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="passing_score">@lang('l.Passing Score')
                                                (@lang('l.points'))</label>
                                            <input type="number" id="passing_score" name="passing_score"
                                                class="form-control" min="0" required />
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="start_time">@lang('l.Start Time')</label>
                                            <input type="datetime-local" id="start_time" name="start_time"
                                                class="form-control" required onchange="updateEndTime()" />
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="end_time">@lang('l.End Time')</label>
                                            <input type="datetime-local" id="end_time" name="end_time" class="form-control"
                                                readonly />
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="form-check">
                                                <input type="checkbox" id="is_random_questions" name="is_random_questions"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="is_random_questions">
                                                    @lang('l.Randomize Questions Order')
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="form-check">
                                                <input type="checkbox" id="is_random_answers" name="is_random_answers"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="is_random_answers">
                                                    @lang('l.Randomize Answers Order')
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="show_result">@lang('l.Show Result')</label>
                                            <select id="show_result" name="show_result" class="form-select" required>
                                                <option value="after_submission">@lang('l.After Submission')</option>
                                                <option value="after_exam_end">@lang('l.After Exam End')</option>
                                                <option value="manual">@lang('l.Manual by Admin')</option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                                        <div class="col-12 text-center mt-4">
                                            <button type="submit"
                                                class="btn btn-primary me-sm-3 me-1">@lang('l.Submit')</button>
                                            <button type="button" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal">@lang('l.Cancel')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script>
        var table = $('#data-table').DataTable({
            ordering: true,
            order: [],
        });

        $('#search-input').keyup(function() {
            table.search($(this).val()).draw();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRoleButton = document.querySelector('.add-new-quiz');
            const addRoleModal = document.querySelector('#addRoleModal');

            addRoleButton.addEventListener('click', function() {
                var modal = new bootstrap.Modal(addRoleModal);
                modal.show();
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-quiz', function(e) {
            e.preventDefault();
            const quizId = $(this).data('quiz-id');

            Swal.fire({
                title: "@lang('l.Are you sure?')",
                text: "@lang('l.You will be delete this forever!')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#343a40',
                confirmButtonText: "@lang('l.Yes, delete it!')",
                cancelButtonText: "@lang('l.Cancel')"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('dashboard.admins.quizzes-delete') }}?id=' + quizId;
                }
            });
        });
    </script>
    <script>
        function updateEndTime() {
            const startTime = document.getElementById('start_time').value;
            const duration = document.getElementById('duration').value;

            if (startTime && duration) {
                // تحويل وقت البداية إلى كائن Date
                const startDate = new Date(startTime);

                // إضافة المدة بالدقائق
                const endDate = new Date(startDate.getTime() + duration * 60000);

                // تنسيق التاريخ والوقت مع مراعاة المنطقة الزمنية
                const endTimeString = endDate.getFullYear() + '-' +
                    String(endDate.getMonth() + 1).padStart(2, '0') + '-' +
                    String(endDate.getDate()).padStart(2, '0') + 'T' +
                    String(endDate.getHours()).padStart(2, '0') + ':' +
                    String(endDate.getMinutes()).padStart(2, '0');

                document.getElementById('end_time').value = endTimeString;
            }
        }
    </script>
@endsection
