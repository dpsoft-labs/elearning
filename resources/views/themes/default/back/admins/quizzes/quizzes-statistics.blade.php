@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Quiz Statistics') - {{ $quiz->title }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title">@lang('l.Quiz Statistics') - {{ $quiz->title }}</h5>
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

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('l.General Statistics')</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">@lang('l.Total Students'): <span class="fw-semibold">{{ $statistics['total_students'] }}</span></li>
                            <li class="mb-2">@lang('l.Total Attempts'): <span class="fw-semibold">{{ $statistics['total_attempts'] }}</span></li>
                            <li class="mb-2">@lang('l.Completed Attempts'): <span class="fw-semibold">{{ $statistics['completed_attempts'] }}</span></li>
                            <li class="mb-2">@lang('l.Passed Students'): <span class="fw-semibold">{{ $statistics['passed_students'] }}</span></li>
                            <li class="mb-2">@lang('l.Average Score'): <span class="fw-semibold">{{ number_format($statistics['average_score'], 2) }}</span></li>
                            <li class="mb-2">@lang('l.Highest Score'): <span class="fw-semibold">{{ $statistics['highest_score'] }}</span></li>
                            <li class="mb-2">@lang('l.Lowest Score'): <span class="fw-semibold">{{ $statistics['lowest_score'] }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('l.Score Distribution')</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="scoreDistributionChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $no == 0 ? 'active' : '' }}"
                                   href="{{ route('dashboard.admins.quizzes-statistics', ['id' => encrypt($quiz->id)]) }}">
                                    @lang('l.Students who attended the quiz')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $no == 1 ? 'active' : '' }}"
                                   href="{{ route('dashboard.admins.quizzes-statistics', ['id' => encrypt($quiz->id), 'no' => 1]) }}">
                                    @lang('l.Students who did not attend the quiz')
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade {{ $no == 0 ? 'show active' : '' }}" id="attended" role="tabpanel">
                                @if ($no == 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('l.Student Name')</th>
                                                    <th>@lang('l.Phone')</th>
                                                    <th>@lang('l.Parent Number')</th>
                                                    <th>@lang('l.Start Time')</th>
                                                    <th>@lang('l.End Time')</th>
                                                    <th>@lang('l.Score')</th>
                                                    <th>@lang('l.Result')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Attempts as $attempt)
                                                    <tr>
                                                        <td>{{ $attempt->user->firstname }} {{ $attempt->user->lastname }}</td>
                                                        <td>{{ $attempt->user->phone }}</td>
                                                        <td>{{ $attempt->user->parent }}</td>
                                                        <td>{{ $attempt->started_at->format('Y-m-d H:i:s') }}</td>
                                                        <td>{{ $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i:s') : 'لم يكتمل' }}</td>
                                                        <td>{{ $attempt->score }}</td>
                                                        <td>
                                                            @if ($attempt->is_passed)
                                                                <span class="badge bg-label-success">@lang('l.Passed')</span>
                                                            @else
                                                                <span class="badge bg-label-danger">@lang('l.Failed')</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-center mt-4">
                                            @php
                                                $attempts = $Attempts;
                                            @endphp
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li class="page-item {{ $attempts->onFirstPage() ? 'disabled' : '' }}">
                                                        <a class="page-link" href="{{ $attempts->previousPageUrl() }}" aria-label="Previous">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                    @for ($i = 1; $i <= $attempts->lastPage(); $i++)
                                                        <li class="page-item {{ $attempts->currentPage() == $i ? 'active' : '' }}">
                                                            <a class="page-link" href="{{ $attempts->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    <li class="page-item {{ !$attempts->hasMorePages() ? 'disabled' : '' }}">
                                                        <a class="page-link" href="{{ $attempts->nextPageUrl() }}" aria-label="Next">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane fade {{ $no == 1 ? 'show active' : '' }}" id="not-attended" role="tabpanel">
                                @if ($no == 1)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('l.Student Name')</th>
                                                    <th>@lang('l.Phone')</th>
                                                    <th>@lang('l.Email')</th>
                                                    <th>@lang('l.Parent Number')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Attempts as $student)
                                                    <tr>
                                                        <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                                        <td>{{ $student->phone }}</td>
                                                        <td>{{ $student->email }}</td>
                                                        <td>{{ $student->parent }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-center mt-4">
                                            @php
                                                $attempts = $Attempts;
                                            @endphp
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li class="page-item {{ $attempts->onFirstPage() ? 'disabled' : '' }}">
                                                        <a class="page-link" href="{{ $attempts->previousPageUrl() }}" aria-label="Previous">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                    @for ($i = 1; $i <= $attempts->lastPage(); $i++)
                                                        <li class="page-item {{ $attempts->currentPage() == $i ? 'active' : '' }}">
                                                            <a class="page-link" href="{{ $attempts->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor
                                                    <li class="page-item {{ !$attempts->hasMorePages() ? 'disabled' : '' }}">
                                                        <a class="page-link" href="{{ $attempts->nextPageUrl() }}" aria-label="Next">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('scoreDistributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys({!! json_encode($scoreDistribution) !!}),
                datasets: [{
                    label: '@lang('l.Number of students')',
                    data: Object.values({!! json_encode($scoreDistribution) !!}),
                    backgroundColor: 'rgba(105, 108, 255, 0.5)',
                    borderColor: 'rgba(105, 108, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection
