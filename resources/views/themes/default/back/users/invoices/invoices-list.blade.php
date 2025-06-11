@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Invoices')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/themes/default/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">@lang('l.Invoices') /</span> @lang('l.Invoices List')
        </h4>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="invoice-list-table table border-top">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('l.Student')</th>
                            <th>@lang('l.Amount')</th>
                            <th>@lang('l.Payment Method')</th>
                            <th>@lang('l.Status')</th>
                            <th>@lang('l.Created Date')</th>
                            <th>@lang('l.Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>
                                    <a
                                        href="{{ route('dashboard.users.invoices-show', ['invoice_id' => encrypt($invoice->id)]) }}">
                                        #{{ $invoice->id }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2">
                                                <span
                                                    class="avatar-initial rounded-circle
                                                    bg-label-{{ $invoice->status == 'paid'
                                                        ? 'success'
                                                        : ($invoice->status == 'pending'
                                                            ? 'warning'
                                                            : ($invoice->status == 'failed'
                                                                ? 'danger'
                                                                : 'info')) }}">
                                                    {{ substr($invoice->user->firstname ?? 'U', 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="javascript:void(0)"
                                                class="text-body fw-medium">
                                                {{ $invoice->user->firstname }} {{ $invoice->user->lastname }} <small
                                                    class="text-muted"
                                                    style="font-size: 0.6rem; color: #e1d00f;">({{ $invoice->user->sid ?? '' }})</small>
                                            </a>
                                            <small class="text-muted">{{ $invoice->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($invoice->amount, 2) }}</td>
                                <td>{{ $invoice->payment_method }}</td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ $invoice->status == 'paid'
                                            ? 'success'
                                            : ($invoice->status == 'pending'
                                                ? 'warning'
                                                : ($invoice->status == 'failed'
                                                    ? 'danger'
                                                    : 'info')) }}">
                                        {{ __('l.' . ucfirst($invoice->status)) }}
                                    </span>
                                </td>
                                <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('dashboard.users.invoices-show', ['invoice_id' => encrypt($invoice->id)]) }}"
                                            class="btn btn-sm btn-icon">
                                            <i class="bx bx-show mx-1"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/themes/default/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.invoice-list-table').DataTable({
                responsive: true,
                order: [
                    [0, 'desc']
                ],
                language: {
                    search: '@lang('l.Search')',
                    lengthMenu: '@lang('l.Show _MENU_ entries')',
                    paginate: {
                        first: '@lang('l.First')',
                        last: '@lang('l.Last')',
                        next: '@lang('l.Next')',
                        previous: '@lang('l.Previous')'
                    }
                }
            });
        });
    </script>
@endsection
