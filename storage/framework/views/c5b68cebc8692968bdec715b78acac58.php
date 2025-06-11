<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Google Analytics'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.1/apexcharts.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.11.0/css/flag-icons.min.css">
    <style>
        .chart-card {
            min-height: 385px; /* Adjusted height */
        }
        .table-responsive {
            max-height: 350px; /* Add scroll for long tables */
        }
        .nav-pills .nav-link.active,
        .nav-pills .show > .nav-link {
            background-color: var(--bs-primary) !important;
            color: var(--bs-white) !important;
        }
        .card-header .nav-pills {
            margin-bottom: -1rem; /* Adjust alignment */
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold mb-0"><?php echo app('translator')->get('l.Google Analytics'); ?></h4>
            <?php if($google != null): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show visitors_statistics')): ?>
                    <div class="btn-group" id="period-selector">
                        <button type="button" class="btn btn-sm btn-label-primary <?php if(isset($_GET['period']) && $_GET['period'] == 7): ?> active <?php endif; ?>" data-period="7">7 <?php echo app('translator')->get('l.Days'); ?></button>
                        <button type="button" class="btn btn-sm btn-label-primary <?php if(!isset($_GET['period']) || $_GET['period'] == 30): ?> active <?php endif; ?>" data-period="30">30 <?php echo app('translator')->get('l.Days'); ?></button>
                        <button type="button" class="btn btn-sm btn-label-primary <?php if(isset($_GET['period']) && $_GET['period'] == 90): ?> active <?php endif; ?>" data-period="90">90 <?php echo app('translator')->get('l.Days'); ?></button>
                        <button type="button" class="btn btn-sm btn-label-primary <?php if(isset($_GET['period']) && $_GET['period'] == 180): ?> active <?php endif; ?>" data-period="180">180 <?php echo app('translator')->get('l.Days'); ?></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="mb-0"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($google != null): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                <div class="alert alert-info d-flex justify-content-between align-items-center mb-4 alert-dismissible fade show" role="alert">
                    <span><?php echo app('translator')->get('l.Google Analytics is currently enabled. Disabling this feature will stop Google Analytics visitor data'); ?></span>
                    <div>
                        <form id="disable-form" action="<?php echo e(route('dashboard.admins.statistics-google-status')); ?>" method="post" style="display: none;"><?php echo csrf_field(); ?></form>
                        <button type="button" onclick="confirmDisable()" class="btn btn-sm btn-danger me-2"><?php echo app('translator')->get('l.Disable Google Analytics'); ?></button>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show visitors_statistics')): ?>
                <div class="row g-4">
                    <!-- Overview Statistics -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="avatar avatar-md mx-auto mb-2">
                                    <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-user fs-4"></i></span>
                                </div>
                                <h6 class="mb-1"><?php echo app('translator')->get('l.Total Active Users'); ?></h6>
                                <h4 class="mb-0"><?php echo e($analyticsData['metrics']->first()['activeUsers']); ?></h4>
                                <small class="text-muted"><?php echo app('translator')->get('l.New Users'); ?>: <?php echo e($analyticsData['metrics']->first()['newUsers']); ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="avatar avatar-md mx-auto mb-2">
                                    <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-show fs-4"></i></span>
                                </div>
                                <h6 class="mb-1"><?php echo app('translator')->get('l.Total Page Views'); ?></h6>
                                <h4 class="mb-0"><?php echo e($analyticsData['totalVisitors']->sum('screenPageViews')); ?></h4>
                                <small class="text-muted"><?php echo app('translator')->get('l.Views Per Session'); ?>: <?php echo e(number_format($analyticsData['metrics']->first()['screenPageViewsPerSession'], 1)); ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="avatar avatar-md mx-auto mb-2">
                                    <span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-time-five fs-4"></i></span>
                                </div>
                                <h6 class="mb-1"><?php echo app('translator')->get('l.Avg. Session Duration'); ?></h6>
                                <h4 class="mb-0"><?php echo e(gmdate("i:s", $analyticsData['metrics']->first()['averageSessionDuration'] ?? 0)); ?></h4>
                                <small class="text-muted"><?php echo app('translator')->get('l.Engagement Rate'); ?>: <?php echo e(number_format($analyticsData['metrics']->first()['engagementRate'] * 100, 1)); ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="avatar avatar-md mx-auto mb-2">
                                    <span class="avatar-initial rounded-circle bg-label-warning"><i class="bx bx-line-chart fs-4"></i></span>
                                </div>
                                <h6 class="mb-1"><?php echo app('translator')->get('l.Bounce Rate'); ?></h6>
                                <h4 class="mb-0"><?php echo e(number_format(($analyticsData['metrics']->first()['bounceRate'] ?? 0) * 100, 2)); ?>%</h4>
                                <small class="text-muted"><?php echo app('translator')->get('l.Sessions Per User'); ?>: <?php echo e(number_format($analyticsData['metrics']->first()['sessionsPerUser'], 1)); ?></small>
                            </div>
                        </div>
                    </div>

                    <!-- Browsers & Countries -->
                    <div class="col-lg-5">
                        <div class="card text-center h-100">
                            <div class="card-header nav-align-top">
                                <ul class="nav nav-pills card-header-pills" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-pills-browser"
                                            aria-controls="navs-pills-browser" aria-selected="true">
                                            <i class="bx bxl-chrome me-1"></i> <?php echo app('translator')->get('l.Top Browsers'); ?>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-country" aria-controls="navs-pills-country"
                                            aria-selected="false">
                                            <i class="bx bx-globe me-1"></i> <?php echo app('translator')->get('l.Top Countries'); ?>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="navs-pills-browser" role="tabpanel">
                                    <div class="table-responsive text-start text-nowrap">
                                        <table class="table table-borderless card-table">
                                            <tbody>
                                                <?php
                                                    $totalBrowserViews = $analyticsData['topBrowsers']->sum('screenPageViews');
                                                    $browserIcons = [
                                                        'chrome' => 'chrome.png',
                                                        'safari' => 'safari.png',
                                                        'firefox' => 'firefox.png',
                                                        'edge' => 'edge.png',
                                                        'opera' => 'opera.png',
                                                        'internet explorer' => 'social-label.png',
                                                        'samsung internet' => 'social-label.png',
                                                        'android' => 'android.png',
                                                        'uc browser' => 'uc.png',
                                                    ];
                                                    $colorClasses = ['bg-success', 'bg-primary', 'bg-info', 'bg-warning', 'bg-danger', 'bg-secondary', 'bg-dark'];
                                                ?>

                                                <?php $__empty_1 = true; $__currentLoopData = $analyticsData['topBrowsers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $browser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php
                                                        $percentage = $totalBrowserViews > 0 ? ($browser['screenPageViews'] / $totalBrowserViews) * 100 : 0;
                                                        $iconFile = strtolower($browser['browser']);
                                                        $icon = $browserIcons[$iconFile] ?? 'social-label.png'; // Fallback icon
                                                        $colorClass = $colorClasses[$index % count($colorClasses)];
                                                    ?>
                                                    <tr>
                                                        <td style="width: 5%;"><small><?php echo e($index + 1); ?></small></td>
                                                        <td style="width: 30%;">
                                                            <div class="d-flex align-items-center">
                                                                <img src="<?php echo e(asset('assets/themes/default/img/icons/brands/' . $icon)); ?>"
                                                                    alt="<?php echo e($browser['browser']); ?>" height="24" class="me-2 rounded-circle" />
                                                                <span class="text-heading text-truncate"><?php echo e($browser['browser']); ?></span>
                                                            </div>
                                                        </td>
                                                        <td style="width: 15%;" class="text-end"><small><?php echo e($browser['screenPageViews']); ?></small></td>
                                                        <td style="width: 50%;">
                                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                                 <small class="fw-medium"><?php echo e(number_format($percentage, 1)); ?>%</small>
                                                                <div class="progress w-75" style="height: 6px;">
                                                                    <div class="progress-bar <?php echo e($colorClass); ?>"
                                                                        role="progressbar" style="width: <?php echo e($percentage); ?>%"
                                                                        aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                            </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr><td colspan="4" class="text-center py-3"><?php echo app('translator')->get('l.No data available'); ?></td></tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                        </div>
                    </div>
                                <div class="tab-pane fade" id="navs-pills-country" role="tabpanel">
                                    <div class="table-responsive text-start text-nowrap">
                                        <table class="table table-borderless card-table">
                                            <tbody>
                                                <?php
                                                    $totalCountryViews = $analyticsData['topCountries']->sum('screenPageViews');
                                                    $colorClasses = ['bg-success', 'bg-primary', 'bg-info', 'bg-warning', 'bg-danger', 'bg-secondary', 'bg-dark'];
                                                ?>

                                                <?php $__empty_1 = true; $__currentLoopData = $analyticsData['topCountries']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php
                                                        $percentage = $totalCountryViews > 0 ? ($country['screenPageViews'] / $totalCountryViews) * 100 : 0;
                                                        $colorClass = $colorClasses[$index % count($colorClasses)];
                                                        // تحويل رمز الدولة إلى التنسيق المطلوب لمكتبة الأعلام
                                                        $countryCode = isset($country['countryIsoCode']) && $country['countryIsoCode'] !== '(not set)'
                                                            ? strtolower($country['countryIsoCode'])
                                                            : null;

                                                        // إذا كان الرمز غير موجود، نحاول استخراجه من اسم الدولة
                                                        if (!$countryCode && isset($country['country'])) {
                                                            $countryName = $country['country'];
                                                            // قائمة الدول وأكوادها
                                                            $countryCodes = [
                                                                'United States' => 'us',
                                                                'United Kingdom' => 'gb',
                                                                'Saudi Arabia' => 'sa',
                                                                'United Arab Emirates' => 'ae',
                                                                'Kuwait' => 'kw',
                                                                'Qatar' => 'qa',
                                                                'Bahrain' => 'bh',
                                                                'Oman' => 'om',
                                                                'Egypt' => 'eg',
                                                                'Jordan' => 'jo',
                                                                'Lebanon' => 'lb',
                                                                'Iraq' => 'iq',
                                                                'Syria' => 'sy',
                                                                'Yemen' => 'ye',
                                                                'Palestine' => 'ps',
                                                                'Morocco' => 'ma',
                                                                'Algeria' => 'dz',
                                                                'Tunisia' => 'tn',
                                                                'Libya' => 'ly',
                                                                'Sudan' => 'sd',
                                                                'Türkiye' => 'tr',
                                                                'Iran' => 'ir',
                                                                'Pakistan' => 'pk',
                                                                'India' => 'in',
                                                                'China' => 'cn',
                                                                'Japan' => 'jp',
                                                                'South Korea' => 'kr',
                                                                'Russia' => 'ru',
                                                                'Germany' => 'de',
                                                                'France' => 'fr',
                                                                'Italy' => 'it',
                                                                'Spain' => 'es',
                                                                'Canada' => 'ca',
                                                                'Australia' => 'au',
                                                                'Brazil' => 'br',
                                                                'Mexico' => 'mx',
                                                                'Argentina' => 'ar',
                                                                'South Africa' => 'za',
                                                                'Afghanistan' => 'af',
                                                                'Albania' => 'al',
                                                                'Andorra' => 'ad',
                                                                'Angola' => 'ao',
                                                                'Antigua and Barbuda' => 'ag',
                                                                'Armenia' => 'am',
                                                                'Austria' => 'at',
                                                                'Azerbaijan' => 'az',
                                                                'Bahamas' => 'bs',
                                                                'Bangladesh' => 'bd',
                                                                'Barbados' => 'bb',
                                                                'Belarus' => 'by',
                                                                'Belgium' => 'be',
                                                                'Belize' => 'bz',
                                                                'Benin' => 'bj',
                                                                'Bhutan' => 'bt',
                                                                'Bolivia' => 'bo',
                                                                'Bosnia and Herzegovina' => 'ba',
                                                                'Botswana' => 'bw',
                                                                'Brunei' => 'bn',
                                                                'Bulgaria' => 'bg',
                                                                'Burkina Faso' => 'bf',
                                                                'Burundi' => 'bi',
                                                                'Cambodia' => 'kh',
                                                                'Cameroon' => 'cm',
                                                                'Cape Verde' => 'cv',
                                                                'Central African Republic' => 'cf',
                                                                'Chad' => 'td',
                                                                'Chile' => 'cl',
                                                                'Colombia' => 'co',
                                                                'Comoros' => 'km',
                                                                'Congo' => 'cg',
                                                                'Costa Rica' => 'cr',
                                                                'Croatia' => 'hr',
                                                                'Cuba' => 'cu',
                                                                'Cyprus' => 'cy',
                                                                'Czech Republic' => 'cz',
                                                                'Denmark' => 'dk',
                                                                'Djibouti' => 'dj',
                                                                'Dominica' => 'dm',
                                                                'Dominican Republic' => 'do',
                                                                'East Timor' => 'tl',
                                                                'Ecuador' => 'ec',
                                                                'El Salvador' => 'sv',
                                                                'Equatorial Guinea' => 'gq',
                                                                'Eritrea' => 'er',
                                                                'Estonia' => 'ee',
                                                                'Ethiopia' => 'et',
                                                                'Fiji' => 'fj',
                                                                'Finland' => 'fi',
                                                                'Gabon' => 'ga',
                                                                'Gambia' => 'gm',
                                                                'Georgia' => 'ge',
                                                                'Ghana' => 'gh',
                                                                'Greece' => 'gr',
                                                                'Grenada' => 'gd',
                                                                'Guatemala' => 'gt',
                                                                'Guinea' => 'gn',
                                                                'Guinea-Bissau' => 'gw',
                                                                'Guyana' => 'gy',
                                                                'Haiti' => 'ht',
                                                                'Honduras' => 'hn',
                                                                'Hungary' => 'hu',
                                                                'Iceland' => 'is',
                                                                'Indonesia' => 'id',
                                                                'Ireland' => 'ie',
                                                                'Israel' => 'il',
                                                                'Ivory Coast' => 'ci',
                                                                'Jamaica' => 'jm',
                                                                'Kazakhstan' => 'kz',
                                                                'Kenya' => 'ke',
                                                                'Kiribati' => 'ki',
                                                                'North Korea' => 'kp',
                                                                'Kosovo' => 'xk',
                                                                'Kyrgyzstan' => 'kg',
                                                                'Laos' => 'la',
                                                                'Latvia' => 'lv',
                                                                'Lesotho' => 'ls',
                                                                'Liberia' => 'lr',
                                                                'Liechtenstein' => 'li',
                                                                'Lithuania' => 'lt',
                                                                'Luxembourg' => 'lu',
                                                                'Macedonia' => 'mk',
                                                                'Madagascar' => 'mg',
                                                                'Malawi' => 'mw',
                                                                'Malaysia' => 'my',
                                                                'Maldives' => 'mv',
                                                                'Mali' => 'ml',
                                                                'Malta' => 'mt',
                                                                'Marshall Islands' => 'mh',
                                                                'Mauritania' => 'mr',
                                                                'Mauritius' => 'mu',
                                                                'Micronesia' => 'fm',
                                                                'Moldova' => 'md',
                                                                'Monaco' => 'mc',
                                                                'Mongolia' => 'mn',
                                                                'Montenegro' => 'me',
                                                                'Mozambique' => 'mz',
                                                                'Myanmar' => 'mm',
                                                                'Namibia' => 'na',
                                                                'Nauru' => 'nr',
                                                                'Nepal' => 'np',
                                                                'Netherlands' => 'nl',
                                                                'New Zealand' => 'nz',
                                                                'Nicaragua' => 'ni',
                                                                'Niger' => 'ne',
                                                                'Nigeria' => 'ng',
                                                                'Norway' => 'no',
                                                                'Panama' => 'pa',
                                                                'Papua New Guinea' => 'pg',
                                                                'Paraguay' => 'py',
                                                                'Peru' => 'pe',
                                                                'Philippines' => 'ph',
                                                                'Poland' => 'pl',
                                                                'Portugal' => 'pt',
                                                                'Romania' => 'ro',
                                                                'Rwanda' => 'rw',
                                                                'Saint Kitts and Nevis' => 'kn',
                                                                'Saint Lucia' => 'lc',
                                                                'Saint Vincent and the Grenadines' => 'vc',
                                                                'Samoa' => 'ws',
                                                                'San Marino' => 'sm',
                                                                'Sao Tome and Principe' => 'st',
                                                                'Senegal' => 'sn',
                                                                'Serbia' => 'rs',
                                                                'Seychelles' => 'sc',
                                                                'Sierra Leone' => 'sl',
                                                                'Singapore' => 'sg',
                                                                'Slovakia' => 'sk',
                                                                'Slovenia' => 'si',
                                                                'Solomon Islands' => 'sb',
                                                                'Somalia' => 'so',
                                                                'Sri Lanka' => 'lk',
                                                                'Suriname' => 'sr',
                                                                'Swaziland' => 'sz',
                                                                'Sweden' => 'se',
                                                                'Switzerland' => 'ch',
                                                                'Taiwan' => 'tw',
                                                                'Tajikistan' => 'tj',
                                                                'Tanzania' => 'tz',
                                                                'Thailand' => 'th',
                                                                'Togo' => 'tg',
                                                                'Tonga' => 'to',
                                                                'Trinidad and Tobago' => 'tt',
                                                                'Turkmenistan' => 'tm',
                                                                'Tuvalu' => 'tv',
                                                                'Uganda' => 'ug',
                                                                'Ukraine' => 'ua',
                                                                'Uruguay' => 'uy',
                                                                'Uzbekistan' => 'uz',
                                                                'Vanuatu' => 'vu',
                                                                'Vatican City' => 'va',
                                                                'Venezuela' => 've',
                                                                'Vietnam' => 'vn',
                                                                'Western Sahara' => 'eh',
                                                                'Zambia' => 'zm',
                                                                'Zimbabwe' => 'zw',
                                                            ];

                                                            $countryCode = $countryCodes[$countryName] ?? null;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td style="width: 5%;"><small><?php echo e($index + 1); ?></small></td>
                                                        <td style="width: 30%;">
                                                            <div class="d-flex align-items-center">
                                                                <?php if($countryCode): ?>
                                                                    <span class="fi fi-<?php echo e($countryCode); ?> me-2"></span>
                                                                <?php else: ?>
                                                                    <i class="bx bx-question-mark rounded-circle fs-5 me-2 bg-label-secondary p-1"></i>
                                                                <?php endif; ?>
                                                                <span class="text-heading text-truncate"><?php echo e($country['country']); ?></span>
                                                            </div>
                                                        </td>
                                                        <td style="width: 15%;" class="text-end"><small><?php echo e($country['screenPageViews']); ?></small></td>
                                                        <td style="width: 50%;">
                                                           <div class="d-flex justify-content-end align-items-center gap-2">
                                                                 <small class="fw-medium"><?php echo e(number_format($percentage, 1)); ?>%</small>
                                                                <div class="progress w-75" style="height: 6px;">
                                                                    <div class="progress-bar <?php echo e($colorClass); ?>"
                                                                        role="progressbar" style="width: <?php echo e($percentage); ?>%"
                                                                        aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                     <tr><td colspan="4" class="text-center py-3"><?php echo app('translator')->get('l.No data available'); ?></td></tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Device Categories -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><?php echo app('translator')->get('l.Device Categories'); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th><?php echo app('translator')->get('l.Device'); ?></th>
                                                <th><?php echo app('translator')->get('l.Users'); ?></th>
                                                <th><?php echo app('translator')->get('l.Percentage'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $totalDeviceUsers = $analyticsData['deviceCategory']->sum('activeUsers');
                                            ?>
                                            <?php $__currentLoopData = $analyticsData['deviceCategory']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $percentage = $totalDeviceUsers > 0 ? ($device['activeUsers'] / $totalDeviceUsers) * 100 : 0;
                                                    $icon = match(strtolower($device['deviceCategory'])) {
                                                        'mobile' => 'bx-mobile-alt',
                                                        'desktop' => 'bx-desktop',
                                                        'tablet' => 'bx-tablet',
                                                        default => 'bx-devices'
                                                    };
                                                ?>
                                                <tr>
                                                    <td>
                                                        <i class="bx <?php echo e($icon); ?> me-2"></i>
                                                        <?php echo e($device['deviceCategory']); ?>

                                                    </td>
                                                    <td><?php echo e($device['activeUsers']); ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="progress flex-grow-1" style="height: 6px;">
                                                                <div class="progress-bar bg-primary" style="width: <?php echo e($percentage); ?>%"></div>
                                                            </div>
                                                            <small class="text-muted"><?php echo e(number_format($percentage, 1)); ?>%</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Engagement -->
                    <div class="col-lg-3">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><?php echo app('translator')->get('l.User Engagement'); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-time"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo app('translator')->get('l.Avg. Engagement Time'); ?></h6>
                                                <small class="text-muted"><?php echo e(gmdate("i:s", $analyticsData['userEngagement']->first()['userEngagementDuration'] ?? 0)); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded bg-label-success">
                                                    <i class="bx bx-user-check"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo app('translator')->get('l.Engaged Sessions'); ?></h6>
                                                <small class="text-muted"><?php echo e(number_format($analyticsData['userEngagement']->first()['engagedSessions'] ?? 0)); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Types Chart -->
                    <div class="col-lg-4">
                        <div class="card chart-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><?php echo app('translator')->get('l.User Types'); ?></h5>
                            </div>
                            <div class="card-body">
                                <?php
                                    $totalUsers = $analyticsData['userTypes']->sum('activeUsers');
                                    $newUsers = $analyticsData['userTypes']->where('newVsReturning', 'new')->first()['activeUsers'] ?? 0;
                                    $returningUsers = $analyticsData['userTypes']->where('newVsReturning', 'returning')->first()['activeUsers'] ?? 0;
                                ?>
                                <div class="d-flex justify-content-center mb-4">
                                    <div id="userTypesChart" style="min-height: 300px;"></div>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <div class="text-center">
                                        <h6 class="mb-1"><?php echo app('translator')->get('l.New Users'); ?></h6>
                                        <h4 class="mb-0"><?php echo e($newUsers); ?></h4>
                                        <small class="text-muted"><?php echo e($totalUsers > 0 ? number_format(($newUsers / $totalUsers) * 100, 1) : 0); ?>%</small>
                                    </div>
                                    <div class="text-center">
                                        <h6 class="mb-1"><?php echo app('translator')->get('l.Returning Users'); ?></h6>
                                        <h4 class="mb-0"><?php echo e($returningUsers); ?></h4>
                                        <small class="text-muted"><?php echo e($totalUsers > 0 ? number_format(($returningUsers / $totalUsers) * 100, 1) : 0); ?>%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visitors Trend Chart -->
                    <div class="col-lg-8">
                        <div class="card chart-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><?php echo app('translator')->get('l.Visitors & Page Views Trend'); ?></h5>
                            </div>
                            <div class="card-body">
                                <div id="visitorsChart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Most Visited Pages -->
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><?php echo app('translator')->get('l.Most Visited Pages'); ?></h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-borderless card-table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th><?php echo app('translator')->get('l.Page Title'); ?></th>
                                                <th><?php echo app('translator')->get('l.Views'); ?></th>
                                                <th><?php echo app('translator')->get('l.Percentage'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $totalViews = $analyticsData['topPages']->sum('screenPageViews');
                                            ?>
                                            <?php $__empty_1 = true; $__currentLoopData = $analyticsData['topPages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                             <?php
                                                $percentage = $totalViews > 0 ? ($page['screenPageViews'] / $totalViews) * 100 : 0;
                                            ?>
                                                <tr>
                                                    <td class="text-truncate">
                                                        <a href="https://<?php echo e($page['fullPageUrl']); ?>" target="_blank" title="<?php echo e($page['pageTitle']); ?> (<?php echo e($page['fullPageUrl']); ?>)">
                                                            <?php echo e($page['pageTitle'] !== '(not set)' ? $page['pageTitle'] : $page['fullPageUrl']); ?>

                                                        </a>
                                                    </td>
                                                    <td><small><?php echo e($page['screenPageViews']); ?></small></td>
                                                    <td>
                                                         <div class="d-flex justify-content-end align-items-center gap-2">
                                                            <small class="fw-medium"><?php echo e(number_format($percentage, 1)); ?>%</small>
                                                            <div class="progress w-50" style="height: 6px;">
                                                                <div class="progress-bar bg-primary"
                                                                    role="progressbar" style="width: <?php echo e($percentage); ?>%"
                                                                    aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr><td colspan="3" class="text-center py-3"><?php echo app('translator')->get('l.No data available'); ?></td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Referrers -->
                     <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><?php echo app('translator')->get('l.Top Referrers'); ?></h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-borderless card-table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th><?php echo app('translator')->get('l.Referrer URL'); ?></th>
                                                <th><?php echo app('translator')->get('l.Views'); ?></th>
                                                <th><?php echo app('translator')->get('l.Percentage'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $totalReferrerViews = $analyticsData['topReferrers']->sum('screenPageViews');
                                            ?>
                                            <?php $__empty_1 = true; $__currentLoopData = $analyticsData['topReferrers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referrer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                             <?php
                                                $percentage = $totalReferrerViews > 0 ? ($referrer['screenPageViews'] / $totalReferrerViews) * 100 : 0;
                                                $url = $referrer['pageReferrer'];
                                                $host = parse_url($url, PHP_URL_HOST) ?? $url; // Display host or full URL if parse fails
                                            ?>
                                                <tr>
                                                    <td class="text-truncate">
                                                        <a href="<?php echo e($url); ?>" target="_blank" title="<?php echo e($url); ?>">
                                                            <?php echo e($host); ?>

                                                        </a>
                                                    </td>
                                                    <td><small><?php echo e($referrer['screenPageViews']); ?></small></td>
                                                    <td>
                                                         <div class="d-flex justify-content-end align-items-center gap-2">
                                                            <small class="fw-medium"><?php echo e(number_format($percentage, 1)); ?>%</small>
                                                            <div class="progress w-50" style="height: 6px;">
                                                                <div class="progress-bar bg-info"
                                                                    role="progressbar" style="width: <?php echo e($percentage); ?>%"
                                                                    aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr><td colspan="3" class="text-center py-3"><?php echo app('translator')->get('l.No data available'); ?></td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                             <div class="card-header">
                                <h5 class="card-title mb-0"><?php echo app('translator')->get('l.Enable Google Analytics'); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo app('translator')->get('l.Google Analytics is currently disabled. Enabling this feature will provide all data of Google Analytics'); ?><br>
                                    <?php echo app('translator')->get('l.If you need help getting these credentials, please read our detailed guide at'); ?> <a href="<?php echo e(env('google_analytics_guide_url')); ?>" target="_blank" class="alert-link"><?php echo app('translator')->get('l.Here'); ?></a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                                <form action="<?php echo e(route('dashboard.admins.statistics-google-status')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                                        <label class="form-label" for="google_analytics_id"><?php echo app('translator')->get('l.Google Analytics Property ID'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bxs-analyse"></i></span>
                                            <input type="text" class="form-control" id="google_analytics_id" name="google_analytics" required placeholder="G-XXXXXXXXXX">
                        </div>
                    </div>
                    <div class="mb-3">
                                        <label class="form-label" for="google_analytics_file"><?php echo app('translator')->get('l.Google Analytics File'); ?></label>
                                         <input type="file" class="form-control" id="google_analytics_file" name="google_analytics_file" required accept=".json">
                                        <small class="text-muted d-block mt-1"><?php echo app('translator')->get('l.Upload service-account-credentials.json file'); ?></small>
                        </div>
                                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-check me-1"></i>
                            <?php echo app('translator')->get('l.Enable Google Analytics'); ?>
                        </button>
                    </div>
                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.1/apexcharts.min.js"></script>
    <script>
        function confirmDisable() {
            Swal.fire({
                title: '<?php echo app('translator')->get("l.Are you sure?"); ?>',
                text: '<?php echo app('translator')->get("l.You are about to disable Google Analytics tracking. You can re-enable it later."); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: config.colors.danger,
                cancelButtonColor: config.colors.secondary,
                confirmButtonText: '<?php echo app('translator')->get("l.Yes, disable it!"); ?>',
                cancelButtonText: '<?php echo app('translator')->get("l.Cancel"); ?>',
                customClass: {
                    confirmButton: 'btn btn-danger waves-effect waves-light',
                    cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('disable-form').submit();
                }
            });
        }

        <?php if($google != null): ?>
            document.addEventListener('DOMContentLoaded', function() {
                // Helper function to get theme colors
                const cardColor = config.colors.cardColor;
                const headingColor = config.colors.headingColor;
                const axisColor = config.colors.axisColor;
                const borderColor = config.colors.borderColor;
                const primaryColor = config.colors.primary;
                const secondaryColor = config.colors.secondary;
                const infoColor = config.colors.info;
                const successColor = config.colors.success;

                // Data
                const totalVisitorsData = <?php echo json_encode($analyticsData['totalVisitors'] ?? [], 15, 512) ?>;
                const userTypesData = <?php echo json_encode($analyticsData['userTypes'] ?? [], 15, 512) ?>;

                // RTL Check
                const isRTL = document.documentElement.getAttribute('dir') === 'rtl';

                // Visitors Trend Chart
                const visitorsChartEl = document.querySelector('#visitorsChart');
                if (visitorsChartEl) {
                    const visitorsChartConfig = {
                        series: [
                            {
                                name: '<?php echo app('translator')->get("l.Active Users"); ?>',
                        type: 'line',
                                data: totalVisitorsData.map(item => [new Date(item.date).getTime(), item.activeUsers])
                            },
                             {
                                name: '<?php echo app('translator')->get("l.Page Views"); ?>',
                                type: 'column', // Changed to column for variation
                                data: totalVisitorsData.map(item => [new Date(item.date).getTime(), item.screenPageViews])
                            }
                        ],
                    chart: {
                        height: 350,
                        type: 'line',
                            parentHeightOffset: 0,
                            stacked: false,
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            // dir: isRTL ? 'rtl' : 'ltr' // ApexCharts handles RTL automatically based on body dir
                        },
                        markers: {
                            size: 4,
                            colors: [primaryColor, successColor],
                            strokeColors: 'transparent',
                            strokeWidth: 3,
                            hover: { size: 6 },
                        },
                        colors: [primaryColor, successColor],
                    stroke: {
                        curve: 'smooth',
                            width: [3, 0], // Line width for series 1, 0 for column
                        },
                        dataLabels: { enabled: false },
                        legend: {
                            show: true,
                            position: 'top',
                            horizontalAlign: 'center',
                             labels: { colors: axisColor }, // Use theme color
                            markers: { offsetX: isRTL ? 10 : -10 }
                        },
                        grid: {
                            borderColor: borderColor,
                            padding: { top: -10, bottom: -15, left: 0, right: 0 }
                    },
                    xaxis: {
                        type: 'datetime',
                            axisBorder: { show: false },
                            axisTicks: { color: borderColor },
                            labels: {
                                style: { colors: axisColor, fontSize: '13px' },
                                // formatter: function (val) { // Optional: customize date format
                                //     return new Date(val).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                                // }
                            },
                            tooltip: { enabled: false } // Disable x-axis tooltip
                        },
                        yaxis: [
                            {
                                // Series 1: Active Users
                                title: {
                                    text: '<?php echo app('translator')->get("l.Users"); ?>',
                                    style: { color: axisColor, fontSize: '13px' }
                                },
                                labels: {
                                    style: { colors: axisColor, fontSize: '13px' },
                                    formatter: function (val) { return Math.round(val); }
                                },
                                opposite: isRTL
                            },
                            {
                                // Series 2: Page Views
                                opposite: !isRTL,
                                title: {
                                    text: '<?php echo app('translator')->get("l.Views"); ?>',
                                    style: { color: axisColor, fontSize: '13px' }
                                },
                        labels: {
                                    style: { colors: axisColor, fontSize: '13px' },
                                     formatter: function (val) { return Math.round(val); }
                                },

                            }
                        ],
                        tooltip: {
                            shared: false,
                            intersect: true,
                            x: {
                                format: 'dd MMM yyyy'
                            }
                        }
                    };
                    new ApexCharts(visitorsChartEl, visitorsChartConfig).render();
                }

                // User Types Chart
                const userTypesChartEl = document.querySelector('#userTypesChart');
                if (userTypesChartEl && userTypesData.length > 0) {
                    const userTypesChartConfig = {
                        series: userTypesData.map(item => item.activeUsers),
                        labels: userTypesData.map(item =>
                            item.newVsReturning === 'new' ? '<?php echo app('translator')->get("l.New Users"); ?>' : '<?php echo app('translator')->get("l.Returning Users"); ?>'
                        ),
                        chart: {
                            type: 'donut',
                            height: 330 // Adjust height if needed
                        },
                        colors: [primaryColor, secondaryColor],
                        stroke: { width: 5, colors: [cardColor] },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val, opt) {
                                return parseInt(val) + '%';
                            }
                        },
                    legend: {
                            show: true,
                            position: 'bottom',
                            horizontalAlign: 'center',
                            labels: { colors: axisColor, useSeriesColors: false },
                            markers: { offsetX: isRTL ? 10 : -10 },
                            itemMargin: { horizontal: 10 }
                    },
                    plotOptions: {
                            pie: {
                                donut: {
                                    size: '75%',
                                    labels: {
                                        show: true,
                                        value: {
                                            fontSize: '1.5rem',
                                            fontFamily: 'Public Sans',
                                            color: headingColor,
                                            offsetY: -15,
                                            formatter: function (val) {
                                                // Calculate total here if needed, or pass it
                                                // let total = userTypesData.reduce((acc, item) => acc + item.activeUsers, 0);
                                                // return parseInt(total) + ' Users';
                                                return parseInt(val);
                                            }
                                        },
                                        name: {
                                            fontSize: '1rem',
                                            fontFamily: 'Public Sans',
                                            color: axisColor,
                                            offsetY: 10
                                        },
                                        total: {
                                            show: true,
                                            fontSize: '0.9rem',
                                            label: '<?php echo app('translator')->get("l.Total Users"); ?>',
                                            color: axisColor,
                                            formatter: function (w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    };
                    new ApexCharts(userTypesChartEl, userTypesChartConfig).render();
                } else if (userTypesChartEl) {
                    userTypesChartEl.innerHTML = '<div class="text-center text-muted small py-5"><?php echo app('translator')->get("l.No data available"); ?></div>';
                }

                 // Handle period selector clicks
                document.querySelectorAll('#period-selector button[data-period]').forEach(button => {
                button.addEventListener('click', function() {
                        const period = this.getAttribute('data-period');
                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('period', period);
                        window.location.href = currentUrl.toString();
                    });
                });
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/statistics/visitors/google-analytics.blade.php ENDPATH**/ ?>