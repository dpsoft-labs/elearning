@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Course Staff') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('edit courses')
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">{{ __('l.Course Staff') }} - {{ $course->name }}</h5>
                        <a href="{{ route('dashboard.admins.courses') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i>{{ __('l.Back to Courses') }}
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('l.Add New Staff Member') }}</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="post" action="{{ route('dashboard.admins.courses-staff-add') }}">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <div class="row">
                                    <div class="col-md-8">
                                        <select name="user_id" class="form-select select2" required>
                                            <option value="">{{ __('l.Select Staff Member') }}</option>
                                            @foreach($availableStaff as $staff)
                                                <option value="{{ $staff->id }}">
                                                    {{ $staff->firstname }} {{ $staff->lastlname }}
                                                    ({{ $staff->roles->first()->name ?? 'No Role' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus me-1"></i>{{ __('l.Add Staff Member') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('l.Current Staff Members') }}</h5>
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
                                        @foreach($currentStaff as $index => $staff)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $staff->firstname }} {{ $staff->lastlname }}</td>
                                                <td>{{ $staff->email }}</td>
                                                <td>{{ $staff->roles->first()->name ?? 'No Role' }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.admins.courses-staff-remove', ['id' => encrypt($course->id), 'user_id' => $staff->id]) }}"
                                                       class="btn btn-sm btn-danger delete-staff"
                                                       data-id="{{ $staff->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
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
        @endcan
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            $('#staff-table').DataTable({
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

            // إضافة معالج حدث الحذف
            $(document).on('click', '.delete-staff', function(e) {
                e.preventDefault();
                let deleteUrl = $(this).attr('href');

                Swal.fire({
                    title: "{{ __('l.Are you sure?') }}",
                    text: "{{ __('l.You will remove this staff member from the course!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('l.Yes, remove it!') }}",
                    cancelButtonText: "{{ __('l.Cancel') }}",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    </script>
@endsection