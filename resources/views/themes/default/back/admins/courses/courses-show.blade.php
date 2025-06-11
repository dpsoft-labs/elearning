@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Course Details') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('show courses')
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">{{ __('l.Course Details') }}</h5>
                        <a href="{{ route('dashboard.admins.courses') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i>{{ __('l.Back to Courses') }}
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $course->name }}</h5>
                            <div>
                                @can('edit courses')
                                    <a href="{{ route('dashboard.admins.courses-staff', ['id' => encrypt($course->id)]) }}"
                                       class="btn btn-info me-2">
                                        <i class="fa fa-users me-1"></i>{{ __('l.Manage Staff') }}
                                    </a>
                                    <a href="{{ route('dashboard.admins.courses-edit', ['id' => encrypt($course->id)]) }}"
                                       class="btn btn-primary">
                                        <i class="fa fa-edit me-1"></i>{{ __('l.Edit') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center mb-4">
                                    <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" class="img-fluid" style="max-height: 200px;">
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6>{{ __('l.Name') }}</h6>
                                            <p>{{ $course->name }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>{{ __('l.Code') }}</h6>
                                            <p>{{ $course->code }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>{{ __('l.Hours') }}</h6>
                                            <p>{{ $course->hours }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>{{ __('l.College') }}</h6>
                                            <p>{{ $course->college->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>{{ __('l.Required Hours') }}</h6>
                                            <p>{{ $course->required_hours }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>{{ __('l.Status') }}</h6>
                                            <p>
                                                @if($course->is_active)
                                                    <span class="badge bg-success">{{ __('l.Active') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __('l.Inactive') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6>{{ __('l.Required Courses') }}</h6>
                                    <ul class="list-group">
                                        @if($course->required1)
                                            <li class="list-group-item">{{ $course->required1 }}</li>
                                        @endif
                                        @if($course->required2)
                                            <li class="list-group-item">{{ $course->required2 }}</li>
                                        @endif
                                        @if($course->required3)
                                            <li class="list-group-item">{{ $course->required3 }}</li>
                                        @endif
                                        @if(!$course->required1 && !$course->required2 && !$course->required3)
                                            <li class="list-group-item">{{ __('l.No required courses') }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('l.Course Staff') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="staff-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('l.Name') }}</th>
                                            <th>{{ __('l.Email') }}</th>
                                            <th>{{ __('l.Role') }}</th>
                                            <th>{{ __('l.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $staff = $course->users()->wherePivot('status', 'staff')->get(); @endphp
                                        @if(count($staff) > 0)
                                            @foreach($staff as $index => $member)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $member->firstname }} {{ $member->lastlname }}</td>
                                                    <td>{{ $member->email }}</td>
                                                    <td>{{ $member->roles->first()->name ?? 'No Role' }}</td>
                                                    <td>
                                                        @can('show users')
                                                            <a href="{{ route('dashboard.admins.users-show', ['id' => encrypt($member->id)]) }}"
                                                               class="btn btn-sm btn-info" title="{{ __('l.View') }}">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">{{ __('l.No staff members found') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('l.Enrolled Students') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="students-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('l.Name') }}</th>
                                            <th>{{ __('l.Email') }}</th>
                                            <th>{{ __('l.Branch') }}</th>
                                            <th>{{ __('l.College') }}</th>
                                            <th>{{ __('l.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $students = $course->users()->wherePivot('status', 'enrolled')->get(); @endphp
                                        @if(count($students) > 0)
                                            @foreach($students as $index => $student)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $student->firstname }} {{ $student->lastlname }}</td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>{{ $student->branch->name ?? 'N/A' }}</td>
                                                    <td>{{ $student->college->name ?? 'N/A' }}</td>
                                                    <td>
                                                        @can('show students')
                                                            <a href="{{ route('dashboard.admins.students-show', ['id' => encrypt($student->id)]) }}"
                                                               class="btn btn-sm btn-info" title="{{ __('l.View') }}">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">{{ __('l.No students enrolled') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            $('#staff-table, #students-table').DataTable({
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
                }
            });
        });
    </script>
@endsection