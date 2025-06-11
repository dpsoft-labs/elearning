<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Quiz Questions'); ?> - <?php echo e($quiz->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title"><?php echo app('translator')->get('l.Quiz Questions'); ?> - <?php echo e($quiz->title); ?></h5>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo app('translator')->get('l.Questions List'); ?></h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                            <i class="fa fa-plus me-1"></i><?php echo app('translator')->get('l.Add Question'); ?>
                        </button>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="question-card mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><?php echo e($question->question_text); ?></h6>
                                            <div>
                                                <a href="<?php echo e(route('dashboard.admins.quizzes.questions.edit', encrypt($question->id))); ?>"
                                                   class="btn btn-sm btn-primary me-2">
                                                    <i class="fa fa-edit"></i> <?php echo app('translator')->get('l.Edit'); ?>
                                                </a>
                                                <a href="<?php echo e(route('dashboard.admins.quizzes.questions.delete', encrypt($question->id))); ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('<?php echo app('translator')->get('l.Are you sure you want to delete this question?'); ?>')">
                                                    <i class="fa fa-trash"></i> <?php echo app('translator')->get('l.Delete'); ?>
                                                </a>
                                            </div>
                                        </div>

                                        <?php if($question->question_image): ?>
                                            <div class="mt-3">
                                                <img src="<?php echo e(asset($question->question_image)); ?>" class="img-fluid"
                                                    style="max-height: 200px;">
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-3">
                                            <span class="badge bg-label-primary me-2"><?php echo app('translator')->get('l.Type'); ?>: <?php echo e($question->type); ?></span>
                                            <span class="badge bg-label-success"><?php echo app('translator')->get('l.Points'); ?>: <?php echo e($question->points); ?></span>
                                        </div>

                                        <?php if($question->type !== 'essay'): ?>
                                            <div class="answers mt-3">
                                                <h6 class="mb-2"><?php echo app('translator')->get('l.Answers'); ?>:</h6>
                                                <ul class="list-group">
                                                    <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item <?php echo e($answer->is_correct ? 'list-group-item-success' : ''); ?>">
                                                            <?php echo e($answer->answer_text); ?>

                                                            <?php if($answer->answer_image): ?>
                                                                <div class="mt-2">
                                                                    <img src="<?php echo e(asset($answer->answer_image)); ?>"
                                                                        class="img-fluid" style="max-height: 100px;">
                                                                </div>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
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

    <!-- Add Question Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('l.Add New Question'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('dashboard.admins.quizzes.questions.store')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="quiz_id" value="<?php echo e($quiz->id); ?>">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label"><?php echo app('translator')->get('l.Question Text'); ?></label>
                                <textarea name="question_text" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label"><?php echo app('translator')->get('l.Question Image'); ?></label>
                                <input type="file" name="question_image" class="form-control" accept="image/*">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label"><?php echo app('translator')->get('l.Question Type'); ?></label>
                                <select name="type" class="form-select" id="questionType" required>
                                    <option value="multiple_choice"><?php echo app('translator')->get('l.Multiple Choice'); ?></option>
                                    <option value="true_false"><?php echo app('translator')->get('l.True/False'); ?></option>
                                    <option value="essay"><?php echo app('translator')->get('l.Essay'); ?></option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label"><?php echo app('translator')->get('l.Points'); ?></label>
                                <input type="number" name="points" class="form-control" min="1" required>
                            </div>

                            <div class="col-12" id="answersContainer">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label fw-bold mb-0"><?php echo app('translator')->get('l.Answers'); ?></label>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="addAnswerField(document.getElementById('answersList'))">
                                        <i class="fa fa-plus"></i> <?php echo app('translator')->get('l.Add Answer'); ?>
                                    </button>
                                </div>
                                <div id="answersList">
                                    <!-- Answer fields will be added here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"><?php echo app('translator')->get('l.Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Save'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        function addAnswerField(container, answerText = '', isCorrect = false, isReadOnly = false) {
            const answerCount = container.children.length + 1;
            const template = `
                <div class="answer-field mb-4">
                    <div class="mb-2">
                        <textarea name="answers[${answerCount}][text]" class="form-control w-100"
                                rows="3" required ${isReadOnly ? 'readonly' : ''}
                                style="resize: vertical;">${answerText}</textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="correct_answer"
                                   value="${answerCount-1}" id="correct_${answerCount}"
                                   onchange="updateCorrectAnswer(this)" ${isCorrect ? 'checked' : ''}>
                            <label class="form-check-label" for="correct_${answerCount}">
                                <?php echo app('translator')->get('l.Correct Answer'); ?>
                            </label>
                        </div>

                        ${!isReadOnly ? `
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group" style="max-width: 300px;">
                                    <input type="file" name="answers[${answerCount}][image]"
                                           class="form-control" accept="image/*">
                                </div>
                                <button type="button" class="btn btn-icon btn-label-danger btn-sm remove-answer">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        ` : ''}

                        <input type="hidden" name="answers[${answerCount}][is_correct]"
                               value="${isCorrect ? '1' : '0'}">
                    </div>

                    <div class="current-answer-image mt-2"></div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
        }

        function updateCorrectAnswer(radio) {
            const answerFields = document.querySelectorAll('.answer-field');
            answerFields.forEach(field => {
                const hiddenInput = field.querySelector('input[name^="answers"][name$="[is_correct]"]');
                hiddenInput.value = field.querySelector('input[name="correct_answer"]').checked ? '1' : '0';
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-answer')) {
                e.target.closest('.answer-field').remove();
            }
        });

        // Initialize with two answer fields for multiple choice
        document.addEventListener('DOMContentLoaded', function() {
            const questionType = document.getElementById('questionType');
            const answersList = document.getElementById('answersList');
            const answersContainer = document.getElementById('answersContainer');

            function updateAnswerFields() {
                answersList.innerHTML = '';
                if (questionType.value === 'multiple_choice') {
                    answersContainer.style.display = 'block';
                    addAnswerField(answersList);
                    addAnswerField(answersList);
                } else if (questionType.value === 'true_false') {
                    answersContainer.style.display = 'block';
                    addAnswerField(answersList, '<?php echo app('translator')->get("l.True"); ?>', false, true);
                    addAnswerField(answersList, '<?php echo app('translator')->get("l.False"); ?>', false, true);
                } else {
                    answersContainer.style.display = 'none';
                }
            }

            questionType.addEventListener('change', updateAnswerFields);
            updateAnswerFields();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/quizzes/quizzes-questions-list.blade.php ENDPATH**/ ?>