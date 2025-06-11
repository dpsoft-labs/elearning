@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Translate SEO Page')
@endsection

@section('css')
<style>
    .nav-tabs .nav-link {
        position: relative;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #696cff;
    }
    .nav-tabs .nav-link:hover:not(.active) {
        background-color: rgba(105, 108, 255, 0.05);
        border-color: transparent;
    }
    .back-btn {
        transition: all 0.3s ease;
    }
    .back-btn:hover {
        transform: translateX(-5px);
    }
    .textarea-counter {
        position: absolute;
        bottom: 10px;
        right: 10px;
        font-size: 0.75rem;
        color: #697a8d;
        background: rgba(255,255,255,0.9);
        padding: 0 5px;
        border-radius: 4px;
    }
    .textarea-wrapper {
        position: relative;
    }
    .auto-translate-btn {
        transition: all 0.3s ease;
    }
    .auto-translate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(33, 37, 41, 0.25);
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('dashboard.admins.seo') }}" class="btn btn-icon btn-outline-primary back-btn me-3">
                <i class="bx bx-arrow-back"></i>
            </a>
            <h4 class="fw-bold py-3 mb-0">
                <i class="bx bx-globe text-primary me-1"></i>
                @lang('l.Translate SEO Page'): {{ $seoPage->getTranslation('title', $defaultLanguage) }}
            </h4>
        </div>

        <a href="{{ route('dashboard.admins.seo-auto-translate', ['id' => encrypt($seoPage->id)]) }}" class="btn btn-dark auto-translate-btn">
            <i class="bx bx-bulb me-1"></i> @lang('l.Auto Translate')
        </a>
    </div>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bx bx-info-circle me-1"></i>
        @lang('l.Please note that automatic translation for large content is not efficient and may take some time, so we do not recommend using it for large content')
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">@lang('l.Translate SEO Content')</h5>
        </div>

        <div class="card-body">
            <form id="translateForm" method="post" action="{{ route('dashboard.admins.seo-translate') }}">
                @csrf @method('PATCH')
                <input type="hidden" name="id" value="{{ encrypt($seoPage->id) }}">

                <ul class="nav nav-tabs mb-4" role="tablist">
                    @foreach ($languages as $language)
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link d-flex align-items-center {{ $loop->first ? 'active' : '' }}"
                                role="tab" data-bs-toggle="tab" data-bs-target="#lang-{{ $language->code }}"
                                aria-controls="lang-{{ $language->code }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                <i class="fi fi-{{ strtolower($language->flag) }} me-2"></i>
                                {{ $language->native }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach ($languages as $language)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            id="lang-{{ $language->code }}" role="tabpanel">

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-text text-primary me-2"></i>
                                        @lang('l.Meta Title') ({{ $language->native }})
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <input
                                            type="text"
                                            class="form-control translation-input"
                                            name="title-{{ $language->code }}"
                                            required
                                            placeholder="@lang('l.Enter title in') {{ $language->native }}"
                                            id="title-{{ $language->code }}"
                                            maxlength="255"
                                            value="{{ $seoPage->getTranslation('title', $language->code, false) }}"
                                        >
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-detail text-primary me-2"></i>
                                        @lang('l.Meta Description') ({{ $language->native }})
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <textarea
                                            class="form-control translation-input"
                                            name="description-{{ $language->code }}"
                                            rows="3"
                                            required
                                            placeholder="@lang('l.Enter description in') {{ $language->native }}"
                                            id="description-{{ $language->code }}"
                                            maxlength="500"
                                        >{{ $seoPage->getTranslation('description', $language->code, false) }}</textarea>
                                        <div class="textarea-counter">
                                            <span id="description-count-{{ $language->code }}">0</span>/500
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-tag text-primary me-2"></i>
                                        @lang('l.Meta Keywords') ({{ $language->native }})
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <textarea
                                            class="form-control translation-input"
                                            name="keywords-{{ $language->code }}"
                                            rows="2"
                                            required
                                            placeholder="@lang('l.Enter keywords in') {{ $language->native }}"
                                            id="meta_keywords-{{ $language->code }}"
                                            maxlength="500"
                                        >{{ $seoPage->getTranslation('keywords', $language->code, false) }}</textarea>
                                        <div class="textarea-counter">
                                            <span id="keywords-count-{{ $language->code }}">0</span>/500
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-share-alt text-primary me-2"></i>
                                        @lang('l.OG Title') ({{ $language->native }})
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <input
                                            type="text"
                                            class="form-control translation-input"
                                            name="og_title-{{ $language->code }}"
                                            required
                                            placeholder="@lang('l.Enter OG title in') {{ $language->native }}"
                                            id="og_title-{{ $language->code }}"
                                            maxlength="255"
                                            value="{{ $seoPage->getTranslation('og_title', $language->code, false) }}"
                                        >
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-detail text-primary me-2"></i>
                                        @lang('l.OG Description') ({{ $language->native }})
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <textarea
                                            class="form-control translation-input"
                                            name="og_description-{{ $language->code }}"
                                            rows="3"
                                            required
                                            placeholder="@lang('l.Enter OG description in') {{ $language->native }}"
                                            id="og_description-{{ $language->code }}"
                                            maxlength="500"
                                        >{{ $seoPage->getTranslation('og_description', $language->code, false) }}</textarea>
                                        <div class="textarea-counter">
                                            <span id="og_description-count-{{ $language->code }}">0</span>/500
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('dashboard.admins.seo') }}" class="btn btn-outline-secondary me-2">
                        <i class="bx bx-x me-1"></i> @lang('l.Cancel')
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> @lang('l.Save Translations')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // تحديث عدادات النصوص
        function updateTextCounter(element) {
            const id = $(element).attr('id');
            if ($(element).is('textarea')) {
                const length = $(element).val().length;
                $(`#${id.replace(/(description|keywords|og_description)/, '$1-count')}`).text(length);
            }
        }

        // تحديث جميع العدادات عند تحميل الصفحة
        $('.translation-input').each(function() {
            updateTextCounter(this);
        });

        // تحديث العدادات عند الكتابة
        $('.translation-input').on('input', function() {
            updateTextCounter(this);
        });
    });
</script>
@endsection