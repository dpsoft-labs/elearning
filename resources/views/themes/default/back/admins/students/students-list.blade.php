@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.List') @if ($inactiveUsers == 1)
        @lang('l.Inactive')
    @endif @lang('l.Students')
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

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        @can('show students')
            @if ($inactiveUsers == 0)
                @can('add students')
                    <div class="card-action-element mb-2" style="text-align: end; ">
                        <a href="{{ route('dashboard.admins.students-import-get') }}" class="btn btn-info waves-effect waves-light me-2">
                            <i class="fa fa-file-import ti-xs me-1"></i>
                            @lang('l.Import Students')
                        </a>
                        <a href="{{ route('dashboard.admins.students-add') }}"
                            class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus ti-xs me-1"></i>
                            @lang('l.Add New Student')
                        </a>
                    </div>
                @endcan
            @elseif ($inactiveUsers == 1)
                @can('delete students')
                    <div class="card-action-element mb-2" style="text-align: end; ">
                        <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light delete-all-inactive"><i
                                class="fa fa-trash ti-xs me-1"></i>@lang('l.Delete All Inactive Students')
                        </a>
                    </div>
                @endcan
            @endif

            <div class="nav-align-top mb-4">
                <ul class="nav nav-tabs nav-fill w-100" role="tablist" style="min-height: 50px;">
                    <li class="nav-item">
                        <a class="nav-link {{ $inactiveUsers == 0 ? 'active' : '' }}"
                            href="{{ route('dashboard.admins.students') }}" style="padding: 15px;">
                            <i class="fa fa-users ti-xs me-1"></i> @lang('l.Active Students')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $inactiveUsers == 1 ? 'active' : '' }}"
                            href="{{ route('dashboard.admins.students') }}?inactive=1" style="padding: 15px;">
                            <i class="fa fa-user-times ti-xs me-1"></i> @lang('l.Inactive Students')
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card" id="div1" style="padding: 15px;">
                <div class="card-datatable table-responsive">
                    <div class="mb-3">
                        <button id="deleteSelected" class="btn btn-danger d-none">
                            <i class="fa fa-trash ti-xs me-1"></i>@lang('l.Delete Selected')
                        </button>
                    </div>
                    <table class="table" id="students-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th>@lang('l.Student Name')</th>
                                <th>@lang('l.Email')</th>
                                <th>@lang('l.Phone')</th>
                                <th>SID</th>
                                <th>@lang('l.Branch')</th>
                                <th>@lang('l.College')</th>
                                @if ($inactiveUsers == 1)
                                    <th>@lang('l.Deleted At')</th>
                                @endif
                                <th>@lang('l.Action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            let table = $('#students-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ request()->url() }}?inactive={{ $inactiveUsers }}',
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        exportable: false,
                        render: function (data, type, row) {
                            if (type === 'display') {
                                return `<input type="checkbox" class="form-check-input row-checkbox" value="${row?.id || ''}">`;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'sid',
                        name: 'sid',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'branch',
                        name: 'branch_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'college',
                        name: 'college_id',
                        orderable: false,
                        searchable: false
                    },
                    @if ($inactiveUsers == 1)
                        {
                            data: 'deleted_at',
                            name: 'deleted_at',
                            orderable: true,
                            searchable: true
                        },
                    @endif {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                @if ($inactiveUsers == 1)
                    order: [
                        [8, 'desc']
                    ],
                @else
                    order: [
                        [1, 'desc']
                    ],
                @endif
                dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"lB><"d-flex align-items-center"f>>rtip',
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "@lang('l.All')"]
                ],
                pageLength: 10,
                buttons: [{
                        extend: 'collection',
                        text: '<i class="ti ti-download me-1"></i> @lang('l.Export')',
                        className: 'btn btn-primary dropdown-toggle mx-3',
                        buttons: [{
                                text: '<i class="ti ti-file-spreadsheet me-1"></i> @lang('l.Excel')',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    window.open(
                                        '{{ route('dashboard.admins.students.export') }}?type=excel&' +
                                        $.param({
                                            search: {
                                                value: table.search()
                                            },
                                            order: [{
                                                column: table.order()[0][0],
                                                dir: table.order()[0][1]
                                            }],
                                            columns: table.settings().init().columns,
                                            inactive: {{ $inactiveUsers ?? 0 }}
                                        }), '_blank');
                                }
                            },
                            {
                                text: '<i class="ti ti-file-text me-1"></i> @lang('l.CSV')',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    window.open(
                                        '{{ route('dashboard.admins.students.export') }}?type=csv&' +
                                        $.param({
                                            search: {
                                                value: table.search()
                                            },
                                            order: [{
                                                column: table.order()[0][0],
                                                dir: table.order()[0][1]
                                            }],
                                            columns: table.settings().init().columns,
                                            inactive: {{ $inactiveUsers ?? 0 }}
                                        }), '_blank');
                                }
                            },
                            {
                                text: '<i class="ti ti-file-description me-1"></i> @lang('l.PDF')',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    exportData('pdf');
                                }
                            },
                            {
                                text: '<i class="ti ti-printer me-1"></i> @lang('l.Print')',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    exportData('print');
                                }
                            }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="ti ti-eye me-1"></i> @lang('l.Columns')',
                        className: 'btn btn-secondary'
                    }
                ],
                language: {
                    // url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/{{ app()->getLocale() }}.json',
                    buttons: {
                        colvis: '@lang('l.Show/Hide Columns')'
                    },
                    lengthMenu: "@lang('l.Show') _MENU_ @lang('l.Records') @lang('l.Per Page')",
                    search: "@lang('l.Search') :",
                    paginate: {
                        first: "@lang('l.First')",
                        previous: "@lang('l.Previous')",
                        next: "@lang('l.Next')",
                        last: "@lang('l.Last')"
                    },
                    info: "@lang('l.Show') _START_ @lang('l.To') _END_ @lang('l.Of') _TOTAL_ @lang('l.Records')",
                    infoEmpty: "@lang('l.No Records Available')",
                    infoFiltered: "@lang('l.Filtered From') _MAX_ @lang('l.Records')",
                    processing: "<i class='fa fa-spinner fa-spin'></i> @lang('l.Loading...')"
                },
                drawCallback: function(settings) {
                    $('.dataTables_processing').hide();
                },
                preDrawCallback: function(settings) {
                    $('.dataTables_processing').show();
                }
            });

            function exportData(type) {
                if (type === 'print' || type === 'pdf') {
                    $.ajax({
                        url: '{{ route('dashboard.admins.students.export') }}',
                        type: 'GET',
                        data: {
                            search: {
                                value: table.search()
                            },
                            order: [{
                                column: table.order()[0][0],
                                dir: table.order()[0][1]
                            }],
                            columns: table.settings().init().columns.filter(col => col.exportable !== false),
                            inactive: {{ $inactiveUsers ?? 0 }}
                        },
                        success: function(response) {
                            printData(response.data);
                        }
                    });
                }
            }

            function printData(data) {
                let printWindow = window.open('', '_blank');
                let html = `
            <html dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
                <head>
                    <!-- <title>@lang('l.Students List')</title> -->
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 8px; }
                        th { background-color: #f5f5f5; }
                        h1 { text-align: center; }
                    </style>
                </head>
                <body>
                    <h1>@lang('l.Students List')</h1>
                    <table>
                        <thead>
                            <tr>${Object.keys(data[0]).map(key => `<th>${key}</th>`).join('')}</tr>
                        </thead>
                        <tbody>
                            ${data.map(row => `
                                    <tr>${Object.values(row).map(value => `<td>${value}</td>`).join('')}</tr>
                                `).join('')}
                        </tbody>
                    </table>
                </body>
            </html>
        `;
                printWindow.document.write(html);
                printWindow.document.close();
                printWindow.print();
            }

            // معالجة أحداث الحذف
            $(document).on('click', '.delete-record', function(e) {
                e.preventDefault();
                const deleteUrl = $(this).attr('href');
                const isInactive = $(this).data('inactive');

                Swal.fire({
                    title: '@lang('l.Are you sure?')',
                    text: isInactive ? "@lang('l.The student will be deleted permanently!')" : "@lang('l.The student will be disabled!')",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('l.Yes, delete it!')',
                    cancelButtonText: '@lang('l.Cancel')',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });

            // تفعيل tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // إضافة معالج حدث للزر حذف جميع المستخدمين غير النشطين
            $('.delete-all-inactive').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '@lang('l.Are you sure?')',
                    text: "@lang('l.All inactive students will be deleted permanently! This action cannot be undone.')",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('l.Yes, delete all!')',
                    cancelButtonText: '@lang('l.Cancel')',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // قم بتوجيه المستخدم إلى رابط حذف جميع المستخدمين غير النشطين
                        window.location.href =
                            '{{ route('dashboard.admins.students-delete-allinactive') }}';
                    }
                });
            });

            // تحديد/إلغاء تحديد الكل
            $('#select-all').on('change', function() {
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
                updateDeleteButton();
            });

            // تحديث حالة زر الحذف عند تغيير أي صندوق تحديد
            $(document).on('change', '.row-checkbox', function() {
                updateDeleteButton();

                // تحديث حالة "تحديد الكل" إذا تم تحديد/إلغاء تحديد كل الصناديق
                let allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#select-all').prop('checked', allChecked);
            });

            // تحديث ظهور زر الحذف
            function updateDeleteButton() {
                let checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#deleteSelected').removeClass('d-none');
                } else {
                    $('#deleteSelected').addClass('d-none');
                }
            }

            // معالجة حدث الحذف المتعدد
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: '@lang('l.Are you sure?')',
                        text: "@lang('l.Selected students will be deleted!')",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '@lang('l.Yes, delete them!')',
                        cancelButtonText: '@lang('l.Cancel')',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("dashboard.admins.students-delete-selected") }}?ids=' + selectedIds.join(',');
                        }
                    });
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '@lang('l.Done')',
                    text: '{{ session('success') }}',
                    confirmButtonText: '@lang('l.OK')'
                });
            });
        </script>
    @endif
@endsection
