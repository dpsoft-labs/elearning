@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Admissions List')
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@lang('l.Admissions List')</h5>
                @can('delete admissions')
                    <button id="deleteSelected" class="btn btn-danger d-none">
                        <i class="fa fa-trash ti-xs me-1"></i>@lang('l.Delete Selected')
                    </button>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th>@lang('l.Name')</th>
                                <th>@lang('l.Email')</th>
                                <th>@lang('l.Phone')</th>
                                <th>@lang('l.Certificate Type')</th>
                                <th>@lang('l.Status')</th>
                                <th>@lang('l.Created At')</th>
                                <th>@lang('l.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admissions as $index => $admission)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox" value="{{ $admission->id }}">
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $admission->ar_name }}</td>
                                    <td>{{ $admission->email }}</td>
                                    <td>{{ $admission->phone }}</td>
                                    <td>{{ $admission->certificate_type }}</td>
                                    <td>
                                        <span class="badge bg-{{ $admission->status == 'pending' ? 'warning' : ($admission->status == 'accepted' ? 'success' : 'danger') }}">
                                            @lang('l.' . ucfirst($admission->status))
                                        </span>
                                    </td>
                                    <td>{{ $admission->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('dashboard.admins.admissions-show', ['id' => encrypt($admission->id)]) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @can('delete admissions')
                                                <button class="btn btn-sm btn-danger delete-admission" data-id="{{ encrypt($admission->id) }}">
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
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
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

            // حذف الطلبات المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: '@lang('l.Are you sure?')',
                        text: '@lang('l.Selected admissions will be deleted!')',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '@lang('l.Yes, delete them!')',
                        cancelButtonText: '@lang('l.Cancel')',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('dashboard.admins.admissions-deleteSelected') }}?ids=' + selectedIds.join(',');
                        }
                    });
                }
            });

            // حذف طلب واحد
            $(document).on('click', '.delete-admission', function() {
                let admissionId = $(this).data('id');

                Swal.fire({
                    title: '@lang('l.Are you sure?')',
                    text: '@lang('l.You will delete this admission forever!')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '@lang('l.Yes, delete it!')',
                    cancelButtonText: '@lang('l.Cancel')',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('dashboard.admins.admissions-delete') }}?id=' + admissionId;
                    }
                });
            });
        });
    </script>
@endsection
