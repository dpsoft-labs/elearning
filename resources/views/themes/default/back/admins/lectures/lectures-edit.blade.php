@extends('themes.default.layouts.back.master')

@section('title')
    {{ $lecture->name }}
@endsection

@section('content')
    <div class="container mt-5">
        <div class="content-wrapper">
            @can('edit lectures')
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
                                    <h3 class="role-title mb-2">{{ $lecture->name }}</h3>
                                </div>
                                <!-- Add role form -->
                                <form id="editProductForm" method="post" class="row g-3" enctype="multipart/form-data" action="{{ route('dashboard.admins.lectures-update') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="name">@lang('l.Name')</label>
                                        <input type="text" id="name" name="name" class="form-control" required value="{{ $lecture->name }}" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="description">@lang('l.Description')</label>
                                        <textarea type="text" id="description" name="description" class="form-control"
                                            placeholder="@lang('l.Enter a lecture description')">{{ $lecture->description }}</textarea>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="video">@lang('l.Video')</label>
                                        <input type="text" id="video" name="video" class="form-control"
                                            placeholder="@lang('l.Enter a lecture video')" value="{{ $lecture->video }}" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="files">@lang('l.Change Files')</label>
                                        <input type="file" id="files" name="files" class="form-control" />
                                        @if($lecture->files)
                                            <a href="{{ asset($lecture->files) }}" target="_blank">@lang('l.View File')</a>
                                        @endif
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-secondary me-sm-3 me-1">@lang('l.Update')</button>
                                        <a href="{{ route('dashboard.admins.lectures') }}?course={{ encrypt($lecture->course_id) }}" class="btn btn-label-secondary">@lang('l.Back')</a>
                                    </div>
                                    <input type="hidden" name="id" value="{{ encrypt($lecture->id) }}" />
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
