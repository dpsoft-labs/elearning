@extends('themes.default.layouts.back.master')


@section('title')
    @lang('l.Quizzes')
@endsection

@section('css')
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .question-card {
            transition: all 0.3s ease;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .answer-section {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .pagination .page-link {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0 0.2rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .question-content h5 {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="content-wrapper">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-header bg-gradient-primary p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class=" mb-0">@lang('l.Quizzes')</h3>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-light btn-sm" id="grid-view">
                                            <i class="fas fa-th-large"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm" id="list-view">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-4" id="quizzes-container">
                                @foreach ($quizzes as $quiz)
                                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 quiz-card hover-shadow">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title mb-0">{{ $quiz->title }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="description mb-3 mt-3">
                                                    <p class="card-text text-muted">{{ $quiz->description }}</p>
                                                </div>

                                                <div class="quiz-info">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-clock text-primary me-2"></i>
                                                        <span>@lang('l.Duration'): {{ $quiz->duration }}
                                                            @lang('l.Minutes')</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-award text-success me-2"></i>
                                                        <span>@lang('l.Passing Score'): {{ $quiz->passing_score }}</span>
                                                    </div>
                                                    <div class="countdown-container mb-2">
                                                        <i class="fas fa-hourglass-start text-warning me-2"></i>
                                                        <span>@lang('l.Starts in'): </span>
                                                        <span class="countdown" data-start="{{ $quiz->start_time }}"></span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-alt text-danger me-2"></i>
                                                        <span data-end="{{ $quiz->end_time }}">@lang('l.End Time'):
                                                            {{ $quiz->end_time->format('Y-m-d H:i') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-light">
                                                <!-- Quiz not started -->
                                                @if ($quiz->start_time > now())
                                                    <button type="button" class="btn btn-secondary w-100 mt-3" disabled>
                                                        <i class="fas fa-clock me-2"></i>
                                                        @lang('l.Not Started Yet')
                                                    </button>
                                                @elseif ($quiz->end_time < now())
                                                    <!-- Quiz ended -->
                                                    @php
                                                        $attempt = $quiz
                                                            ->attempts()
                                                            ->where('user_id', auth()->id())
                                                            ->where('completed_at', '!=', null)
                                                            ->first();
                                                    @endphp
                                                    @if ($attempt)
                                                        <a href="{{ route('dashboard.users.quizzes-show', ['attempt_id' => encrypt($attempt->id)]) }}"
                                                            class="btn btn-info w-100 mt-3">
                                                            <i class="fas fa-eye me-2"></i>
                                                            @lang('l.Show Result')
                                                        </a>
                                                    @else
                                                        <button type="button" class="btn btn-danger w-100 mt-3" disabled>
                                                            <i class="fas fa-times-circle me-2"></i>
                                                            @lang('l.Quiz Ended')
                                                        </button>
                                                    @endif
                                                @else
                                                    <!-- Quiz in progress -->
                                                    @php
                                                        $attempt = $quiz
                                                            ->attempts()
                                                            ->where('user_id', auth()->id())
                                                            ->where('completed_at', '!=', null)
                                                            ->first();
                                                    @endphp
                                                    @if ($attempt)
                                                        <button type="button" class="btn btn-warning w-100" disabled>
                                                            <i class="fas fa-check-circle me-2"></i>
                                                            @lang('l.Already Taken')
                                                        </button>
                                                    @else
                                                        <a href="{{ route('dashboard.users.quizzes-open', ['quiz_id' => encrypt($quiz->id)]) }}"
                                                            class="btn btn-primary w-100 mt-3">
                                                            <i class="fas fa-play-circle me-2"></i>
                                                            @lang('l.Start Quiz')
                                                        </a>
                                                    @endif
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
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Countdown functionality
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(el => {
                const startTime = new Date(el.dataset.start);
                const endTime = new Date(el.closest('.card').querySelector('[data-end]')?.dataset.end);
                const now = new Date();
                const diff = startTime - now;

                if (diff > 0) {
                    // Quiz hasn't started yet - show countdown
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    el.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                } else if (endTime && now > endTime) {
                    // Quiz has ended
                    el.textContent = '@lang('l.Ended')';
                } else {
                    el.textContent = '@lang('l.Started')';
                }
            });
        }

        setInterval(updateCountdowns, 1000);
        updateCountdowns();

        // View toggle functionality
        document.getElementById('grid-view').addEventListener('click', function() {
            const container = document.getElementById('quizzes-container');
            container.querySelectorAll('.col-12').forEach(el => {
                el.className = 'col-12 col-md-6 col-lg-4 mb-4';
            });
        });

        document.getElementById('list-view').addEventListener('click', function() {
            const container = document.getElementById('quizzes-container');
            container.querySelectorAll('.col-12').forEach(el => {
                el.className = 'col-12 mb-4';
            });
        });
    </script>
@endsection
