@extends('themes.default.layouts.back.master')

@section('title')
@lang('l.title')
@endsection

@section('seo')
@endsection

@section('css')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl-8 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">@lang('l.welcome_message')</h5>
                            <p class="mb-6">
                                @lang('l.stats_message')
                            </p>

                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                            <img src="{{ asset('assets/themes/default/img/illustrations/man-with-laptop.png') }}"
                                height="175" class="scaleX-n1-rtl" alt="University Statistics" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body pb-4">
                            <span class="d-block fw-medium mb-1">@lang('l.total_students')</span>
                            <h4 class="card-title mb-0">15,234</h4>
                        </div>
                        <div id="orderChart" class="pb-3"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/themes/default/img/icons/unicons/wallet-info.png') }}"
                                        alt="faculty info" class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">@lang('l.view_more')</a>
                                        <a class="dropdown-item" href="javascript:void(0);">@lang('l.delete')</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">@lang('l.total_faculty')</p>
                            <h4 class="card-title mb-3">1,234</h4>
                            <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i>
                                +12.5%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-lg-8">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">@lang('l.enrollment_trends')</h5>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="totalRevenue"
                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded bx-lg text-muted"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="totalRevenue">
                                    <a class="dropdown-item" href="javascript:void(0);">@lang('l.select_all')</a>
                                    <a class="dropdown-item" href="javascript:void(0);">@lang('l.refresh')</a>
                                    <a class="dropdown-item" href="javascript:void(0);">@lang('l.share')</a>
                                </div>
                            </div>
                        </div>
                        <div id="totalRevenueChart" class="px-3"></div>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center">
                        <div class="card-body px-xl-9">
                            <div class="text-center mb-6">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-label-primary">
                                        <script>
                                            document.write(new Date().getFullYear() - 1);
                                        </script>
                                    </button>
                                    <button type="button"
                                        class="btn btn-label-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0);">2023</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">2022</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">2020</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div id="growthChart"></div>
                            <div class="text-center fw-medium my-6">@lang('l.growth_rate') 15%</div>

                            <div class="d-flex gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded-2 bg-label-primary"><i
                                                class="bx bx-user bx-lg text-primary"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>
                                            <script>
                                                document.write(new Date().getFullYear() - 1);
                                            </script>
                                        </small>
                                        <h6 class="mb-0">12,234</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Revenue -->
        <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2">
            <div class="row">
                <div class="col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/themes/default/img/icons/unicons/paypal.png') }}"
                                        alt="research" class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded text-muted"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="javascript:void(0);">@lang('l.view_more')</a>
                                        <a class="dropdown-item" href="javascript:void(0);">@lang('l.delete')</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">@lang('l.research_projects')</p>
                            <h4 class="card-title mb-3">234</h4>
                            <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body pb-0">
                            <span class="d-block fw-medium mb-1">@lang('l.international_students')</span>
                            <h4 class="card-title mb-0 mb-lg-4">1,234</h4>
                            <div id="revenueChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-sm-row flex-column gap-10">
                                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                    <div class="card-title mb-6">
                                        <h5 class="text-nowrap mb-1">@lang('l.academic_performance')</h5>
                                        <span class="badge bg-label-warning">@lang('l.year') 2025</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <span class="text-success text-nowrap fw-medium"><i class="bx bx-up-arrow-alt"></i>
                                            92.5%</span>
                                        <h4 class="mb-0">@lang('l.graduation_rate')</h4>
                                    </div>
                                </div>
                                <div id="profileReportChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Department Statistics -->
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">@lang('l.department_statistics')</h5>
                        <p class="card-subtitle">@lang('l.total_departments') 12</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn text-muted p-0" type="button" id="orederStatistics"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="orederStatistics">
                            <a class="dropdown-item" href="javascript:void(0);">@lang('l.select_all')</a>
                            <a class="dropdown-item" href="javascript:void(0);">@lang('l.refresh')</a>
                            <a class="dropdown-item" href="javascript:void(0);">@lang('l.share')</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h3 class="mb-1">12</h3>
                            <small>@lang('l.total_departments')</small>
                        </div>
                        <div id="orderStatisticsChart"></div>
                    </div>
                    <ul class="p-0 m-0">
                        <li class="d-flex align-items-center mb-5">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-code-alt"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">@lang('l.computer_science')</h6>
                                    <small>@lang('l.students') 1,234</small>
                                </div>
                                <div class="user-progress">
                                    <h6 class="mb-0">45%</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-building"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">@lang('l.business')</h6>
                                    <small>@lang('l.students') 2,345</small>
                                </div>
                                <div class="user-progress">
                                    <h6 class="mb-0">35%</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-book"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">@lang('l.engineering')</h6>
                                    <small>@lang('l.students') 1,567</small>
                                </div>
                                <div class="user-progress">
                                    <h6 class="mb-0">25%</h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-heart"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">@lang('l.medicine')</h6>
                                    <small>@lang('l.students') 987</small>
                                </div>
                                <div class="user-progress">
                                    <h6 class="mb-0">15%</h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Department Statistics -->

        <!-- Academic Performance -->
        <div class="col-md-6 col-lg-4 order-1 mb-6">
            <div class="card h-100">
                <div class="card-header nav-align-top">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab"
                                data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income"
                                aria-controls="navs-tabs-line-card-income" aria-selected="true">
                                @lang('l.undergraduate')
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income"
                            role="tabpanel">
                            <div class="d-flex mb-6">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="{{ asset('assets/themes/default/img/icons/unicons/wallet-primary.png') }}"
                                        alt="User" />
                                </div>
                                <div>
                                    <p class="mb-0">@lang('l.total_enrollment')</p>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1">12,345</h6>
                                        <small class="text-success fw-medium">
                                            <i class="bx bx-chevron-up bx-lg"></i>
                                            15.8%
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div id="incomeChart"></div>
                            <div class="d-flex align-items-center justify-content-center mt-6 gap-3">
                                <div class="flex-shrink-0">
                                    <div id="expensesOfWeek"></div>
                                </div>
                                <div>
                                    <h6 class="mb-0">@lang('l.current_semester')</h6>
                                    <small>@lang('l.increase_rate') 8.5%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Academic Performance -->

        <!-- Recent Activities -->
        <div class="col-md-6 col-lg-4 order-2 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">@lang('l.recent_activities')</h5>
                    <div class="dropdown">
                        <button class="btn text-muted p-0" type="button" id="transactionID"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">@lang('l.last_28_days')</a>
                            <a class="dropdown-item" href="javascript:void(0);">@lang('l.last_month')</a>
                            <a class="dropdown-item" href="javascript:void(0);">@lang('l.last_year')</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <ul class="p-0 m-0">
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/default/img/icons/unicons/paypal.png') }}" alt="User"
                                    class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">@lang('l.new_course')</small>
                                    <h6 class="fw-normal mb-0">@lang('l.artificial_intelligence')</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">+120</h6>
                                    <span class="text-muted">@lang('l.students')</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/default/img/icons/unicons/wallet.png') }}" alt="User"
                                    class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">@lang('l.research_grant')</small>
                                    <h6 class="fw-normal mb-0">@lang('l.medical_research')</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">$250k</h6>
                                    <span class="text-muted">@lang('l.funding')</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/default/img/icons/unicons/chart.png') }}" alt="User"
                                    class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">@lang('l.conference')</small>
                                    <h6 class="fw-normal mb-0">@lang('l.international_conference')</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <h6 class="fw-normal mb-0">+45</h6>
                                    <span class="text-muted">@lang('l.participants')</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Recent Activities -->
    </div>
</div>
@endsection

@section('js')
@endsection






