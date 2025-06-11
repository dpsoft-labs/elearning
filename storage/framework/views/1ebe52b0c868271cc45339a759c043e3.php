<?php $__env->startSection('title'); ?>
    <?php echo e($attempt->quiz->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .correct-answer {
        background-color: #d4edda !important;
        border-color: #c3e6cb !important;
    }

    .incorrect-answer {
        background-color: #f8d7da !important;
        border-color: #f5c6cb !important;
    }

    .student-answer {
        border-left: 4px solid #007bff;
    }

    .student-wrong-answer {
        background-color: #f8d7da !important;
        border-color: #f5c6cb !important;
        border-left: 4px solid #dc3545 !important;
    }

    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        transition: box-shadow .3s ease-in-out;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo app('translator')->get('l.Quiz Result Summary'); ?></h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong><?php echo app('translator')->get('l.Total Score'); ?>:</strong> <?php echo e($attempt->score); ?> / <?php echo e($attempt->quiz->totalGrade()); ?></li>
                        <li class="mb-2"><strong><?php echo app('translator')->get('l.Passing Score'); ?>:</strong> <?php echo e($attempt->quiz->passing_score); ?></li>
                        <li class="mb-2">
                            <strong><?php echo app('translator')->get('l.Result'); ?>:</strong>
                            <?php if($attempt->is_passed): ?>
                                <span class="badge bg-success"><?php echo app('translator')->get('l.Passed'); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo app('translator')->get('l.Failed'); ?></span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong><?php echo app('translator')->get('l.Started At'); ?>:</strong> <?php echo e($attempt->started_at->format('Y-m-d H:i:s')); ?></li>
                        <li class="mb-2"><strong><?php echo app('translator')->get('l.Completed At'); ?>:</strong> <?php echo e($attempt->completed_at->format('Y-m-d H:i:s')); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $attempt->quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-bold mb-0"><?php echo app('translator')->get('l.Question'); ?> <?php echo e($index + 1); ?></h5>
                    <div>
                        <?php
                            $studentAnswer = $studentAnswersMap[$question->id] ?? null;
                        ?>
                        <?php if($studentAnswer): ?>
                            <?php if($studentAnswer->is_correct): ?>
                                <span class="badge bg-success"><?php echo app('translator')->get('l.Correct'); ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?php echo app('translator')->get('l.Incorrect'); ?></span>
                            <?php endif; ?>
                            <span class="badge bg-info"><?php echo app('translator')->get('l.Points'); ?>: <?php echo e($studentAnswer->points_earned); ?>/<?php echo e($question->points); ?></span>
                        <?php else: ?>
                            <span class="badge bg-warning"><?php echo app('translator')->get('l.Not Answered'); ?></span>
                            <span class="badge bg-info"><?php echo app('translator')->get('l.Points'); ?>: 0/<?php echo e($question->points); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <p class="question-text"><?php echo e($question->question_text); ?></p>

                <?php if($question->question_image): ?>
                    <div class="question-image-container text-center mb-3">
                        <img src="<?php echo e(asset($question->question_image)); ?>"
                             class="img-fluid rounded"
                             style="max-height: 300px; object-fit: contain;"
                             alt="Question Image">
                    </div>
                <?php endif; ?>

                <?php if($question->type == 'essay'): ?>
                    <div class="mt-4">
                        <h6 class="fw-bold"><?php echo app('translator')->get('l.Your Answer'); ?>:</h6>
                        <div class="p-3 border rounded student-answer">
                            <?php echo e($studentAnswer->essay_answer ?? __('l.Not Answered')); ?>

                        </div>
                    </div>
                <?php else: ?>
                    <div class="answers-container mt-4">
                        <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check answer-option mb-3 p-3 border rounded
                                <?php echo e($answer->is_correct ? 'correct-answer' : ''); ?>

                                <?php echo e($studentAnswer && $studentAnswer->answer_id == $answer->id && !$studentAnswer->is_correct ? 'student-wrong-answer' : ''); ?>

                                <?php echo e($studentAnswer && $studentAnswer->answer_id == $answer->id && $studentAnswer->is_correct ? 'student-answer correct-answer' : ''); ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="answer-text"><?php echo e($answer->answer_text); ?></span>
                                        <?php if($answer->is_correct): ?>
                                            <span class="badge bg-success ms-2"><?php echo app('translator')->get('l.Correct Answer'); ?></span>
                                        <?php endif; ?>
                                        <?php if($studentAnswer && $studentAnswer->answer_id == $answer->id): ?>
                                            <span class="badge <?php echo e($studentAnswer->is_correct ? 'bg-success' : 'bg-danger'); ?> ms-2"><?php echo app('translator')->get('l.Your Answer'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if($answer->answer_image): ?>
                                    <div class="answer-image-container text-center mt-2">
                                        <img src="<?php echo e(asset($answer->answer_image)); ?>"
                                             class="img-fluid rounded"
                                             style="max-height: 200px; object-fit: contain;"
                                             alt="Answer Image">
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/quizzes/quizzes-show.blade.php ENDPATH**/ ?>