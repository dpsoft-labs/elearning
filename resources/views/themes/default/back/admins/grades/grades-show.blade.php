@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Course Grades') }}: {{ $course->name }}
@endsection

@section('css')
<style>
    .course-header {
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .course-image {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        object-fit: cover;
    }
    .stat-box {
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        height: 100%;
    }
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .stat-label {
        font-size: 0.9rem;
        color: #666;
    }
    .grade-cell {
        min-width: 70px;
        text-align: center;
    }
    .success-row {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }
    .fail-row {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
</style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- معلومات الكورس -->
            <div class="col-12">
                <div class="card course-header bg-light shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if($course->image)
                                    <img src="{{ asset($course->image) }}" class="course-image" alt="{{ $course->name }}">
                                @else
                                    <div class="course-image bg-primary d-flex justify-content-center align-items-center">
                                        <i class="fas fa-book fa-2x text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <h3 class="mb-1">{{ $course->name }}</h3>
                                <div class="d-flex mb-2">
                                    <span class="badge bg-primary me-2">{{ $course->code }}</span>
                                    <span class="badge bg-info me-2">{{ $course->hours }} {{ __('l.hours') }}</span>
                                    <span class="badge bg-secondary">{{ $course->college->name ?? '' }}</span>
                                </div>
                                <p class="mb-0">
                                    <a href="{{ route('dashboard.admins.grades') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-arrow-left"></i> {{ __('l.Back to Courses') }}
                                    </a>
                                    <a href="{{ route('dashboard.admins.grades-download-template', ['course_id' => encrypt($course->id)]) }}"
                                       class="btn btn-sm btn-outline-success ms-2">
                                        <i class="fas fa-download"></i> {{ __('l.Download Template') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إحصائيات الكورس -->
            <div class="col-12">
                <div class="row">
                    @php
                        $totalStudents = count($students);
                        $passedStudents = $students->where('pivot.status', 'success')->count();
                        $failedStudents = $students->where('pivot.status', 'fail')->count();
                        $passRate = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100) : 0;

                        $avgQuizzes = $students->avg('pivot.quizzes') ?: 0;
                        $avgMidterm = $students->avg('pivot.midterm') ?: 0;
                        $avgAttendance = $students->avg('pivot.attendance') ?: 0;
                        $avgFinal = $students->avg('pivot.final') ?: 0;
                        $avgTotal = $students->avg('pivot.total') ?: 0;
                    @endphp

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-primary bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-value">{{ $totalStudents }}</div>
                                <div class="stat-label">{{ __('l.Total Students') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-success bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-value">{{ $passedStudents }}</div>
                                <div class="stat-label">{{ __('l.Passed Students') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-danger bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stat-value">{{ $failedStudents }}</div>
                                <div class="stat-label">{{ __('l.Failed Students') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-info bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-info">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="stat-value">{{ $enrolledStudents }}</div>
                                <div class="stat-label">{{ __('l.Enrolled Students') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- متوسطات الدرجات -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light mb-5">
                        <h5 class="mb-0">{{ __('l.Average Grades') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $avgQuizzes }}%;"
                                         aria-valuenow="{{ $avgQuizzes }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($avgQuizzes, 1) }}
                                    </div>
                                </div>
                                <p class="text-center small mt-1">{{ __('l.Quizzes') }}</p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $avgMidterm }}%;"
                                         aria-valuenow="{{ $avgMidterm }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($avgMidterm, 1) }}
                                    </div>
                                </div>
                                <p class="text-center small mt-1">{{ __('l.Midterm') }}</p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $avgAttendance }}%;"
                                         aria-valuenow="{{ $avgAttendance }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($avgAttendance, 1) }}
                                    </div>
                                </div>
                                <p class="text-center small mt-1">{{ __('l.Attendance') }}</p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $avgFinal }}%;"
                                         aria-valuenow="{{ $avgFinal }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($avgFinal, 1) }}
                                    </div>
                                </div>
                                <p class="text-center small mt-1">{{ __('l.Final') }}</p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $avgTotal }}%;"
                                         aria-valuenow="{{ $avgTotal }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($avgTotal, 1) }}
                                    </div>
                                </div>
                                <p class="text-center small mt-1">{{ __('l.Total') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- نسبة النجاح -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header bg-light mb-5">
                        <h5 class="mb-0">{{ __('l.Success Rate') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="progress" style="height: 30px;">
                            @php
                                $passRateStyle = "width: {$passRate}%";
                                $failRateStyle = "width: " . (100 - $passRate) . "%";
                            @endphp
                            <div class="progress-bar bg-success" style="{{ $passRateStyle }}" role="progressbar" aria-valuenow="{{ $passRate }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $passRate }}% {{ __('l.Passed') }}
                            </div>
                            <div class="progress-bar bg-danger" style="{{ $failRateStyle }}" role="progressbar" aria-valuenow="{{ 100 - $passRate }}" aria-valuemin="0" aria-valuemax="100">
                                {{ 100 - $passRate }}% {{ __('l.Failed') }}
                            </div>
                        </div>
                        <div class="text-muted small mt-2 text-center">
                            {{ __('l.Note: Success rate is calculated only for examined students (excluding enrolled students without final scores).') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- جدول الطلاب ودرجاتهم -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('l.Students Grades') }}</h5>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table table-striped" id="students-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('l.SID') }}</th>
                                    <th>{{ __('l.Name') }}</th>
                                    <th class="grade-cell">{{ __('l.Quizzes') }}</th>
                                    <th class="grade-cell">{{ __('l.Midterm') }}</th>
                                    <th class="grade-cell">{{ __('l.Attendance') }}</th>
                                    <th class="grade-cell">{{ __('l.Final') }}</th>
                                    <th class="grade-cell">{{ __('l.Total') }}</th>
                                    <th class="grade-cell">{{ __('l.Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                <?php
                                    // تحديد لون وفئة الصف بناءً على الحالة
                                    $status = $student->pivot->status;
                                    if ($status == 'success') {
                                        $rowClass = 'success-row';
                                        $badgeClass = 'bg-success';
                                        $statusText = __('l.Passed');
                                    } elseif ($status == 'fail') {
                                        $rowClass = 'fail-row';
                                        $badgeClass = 'bg-danger';
                                        $statusText = __('l.Failed');
                                    } else { // الحالة هي 'enrolled' أو غيرها
                                        $rowClass = '';
                                        $badgeClass = 'bg-info';
                                        $statusText = __('l.Enrolled');
                                    }

                                    // التأكد من الحصول على القيم الصحيحة للدرجات
                                    $quizzes = $student->pivot->quizzes;
                                    $midterm = $student->pivot->midterm;
                                    $attendance = $student->pivot->attendance;
                                    $final = $student->pivot->final;
                                    $total = $student->pivot->total;
                                ?>
                                <tr class="{{ $rowClass }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->getSidAttribute() }}</td>
                                    <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                    <td class="grade-cell">{{ $quizzes }}</td>
                                    <td class="grade-cell">{{ $midterm }}</td>
                                    <td class="grade-cell">{{ $attendance }}</td>
                                    <td class="grade-cell">{{ $final }}</td>
                                    <td class="grade-cell fw-bold">{{ $total }}</td>
                                    <td class="grade-cell">
                                        <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // إعداد الجدول مع البحث والترتيب والصفحات
    let table = $('#students-table').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "{{ __('l.All') }}"]
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex align-items-center"f>>rtip',
        language: {
            search: "{{ __('l.Search') }}:",
            lengthMenu: "{{ __('l.Show') }} _MENU_ {{ __('l.entries') }}",
            paginate: {
                next: "{{ __('l.Next') }}",
                previous: "{{ __('l.Previous') }}"
            },
            info: "{{ __('l.Showing') }} _START_ {{ __('l.to') }} _END_ {{ __('l.of') }} _TOTAL_ {{ __('l.entries') }}",
            infoEmpty: "{{ __('l.Showing') }} 0 {{ __('l.To') }} 0 {{ __('l.Of') }} 0 {{ __('l.entries') }}",
            infoFiltered: "{{ __('l.Showing') }} 1 {{ __('l.Of') }} 1 {{ __('l.entries') }}",
            zeroRecords: "{{ __('l.No matching records found') }}",
            loadingRecords: "{{ __('l.Loading...') }}",
            processing: "{{ __('l.Processing...') }}",
            emptyTable: "{{ __('l.No data available in table') }}",
        },
        // إضافة ميزة الترتيب الافتراضي
        order: [[7, 'desc']], // ترتيب حسب العمود الثامن (إجمالي الدرجات) تنازليًا
        // تمكين التصدير
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });

    // إضافة لون خلفية مختلف للصفوف اعتمادًا على حالة النجاح/الرسوب
    $('#students-table tbody tr').each(function() {
        if ($(this).hasClass('success-row')) {
            $(this).find('td').css('background-color', 'rgba(40, 167, 69, 0.05)');
        } else if ($(this).hasClass('fail-row')) {
            $(this).find('td').css('background-color', 'rgba(220, 53, 69, 0.05)');
        }
    });
});
</script>
@endsection
