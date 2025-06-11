@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Colleges') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('show colleges')
            @can('add colleges')
                <div class="card-action-element mb-2" style="text-align: end;">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#addCollegeModal">
                        <i class="fa fa-plus fa-xs me-1"></i> {{ __('l.Add New College') }}
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addCollegeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-header">
                                <h3 class="modal-title text-center">{{ __('l.Add New College') }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addCollegeForm" class="row g-3" method="post"
                                    action="{{ route('dashboard.admins.colleges-store') }}">
                                    @csrf
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="name">{{ __('l.Name') }}</label>
                                        <input type="text" id="name" name="name" class="form-control" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="address">{{ __('l.Address') }}</label>
                                        <input type="text" id="address" name="address" class="form-control" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="phone">{{ __('l.Phone') }}</label>
                                        <input type="text" id="phone" name="phone" class="form-control" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="email">{{ __('l.Email') }}</label>
                                        <input type="email" id="email" name="email" class="form-control" required />
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
                        @can('delete colleges')
                            <button id="deleteSelected" class="btn btn-danger d-none">
                                <i class="fa fa-trash ti-xs me-1"></i>{{ __('l.Delete Selected') }}
                            </button>
                        @endcan
                    </div>
                    <table class="table" id="colleges-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th>{{ __('l.Name') }}</th>
                                <th>{{ __('l.Address') }}</th>
                                <th>{{ __('l.Phone') }}</th>
                                <th>{{ __('l.Email') }}</th>
                                <th>{{ __('l.Students Count') }}</th>
                                <th>{{ __('l.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($colleges as $index => $college)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox" value="{{ $college->id }}">
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $college->name }}</td>
                                    <td>{{ $college->address }}</td>
                                    <td>{{ $college->phone }}</td>
                                    <td>{{ $college->email }}</td>
                                    <td>{{ $college->students->count() }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @can('show colleges')
                                                <a href="{{ route('dashboard.admins.colleges-show', ['id' => encrypt($college->id)]) }}"
                                                   class="btn btn-sm btn-info me-1" title="{{ __('l.View') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('edit colleges')
                                                <a href="{{ route('dashboard.admins.colleges-edit', ['id' => encrypt($college->id)]) }}"
                                                   class="btn btn-sm btn-primary me-1" title="{{ __('l.Edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete colleges')
                                                <button type="button" class="btn btn-sm btn-danger delete-college"
                                                        data-id="{{ encrypt($college->id) }}" title="{{ __('l.Delete') }}">
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
            let table = $('#colleges-table').DataTable({
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

            // حذف الفروع المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: "{{ __('l.Are you sure?') }}",
                        text: "{{ __('l.Selected colleges will be deleted!') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "{{ __('l.Yes, delete them!') }}",
                        cancelButtonText: "{{ __('l.Cancel') }}",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                "{{ route('dashboard.admins.colleges-deleteSelected') }}?ids=" +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // إضافة معالج حدث الحذف للأزرار التي يتم إنشاؤها ديناميكياً
            $(document).on('click', '.delete-college', function() {
                let collegeId = $(this).data('id');

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
                            "{{ route('dashboard.admins.colleges-delete') }}?id=" +
                            collegeId;
                    }
                });
            });
        });
    </script>
@endsection
