@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Admission Details')
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">@lang('l.Admission Details')</h5>
                        <a href="{{ route('dashboard.admins.admissions') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> @lang('l.Back')
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- المعلومات الشخصية -->
                            <div class="col-md-6">
                                <h6 class="mb-3">@lang('l.Personal Information')</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>@lang('l.Name (Arabic)')</th>
                                        <td>{{ $admission->ar_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Name (English)')</th>
                                        <td>{{ $admission->en_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Email')</th>
                                        <td>{{ $admission->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Phone')</th>
                                        <td>{{ $admission->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Address')</th>
                                        <td>{{ $admission->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.City')</th>
                                        <td>{{ $admission->city }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Country')</th>
                                        <td>{{ $admission->country }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Gender')</th>
                                        <td>{{ $admission->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Date of Birth')</th>
                                        <td>{{ $admission->date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Nationality')</th>
                                        <td>{{ $admission->nationality }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.National ID')</th>
                                        <td>{{ $admission->national_id }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- المعلومات التعليمية -->
                            <div class="col-md-6">
                                <h6 class="mb-3">@lang('l.Education Information')</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>@lang('l.Certificate Type')</th>
                                        <td>{{ $admission->certificate_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.School Name')</th>
                                        <td>{{ $admission->school_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Graduation Year')</th>
                                        <td>{{ $admission->graduation_year }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Grade Percentage')</th>
                                        <td>{{ $admission->grade_percentage }}%</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Grade Evaluation')</th>
                                        <td>{{ $admission->grade_evaluation }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Academic Section')</th>
                                        <td>{{ $admission->academic_section }}</td>
                                    </tr>
                                </table>

                                <h6 class="mb-3 mt-4">@lang('l.Parent Information')</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>@lang('l.Parent Name')</th>
                                        <td>{{ $admission->parent_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Parent Phone')</th>
                                        <td>{{ $admission->parent_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('l.Parent Job')</th>
                                        <td>{{ $admission->parent_job }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- المستندات -->
                            <div class="col-12 mt-4">
                                <h6 class="mb-3">@lang('l.Documents')</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset($admission->student_photo) }}" class="card-img-top" alt="Student Photo">
                                            <div class="card-body">
                                                <h6 class="card-title">@lang('l.Student Photo')</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset($admission->certificate_photo) }}" class="card-img-top" alt="Certificate">
                                            <div class="card-body">
                                                <h6 class="card-title">@lang('l.Certificate')</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset($admission->national_id_photo) }}" class="card-img-top" alt="National ID">
                                            <div class="card-body">
                                                <h6 class="card-title">@lang('l.National ID')</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ asset($admission->parent_national_id_photo) }}" class="card-img-top" alt="Parent National ID">
                                            <div class="card-body">
                                                <h6 class="card-title">@lang('l.Parent National ID')</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تغيير الحالة -->
                            @can('edit admissions')
                                <div class="col-12 mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">@lang('l.Change Status')</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('dashboard.admins.admissions-update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ encrypt($admission->id) }}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>@lang('l.Status')</label>
                                                            <select name="status" class="form-select">
                                                                <option value="pending" {{ $admission->status == 'pending' ? 'selected' : '' }}>@lang('l.Pending')</option>
                                                                <option value="accepted" {{ $admission->status == 'accepted' ? 'selected' : '' }}>@lang('l.Accepted')</option>
                                                                <option value="rejected" {{ $admission->status == 'rejected' ? 'selected' : '' }}>@lang('l.Rejected')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fa fa-save me-1"></i> @lang('l.Update Status')
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
