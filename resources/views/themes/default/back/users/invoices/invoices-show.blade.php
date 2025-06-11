@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Invoice') #{{ $invoice->id }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
                <div class="card invoice-preview-card p-sm-12 p-6">
                    <div class="card-body invoice-preview-header rounded">
                        <div
                            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column align-items-xl-center align-items-md-start align-items-sm-center align-items-start">
                            <div class="mb-xl-0 mb-6 text-heading">
                                <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
                                    <span class="app-brand-logo demo">
                                        <span class="text-primary">
                                            <img src="{{ asset($settings['logo'] ?? 'assets/images/logo/logo.png') }}" alt="Logo" height="40">
                                        </span>
                                    </span>
                                </div>
                                <p class="mb-2">{{ $settings['address'] ?? '' }}</p>
                                {{-- <p class="mb-2">{{ $settings['city'] ?? '' }}, {{ $settings['country'] ?? '' }}</p> --}}
                                <p class="mb-0">{{ $settings['phone1'] ?? '' }}, {{ $settings['email1'] ?? '' }}</p>
                            </div>
                            <div>
                                <h5 class="mb-6">@lang('l.Invoice') #{{ $invoice->id }}</h5>
                                <div class="mb-1 text-heading">
                                    <span>@lang('l.Date Issues'):</span>
                                    <span class="fw-medium">{{ $invoice->created_at->format('Y-m-d') }}</span>
                                </div>
                                @if($invoice->paid_at)
                                <div class="text-heading">
                                    <span>@lang('l.Date Paid'):</span>
                                    <span class="fw-medium">{{ $invoice->paid_at }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="row">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                                <h6>@lang('l.Student Information'):</h6>
                                <p class="mb-1">{{ $invoice->user->fullName() }}</p>
                                <p class="mb-1">{{ $invoice->user->college->name ?? '' }}</p>
                                <p class="mb-1">{{ $invoice->user->branch->name ?? '' }}</p>
                                <p class="mb-1">{{ $invoice->user->phone ?? '' }}</p>
                                <p class="mb-0">{{ $invoice->user->email }}</p>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <h6>@lang('l.Invoice Details'):</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4">@lang('l.Total Amount'):</td>
                                            <td class="fw-medium">{{ number_format($invoice->amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">@lang('l.Payment Method'):</td>
                                            <td>{{ ucfirst($invoice->payment_method) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">@lang('l.Status'):</td>
                                            <td>
                                                <span class="badge bg-label-{{ $invoice->status == 'paid' ? 'success' :
                                                                ($invoice->status == 'pending' ? 'warning' :
                                                                ($invoice->status == 'failed' ? 'danger' : 'info')) }}">
                                                    {{ __('l.' . ucfirst($invoice->status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">@lang('l.Transaction ID'):</td>
                                            <td>{{ $invoice->pid }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive border border-bottom-0 border-top-0 rounded">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>@lang('l.Course Code')</th>
                                    <th>@lang('l.Course Name')</th>
                                    <th>@lang('l.Hours')</th>
                                    <th>@lang('l.Hour Price')</th>
                                    <th>@lang('l.Total')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->details['courses'] ?? [] as $course)
                                <tr>
                                    <td class="text-nowrap text-heading">{{ $course['code'] }}</td>
                                    <td class="text-nowrap">{{ $course['name'] }}</td>
                                    <td>{{ $course['hours'] }}</td>
                                    <td>{{ number_format($invoice->details['hours_info']['hour_price'] ?? 0, 2) }}</td>
                                    <td>{{ number_format($course['price'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-borderless">
                            <tbody>
                                <tr>
                                    <td class="align-top pe-6 ps-0 py-6 text-body">
                                        <p class="mb-1">
                                            <span class="me-2 h6">@lang('l.Status'):</span>
                                            <span class="badge bg-label-{{ $invoice->status == 'paid' ? 'success' :
                                                                ($invoice->status == 'pending' ? 'warning' :
                                                                ($invoice->status == 'failed' ? 'danger' : 'info')) }}">
                                                {{ __('l.' . ucfirst($invoice->status)) }}
                                            </span>
                                        </p>
                                        <span>@lang('l.Thank you for your registration')</span>
                                    </td>
                                    <td class="px-0 py-6 w-px-100">
                                        <p class="mb-2">@lang('l.Subtotal'):</p>
                                        @foreach($invoice->details['taxes_info'] ?? [] as $tax)
                                        <p class="mb-2">{{ $tax['tax_name'] }}:</p>
                                        @endforeach
                                        <p class="mb-2 border-bottom pb-2">@lang('l.Total Taxes'):</p>
                                        <p class="mb-0">@lang('l.Total'):</p>
                                    </td>
                                    <td class="text-end px-0 py-6 w-px-100 fw-medium text-heading">
                                        <p class="fw-medium mb-2">{{ number_format($invoice->details['hours_info']['total_hours_price'] ?? 0, 2) }}</p>
                                        @foreach($invoice->details['taxes_info'] ?? [] as $tax)
                                        <p class="fw-medium mb-2">{{ number_format($tax['tax_amount'], 2) }}
                                            @if($tax['tax_type'] == 'percentage') ({{ $tax['tax_rate'] }}%) @endif
                                        </p>
                                        @endforeach
                                        <p class="fw-medium mb-2 border-bottom pb-2">{{ number_format($invoice->details['total_tax_amount'] ?? 0, 2) }}</p>
                                        <p class="fw-medium mb-0">{{ number_format($invoice->amount, 2) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="mt-0 mb-6" />
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-medium text-heading">@lang('l.Note'):</span>
                                <span>@lang('l.This invoice is automatically generated upon course registration. If you have any questions, please contact the student affairs department.')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        @if($invoice->status == 'pending')
                        <a href="javascript:void(0)" class="btn btn-primary d-grid w-100 mb-4">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                {!! $invoice->link !!}
                                {{-- <i class="bx bx-credit-card me-2"></i>@lang('l.Pay Now') --}}
                            </span>
                        </a>
                        @endif
                        <button class="btn btn-label-secondary d-grid w-100 mb-4" onclick="window.print()">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-download me-2"></i>@lang('l.Download')
                            </span>
                        </button>
                        <button class="btn btn-label-secondary d-grid w-100" onclick="window.print()">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-printer me-2"></i>@lang('l.Print')
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </div>
    <!--/ Content -->
@endsection

@section('js')
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
@endsection
