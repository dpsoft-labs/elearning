<div class="quiz-attempt-review">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0"><?php echo app('translator')->get('l.Student'); ?>: <?php echo e($attempt->user->firstname); ?> <?php echo e($attempt->user->lastname); ?></h6>
                <div class="d-flex gap-3">
                    <span><?php echo app('translator')->get('l.Total Score'); ?>: <strong id="total-score-<?php echo e($attempt->id); ?>"><?php echo e($attempt->score); ?></strong>/<?php echo e($quiz->totalGrade()); ?></span>
                    <span><?php echo app('translator')->get('l.Passing Score'); ?>: <?php echo e($quiz->passing_score); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="questions-list">
        <?php $__currentLoopData = $attempt->studentAnswers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><?php echo app('translator')->get('l.Question'); ?> <?php echo e($index + 1); ?></h6>
                    <span class="badge bg-label-info"><?php echo e($answer->question->points); ?> <?php echo app('translator')->get('l.points'); ?></span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="mb-2"><?php echo app('translator')->get('l.Question Text'); ?></h6>
                        <p class="mb-0"><?php echo e($answer->question->question_text); ?></p>
                        <?php if($answer->question->question_image): ?>
                            <div class="mt-3">
                                <img src="<?php echo e(asset($answer->question->question_image)); ?>" class="img-fluid"
                                    style="max-height: 200px">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="<?php echo e($answer->question->type != 'essay' ? 'col-md-6' : 'col-md-12'); ?>">
                                    <h6 class="mb-3"><?php echo app('translator')->get('l.Student Answer'); ?></h6>
                                    <?php if($answer->question->type == 'essay'): ?>
                                        <div class="p-3 bg-lighter rounded">
                                            <?php echo e($answer->essay_answer); ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="selected-answer">
                                            <?php if($answer->answer): ?>
                                                <div class="d-flex align-items-center">
                                                    <span><?php echo e($answer->answer->answer_text); ?></span>
                                                </div>
                                                <?php if($answer->answer->answer_image): ?>
                                                    <div class="mt-3">
                                                        <img src="<?php echo e(asset($answer->answer->answer_image)); ?>" class="img-fluid"
                                                            style="max-height: 150px">
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted"><?php echo app('translator')->get('l.No Answer'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if($answer->question->type != 'essay'): ?>
                                    <div class="col-md-6">
                                        <h6 class="mb-3"><?php echo app('translator')->get('l.Correct Answer'); ?></h6>
                                        <div class="correct-answer">
                                            <?php
                                                $correctAnswer = $answer->question->answers()->where('is_correct', true)->first();
                                            ?>

                                            <?php if($correctAnswer): ?>
                                                <div class="d-flex align-items-center">
                                                    <span><?php echo e($correctAnswer->answer_text); ?></span>
                                                </div>
                                                <?php if($correctAnswer->answer_image): ?>
                                                    <div class="mt-3">
                                                        <img src="<?php echo e(asset($correctAnswer->answer_image)); ?>" class="img-fluid"
                                                            style="max-height: 150px">
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted"><?php echo app('translator')->get('l.No Answer'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><?php echo app('translator')->get('l.Points'); ?></label>
                            <input type="number" class="form-control" value="<?php echo e($answer->points_earned); ?>"
                                min="0" max="<?php echo e($answer->question->points); ?>"
                                onchange="updateGrade(<?php echo e($answer->id); ?>, this.value, <?php echo e($attempt->id); ?>, this)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo app('translator')->get('l.Status'); ?></label>
                            <select class="form-select"
                                onchange="updateAnswerStatus(<?php echo e($answer->id); ?>, this.value, <?php echo e($attempt->id); ?>, this)">
                                <option value="1" <?php echo e($answer->is_correct ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Correct'); ?></option>
                                <option value="0" <?php echo e(!$answer->is_correct ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Incorrect'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<style>
.student-and-correct-answers {
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 5px;
}

.student-and-correct-answers .col-md-6 {
    padding: 15px;
}

@media (min-width: 768px) {
    .student-and-correct-answers .row {
        display: flex;
        flex-wrap: nowrap;
    }

    .student-and-correct-answers .col-md-6:first-child {
        border-right: 1px solid #eee;
    }
}

.selected-answer, .correct-answer {
    margin-top: 10px;
}
</style>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/quizzes/quizzes-grade-attempt.blade.php ENDPATH**/ ?>