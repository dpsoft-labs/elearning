@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Branch Details') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('show branches')
            <div class="row">
                <div class="col-12">
                    <h5 class="card-title">{{ __('l.Branch Details') }}</h5>
                </div>

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $branch->name }}</h5>
                            @can('edit branches')
                                <a href="{{ route('dashboard.admins.branches-edit', ['id' => encrypt($branch->id)]) }}"
                                   class="btn btn-primary">
                                    <i class="fa fa-edit me-1"></i>{{ __('l.Edit') }}
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>{{ __('l.Name') }}</h6>
                                    <p>{{ $branch->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>{{ __('l.Email') }}</h6>
                                    <p>{{ $branch->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>{{ __('l.Phone') }}</h6>
                                    <p>{{ $branch->phone }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>{{ __('l.Address') }}</h6>
                                    <p>{{ $branch->address }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>{{ __('l.Students Count') }}</h6>
                                    <p>{{ $branch->students->count() }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>{{ __('l.Created At') }}</h6>
                                    <p>{{ $branch->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('l.Students in this Branch') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="students-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('l.Name') }}</th>
                                            <th>{{ __('l.Email') }}</th>
                                            <th>{{ __('l.Phone') }}</th>
                                            <th>{{ __('l.College') }}</th>
                                            <th>{{ __('l.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($branch->students as $index => $student)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $student->firstname }} {{ $student->lastlname }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->phone ?? '-' }}</td>
                                                <td>{{ $student->college->name ?? '-' }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @can('show students')
                                                            <a href="{{ route('dashboard.admins.students-show', ['id' => encrypt($student->id)]) }}"
                                                               class="btn btn-sm btn-info me-1" title="{{ __('l.View') }}">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
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
            </div>
        @endcan
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            $('#students-table').DataTable({
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
