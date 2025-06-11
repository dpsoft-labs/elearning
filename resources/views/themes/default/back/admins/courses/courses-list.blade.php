@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Courses') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('show courses')
            @can('add courses')
                <div class="card-action-element mb-2" style="text-align: end;">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#addCourseModal">
                        <i class="fa fa-plus fa-xs me-1"></i> {{ __('l.Add New Course') }}
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-header">
                                <h3 class="modal-title text-center">{{ __('l.Add New Course') }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addCourseForm" class="row g-3" method="post" enctype="multipart/form-data"
                                    action="{{ route('dashboard.admins.courses-store') }}">
                                    @csrf
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="name">{{ __('l.Name') }}</label>
                                        <input type="text" id="name" name="name" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="code">{{ __('l.Code') }}</label>
                                        <input type="text" id="code" name="code" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="hours">{{ __('l.Hours') }}</label>
                                        <input type="text" id="hours" name="hours" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="college_id">{{ __('l.College') }}</label>
                                        <select id="college_id" name="college_id" class="form-select" required>
                                            <option value="">{{ __('l.Select College') }}</option>
                                            @foreach(\App\Models\College::all() as $college)
                                                <option value="{{ $college->id }}">{{ $college->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="required_hours">{{ __('l.Required Hours') }}</label>
                                        <input type="number" id="required_hours" name="required_hours" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="is_active">{{ __('l.Status') }}</label>
                                        <select id="is_active" name="is_active" class="form-select" required>
                                            <option value="1">{{ __('l.Active') }}</option>
                                            <option value="0">{{ __('l.Inactive') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label" for="required1">{{ __('l.Required Course') }} 1</label>
                                        <select id="required1" name="required1" class="form-select">
                                            <option value="">{{ __('l.No Requirement') }}</option>
                                            @foreach(\App\Models\Course::where('is_active', 1)->get() as $req_course)
                                                <option value="{{ $req_course->code }}">
                                                    {{ $req_course->code }} - {{ $req_course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label" for="required2">{{ __('l.Required Course') }} 2</label>
                                        <select id="required2" name="required2" class="form-select">
                                            <option value="">{{ __('l.No Requirement') }}</option>
                                            @foreach(\App\Models\Course::where('is_active', 1)->get() as $req_course)
                                                <option value="{{ $req_course->code }}">
                                                    {{ $req_course->code }} - {{ $req_course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label" for="required3">{{ __('l.Required Course') }} 3</label>
                                        <select id="required3" name="required3" class="form-select">
                                            <option value="">{{ __('l.No Requirement') }}</option>
                                            @foreach(\App\Models\Course::where('is_active', 1)->get() as $req_course)
                                                <option value="{{ $req_course->code }}">
                                                    {{ $req_course->code }} - {{ $req_course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="image">{{ __('l.Image') }}</label>
                                        <input type="file" id="image" name="image" class="form-control" required />
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal">{{ __('l.Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('l.Create') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="card" style="padding: 15px;">
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

                <div class="card-datatable table-responsive">
                    <div class="mb-3">
                        @can('delete courses')
                            <button id="deleteSelected" class="btn btn-danger d-none">
                                <i class="fa fa-trash ti-xs me-1"></i>{{ __('l.Delete Selected') }}
                            </button>
                        @endcan
                    </div>
                    <table class="table" id="courses-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th>{{ __('l.Image') }}</th>
                                <th>{{ __('l.Code') }}</th>
                                <th>{{ __('l.Name') }}</th>
                                <th>{{ __('l.Hours') }}</th>
                                <th>{{ __('l.College') }}</th>
                                <th>{{ __('l.Staff Count') }}</th>
                                <th>{{ __('l.Students Count') }}</th>
                                <th>{{ __('l.Status') }}</th>
                                <th>{{ __('l.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $index => $course)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox" value="{{ $course->id }}">
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" width="50" height="50">
                                    </td>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->hours }}</td>
                                    <td>{{ $course->college->name ?? 'N/A' }}</td>
                                    <td>{{ $course->users()->wherePivot('status', 'staff')->count() }}</td>
                                    <td>{{ $course->users()->wherePivot('status', 'enrolled')->count() }}</td>
                                    <td>
                                        @if($course->is_active)
                                            <span class="badge bg-success">{{ __('l.Active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('l.Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @can('show courses')
                                                <a href="{{ route('dashboard.admins.courses-show', ['id' => encrypt($course->id)]) }}"
                                                   class="btn btn-sm btn-info me-1" title="{{ __('l.View') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('edit courses')
                                                <a href="{{ route('dashboard.admins.courses-edit', ['id' => encrypt($course->id)]) }}"
                                                   class="btn btn-sm btn-primary me-1" title="{{ __('l.Edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('dashboard.admins.courses-staff', ['id' => encrypt($course->id)]) }}"
                                                   class="btn btn-sm btn-warning me-1" title="{{ __('l.Manage Staff') }}">
                                                    <i class="fa fa-users"></i>
                                                </a>
                                            @endcan
                                            @can('delete courses')
                                                <button type="button" class="btn btn-sm btn-danger delete-course"
                                                        data-id="{{ encrypt($course->id) }}" title="{{ __('l.Delete') }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            let table = $('#courses-table').DataTable({
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

            // حدث تحديد/إلغاء تحديد الكل
            $('#select-all').on('change', function() {
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
                updateDeleteButton();
            });

            // تحديث حالة زر الحذف عند تغيير أي صندوق تحديد
            $(document).on('change', '.row-checkbox', function() {
                updateDeleteButton();
                let allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#select-all').prop('checked', allChecked);
            });

            function updateDeleteButton() {
                let checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#deleteSelected').removeClass('d-none');
                } else {
                    $('#deleteSelected').addClass('d-none');
                }
            }

            // حذف المواد المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: "{{ __('l.Are you sure?') }}",
                        text: "{{ __('l.Selected courses will be deleted!') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "{{ __('l.Yes, delete them!') }}",
                        cancelButtonText: "{{ __('l.Cancel') }}",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                "{{ route('dashboard.admins.courses-deleteSelected') }}?ids=" +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // إضافة معالج حدث الحذف للأزرار التي يتم إنشاؤها ديناميكياً
            $(document).on('click', '.delete-course', function() {
                let courseId = $(this).data('id');

                Swal.fire({
                    title: "{{ __('l.Are you sure?') }}",
                    text: "{{ __('l.You will be delete this forever!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('l.Yes, delete it!') }}",
                    cancelButtonText: "{{ __('l.Cancel') }}",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href =
                            "{{ route('dashboard.admins.courses-delete') }}?id=" +
                            courseId;
                    }
                });
            });
        });
    </script>
@endsection