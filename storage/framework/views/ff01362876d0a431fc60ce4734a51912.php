<!-- Modal Task -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel"><?php echo e(__('l.Add New Task')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTaskForm" action="<?php echo e(route('dashboard.admins.tasks-store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="title" class="form-label required"><?php echo e(__('l.Task Title')); ?></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label required"><?php echo e(__('l.Task Description')); ?></label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="assigned_to" class="form-label required"><?php echo e(__('l.Assign To')); ?></label>
                            <select class="form-select select2" id="assigned_to" name="assigned_to" required>
                                <option value=""><?php echo e(__('l.Select User')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->firstname . ' ' . $user->lastname); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="due_date" class="form-label required"><?php echo e(__('l.Due Date')); ?></label>
                            <input type="datetime-local" class="form-control" id="due_date" name="due_date" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('l.Cancel')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('l.Save Task')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/tasks/partials/add-task-modal.blade.php ENDPATH**/ ?>