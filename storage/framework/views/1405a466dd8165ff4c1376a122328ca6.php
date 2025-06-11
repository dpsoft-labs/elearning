<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Tasks List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/libs/jkanban/jkanban.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/libs/flatpickr/flatpickr.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/css/pages/app-kanban.css')); ?>">
    <style>
        /* تنسيقات عامة */
        .task-item {
            cursor: grab;
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 1.25rem;
        }

        .task-item:active {
            cursor: grabbing;
        }

        .task-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* تنسيقات بطاقة المهمة الجديدة */
        .task-card-fancy {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05) !important;
            border: none !important;
        }

        .task-header {
            background-color: rgba(var(--bs-primary-rgb), 0.05);
            position: relative;
        }

        .task-title {
            font-size: 0.95rem;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .task-description {
            color: var(--bs-secondary-color);
            font-size: 0.85rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.6rem;
        }

        .task-badge .badge {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
        }

        .task-info {
            font-size: 0.85rem;
        }

        /* تنسيقات جديدة للتواريخ */
        .task-dates {
            padding-top: 0.2rem;
        }

        .task-date-item {
            text-align: center;
            position: relative;
            transition: all 0.2s ease;
        }

        .task-date-item:hover {
            transform: translateY(-3px);
        }

        .task-date-item .badge {
            transition: all 0.2s ease;
        }

        .task-date-item:hover .badge {
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .task-date-item small {
            font-size: 0.75rem;
            line-height: 1.2;
        }

        /* تنسيقات أعمدة المهام */
        .task-status-column {
            min-height: 300px;
            padding: 0.75rem;
        }

        .card-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-body {
            padding: 0;
        }

        .progress {
            overflow: hidden;
            background-color: var(--bs-secondary-bg);
        }

        /* تنسيقات offcanvas */
        .offcanvas-task-details {
            width: 360px;
            color: var(--bs-body-color);
        }

        .offcanvas-task-details .offcanvas-header {
            border-bottom: 1px solid var(--bs-border-color);
        }

        .task-details-section {
            padding: 1.5rem;
            border-bottom: 1px solid var(--bs-border-color);
        }

        .task-details-section:last-child {
            border-bottom: none;
        }

        .list-group-item {
            border-left: 0;
            border-right: 0;
            padding-left: 0;
            padding-right: 0;
            margin-bottom: 0.5rem;
        }

        /* تنسيقات Avatar */
        .avatar-md {
            width: 40px;
            height: 40px;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
        }

        .avatar-xs {
            width: 24px;
            height: 24px;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* تنسيقات الشريط الجانبي */
        .kanban-container {
            min-height: 700px;
        }

        /* تنسيقات لشاشات الجوال */
        @media (max-width: 767.98px) {
            .task-title {
                max-width: 140px;
            }

            .task-info .text-truncate {
                max-width: 90px !important;
            }

            .offcanvas-task-details {
                width: 300px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-kanban">
            <!-- إضافة مهمة جديدة -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add tasks')): ?>
                <div class="row mb-4">
                    <div class="col-12 d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
                                <i class="icon-base bx bx-plus"></i>
                                <span class="align-middle"><?php echo e(__('l.Add New Task')); ?></span>
                            </button>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete tasks')): ?>
                            <div>
                                <button id="deleteSelectedTasks" class="btn btn-danger d-none">
                                    <i class="bx bx-trash me-1"></i>
                                    <span class="align-middle"><?php echo e(__('l.Delete Selected Tasks')); ?></span>
                                </button>
                                <button id="selectAllTasks" class="btn btn-outline-primary">
                                    <i class="bx bx-select-multiple me-1"></i>
                                    <span class="align-middle"><?php echo e(__('l.Select All Tasks')); ?></span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- عرض المهام في لوحة كانبان -->
            <div class="row g-3" id="kanban-container">
                <!-- المهام الجديدة -->
                <div class="col-md-6 col-lg-4 mb-0">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center pb-1">
                            <h5 class="card-title mb-0 text-primary d-flex align-items-center">
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary p-1 me-2" style="width: 24px; height: 24px;">
                                    <i class="bx bx-plus-circle"></i>
                                </span>
                                <?php echo e(__('l.New Tasks')); ?>

                            </h5>
                            <span class="badge bg-label-primary rounded-pill"><?php echo e($tasksByStatus['new']->count()); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="kanban-task-list task-status-column" id="new-tasks" data-status="new">
                                <?php $__currentLoopData = $tasksByStatus['new']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('themes.default.back.admins.tasks.partials.task-card', ['task' => $task, 'status' => 'new'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المهام قيد التنفيذ -->
                <div class="col-md-6 col-lg-4 mb-0">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center pb-1">
                            <h5 class="card-title mb-0 text-info d-flex align-items-center">
                                <span class="badge rounded-pill bg-info bg-opacity-10 text-info p-1 me-2" style="width: 24px; height: 24px;">
                                    <i class="bx bx-loader-circle"></i>
                                </span>
                                <?php echo e(__('l.In Progress')); ?>

                            </h5>
                            <span class="badge bg-label-info rounded-pill"><?php echo e($tasksByStatus['in_progress']->count()); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="kanban-task-list task-status-column" id="in-progress-tasks" data-status="in_progress">
                                <?php $__currentLoopData = $tasksByStatus['in_progress']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('themes.default.back.admins.tasks.partials.task-card', ['task' => $task, 'status' => 'in_progress'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المهام المكتملة -->
                <div class="col-md-6 col-lg-4 mb-0">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center pb-1">
                            <h5 class="card-title mb-0 text-success d-flex align-items-center">
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success p-1 me-2" style="width: 24px; height: 24px;">
                                    <i class="bx bx-check-circle"></i>
                                </span>
                                <?php echo e(__('l.Completed')); ?>

                            </h5>
                            <span class="badge bg-label-success rounded-pill"><?php echo e($tasksByStatus['completed']->count()); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="kanban-task-list task-status-column" id="completed-tasks" data-status="completed">
                                <?php $__currentLoopData = $tasksByStatus['completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('themes.default.back.admins.tasks.partials.task-card', ['task' => $task, 'status' => 'completed'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- صف ثاني للأنواع الأخرى من المهام -->
            <div class="row g-3 mt-3">
                <!-- المهام المتأخرة -->
                <div class="col-md-6 mb-0">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center pb-1">
                            <h5 class="card-title mb-0 text-danger d-flex align-items-center">
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger p-1 me-2" style="width: 24px; height: 24px;">
                                    <i class="bx bx-time-five"></i>
                                </span>
                                <?php echo e(__('l.Delayed')); ?>

                            </h5>
                            <span class="badge bg-label-danger rounded-pill"><?php echo e($tasksByStatus['delayed']->count()); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="kanban-task-list task-status-column" id="delayed-tasks" data-status="delayed">
                                <?php $__currentLoopData = $tasksByStatus['delayed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('themes.default.back.admins.tasks.partials.task-card', ['task' => $task, 'status' => 'delayed'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المهام الملغاة -->
                <div class="col-md-6 mb-0">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center pb-1">
                            <h5 class="card-title mb-0 text-secondary d-flex align-items-center">
                                <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary p-1 me-2" style="width: 24px; height: 24px;">
                                    <i class="bx bx-x-circle"></i>
                                </span>
                                <?php echo e(__('l.Cancelled')); ?>

                            </h5>
                            <span class="badge bg-label-secondary rounded-pill"><?php echo e($tasksByStatus['cancelled']->count()); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="kanban-task-list task-status-column" id="cancelled-tasks" data-status="cancelled">
                                <?php $__currentLoopData = $tasksByStatus['cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('themes.default.back.admins.tasks.partials.task-card', ['task' => $task, 'status' => 'cancelled'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- نموذج إضافة مهمة جديدة -->
        <?php echo $__env->make('themes.default.back.admins.tasks.partials.add-task-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('assets/themes/default/vendor/libs/moment/moment.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/themes/default/vendor/libs/jkanban/jkanban.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/themes/default/vendor/libs/flatpickr/flatpickr.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // التحقق من المهام المتأخرة عند تحميل الصفحة وكل دقيقة بعد ذلك
            checkOverdueTasks();
            setInterval(checkOverdueTasks, 60000); // التحقق كل دقيقة

            // تهيئة المودال يدويًا
            const taskModalEl = document.getElementById('taskModal');
            if (taskModalEl) {
                const taskModalOptions = {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                };
                const taskModal = new bootstrap.Modal(taskModalEl, taskModalOptions);

                // إضافة معالج الحدث للزر الذي يفتح المودال
                document.querySelector('[data-bs-target="#taskModal"]')?.addEventListener('click', function() {
                    taskModal.show();
                });
            }

            // دالة للتحقق من المهام المتأخرة وتحديث حالتها تلقائيًا
            function checkOverdueTasks() {
                fetch('<?php echo e(route("dashboard.admins.tasks-check-overdue")); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.count > 0) {
                        console.log(`<?php echo e(__('l.Updated')); ?> ${data.count} <?php echo e(__('l.delayed tasks')); ?>`);
                        // إعادة تحميل الصفحة إذا تم تحديث أي مهمة
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('<?php echo e(__('l.Error in checking overdue tasks:')); ?>', error);
                });
            }

            // إدارة تحديد المهام متعددة
            const selectAllTasksBtn = document.getElementById('selectAllTasks');
            const deleteSelectedTasksBtn = document.getElementById('deleteSelectedTasks');
            const taskCheckboxes = document.querySelectorAll('.task-checkbox');

            // تحديد أو إلغاء تحديد كل المهام
            if (selectAllTasksBtn) {
                let allSelected = false;
                selectAllTasksBtn.addEventListener('click', function() {
                    allSelected = !allSelected;
                    taskCheckboxes.forEach(checkbox => {
                        checkbox.checked = allSelected;
                    });
                    updateDeleteButtonVisibility();

                    // تغيير نص الزر حسب الحالة
                    this.innerHTML = allSelected ?
                        '<i class="bx bx-check-square me-1"></i><span class="align-middle"><?php echo e(__('l.Deselect All')); ?></span>' :
                        '<i class="bx bx-select-multiple me-1"></i><span class="align-middle"><?php echo e(__('l.Select All')); ?></span>';
                });
            }

            // التحقق من عدد العناصر المحددة وتحديث حالة زر الحذف
            function updateDeleteButtonVisibility() {
                const checkedCount = document.querySelectorAll('.task-checkbox:checked').length;
                if (deleteSelectedTasksBtn) {
                    if (checkedCount > 0) {
                        deleteSelectedTasksBtn.classList.remove('d-none');
                        deleteSelectedTasksBtn.innerHTML = `<i class="bx bx-trash me-1"></i><span class="align-middle"><?php echo e(__('l.Delete Selected Tasks')); ?> (${checkedCount})</span>`;
                    } else {
                        deleteSelectedTasksBtn.classList.add('d-none');
                    }
                }
            }

            // إضافة معالج الأحداث للتحقق من كل مهمة يتم تحديدها أو إلغاء تحديدها
            taskCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateDeleteButtonVisibility);
            });

            // معالجة حدث النقر على زر حذف المهام المحددة
            if (deleteSelectedTasksBtn) {
                deleteSelectedTasksBtn.addEventListener('click', function() {
                    const selectedTaskIds = Array.from(document.querySelectorAll('.task-checkbox:checked'))
                        .map(checkbox => checkbox.value);

                    if (selectedTaskIds.length > 0) {
                        Swal.fire({
                            title: '<?php echo e(__('l.Are you sure?')); ?>',
                            text: `<?php echo e(__('l.This will delete')); ?> ${selectedTaskIds.length} <?php echo e(__('l.tasks from the database!')); ?>`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '<?php echo e(__('l.Yes, delete them!')); ?>',
                            cancelButtonText: '<?php echo e(__('l.Cancel')); ?>',
                            customClass: {
                                confirmButton: 'btn btn-danger me-3',
                                cancelButton: 'btn btn-label-secondary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `<?php echo e(route('dashboard.admins.tasks-delete-selected')); ?>?ids=${selectedTaskIds.join(',')}`;
                            }
                        });
                    }
                });
            }

            // تهيئة السحب والإفلات
            const taskColumns = document.querySelectorAll('.task-status-column');
            const taskUpdateToast = document.getElementById('taskUpdateToast') ?
                                  new bootstrap.Toast(document.getElementById('taskUpdateToast')) : null;

            taskColumns.forEach(column => {
                new Sortable(column, {
                    group: {
                        name: 'tasks',
                        pull: function(to, from) {
                            // يمكن للجميع سحب المهام من أي مكان إذا كان لديهم الصلاحية المناسبة
                            return true;
                        },
                        put: function(to, from) {
                            // الحصول على الحالة المستهدفة
                            const targetStatus = to.el.getAttribute('data-status');

                            <?php if(Gate::allows('edit tasks')): ?>
                                // إذا كان المستخدم لديه صلاحية تعديل المهام، يمكنه نقلها إلى أي حالة
                                return true;
                            <?php else: ?>
                                // إذا لم يكن لديه صلاحية التعديل، فيمكنه فقط نقل المهام بين "جديدة" و"قيد التنفيذ" و"مكتملة"
                                return ['new', 'in_progress', 'completed'].includes(targetStatus);
                            <?php endif; ?>
                        }
                    },
                    animation: 150,
                    ghostClass: 'bg-light',
                    onStart: function(evt) {
                        evt.item.querySelectorAll('a, button').forEach(el => {
                            el.style.pointerEvents = 'none';
                        });
                    },
                    onEnd: function(evt) {
                        evt.item.querySelectorAll('a, button').forEach(el => {
                            el.style.pointerEvents = 'auto';
                        });

                        const taskId = evt.item.getAttribute('data-task-id');
                        const newStatus = evt.to.getAttribute('data-status');
                        const fromStatus = evt.from.getAttribute('data-status');

                        // التحقق ما إذا كان المستخدم له الصلاحية لنقل المهمة إلى هذه الحالة
                        <?php if(!Gate::allows('edit tasks')): ?>
                            // إذا كان المستخدم ليس لديه صلاحية التعديل ويحاول نقل المهمة إلى حالة غير مسموح بها
                            if (!['new', 'in_progress', 'completed'].includes(newStatus)) {
                                // إعادة العنصر إلى مكانه الأصلي
                                evt.from.appendChild(evt.item);
                                showErrorAlert('<?php echo e(__('l.You do not have permission to move the task to this status')); ?>');
                                return;
                            }
                        <?php endif; ?>

                        if (taskId && newStatus) {
                            // إذا كانت الحالة السابقة "مكتملة" والحالة الجديدة ليست "مكتملة"، نحتاج لتصفير تاريخ الإكمال
                            const needResetCompletedAt = (fromStatus === 'completed' && newStatus !== 'completed');
                            updateTaskStatus(taskId, newStatus, needResetCompletedAt);
                        }
                    }
                });
            });

            // تحديث حالة المهمة
            function updateTaskStatus(taskId, newStatus, resetCompletedAt = false) {
                const currentTask = document.querySelector(`[data-task-id="${taskId}"]`);
                if (currentTask) {
                    currentTask.style.opacity = '0.6';
                }

                const formData = new FormData();
                formData.append('task_id', taskId);
                formData.append('status', newStatus);
                if (resetCompletedAt) {
                    formData.append('reset_completed_at', 'true');
                }
                formData.append('_token', '<?php echo e(csrf_token()); ?>');

                fetch('<?php echo e(route('dashboard.admins.tasks-update-status')); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessAlert('<?php echo e(__('l.Task status updated successfully')); ?>');

                        // تحديث عدد المهام وإعادة تحميل الصفحة
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    } else {
                        showErrorAlert('<?php echo e(__('l.An error occurred while updating the task status:')); ?> ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('<?php echo e(__('l.An error occurred while connecting to the server')); ?>');
                })
                .finally(() => {
                    if (currentTask) {
                        currentTask.style.opacity = '1';
                    }
                });
            }

            // إضافة معالج للنقر على زر إكمال المهمة
            document.querySelectorAll('.complete-task-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const taskId = this.getAttribute('data-task-id');
                    if (taskId) {
                        // إظهار رسالة تأكيد
                        if (confirm('<?php echo e(__('l.Are you sure you want to complete this task?')); ?>')) {
                            updateTaskStatus(taskId, 'completed');

                            // إغلاق نافذة التفاصيل
                            const offcanvasEl = this.closest('.offcanvas');
                            if (offcanvasEl) {
                                const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                                if (offcanvas) {
                                    offcanvas.hide();
                                }
                            }
                        }
                    }
                });
            });

            // عرض رسائل النجاح والخطأ باستخدام toastr
            function showSuccessAlert(message) {
                if (typeof toastr !== 'undefined') {
                    toastr.success(message);
                } else {
                    alert(message);
                }
            }

            function showErrorAlert(message) {
                if (typeof toastr !== 'undefined') {
                    toastr.error(message);
                } else {
                    alert(message);
                }
            }

            // تحديث عدد المهام في كل عمود
            function updateTaskCounts() {
                const columns = [
                    { id: 'new-tasks', badge: document.querySelector('.card-title.text-primary').nextElementSibling },
                    { id: 'in-progress-tasks', badge: document.querySelector('.card-title.text-info').nextElementSibling },
                    { id: 'completed-tasks', badge: document.querySelector('.card-title.text-success').nextElementSibling },
                    { id: 'delayed-tasks', badge: document.querySelector('.card-title.text-danger').nextElementSibling },
                    { id: 'cancelled-tasks', badge: document.querySelector('.card-title.text-secondary').nextElementSibling }
                ];

                columns.forEach(column => {
                    const count = document.getElementById(column.id)?.querySelectorAll('.task-item').length || 0;
                    if (column.badge) {
                        column.badge.textContent = count;
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/tasks/tasks-list.blade.php ENDPATH**/ ?>