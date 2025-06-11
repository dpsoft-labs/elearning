<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Money Statistics'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h4 class="fw-bold py-3 mb-4">
                    <span class="text-muted fw-light"><?php echo app('translator')->get('l.Statistics'); ?> /</span> <?php echo app('translator')->get('l.Money Statistics'); ?>
                </h4>
            </div>
        </div>

        <!-- البطاقات الإحصائية -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0"><?php echo app('translator')->get('l.Total Revenue'); ?></h6>
                                <h3 class="mt-2 mb-0"><?php echo e(number_format($totalRevenue, 2)); ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-content bg-success">
                                    <i class="fas fa-money-bill-wave text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0"><?php echo app('translator')->get('l.Current Month Revenue'); ?></h6>
                                <h3 class="mt-2 mb-0"><?php echo e(number_format($currentMonthRevenue, 2)); ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-content bg-primary">
                                    <i class="fas fa-calendar-alt text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0"><?php echo app('translator')->get('l.Pending Payments'); ?></h6>
                                <h3 class="mt-2 mb-0"><?php echo e(number_format($pendingPayments, 2)); ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-content bg-warning">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0"><?php echo app('translator')->get('l.Failed Payments'); ?></h6>
                                <h3 class="mt-2 mb-0"><?php echo e(number_format($failedPayments, 2)); ?></h3>
                            </div>
                            <div class="avatar">
                                <div class="avatar-content bg-danger">
                                    <i class="fas fa-times-circle text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسوم البيانية -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><?php echo app('translator')->get('l.Last 6 Months Revenue'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div id="monthlyRevenueChart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><?php echo app('translator')->get('l.Payment Methods'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div id="paymentMethodsChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.min.js"></script>
    <script>
        // رسم بياني للإيرادات الشهرية
        var monthlyRevenueOptions = {
            series: [{
                name: 'الإيرادات',
                data: <?php echo json_encode($monthlyRevenue->pluck('total'), 15, 512) ?>
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: <?php echo json_encode($monthlyRevenue->map(function($item) {
                    return Carbon\Carbon::createFromDate($item->year, $item->month, 1)->format('M Y');
                })) ?>
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toFixed(2) + ""
                    }
                }
            }
        };

        var monthlyRevenueChart = new ApexCharts(document.querySelector("#monthlyRevenueChart"), monthlyRevenueOptions);
        monthlyRevenueChart.render();

        // رسم بياني لطرق الدفع
        var paymentMethodsOptions = {
            series: <?php echo json_encode($paymentMethods->pluck('total'), 15, 512) ?>,
            chart: {
                type: 'donut',
                height: 350
            },
            labels: <?php echo json_encode($paymentMethods->pluck('payment_method'), 15, 512) ?>,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var paymentMethodsChart = new ApexCharts(document.querySelector("#paymentMethodsChart"), paymentMethodsOptions);
        paymentMethodsChart.render();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/statistics/money/money-statistics.blade.php ENDPATH**/ ?>