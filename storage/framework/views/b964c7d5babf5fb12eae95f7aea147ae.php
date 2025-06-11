<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Quiz Grade'); ?> - <?php echo e($quiz->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title"><?php echo app('translator')->get('l.Quiz Grade'); ?> - <?php echo e($quiz->title); ?></h5>
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

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Student Name'); ?></th>
                                        <th><?php echo app('translator')->get('l.Phone'); ?></th>
                                        <th><?php echo app('translator')->get('l.Start Time'); ?></th>
                                        <th><?php echo app('translator')->get('l.End Time'); ?></th>
                                        <th><?php echo app('translator')->get('l.Score'); ?></th>
                                        <th><?php echo app('translator')->get('l.Status'); ?></th>
                                        <th><?php echo app('translator')->get('l.Actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $quiz->attempts()->paginate(100); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($attempt->user->firstname); ?> <?php echo e($attempt->user->lastname); ?></td>
                                            <td><?php echo e($attempt->user->phone); ?></td>
                                            <td><?php echo e($attempt->started_at ? $attempt->started_at->format('Y-m-d H:i') : '-'); ?></td>
                                            <td><?php echo e($attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i') : '-'); ?></td>
                                            <td>
                                                <span class="badge bg-label-<?php echo e($attempt->is_passed ? 'success' : 'danger'); ?>">
                                                    <?php echo e($attempt->score); ?>/<?php echo e($quiz->totalGrade()); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($attempt->completed_at): ?>
                                                    <span class="badge bg-label-success"><?php echo app('translator')->get('l.Completed'); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-label-warning"><?php echo app('translator')->get('l.In Progress'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="showGradeModal(<?php echo e($attempt->id); ?>)">
                                                    <i class="fa fa-check me-1"></i> <?php echo app('translator')->get('l.Grade'); ?>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center mt-4">
                                <?php
                                    $attempts = $quiz->attempts()->paginate(100);
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Modal -->
    <div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('l.Grade Quiz'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="gradeModalBody">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        function showGradeModal(attemptId) {
            const modal = new bootstrap.Modal(document.getElementById('gradeModal'));
            const modalBody = document.getElementById('gradeModalBody');

            // Show loading
            modalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>';
            modal.show();

            // Fetch attempt details
            fetch(`<?php echo e(url('admins/quizzes/get-attempt')); ?>/${attemptId}`)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                });
        }

        function updateGrade(answerId, points, attemptId, element) {
            if (element) {
                element.disabled = true;
            }

            fetch('<?php echo e(route('dashboard.admins.quizzes-update-grade')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        answer_id: answerId,
                        points: points
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (attemptId) {
                            document.getElementById(`total-score-${attemptId}`).textContent = data.new_total;
                        }
                        showToast('success', data.message);
                    } else {
                        showToast('error', data.message || '<?php echo app('translator')->get('l.Error'); ?>');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', '<?php echo app('translator')->get('l.Error'); ?>');
                })
                .finally(() => {
                    if (element) {
                        element.disabled = false;
                    }
                });
        }

        function updateAnswerStatus(answerId, isCorrect, attemptId, element) {
            if (element) {
                element.disabled = true;
            }

            fetch('<?php echo e(route('dashboard.admins.quizzes-update-grade')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        answer_id: answerId,
                        is_correct: isCorrect
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (attemptId) {
                            document.getElementById(`total-score-${attemptId}`).textContent = data.new_total;
                        }
                        showToast('success', data.message);
                    } else {
                        showToast('error', data.message || '<?php echo app('translator')->get('l.Error'); ?>');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', '<?php echo app('translator')->get('l.Error'); ?>');
                })
                .finally(() => {
                    if (element) {
                        element.disabled = false;
                    }
                });
        }

        function showToast(type, message) {
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                };
                toastr[type](message);
            } else {
                alert(message);
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/quizzes/quizzes-grade.blade.php ENDPATH**/ ?>