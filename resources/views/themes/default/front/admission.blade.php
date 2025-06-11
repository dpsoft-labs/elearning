@extends('themes.default.layouts.front.master')

@section('title', $seoPage->title)
@section('description', $seoPage->description)
@section('keywords', $seoPage->keywords)
@section('og_title', $seoPage->og_title)
@section('og_description', $seoPage->og_description)
@section('og_image', asset($seoPage->og_image))
@section('structured_data')
    <script type="application/ld+json">
        {!! $seoPage->structured_data !!}
    </script>
@endsection

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
    .form-label {
        font-weight: 500;
    }
    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
    }
    .required-field::after {
        content: "*";
        color: red;
        margin-left: 4px;
    }
    .preview-image {
        max-width: 200px;
        max-height: 200px;
        margin-top: 10px;
        border-radius: 8px;
        display: none;
    }
</style>
@endsection

@section('content')
<section class="admission-section mt-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="admission-form">
                    <h2 class="text-center mb-4">@lang('front.admission_form')</h2>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }} <a href="{{ route('admission.show') }}?id={{ session('admission')->id }}">@lang('front.admission_number') #{{ session('admission')->id }} @lang('front.view_admission')</a>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <ul class="nav nav-tabs" id="admissionTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="search-tab" data-bs-toggle="tab" data-bs-target="#search" type="button" role="tab" aria-controls="search" aria-selected="true">@lang('front.search_admission')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="create-tab" data-bs-toggle="tab" data-bs-target="#create" type="button" role="tab" aria-controls="create" aria-selected="false">@lang('front.create_admission')</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="admissionTabsContent">
                        <!-- فورم البحث -->
                        <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="search-tab">
                            <div class="search-form">
                                <form action="{{ route('admission.show') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label">@lang('front.admission_number')</label>
                                                <input type="text" name="id" class="form-control" placeholder="@lang('front.enter_admission_number')" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary w-100">@lang('front.search')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- فورم إنشاء طلب جديد -->
                        <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="create-tab">
                            <form action="{{ route('admission.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- المعلومات الشخصية -->
                                <div class="form-section">
                                    <h3 class="section-title">@lang('front.personal_information')</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.english_name')</label>
                                            <input type="text" name="en_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.arabic_name')</label>
                                            <input type="text" name="ar_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.email')</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.phone')</label>
                                            <input type="tel" name="phone" class="form-control" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label required-field">@lang('front.address')</label>
                                            <input type="text" name="address" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.city')</label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.country')</label>
                                            <select name="country" class="form-control form-select select2" required>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.gender')</label>
                                            <select name="gender" class="form-control form-select select2" required>
                                                <option value="">@lang('front.choose_gender')</option>
                                                <option value="male">@lang('front.male')</option>
                                                <option value="female">@lang('front.female')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.date_of_birth')</label>
                                            <input type="date" name="date_of_birth" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.nationality')</label>
                                            <input type="text" name="nationality" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.national_id')</label>
                                            <input type="text" name="national_id" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- معلومات التعليم -->
                                <div class="form-section">
                                    <h3 class="section-title">@lang('front.education_information')</h3>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label required-field">@lang('front.school_name')</label>
                                            <input type="text" name="school_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.certificate_type')</label>
                                            <select name="certificate_type" class="form-control form-select select2" required>
                                                <option value="">@lang('front.choose_certificate_type')</option>
                                                <option value="azhary">@lang('front.azhary')</option>
                                                <option value="languages">@lang('front.languages')</option>
                                                <option value="general">@lang('front.general')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.graduation_year')</label>
                                            <input type="text" name="graduation_year" class="form-control" maxlength="4" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.grade_percentage')</label>
                                            <input type="number" name="grade_percentage" class="form-control" min="0" max="100" step="0.01" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.grade_evaluation')</label>
                                            <input type="text" name="grade_evaluation" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.academic_section')</label>
                                            <select name="academic_section" class="form-control form-select select2" required>
                                                <option value="">@lang('front.choose_academic_section')</option>
                                                <option value="science">@lang('front.science')</option>
                                                <option value="math">@lang('front.math')</option>
                                                <option value="arts">@lang('front.arts')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- معلومات الوالدين -->
                                <div class="form-section">
                                    <h3 class="section-title">@lang('front.parent_information')</h3>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.parent_name')</label>
                                            <input type="text" name="parent_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.parent_phone')</label>
                                            <input type="tel" name="parent_phone" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field">@lang('front.parent_job')</label>
                                            <input type="text" name="parent_job" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- المرفقات -->
                                <div class="form-section">
                                    <h3 class="section-title">@lang('front.attachments')</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.student_photo')</label>
                                            <input type="file" name="student_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'student_preview')">
                                            <img id="student_preview" class="preview-image">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.certificate_photo')</label>
                                            <input type="file" name="certificate_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'certificate_preview')">
                                            <img id="certificate_preview" class="preview-image">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.national_id_photo')</label>
                                            <input type="file" name="national_id_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'national_id_preview')">
                                            <img id="national_id_preview" class="preview-image">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">@lang('front.parent_national_id_photo')</label>
                                            <input type="file" name="parent_national_id_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'parent_national_id_preview')">
                                            <img id="parent_national_id_preview" class="preview-image">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">@lang('front.submit_request')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
@endsection
