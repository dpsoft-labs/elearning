@extends('themes.default.layouts.front.master')

@section('title', __('front.admission_form') . ' #' . $admission->id)
@section('description', __('front.admission_form') . ' #' . $admission->id)
@section('keywords', __('front.admission_form') . ' #' . $admission->id)
@section('og_title', __('front.admission_form') . ' #' . $admission->id)
@section('og_description', __('front.admission_form') . ' #' . $admission->id)
@section('og_image', asset($admission->student_photo))
@section('structured_data')@endsection

@section('css')
<style>
    .admission-form {
        border-radius: 15px;
        padding: 30px;
        margin: 30px 0;
    }
    .form-section {
        padding: 20px 0;
        margin-bottom: 20px;
    }
    .form-section:last-child {
        border-bottom: none;
    }
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .info-label {
        font-weight: 500;
    }
    .info-value {
        font-weight: 600;
    }
    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 500;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-approved {
        background-color: #d4edda;
        color: #155724;
    }
    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    .document-preview {
        max-width: 200px;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<section class="admission-section mt-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="admission-form">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('admission') }}" class="btn btn-primary"><- @lang('l.Back')</a>
                        <h2>@lang('front.admission_form') #{{ $admission->id }}</h2>
                        <span class="status-badge status-{{ $admission->status }}">
                            @lang('front.status_' . $admission->status)
                        </span>
                    </div>

                    <!-- المعلومات الشخصية -->
                    <div class="form-section">
                        <h3 class="section-title">@lang('front.personal_information')</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.english_name')</div>
                                <div class="info-value">{{ $admission->en_name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.arabic_name')</div>
                                <div class="info-value">{{ $admission->ar_name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.email')</div>
                                <div class="info-value">{{ $admission->email }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.phone')</div>
                                <div class="info-value">{{ $admission->phone }}</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="info-label">@lang('front.address')</div>
                                <div class="info-value">{{ $admission->address }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.city')</div>
                                <div class="info-value">{{ $admission->city }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.country')</div>
                                <div class="info-value">{{ $admission->country }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.gender')</div>
                                <div class="info-value">@lang('front.' . $admission->gender)</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.date_of_birth')</div>
                                <div class="info-value">{{ $admission->date_of_birth }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.nationality')</div>
                                <div class="info-value">{{ $admission->nationality }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.national_id')</div>
                                <div class="info-value">{{ $admission->national_id }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات التعليم -->
                    <div class="form-section">
                        <h3 class="section-title">@lang('front.education_information')</h3>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="info-label">@lang('front.school_name')</div>
                                <div class="info-value">{{ $admission->school_name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.certificate_type')</div>
                                <div class="info-value">@lang('front.' . $admission->certificate_type)</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.graduation_year')</div>
                                <div class="info-value">{{ $admission->graduation_year }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.grade_percentage')</div>
                                <div class="info-value">{{ $admission->grade_percentage }}%</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.grade_evaluation')</div>
                                <div class="info-value">{{ $admission->grade_evaluation }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.academic_section')</div>
                                <div class="info-value">@lang('front.' . $admission->academic_section)</div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات الوالدين -->
                    <div class="form-section">
                        <h3 class="section-title">@lang('front.parent_information')</h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.parent_name')</div>
                                <div class="info-value">{{ $admission->parent_name }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.parent_phone')</div>
                                <div class="info-value">{{ $admission->parent_phone }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">@lang('front.parent_job')</div>
                                <div class="info-value">{{ $admission->parent_job }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- المرفقات -->
                    <div class="form-section">
                        <h3 class="section-title">@lang('front.attachments')</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.student_photo')</div>
                                <img src="{{ asset($admission->student_photo) }}" class="document-preview">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.certificate_photo')</div>
                                <img src="{{ asset($admission->certificate_photo) }}" class="document-preview">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.national_id_photo')</div>
                                <img src="{{ asset($admission->national_id_photo) }}" class="document-preview">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">@lang('front.parent_national_id_photo')</div>
                                <img src="{{ asset($admission->parent_national_id_photo) }}" class="document-preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@endsection
