<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Frequently Asked Questions')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .question-card {
        border-left: 4px solid #696cff;
        transition: all 0.3s ease;
    }
    .question-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }
    .question-header {
        cursor: pointer;
        padding: 1rem;
    }
    .question-content {
        border-top: 1px solid rgba(0,0,0,.1);
        padding: 1rem;
        background-color: rgba(105, 108, 255, 0.05);
    }
    .question-actions {
        padding: 0.5rem 1rem;
        border-top: 1px solid rgba(0,0,0,.1);
    }
    .add-question-btn {
        transition: all 0.3s ease;
    }
    .add-question-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(105, 108, 255, 0.4);
    }
    .expand-icon {
        transition: transform 0.3s ease;
    }
    .collapsed .expand-icon {
        transform: rotate(-90deg);
    }
    .question-number {
        display: inline-flex;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #696cff;
        color: white;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    [dir="ltr"] .question-number {
        margin-right: 10px;
    }
    [dir="rtl"] .question-number {
        margin-left: 10px;
    }
    .lang-flag {
        width: 20px;
        height: 15px;
        margin-right: 5px;
        border-radius: 2px;
    }
    .action-buttons .btn {
        margin-left: 5px;
        transition: all 0.2s;
    }
    .action-buttons .btn:hover {
        transform: translateY(-2px);
    }
    .delete-selected {
        transition: all 0.3s;
    }
    .delete-selected:hover {
        background-color: #e05260;
        color: white;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="fw-bold py-3 mb-0">
                    <i class="bx bx-help-circle text-primary me-1"></i>
                    <?php echo e(__('l.Frequently Asked Questions')); ?>

                </h4>

                <div class="action-buttons">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete questions')): ?>
                    <button id="deleteSelected" class="btn btn-outline-danger delete-selected d-none">
                        <i class="bx bx-trash me-1"></i> <?php echo e(__('l.Delete Selected')); ?>

                    </button>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add questions')): ?>
                    <button type="button" class="btn btn-primary add-question-btn" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                        <i class="bx bx-plus-circle me-1"></i> <?php echo e(__('l.Add New Question')); ?>

                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($error); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="row">
        <div class="col-12">
            <?php $__empty_1 = true; $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-3 question-card">
                <div class="card-header question-header p-0" data-bs-toggle="collapse" data-bs-target="#question<?php echo e($question->id); ?>" aria-expanded="false">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex align-items-center">
                            <span class="question-number"><?php echo e($index + 1); ?></span>
                            <span class="fw-semibold"><?php echo e(is_array($question->question) ? ($question->question[$defaultLanguage] ?? reset($question->question)) : $question->question); ?></span>
                            <div class="ms-2">
                                <?php $__currentLoopData = is_array($question->question) ? array_keys($question->question) : []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <i class="fi fi-<?php echo e(strtolower($langCode)); ?> fis"></i>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input row-checkbox" type="checkbox" value="<?php echo e($question->id); ?>" id="check<?php echo e($question->id); ?>">
                            </div>
                            <i class="bx bx-chevron-down fs-4 expand-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="question<?php echo e($question->id); ?>">
                    <div class="question-content">
                        <p class="mb-0"><?php echo e(is_array($question->answer) ? ($question->answer[$defaultLanguage] ?? reset($question->answer)) : $question->answer); ?></p>
                    </div>

                    <div class="question-actions d-flex justify-content-end">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit questions')): ?>
                        <a href="<?php echo e(route('dashboard.admins.questions-get-translations', ['id' => encrypt($question->id)])); ?>" class="btn btn-sm btn-dark me-2">
                            <i class="bx bx-globe me-1"></i> <?php echo e(__('l.Translations')); ?>

                        </a>

                        <a href="<?php echo e(route('dashboard.admins.questions-edit', ['id' => encrypt($question->id)])); ?>" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bx bx-edit me-1"></i> <?php echo e(__('l.Edit')); ?>

                        </a>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete questions')): ?>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-question" data-id="<?php echo e(encrypt($question->id)); ?>">
                            <i class="bx bx-trash me-1"></i> <?php echo e(__('l.Delete')); ?>

                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="لا توجد أسئلة" class="mb-3" style="max-width: 200px;">
                    <h5><?php echo e(__('l.No Questions Added Yet')); ?></h5>
                    <p class="text-muted"><?php echo e(__('l.Start by adding your first question')); ?></p>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add questions')): ?>
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                        <i class="bx bx-plus-circle me-1"></i> <?php echo e(__('l.Add First Question')); ?>

                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add questions')): ?>
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('l.Add New Question')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('dashboard.admins.questions-store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label d-flex align-items-center">
                                <?php echo e(__('l.Question')); ?> <span class="text-danger mx-1">*</span>
                                <i class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i>
                            </label>
                            <textarea class="form-control" name="question" rows="3" required placeholder="<?php echo e(__('l.Enter your question here')); ?>"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label d-flex align-items-center">
                                <?php echo e(__('l.Answer')); ?> <span class="text-danger mx-1">*</span>
                                <i class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i>
                            </label>
                            <textarea class="form-control" name="answer" rows="5" required placeholder="<?php echo e(__('l.Enter the answer here')); ?>"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="auto_translate" name="auto_translate">
                                <label class="form-check-label" for="auto_translate"><?php echo e(__('l.Auto Translate')); ?></label>
                            </div>
                            <small class="text-muted"><?php echo e(__('l.Please note that automatic translation for large content is not efficient and may take some time, so we do not recommend using it for large content')); ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo e(__('l.Cancel')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('l.Save Question')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function() {
        // تبديل الأيقونة عند فتح وإغلاق التفاصيل
        $('.question-header').on('click', function() {
            $(this).toggleClass('collapsed');
        });

        // حدث تحديد/إلغاء تحديد الكل
        $('#select-all').on('change', function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
            updateDeleteButton();
        });

        // تحديث حالة زر الحذف عند تغيير أي صندوق تحديد
        $(document).on('change', '.row-checkbox', function() {
            updateDeleteButton();
        });

        function updateDeleteButton() {
            let checkedCount = $('.row-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#deleteSelected').removeClass('d-none');
            } else {
                $('#deleteSelected').addClass('d-none');
            }
        }

        // حذف الأسئلة المحددة
        $('#deleteSelected').on('click', function() {
            let selectedIds = $('.row-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length > 0) {
                Swal.fire({
                    title: "<?php echo e(__('l.Are you sure?')); ?>",
                    text: "<?php echo e(__('l.Selected questions will be deleted!')); ?>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "<?php echo e(__('l.Yes, delete them!')); ?>",
                    cancelButtonText: "<?php echo e(__('l.Cancel')); ?>"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('dashboard.admins.questions-deleteSelected')); ?>?ids=" + selectedIds.join(',');
                    }
                });
            }
        });

        // حذف سؤال
        $('.delete-question').on('click', function() {
            var questionId = $(this).data('id');

            Swal.fire({
                title: "<?php echo e(__('l.Are you sure?')); ?>",
                text: "<?php echo e(__('l.You will be delete this forever!')); ?>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "<?php echo e(__('l.Yes, delete it!')); ?>",
                cancelButtonText: "<?php echo e(__('l.Cancel')); ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo e(route('dashboard.admins.questions-delete')); ?>?id=" + questionId;
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/pages/questions/questions-list.blade.php ENDPATH**/ ?>