<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Quizzes List'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('keywords'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('description'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <?php if(isset($courses)): ?>
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo e($course->name); ?></h4>
                                    <div class="stats mt-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><?php echo app('translator')->get('l.Students'); ?></span>
                                            <span class="badge bg-primary"><?php echo e($course->students()->count()); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><?php echo app('translator')->get('l.Quizzes'); ?></span>
                                            <span class="badge bg-info"><?php echo e($course->quizzes()->count()); ?></span>
                                        </div>
                                    </div>
                                    <a href="<?php echo e(route('dashboard.admins.quizzes')); ?>?course=<?php echo e(encrypt($course->id)); ?>"
                                        class="btn btn-primary btn-block mt-3">
                                        <?php echo app('translator')->get('l.View Quizzes'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo app('translator')->get('l.No Courses Found'); ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show quizzes')): ?>
                    <!-- Add Quiz Button -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add quizzes')): ?>
                        <div class="col-12 mb-4">
                            <div class="text-end">
                                <a href="#" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn btn-primary">
                                    <i class="fa fa-plus me-1"></i><?php echo app('translator')->get('l.Add new Quiz'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Quiz List Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo app('translator')->get('l.Title'); ?></th>
                                                <th><?php echo app('translator')->get('l.Duration'); ?></th>
                                                <th><?php echo app('translator')->get('l.Start Time'); ?></th>
                                                <th><?php echo app('translator')->get('l.End Time'); ?></th>
                                                <th><?php echo app('translator')->get('l.Passing Score'); ?></th>
                                                <th><?php echo app('translator')->get('l.Created At'); ?></th>
                                                <th><?php echo app('translator')->get('l.Action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="capital">
                                                        <?php echo e($loop->iteration); ?>

                                                    </td>
                                                    <td class="capital"><?php echo e($quiz->title); ?></td>
                                                    <td class="capital"><?php echo e($quiz->duration); ?> <?php echo app('translator')->get('l.minutes'); ?></td>
                                                    <td class="capital"><?php echo e($quiz->start_time->format('d/m/Y H:i')); ?></td>
                                                    <td class="capital"><?php echo e($quiz->end_time->format('d/m/Y H:i')); ?></td>
                                                    <td class="capital"><?php echo e($quiz->passing_score); ?> <?php echo app('translator')->get('l.points'); ?></td>
                                                    <td class="capital"><?php echo e($quiz->created_at->format('d/m/Y H:i')); ?></td>
                                                    <td class="capital">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show quizzes')): ?>
                                                            <a href="<?php echo e(route('dashboard.admins.quizzes-questions', encrypt($quiz->id))); ?>"
                                                                data-bs-toggle="tooltip" title="<?php echo app('translator')->get('l.Questions and Answers'); ?>"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fa fa-question"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit quizzes')): ?>
                                                            <a href="<?php echo e(route('dashboard.admins.quizzes-grade', encrypt($quiz->id))); ?>"
                                                                data-bs-toggle="tooltip" title="grade" class="btn btn-success btn-sm">
                                                                <i class="fa fa-pen"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show quizzes')): ?>
                                                            <a href="<?php echo e(route('dashboard.admins.quizzes-statistics', encrypt($quiz->id))); ?>"
                                                                data-bs-toggle="tooltip" title="statistics" class="btn btn-dark btn-sm">
                                                                <i class="fa fa-chart-bar"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit quizzes')): ?>
                                                            <a href="<?php echo e(route('dashboard.admins.quizzes-edit')); ?>?id=<?php echo e(encrypt($quiz->id)); ?>"
                                                                data-bs-toggle="tooltip" title="edit" class="btn btn-warning btn-sm">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete quizzes')): ?>
                                                            <a class="delete-quiz btn btn-danger btn-sm" href="javascript:void(0);"
                                                                data-bs-toggle="tooltip" title="delete quiz"
                                                                data-quiz-id="<?php echo e(encrypt($quiz->id)); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Quiz Modal -->
                    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        <h3 class="role-title mb-2"><?php echo app('translator')->get('l.Add new Quiz'); ?></h3>
                                    </div>
                                    <form id="addLectureForm" class="row g-3" method="post" enctype="multipart/form-data"
                                        action="<?php echo e(route('dashboard.admins.quizzes-store')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="title"><?php echo app('translator')->get('l.Title'); ?></label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                placeholder="<?php echo app('translator')->get('l.Enter a quiz title'); ?>" required />
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="description"><?php echo app('translator')->get('l.Description'); ?></label>
                                            <textarea id="description" name="description" class="form-control" placeholder="<?php echo app('translator')->get('l.Enter quiz description'); ?>"></textarea>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="duration"><?php echo app('translator')->get('l.Duration'); ?>
                                                (<?php echo app('translator')->get('l.minutes'); ?>)</label>
                                            <input type="number" id="duration" name="duration" class="form-control"
                                                min="1" required onchange="updateEndTime()" />
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="passing_score"><?php echo app('translator')->get('l.Passing Score'); ?>
                                                (<?php echo app('translator')->get('l.points'); ?>)</label>
                                            <input type="number" id="passing_score" name="passing_score"
                                                class="form-control" min="0" required />
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="start_time"><?php echo app('translator')->get('l.Start Time'); ?></label>
                                            <input type="datetime-local" id="start_time" name="start_time"
                                                class="form-control" required onchange="updateEndTime()" />
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="form-label" for="end_time"><?php echo app('translator')->get('l.End Time'); ?></label>
                                            <input type="datetime-local" id="end_time" name="end_time" class="form-control"
                                                readonly />
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="form-check">
                                                <input type="checkbox" id="is_random_questions" name="is_random_questions"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="is_random_questions">
                                                    <?php echo app('translator')->get('l.Randomize Questions Order'); ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="form-check">
                                                <input type="checkbox" id="is_random_answers" name="is_random_answers"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="is_random_answers">
                                                    <?php echo app('translator')->get('l.Randomize Answers Order'); ?>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="show_result"><?php echo app('translator')->get('l.Show Result'); ?></label>
                                            <select id="show_result" name="show_result" class="form-select" required>
                                                <option value="after_submission"><?php echo app('translator')->get('l.After Submission'); ?></option>
                                                <option value="after_exam_end"><?php echo app('translator')->get('l.After Exam End'); ?></option>
                                                <option value="manual"><?php echo app('translator')->get('l.Manual by Admin'); ?></option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>">

                                        <div class="col-12 text-center mt-4">
                                            <button type="submit"
                                                class="btn btn-primary me-sm-3 me-1"><?php echo app('translator')->get('l.Submit'); ?></button>
                                            <button type="button" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal"><?php echo app('translator')->get('l.Cancel'); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        var table = $('#data-table').DataTable({
            ordering: true,
            order: [],
        });

        $('#search-input').keyup(function() {
            table.search($(this).val()).draw();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRoleButton = document.querySelector('.add-new-quiz');
            const addRoleModal = document.querySelector('#addRoleModal');

            addRoleButton.addEventListener('click', function() {
                var modal = new bootstrap.Modal(addRoleModal);
                modal.show();
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-quiz', function(e) {
            e.preventDefault();
            const quizId = $(this).data('quiz-id');

            Swal.fire({
                title: "<?php echo app('translator')->get('l.Are you sure?'); ?>",
                text: "<?php echo app('translator')->get('l.You will be delete this forever!'); ?>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#343a40',
                confirmButtonText: "<?php echo app('translator')->get('l.Yes, delete it!'); ?>",
                cancelButtonText: "<?php echo app('translator')->get('l.Cancel'); ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo e(route('dashboard.admins.quizzes-delete')); ?>?id=' + quizId;
                }
            });
        });
    </script>
    <script>
        function updateEndTime() {
            const startTime = document.getElementById('start_time').value;
            const duration = document.getElementById('duration').value;

            if (startTime && duration) {
                // تحويل وقت البداية إلى كائن Date
                const startDate = new Date(startTime);

                // إضافة المدة بالدقائق
                const endDate = new Date(startDate.getTime() + duration * 60000);

                // تنسيق التاريخ والوقت مع مراعاة المنطقة الزمنية
                const endTimeString = endDate.getFullYear() + '-' +
                    String(endDate.getMonth() + 1).padStart(2, '0') + '-' +
                    String(endDate.getDate()).padStart(2, '0') + 'T' +
                    String(endDate.getHours()).padStart(2, '0') + ':' +
                    String(endDate.getMinutes()).padStart(2, '0');

                document.getElementById('end_time').value = endTimeString;
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/quizzes/quizzes-list.blade.php ENDPATH**/ ?>