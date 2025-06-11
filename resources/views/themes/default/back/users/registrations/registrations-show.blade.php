@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Student Registrations') }}
@endsection

@section('css')
    <style>
        .course-card {
            transition: all 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">{{ __('l.Student Registrations') }}</h5>
                        <h6 class="text-muted">{{ $student->firstname }} {{ $student->lastlname }} ({{ $student->sid }})</h6>
                    </div>
                    <div class="d-flex">
                        @if (
                            $settings['registration_status'] == '1' &&
                                $settings['registration_start_date'] <= now() &&
                                $settings['registration_end_date'] >= now())
                            <a href="{{ route('dashboard.users.registrations-available', ['student_id' => $student->id]) }}"
                                class="btn btn-primary">
                                <i class="fa fa-plus me-1"></i>{{ __('l.Add Courses') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('l.Student Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ asset($student->photo) }}" alt="{{ $student->firstname }}" class="rounded-circle"
                                    width="60" height="60">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $student->firstname }} {{ $student->lastlname }}</h5>
                                <p class="mb-0">{{ $student->email }}</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6>{{ __('l.College') }}</h6>
                            <p>{{ $student->college->name ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <h6>{{ __('l.Branch') }}</h6>
                            <p>{{ $student->branch->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h6>{{ __('l.Total Success Hours') }}</h6>
                            <p>{{ $totalSuccessHours }} {{ __('l.hours') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('l.Enrolled Courses') }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (count($enrolledCourses) > 0)
                            <div class="row">
                                @foreach ($enrolledCourses as $course)
                                    <div class="col-md-6 mb-3">
                                        <div class="card course-card h-100">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <span>{{ $course->code }}</span>
                                                <span class="badge bg-primary">{{ $course->hours }}
                                                    {{ __('l.hours') }}</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <img src="{{ asset($course->image) }}" alt="{{ $course->name }}"
                                                            class="rounded" width="60" height="60">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title mb-1">{{ $course->name }}</h5>
                                                        <p class="card-text text-muted small">
                                                            {{ $course->college->name ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>{{ __('l.Grades') }}</h6>
                                                    <div class="d-flex justify-content-between small text-muted">
                                                        <span>{{ __('l.Quizzes') }}: {{ $course->pivot->quizzes }}</span>
                                                        <span>{{ __('l.Midterm') }}: {{ $course->pivot->midterm }}</span>
                                                        <span>{{ __('l.Final') }}: {{ $course->pivot->final }}</span>
                                                    </div>
                                                    <div class="progress mt-2" style="height: 10px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $course->pivot->total }}%;"
                                                            aria-valuenow="{{ $course->pivot->total }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ $course->pivot->total }}%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-book fa-3x text-muted mb-3"></i>
                                <h5>{{ __('l.No courses enrolled') }}</h5>
                                @if ($settings['registration_status'] == '1' &&
                                    $settings['registration_start_date'] <= now() &&
                                    $settings['registration_end_date'] >= now())
                                    <a href="{{ route('dashboard.users.registrations-available', ['student_id' => $student->id]) }}"
                                        class="btn btn-primary mt-3">
                                        <i class="fa fa-plus me-1"></i>{{ __('l.Add Courses') }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (count($successCourses) > 0)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('l.Successfully Completed Courses') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($successCourses as $course)
                                    <div class="col-md-4 mb-3">
                                        <div class="card course-card h-100 border-success">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <span>{{ $course->code }}</span>
                                                <span class="badge bg-success">{{ $course->hours }}
                                                    {{ __('l.hours') }}</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <img src="{{ asset($course->image) }}" alt="{{ $course->name }}"
                                                            class="rounded" width="60" height="60">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title mb-1">{{ $course->name }}</h5>
                                                        <p class="card-text text-muted small">
                                                            {{ $course->college->name ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <h6>{{ __('l.Final Grade') }}</h6>
                                                    <div class="progress mt-2" style="height: 10px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $course->pivot->total }}%;"
                                                            aria-valuenow="{{ $course->pivot->total }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ $course->pivot->total }}%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
