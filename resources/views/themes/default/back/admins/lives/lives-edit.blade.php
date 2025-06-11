@extends('themes.default.layouts.back.master')

@section('title')
    {{ $live->name }}
@endsection

@section('css')
@endsection


@section('content')
    <div class="container mt-5">
        <div class="content-wrapper">
            @can('edit lives')
                <!-- Add Role Modal -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="addRoleModal" tabindex="-1" aria-hidden="false">
                    <div class=" modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <h3 class="role-title mb-2">{{ $live->name }}</h3>
                                </div>
                                <!-- Add role form -->
                                <form id="editProductForm" method="post" class="row g-3" enctype="multipart/form-data" action="{{ route('dashboard.admins.lives-update') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="name">@lang('l.Name')</label>
                                        <input type="text" id="name" name="name" class="form-control" required value="{{ $live->name }}" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="description">@lang('l.Date')</label>
                                        <input type="datetime-local" id="date" name="date" class="form-control" required value="{{ \Carbon\Carbon::parse($live->date)->format('Y-m-d\TH:i') }}" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="link">@lang('l.Link')</label>
                                        <input type="text" id="link" name="link" class="form-control" value="{{ $live->link }}" />
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-secondary me-sm-3 me-1">@lang('l.Update')</button>
                                        <a href="{{ route('dashboard.admins.lives') }}?course={{ encrypt($live->course_id) }}" class="btn btn-label-secondary">@lang('l.Back')</a>
                                    </div>
                                    <input type="hidden" name="id" value="{{ encrypt($live->id) }}" />
                                </form>
                            </div>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('js')
@endsection
