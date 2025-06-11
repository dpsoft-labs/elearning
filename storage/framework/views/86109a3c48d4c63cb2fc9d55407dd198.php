<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Quiz Statistics'); ?> - <?php echo e($quiz->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title"><?php echo app('translator')->get('l.Quiz Statistics'); ?> - <?php echo e($quiz->title); ?></h5>
            </div>

            <?php if($errors->any()): ?>
                <div class="col-12">
                    <div class="alert alert-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($error); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><?php echo app('translator')->get('l.General Statistics'); ?></h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><?php echo app('translator')->get('l.Total Students'); ?>: <span class="fw-semibold"><?php echo e($statistics['total_students']); ?></span></li>
                            <li class="mb-2"><?php echo app('translator')->get('l.Total Attempts'); ?>: <span class="fw-semibold"><?php echo e($statistics['total_attempts']); ?></span></li>
                            <li class="mb-2"><?php echo app('translator')->get('l.Completed Attempts'); ?>: <span class="fw-semibold"><?php echo e($statistics['completed_attempts']); ?></span></li>
                            <li class="mb-2"><?php echo app('translator')->get('l.Passed Students'); ?>: <span class="fw-semibold"><?php echo e($statistics['passed_students']); ?></span></li>
                            <li class="mb-2"><?php echo app('translator')->get('l.Average Score'); ?>: <span class="fw-semibold"><?php echo e(number_format($statistics['average_score'], 2)); ?></span></li>
                            <li class="mb-2"><?php echo app('translator')->get('l.Highest Score'); ?>: <span class="fw-semibold"><?php echo e($statistics['highest_score']); ?></span></li>
                            <li class="mb-2"><?php echo app('translator')->get('l.Lowest Score'); ?>: <span class="fw-semibold"><?php echo e($statistics['lowest_score']); ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><?php echo app('translator')->get('l.Score Distribution'); ?></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="scoreDistributionChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($no == 0 ? 'active' : ''); ?>"
                                   href="<?php echo e(route('dashboard.admins.quizzes-statistics', ['id' => encrypt($quiz->id)])); ?>">
                                    <?php echo app('translator')->get('l.Students who attended the quiz'); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($no == 1 ? 'active' : ''); ?>"
                                   href="<?php echo e(route('dashboard.admins.quizzes-statistics', ['id' => encrypt($quiz->id), 'no' => 1])); ?>">
                                    <?php echo app('translator')->get('l.Students who did not attend the quiz'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade <?php echo e($no == 0 ? 'show active' : ''); ?>" id="attended" role="tabpanel">
                                <?php if($no == 0): ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th><?php echo app('translator')->get('l.Student Name'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Phone'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Parent Number'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Start Time'); ?></th>
                                                    <th><?php echo app('translator')->get('l.End Time'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Score'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Result'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $Attempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($attempt->user->firstname); ?> <?php echo e($attempt->user->lastname); ?></td>
                                                        <td><?php echo e($attempt->user->phone); ?></td>
                                                        <td><?php echo e($attempt->user->parent); ?></td>
                                                        <td><?php echo e($attempt->started_at->format('Y-m-d H:i:s')); ?></td>
                                                        <td><?php echo e($attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i:s') : 'لم يكتمل'); ?></td>
                                                        <td><?php echo e($attempt->score); ?></td>
                                                        <td>
                                                            <?php if($attempt->is_passed): ?>
                                                                <span class="badge bg-label-success"><?php echo app('translator')->get('l.Passed'); ?></span>
                                                            <?php else: ?>
                                                                <span class="badge bg-label-danger"><?php echo app('translator')->get('l.Failed'); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-center mt-4">
                                            <?php
                                                $attempts = $Attempts;
                                            ?>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li class="page-item <?php echo e($attempts->onFirstPage() ? 'disabled' : ''); ?>">
                                                        <a class="page-link" href="<?php echo e($attempts->previousPageUrl()); ?>" aria-label="Previous">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                    <?php for($i = 1; $i <= $attempts->lastPage(); $i++): ?>
                                                        <li class="page-item <?php echo e($attempts->currentPage() == $i ? 'active' : ''); ?>">
                                                            <a class="page-link" href="<?php echo e($attempts->url($i)); ?>"><?php echo e($i); ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                    <li class="page-item <?php echo e(!$attempts->hasMorePages() ? 'disabled' : ''); ?>">
                                                        <a class="page-link" href="<?php echo e($attempts->nextPageUrl()); ?>" aria-label="Next">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="tab-pane fade <?php echo e($no == 1 ? 'show active' : ''); ?>" id="not-attended" role="tabpanel">
                                <?php if($no == 1): ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th><?php echo app('translator')->get('l.Student Name'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Phone'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Email'); ?></th>
                                                    <th><?php echo app('translator')->get('l.Parent Number'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $Attempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($student->firstname); ?> <?php echo e($student->lastname); ?></td>
                                                        <td><?php echo e($student->phone); ?></td>
                                                        <td><?php echo e($student->email); ?></td>
                                                        <td><?php echo e($student->parent); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-center mt-4">
                                            <?php
                                                $attempts = $Attempts;
                                            ?>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li class="page-item <?php echo e($attempts->onFirstPage() ? 'disabled' : ''); ?>">
                                                        <a class="page-link" href="<?php echo e($attempts->previousPageUrl()); ?>" aria-label="Previous">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                    <?php for($i = 1; $i <= $attempts->lastPage(); $i++): ?>
                                                        <li class="page-item <?php echo e($attempts->currentPage() == $i ? 'active' : ''); ?>">
                                                            <a class="page-link" href="<?php echo e($attempts->url($i)); ?>"><?php echo e($i); ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                    <li class="page-item <?php echo e(!$attempts->hasMorePages() ? 'disabled' : ''); ?>">
                                                        <a class="page-link" href="<?php echo e($attempts->nextPageUrl()); ?>" aria-label="Next">
                                                            <span aria-hidden="true"><i class="ti ti-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> ti-xs"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('scoreDistributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(<?php echo json_encode($scoreDistribution); ?>),
                datasets: [{
                    label: '<?php echo app('translator')->get('l.Number of students'); ?>',
                    data: Object.values(<?php echo json_encode($scoreDistribution); ?>),
                    backgroundColor: 'rgba(105, 108, 255, 0.5)',
                    borderColor: 'rgba(105, 108, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/quizzes/quizzes-statistics.blade.php ENDPATH**/ ?>