<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Quizzes'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .question-card {
            transition: all 0.3s ease;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .answer-section {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .pagination .page-link {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0 0.2rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .question-content h5 {
                font-size: 1rem;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="content-wrapper">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-header bg-gradient-primary p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class=" mb-0"><?php echo app('translator')->get('l.Quizzes'); ?></h3>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-light btn-sm" id="grid-view">
                                            <i class="fas fa-th-large"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm" id="list-view">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-4" id="quizzes-container">
                                <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 quiz-card hover-shadow">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title mb-0"><?php echo e($quiz->title); ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="description mb-3 mt-3">
                                                    <p class="card-text text-muted"><?php echo e($quiz->description); ?></p>
                                                </div>

                                                <div class="quiz-info">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-clock text-primary me-2"></i>
                                                        <span><?php echo app('translator')->get('l.Duration'); ?>: <?php echo e($quiz->duration); ?>

                                                            <?php echo app('translator')->get('l.Minutes'); ?></span>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-award text-success me-2"></i>
                                                        <span><?php echo app('translator')->get('l.Passing Score'); ?>: <?php echo e($quiz->passing_score); ?></span>
                                                    </div>
                                                    <div class="countdown-container mb-2">
                                                        <i class="fas fa-hourglass-start text-warning me-2"></i>
                                                        <span><?php echo app('translator')->get('l.Starts in'); ?>: </span>
                                                        <span class="countdown" data-start="<?php echo e($quiz->start_time); ?>"></span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-alt text-danger me-2"></i>
                                                        <span data-end="<?php echo e($quiz->end_time); ?>"><?php echo app('translator')->get('l.End Time'); ?>:
                                                            <?php echo e($quiz->end_time->format('Y-m-d H:i')); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-light">
                                                <!-- Quiz not started -->
                                                <?php if($quiz->start_time > now()): ?>
                                                    <button type="button" class="btn btn-secondary w-100 mt-3" disabled>
                                                        <i class="fas fa-clock me-2"></i>
                                                        <?php echo app('translator')->get('l.Not Started Yet'); ?>
                                                    </button>
                                                <?php elseif($quiz->end_time < now()): ?>
                                                    <!-- Quiz ended -->
                                                    <?php
                                                        $attempt = $quiz
                                                            ->attempts()
                                                            ->where('user_id', auth()->id())
                                                            ->where('completed_at', '!=', null)
                                                            ->first();
                                                    ?>
                                                    <?php if($attempt): ?>
                                                        <a href="<?php echo e(route('dashboard.users.quizzes-show', ['attempt_id' => encrypt($attempt->id)])); ?>"
                                                            class="btn btn-info w-100 mt-3">
                                                            <i class="fas fa-eye me-2"></i>
                                                            <?php echo app('translator')->get('l.Show Result'); ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-danger w-100 mt-3" disabled>
                                                            <i class="fas fa-times-circle me-2"></i>
                                                            <?php echo app('translator')->get('l.Quiz Ended'); ?>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <!-- Quiz in progress -->
                                                    <?php
                                                        $attempt = $quiz
                                                            ->attempts()
                                                            ->where('user_id', auth()->id())
                                                            ->where('completed_at', '!=', null)
                                                            ->first();
                                                    ?>
                                                    <?php if($attempt): ?>
                                                        <button type="button" class="btn btn-warning w-100" disabled>
                                                            <i class="fas fa-check-circle me-2"></i>
                                                            <?php echo app('translator')->get('l.Already Taken'); ?>
                                                        </button>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('dashboard.users.quizzes-open', ['quiz_id' => encrypt($quiz->id)])); ?>"
                                                            class="btn btn-primary w-100 mt-3">
                                                            <i class="fas fa-play-circle me-2"></i>
                                                            <?php echo app('translator')->get('l.Start Quiz'); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        // Countdown functionality
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(el => {
                const startTime = new Date(el.dataset.start);
                const endTime = new Date(el.closest('.card').querySelector('[data-end]')?.dataset.end);
                const now = new Date();
                const diff = startTime - now;

                if (diff > 0) {
                    // Quiz hasn't started yet - show countdown
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    el.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                } else if (endTime && now > endTime) {
                    // Quiz has ended
                    el.textContent = '<?php echo app('translator')->get('l.Ended'); ?>';
                } else {
                    el.textContent = '<?php echo app('translator')->get('l.Started'); ?>';
                }
            });
        }

        setInterval(updateCountdowns, 1000);
        updateCountdowns();

        // View toggle functionality
        document.getElementById('grid-view').addEventListener('click', function() {
            const container = document.getElementById('quizzes-container');
            container.querySelectorAll('.col-12').forEach(el => {
                el.className = 'col-12 col-md-6 col-lg-4 mb-4';
            });
        });

        document.getElementById('list-view').addEventListener('click', function() {
            const container = document.getElementById('quizzes-container');
            container.querySelectorAll('.col-12').forEach(el => {
                el.className = 'col-12 mb-4';
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/quizzes/quizzes-list.blade.php ENDPATH**/ ?>