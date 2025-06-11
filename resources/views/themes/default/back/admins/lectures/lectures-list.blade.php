@extends('themes.default.layouts.back.master')


@section('title')
    @lang('l.Lectures List')
@endsection

@section('css')
@endsection

@section('content')
    <div class="container mt-5">
        <div class="page-category">
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
                                                <span>@lang('l.Lectures')</span>
                                                <span class="badge bg-info">{{ $course->lectures()->count() }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('dashboard.admins.lectures') }}?course={{ encrypt($course->id) }}"
                                            class="btn btn-primary btn-block mt-3">
                                            @lang('l.View Lectures')
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
                    @can('show lectures')
                        <!-- Multilingual -->
                        @can('add lectures')
                            <div class="card-action-element mb-2 add-new-lecture" style="text-align: end; ">
                                <a href="#" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn btn-secondary waves-effect waves-light">
                                    <i class="ti ti-plus ti-xs me-1"></i>@lang('l.Add new Lecture')
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
                            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-lecture"
                                    style="justify-content: center;">
                                    <div class="modal-content p-3 p-md-5 col-md-8">
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                <h3 class="role-title mb-2">@lang('l.Add new Lecture')</h3>
                                            </div>
                                            <!-- Add role form -->
                                            <form id="addLectureForm" class="row g-3" method="post" enctype="multipart/form-data"
                                                action="{{ route('dashboard.admins.lectures-store') }}">
                                                @csrf
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="name">@lang('l.Name')</label>
                                                    <input type="text" id="name" name="name" class="form-control"
                                                        required />
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="description">@lang('l.Description')</label>
                                                    <textarea type="text" id="description" name="description" class="form-control"></textarea>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="video">@lang('l.Video')</label>
                                                    <input type="text" id="video" name="video" class="form-control" />
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="files">@lang('l.Files')</label>
                                                    <input type="file" id="files" name="files" class="form-control" />
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
                                            <th>@lang('l.Created At')</th>
                                            <th>@lang('l.Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lectures as $lecture)
                                            <tr>
                                                <td class="capital">
                                                    {{ ($lectures->currentPage() - 1) * $lectures->perPage() + $loop->iteration }}
                                                </td>
                                                <td class="capital">
                                                    {{ $lecture->name }}
                                                </td>
                                                <td class="capital">
                                                    {{ $lecture->course->name }}
                                                </td>
                                                <td class="capital">{{ $lecture->created_at->format('d/m/Y') }}</td>
                                                <td class="capital">
                                                    @can('edit lectures')
                                                        <a href="{{ route('dashboard.admins.lectures-edit') }}?id={{ encrypt($lecture->id) }}"
                                                            data-bs-toggle="tooltip" title="edit" class=" btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete lectures')
                                                        <a class="delete-lecture btn btn-danger btn-sm" href="javascript:void(0);"
                                                            data-bs-toggle="tooltip" title="delete lecture"
                                                            data-lecture-id="{{ encrypt($lecture->id) }}">
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
            const addRoleButton = document.querySelector('.add-new-lecture');
            const addRoleModal = document.querySelector('#addRoleModal');

            addRoleButton.addEventListener('click', function() {
                var modal = new bootstrap.Modal(addRoleModal);
                modal.show();
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-lecture', function(e) {
            e.preventDefault();
            const lectureId = $(this).data('lecture-id');

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
                    window.location.href = '{{ route('dashboard.admins.lectures-delete') }}?id=' + lectureId;
                }
            });
        });
    </script>
@endsection
