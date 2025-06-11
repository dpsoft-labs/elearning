@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Available Courses') }} - {{ $student->firstname }} {{ $student->lastlname }}
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

        .requirements-list {
            padding-left: 20px;
            margin-top: 5px;
            font-size: 0.85rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">{{ __('l.Available Courses') }}</h5>
                        <h6 class="text-muted">{{ $student->firstname }} {{ $student->lastlname }} ({{ $student->sid }})</h6>
                    </div>
                    <a href="{{ route('dashboard.users.registrations', ['student_id' => encrypt($student->id)]) }}"
                        class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>{{ __('l.Back to Registration') }}
                    </a>
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
                                <img src="{{ asset($student->photo) }}" alt="{{ $student->firstname }}"
                                    class="rounded-circle" width="60" height="60">
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
                            <h6>{{ __('l.Total Success Hours') }}</h6>
                            <p>{{ $student->totalSuccessHours() }} {{ __('l.hours') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('l.Available Courses') }}</h5>
                        <button id="registerSelected" class="btn btn-primary d-none">
                            <i class="fa fa-plus me-1"></i>{{ __('l.Register Selected') }}
                        </button>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        @if (count($availableCourses) > 0)
                            <form id="register-form" action="{{ route('dashboard.users.registrations-store') }}"
                                method="post">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">

                                <div class="row">
                                    @foreach ($availableCourses as $course)
                                        <div class="col-md-6 mb-3">
                                            <div class="card course-card h-100">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center bg-light">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="course_ids[]"
                                                            class="form-check-input course-checkbox"
                                                            value="{{ $course->id }}">
                                                        <label class="form-check-label">{{ $course->code }}</label>
                                                    </div>
                                                    <span class="badge bg-primary">{{ $course->hours }}
                                                        {{ __('l.hours') }}</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex mb-3">
                                                        <div class="flex-shrink-0 me-3">
                                                            <img src="{{ asset($course->image) }}"
                                                                alt="{{ $course->name }}" class="rounded" width="60"
                                                                height="60">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="card-title mb-1">{{ $course->name }}</h5>
                                                            <p class="card-text text-muted small">
                                                                {{ $course->college->name ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6 class="mb-1">{{ __('l.Required Hours') }}:
                                                            {{ $course->required_hours }}</h6>
                                                        @if ($course->required1 || $course->required2 || $course->required3)
                                                            <h6 class="mb-0">{{ __('l.Prerequisites') }}:</h6>
                                                            <ul class="requirements-list">
                                                                @if ($course->required1)
                                                                    <li>{{ $course->required1 }}</li>
                                                                @endif
                                                                @if ($course->required2)
                                                                    <li>{{ $course->required2 }}</li>
                                                                @endif
                                                                @if ($course->required3)
                                                                    <li>{{ $course->required3 }}</li>
                                                                @endif
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-book fa-3x text-muted mb-3"></i>
                                <h5>{{ __('l.No available courses for registration') }}</h5>
                                <p class="text-muted">{{ __('l.There are no courses matching the requirements') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            // حدث تغيير الاختيار
            $('.course-checkbox').on('change', function() {
                updateRegisterButton();
            });

            function updateRegisterButton() {
                let checkedCount = $('.course-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#registerSelected').removeClass('d-none');
                } else {
                    $('#registerSelected').addClass('d-none');
                }
            }

            // تسجيل المحدد
            $('#registerSelected').on('click', function() {
                if ($('.course-checkbox:checked').length > 0) {
                    Swal.fire({
                        title: "{{ __('l.Register Courses') }}",
                        text: "{{ __('l.Are you sure you want to register the selected courses?') }}",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: "{{ __('l.Yes, register them!') }}",
                        cancelButtonText: "{{ __('l.Cancel') }}",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#register-form').submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection
