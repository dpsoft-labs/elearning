@extends('themes.default.layouts.back.master')


@section('title')
    @lang('l.Lives List')
@endsection

@section('content')
    <div class="container mt-5">
        <div class="content-wrapper">
            @if (isset($courses))
                <div class="row">
                    @forelse ($courses as $course)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $course->name }}</h4>
                                    <div class="stats mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>@lang('l.Students')</span>
                                            <span class="badge bg-primary">{{ $course->students()->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>@lang('l.Lives')</span>
                                            <span class="badge bg-info">{{ $course->lives()->count() }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('dashboard.admins.lives') }}?course={{ encrypt($course->id) }}"
                                        class="btn btn-primary btn-block mt-3">
                                        @lang('l.View Lives')
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">@lang('l.No Courses Found')</h4>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            @else
                @can('show lives')
                    <!-- Multilingual -->
                    @can('add lives')
                        <div class="card-action-element mb-2 add-new-live" style="text-align: end; ">
                            <a href="#" data-bs-target="#addLiveModal" data-bs-toggle="modal"
                                class="btn btn-secondary waves-effect waves-light">
                                <i class="ti ti-plus ti-xs me-1"></i>@lang('l.Add new Live')
                            </a>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Add Role Modal -->
                        <div class="modal fade" id="addLiveModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-live"
                                style="justify-content: center;">
                                <div class="modal-content p-3 p-md-5 col-md-8">
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="live-title mb-2">@lang('l.Add new Live')</h3>
                                        </div>
                                        <!-- Add role form -->
                                        <form id="addLiveForm" class="row g-3" method="post" enctype="multipart/form-data"
                                            action="{{ route('dashboard.admins.lives-store') }}">
                                            @csrf
                                            <div class="col-12 mb-4">
                                                <label class="form-label" for="name">@lang('l.Name')</label>
                                                <input type="text" id="name" name="name" class="form-control" required />
                                            </div>
                                            <div class="col-12 mb-4">
                                                <label class="form-label" for="date">@lang('l.Date')</label>
                                                <input type="datetime-local" id="date" name="date" class="form-control"
                                                    step="1" required />
                                            </div>
                                            <div class="col-12 mb-4">
                                                <label class="form-label" for="link">@lang('l.Link')</label>
                                                <input type="text" id="link" name="link" class="form-control" required />
                                            </div>
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary me-sm-3 me-1">@lang('l.Submit')</button>
                                            </div>
                                        </form>
                                        <!--/ Add role form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Add Role Modal -->
                    @endcan

                    <div class="card" id="div1" style="padding: 30px;">
                        <div class="card-datatable table-responsive">
                            <table class=" table" id="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('l.Name')</th>
                                        <th>@lang('l.Course')</th>
                                        <th>@lang('l.Date')</th>
                                        <th>@lang('l.Created At')</th>
                                        <th>@lang('l.Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lives as $live)
                                        <tr>
                                            <td class="capital">
                                                {{ ($lives->currentPage() - 1) * $lives->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="capital">
                                                {{ $live->name }}
                                            </td>
                                            <td class="capital">
                                                {{ $live->course->name }}
                                            </td>
                                            <td class="capital">
                                                {{ \Carbon\Carbon::parse($live->date)->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="capital">{{ $live->created_at->format('d/m/Y') }}</td>
                                            <td class="capital">
                                                @can('edit lives')
                                                    <a href="{{ route('dashboard.admins.lives-edit') }}?id={{ encrypt($live->id) }}"
                                                        data-bs-toggle="tooltip" title="edit" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete lives')
                                                    <a class="delete-live btn btn-danger btn-sm" href="javascript:void(0);"
                                                        data-bs-toggle="tooltip" title="delete live"
                                                        data-live-id="{{ encrypt($live->id) }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script>
        var table = $('#data-table').DataTable({
            ordering: true,
            order: [],
        });

        $('#search-input').keyup(function() {
            table.search($(this).val()).draw();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRoleButton = document.querySelector('.add-new-live');
            const addRoleModal = document.querySelector('#addRoleModal');

            addRoleButton.addEventListener('click', function() {
                var modal = new bootstrap.Modal(addRoleModal);
                modal.show();
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-live', function(e) {
            e.preventDefault();
            const liveId = $(this).data('live-id');

            Swal.fire({
                title: "@lang('l.Are you sure?')",
                text: "@lang('l.You will be delete this forever!')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#343a40',
                confirmButtonText: "@lang('l.Yes, delete it!')",
                cancelButtonText: "@lang('l.Cancel')"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('dashboard.admins.lives-delete') }}?id=' + liveId;
                }
            });
        });
    </script>
@endsection
