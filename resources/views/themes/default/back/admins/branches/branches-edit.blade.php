@extends('themes.default.layouts.back.master')

@section('title')
    {{ __('l.Edit Branch') }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('edit branches')
            <div class="row">
                <div class="col-12">
                    <h5 class="card-title">{{ __('l.Edit Branch') }}</h5>
                </div>

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('l.Branch Information') }}</h5>
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

                            <form class="row g-3" method="post"
                                  action="{{ route('dashboard.admins.branches-update') }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{ $branch->id }}">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">{{ __('l.Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ $branch->name }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">{{ __('l.Email') }}</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                           value="{{ $branch->email }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="phone">{{ __('l.Phone') }}</label>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                           value="{{ $branch->phone }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="address">{{ __('l.Address') }}</label>
                                    <input type="text" id="address" name="address" class="form-control"
                                           value="{{ $branch->address }}" required />
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('dashboard.admins.branches') }}"
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
