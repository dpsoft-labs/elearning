@extends('themes.default.layouts.back.master')


@section('title')
    @lang('l.Payments Gateways List')
@endsection

@section('css')
    <style>
        .payment-gateway-icon {
            height: 140px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .status-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-active {
            background-color: #28a745;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
        }

        .status-inactive {
            background-color: #dc3545;
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.5);
        }

        .payment-gateway-icon img {
            max-height: 100px;
            width: auto;
            object-fit: contain;
            transition: transform 0.2s ease;
        }

        .card {
            height: 100%;
            transition: transform 0.2s ease;
            border-radius: 12px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .payment-details {
            background-color: rgba(0, 0, 0, 0.02);
            padding: 12px;
            border-radius: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">@lang('l.Payment Gateways') /</span> @lang('l.List')</h4>

        @can('show settings')
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            <div class="row g-4">
                @foreach ($payments->sortBy('order') as $method)
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100">
                            <div class="status-indicator {{ $method->status == '1' ? 'status-active' : 'status-inactive' }}">
                            </div>
                            <div class="payment-gateway-icon">
                                <img src="{{ asset($method->image) }}" alt="@lang('payment_methods.' . $method->name)" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3 capital">{{ Str::title($method->name) }}</h5>

                                <div class="payment-details">
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-muted">@lang('l.Status'):</span>
                                        @if ($method->status == '1')
                                            <span class="badge bg-success">@lang('l.Active')</span>
                                        @else
                                            <span class="badge bg-danger">@lang('l.Inactive')</span>
                                        @endif
                                    </div>

                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-muted">@lang('l.Fees'):</span>
                                        @if ($method->fees_type == 'fixed')
                                            <span>{{ $method->fees }} {{ strtoupper($settings['default_currency']) }}</span>
                                        @else
                                            <span>{{ $method->fees }}%</span>
                                        @endif
                                    </div>

                                    <p class="card-text text-muted small mb-3">
                                        {{ Str::limit($method->description, 75) }}
                                    </p>
                                </div>

                                @can('edit settings')
                                    <div class="text-center mt-3">
                                        <button data-bs-target="#model-{{ $method->name }}" data-bs-toggle="modal"
                                            title="@lang('l.Edit')" class="edit-{{ $method->name }} btn btn-info">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button data-bs-target="#model-translate-{{ $method->name }}" data-bs-toggle="modal"
                                            title="@lang('l.Translate')" class="translate-{{ $method->name }} btn btn-dark ">
                                            {{-- <i class="fa fa-language"></i> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <g fill="currentColor">
                                                    <path d="M7.75 2.75a.75.75 0 0 0-1.5 0v1.258a32.987 32.987 0 0 0-3.599.278a.75.75 0 1 0 .198 1.487A31.545 31.545 0 0 1 8.7 5.545A19.381 19.381 0 0 1 7 9.56a19.418 19.418 0 0 1-1.002-2.05a.75.75 0 0 0-1.384.577a20.935 20.935 0 0 0 1.492 2.91a19.613 19.613 0 0 1-3.828 4.154a.75.75 0 1 0 .945 1.164A21.116 21.116 0 0 0 7 12.331c.095.132.192.262.29.391a.75.75 0 0 0 1.194-.91a18.97 18.97 0 0 1-.59-.815a20.888 20.888 0 0 0 2.333-5.332c.31.031.618.068.924.108a.75.75 0 0 0 .198-1.487a32.832 32.832 0 0 0-3.599-.278V2.75Z"></path>
                                                    <path fill-rule="evenodd" d="M13 8a.75.75 0 0 1 .671.415l4.25 8.5a.75.75 0 1 1-1.342.67L15.787 16h-5.573l-.793 1.585a.75.75 0 1 1-1.342-.67l4.25-8.5A.75.75 0 0 1 13 8Zm2.037 6.5L13 10.427L10.964 14.5h4.073Z" clip-rule="evenodd"></path>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>

                    @can('edit settings')
                        <!--  مودل التعديل -->
                        <div class="modal fade" id="model-{{ $method->name }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role"
                                style="justify-content: center;">
                                <div class="modal-content p-3 p-md-5 col-md-8">
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="role-title mb-2">@lang('l.Edit') <span style="color:red;">
                                                    {{ strtoupper($method->name) }}</span>
                                            </h3>
                                        </div>
                                        <form id="addProductForm" class="row g-3" method="post" enctype="multipart/form-data"
                                            action="{{ route('dashboard.admins.payments-update') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <label class="form-label" for="status">@lang('l.Status')</label>
                                                    <select id="status" class="form-select" name="status" required>
                                                        <option value="1" {{ $method->status == 1 ? 'selected' : '' }}>
                                                            @lang('l.Active')
                                                        </option>
                                                        <option value="0" {{ $method->status == 0 ? 'selected' : '' }}>
                                                            @lang('l.Inactive')
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label class="form-label" for="fees_type">@lang('l.Fees Type')</label>
                                                    <select id="fees_type" class="form-select" name="fees_type" required>
                                                        <option value="percentage"
                                                            {{ $method->fees_type == 'percentage' ? 'selected' : '' }}>
                                                            @lang('l.Percentage')
                                                        </option>
                                                        <option value="fixed"
                                                            {{ $method->fees_type == 'fixed' ? 'selected' : '' }}>
                                                            @lang('l.Fixed')
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label class="form-label" for="fees">@lang('l.Fees Amount')</label>
                                                    <input type="text" id="fees" name="fees" class="form-control"
                                                        value="{{ $method->fees }}" placeholder="@lang('l.Enter a method fees or percentage')" />
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="description">@lang('l.Description')
                                                        <small class="text-muted">({{ $defaultLanguage->name }} <i
                                                                class="fi fi-{{ $defaultLanguage->flag }} rounded"></i>)</small>
                                                    </label>
                                                    <input type="text" id="description" name="description" class="form-control"
                                                        value="{{ $method->description }}" placeholder="@lang('l.Enter a method description')" />
                                                </div>
                                                @foreach ($method->settings as $setting)
                                                    <div class="col-12 mb-4">
                                                        <label class="form-label" for="{{ $setting->key }}">
                                                            @if ($setting->key == 'CASH_ON_DELIVERY')
                                                                @lang('l.Cash on Delivery static Fee')
                                                            @else
                                                                {{ $setting->key }}
                                                            @endif
                                                        </label>
                                                        <input type="text" id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                            class="form-control" value="{{ $setting->value }}"
                                                            placeholder="@lang('l.Enter a method') {{ $setting->key }}" />
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="id" value="{{ encrypt($method->id) }}">
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                                    @lang('l.Submit')
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  مودل الترجمة -->
                        <div class="modal fade" id="model-translate-{{ $method->name }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role"
                                style="justify-content: center;">
                                <div class="modal-content p-3 p-md-5 col-md-8">
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="role-title mb-2">@lang('l.Translate') <span style="color:red;">
                                                    {{ strtoupper($method->name) }}</span>
                                            </h3>
                                        </div>
                                        <form id="addProductForm" class="row g-3" method="post" enctype="multipart/form-data"
                                            action="{{ route('dashboard.admins.payments-translate') }}">
                                            @csrf
                                            <div class="row">
                                                @foreach ($headerLanguages->where('code', '!=', $settings['default_language']) as $language)
                                                    <div class="col-md-12 mb-4">
                                                        <label class="form-label" for="description-{{ $language->code }}">@lang('l.Description')
                                                            <small class="text-muted">({{ $language->name }} <i
                                                                    class="fi fi-{{ $language->flag }} rounded"></i>)</small>
                                                        </label>
                                                        <textarea id="description-{{ $language->code }}"
                                                            name="description-{{ $language->code }}"
                                                            class="form-control"
                                                            placeholder="@lang('l.Enter a method description')">{{ $method->getTranslation('description', $language->code) }}</textarea>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="id" value="{{ encrypt($method->id) }}">
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                                    @lang('l.Submit')
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                @endforeach
            </div>
        @endcan
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Button = document.querySelector('.edit{{ $method->name }}');
            const Modal = document.querySelector('#model-{{ $method->name }}');
            const Button2 = document.querySelector('.translate{{ $method->name }}');
            const Modal2 = document.querySelector('#model-translate-{{ $method->name }}');

            Button.addEventListener('click', function() {
                var modal = new bootstrap.Modal(Modal);
                modal.show();
            });

            Button2.addEventListener('click', function() {
                var modal = new bootstrap.Modal(Modal2);
                modal.show();
            });
        });
    </script>
@endsection
