@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Edit Course') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('edit courses')
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">{{ __('l.Edit Course') }} - {{ $course->name }}</h5>
                        <a href="{{ route('dashboard.admins.courses-show', ['id' => encrypt($course->id)]) }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i>{{ __('l.Back to Course') }}
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('l.Course Information') }}</h5>
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

                            <form class="row g-3" method="post" enctype="multipart/form-data"
                                  action="{{ route('dashboard.admins.courses-update') }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{ $course->id }}">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">{{ __('l.Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ $course->name }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="code">{{ __('l.Code') }}</label>
                                    <input type="text" id="code" name="code" class="form-control"
                                           value="{{ $course->code }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="hours">{{ __('l.Hours') }}</label>
                                    <input type="text" id="hours" name="hours" class="form-control"
                                           value="{{ $course->hours }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="college_id">{{ __('l.College') }}</label>
                                    <select id="college_id" name="college_id" class="form-select" required>
                                        <option value="">{{ __('l.Select College') }}</option>
                                        @foreach(\App\Models\College::all() as $college)
                                            <option value="{{ $college->id }}" {{ $course->college_id == $college->id ? 'selected' : '' }}>
                                                {{ $college->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="required_hours">{{ __('l.Required Hours') }}</label>
                                    <input type="number" id="required_hours" name="required_hours" class="form-control"
                                           value="{{ $course->required_hours }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="is_active">{{ __('l.Status') }}</label>
                                    <select id="is_active" name="is_active" class="form-select" required>
                                        <option value="1" {{ $course->is_active ? 'selected' : '' }}>{{ __('l.Active') }}</option>
                                        <option value="0" {{ !$course->is_active ? 'selected' : '' }}>{{ __('l.Inactive') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="required1">{{ __('l.Required Course') }} 1</label>
                                    <select id="required1" name="required1" class="form-select">
                                        <option value="">{{ __('l.No Requirement') }}</option>
                                        @foreach(\App\Models\Course::where('is_active', 1)->get() as $req_course)
                                            <option value="{{ $req_course->code }}" {{ $course->required1 == $req_course->code ? 'selected' : '' }}>
                                                {{ $req_course->code }} - {{ $req_course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="required2">{{ __('l.Required Course') }} 2</label>
                                    <select id="required2" name="required2" class="form-select">
                                        <option value="">{{ __('l.No Requirement') }}</option>
                                        @foreach(\App\Models\Course::where('is_active', 1)->get() as $req_course)
                                            <option value="{{ $req_course->code }}" {{ $course->required2 == $req_course->code ? 'selected' : '' }}>
                                                {{ $req_course->code }} - {{ $req_course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="required3">{{ __('l.Required Course') }} 3</label>
                                    <select id="required3" name="required3" class="form-select">
                                        <option value="">{{ __('l.No Requirement') }}</option>
                                        @foreach(\App\Models\Course::where('is_active', 1)->get() as $req_course)
                                            <option value="{{ $req_course->code }}" {{ $course->required3 == $req_course->code ? 'selected' : '' }}>
                                                {{ $req_course->code }} - {{ $req_course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label" for="image">{{ __('l.Image') }}</label>
                                    <input type="file" id="image" name="image" class="form-control" />
                                    <small class="text-muted">{{ __('l.Leave empty to keep current image') }}</small>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{ __('l.Current Image') }}</label>
                                    <div>
                                        <img src="{{ asset($course->image) }}" alt="{{ $course->name }}"
                                             class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('dashboard.admins.courses') }}"
                                           class="btn btn-label-secondary">
                                            {{ __('l.Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('l.Save Changes') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('js')
@endsection