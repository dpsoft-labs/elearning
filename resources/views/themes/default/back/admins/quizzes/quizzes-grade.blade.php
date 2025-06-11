@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Quiz Grade') - {{ $quiz->title }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title">@lang('l.Quiz Grade') - {{ $quiz->title }}</h5>
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>@lang('l.Student Name')</th>
                                        <th>@lang('l.Phone')</th>
                                        <th>@lang('l.Start Time')</th>
                                        <th>@lang('l.End Time')</th>
                                        <th>@lang('l.Score')</th>
                                        <th>@lang('l.Status')</th>
                                        <th>@lang('l.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quiz->attempts()->paginate(100) as $attempt)
                                        <tr>
                                            <td>{{ $attempt->user->firstname }} {{ $attempt->user->lastname }}</td>
                                            <td>{{ $attempt->user->phone }}</td>
                                            <td>{{ $attempt->started_at ? $attempt->started_at->format('Y-m-d H:i') : '-' }}</td>
                                            <td>{{ $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i') : '-' }}</td>
                                            <td>
                                                <span class="badge bg-label-{{ $attempt->is_passed ? 'success' : 'danger' }}">
                                                    {{ $attempt->score }}/{{ $quiz->totalGrade() }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($attempt->completed_at)
                                                    <span class="badge bg-label-success">@lang('l.Completed')</span>
                                                @else
                                                    <span class="badge bg-label-warning">@lang('l.In Progress')</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="showGradeModal({{ $attempt->id }})">
                                                    <i class="fa fa-check me-1"></i> @lang('l.Grade')
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center mt-4">
                                @php
                                    $attempts = $quiz->attempts()->paginate(100);
                                @endphp
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item {{ $attempts->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $attempts->previousPageUrl() }}" aria-label="Previous">
                                                <span aria-hidden="true"><i class="ti ti-chevron-{{app()->getLocale() == 'ar' ? 'right' : 'left'}} ti-xs"></i></span>
                                            </a>
                                        </li>
                                        @for ($i = 1; $i <= $attempts->lastPage(); $i++)
                                            <li class="page-item {{ $attempts->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $attempts->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ !$attempts->hasMorePages() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $attempts->nextPageUrl() }}" aria-label="Next">
                                                <span aria-hidden="true"><i class="ti ti-chevron-{{app()->getLocale() == 'ar' ? 'left' : 'right'}} ti-xs"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Modal -->
    <div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('l.Grade Quiz')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="gradeModalBody">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showGradeModal(attemptId) {
            const modal = new bootstrap.Modal(document.getElementById('gradeModal'));
            const modalBody = document.getElementById('gradeModalBody');

            // Show loading
            modalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>';
            modal.show();

            // Fetch attempt details
            fetch(`{{ url('admins/quizzes/get-attempt') }}/${attemptId}`)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                });
        }

        function updateGrade(answerId, points, attemptId, element) {
            if (element) {
                element.disabled = true;
            }

            fetch('{{ route('dashboard.admins.quizzes-update-grade') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        answer_id: answerId,
                        points: points
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (attemptId) {
                            document.getElementById(`total-score-${attemptId}`).textContent = data.new_total;
                        }
                        showToast('success', data.message);
                    } else {
                        showToast('error', data.message || '@lang('l.Error')');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', '@lang('l.Error')');
                })
                .finally(() => {
                    if (element) {
                        element.disabled = false;
                    }
                });
        }

        function updateAnswerStatus(answerId, isCorrect, attemptId, element) {
            if (element) {
                element.disabled = true;
            }

            fetch('{{ route('dashboard.admins.quizzes-update-grade') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        answer_id: answerId,
                        is_correct: isCorrect
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (attemptId) {
                            document.getElementById(`total-score-${attemptId}`).textContent = data.new_total;
                        }
                        showToast('success', data.message);
                    } else {
                        showToast('error', data.message || '@lang('l.Error')');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', '@lang('l.Error')');
                })
                .finally(() => {
                    if (element) {
                        element.disabled = false;
                    }
                });
        }

        function showToast(type, message) {
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                };
                toastr[type](message);
            } else {
                alert(message);
            }
        }
    </script>
@endsection
