<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Support Tickets'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('seo'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="app-content">
        <div class="container-fluid">
            <div class="content-wrapper">
                <h4 class="fw-semibold mb-4"><?php echo app('translator')->get('l.Support Tickets'); ?></h4>
                <div class="card-action-element mb-2 add-new-product" style="text-align: end; ">
                    <a href="#" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                        class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-plus bx-xs me-1"></i><?php echo app('translator')->get('l.Add New Ticket'); ?>
                    </a>
                </div>
                <!-- Add Role Modal -->
                <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role"
                        style="justify-content: center;">
                        <div class="modal-content p-3 p-md-5 col-md-8">
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <h3 class="role-title mb-2"><?php echo app('translator')->get('l.Add New Ticket'); ?></h3>
                                </div>
                                <!-- Add role form -->
                                <form id="addRoleForm" class="row g-3" method="post"
                                    action="<?php echo e(route('dashboard.users.tickets-store')); ?>"><?php echo csrf_field(); ?>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="modalRoleName"><?php echo app('translator')->get('l.Subject'); ?></label>
                                        <input type="text" id="modalRoleName" name="subject" class="form-control"
                                            placeholder="<?php echo app('translator')->get('l.Enter a Subject'); ?>" tabindex="-1" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="id"><?php echo app('translator')->get('l.Support Type'); ?></label>
                                        <select id="id" class="select2 form-control" name="support_type" required>
                                            <option value=""><?php echo app('translator')->get('l.Select'); ?></option>
                                            <option value="sales support"><?php echo app('translator')->get('l.Sales support'); ?></option>
                                            <option value="technical support"><?php echo app('translator')->get('l.Technical support'); ?></option>
                                            <option value="Admin"><?php echo app('translator')->get('l.Admin'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="Whois"><?php echo app('translator')->get('l.Description'); ?></label>
                                        <textarea id="Whois" name="description" class="form-control" required rows="10"></textarea>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary me-sm-3 me-1"><?php echo app('translator')->get('l.Submit'); ?></button>
                                    </div>
                                </form>
                                <!--/ Add role form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Add Role Modal -->

                <div class="card" style="padding: 15px;">
                    <div class="card-datatable table-responsive">
                        <table class="table" id="tickets-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo app('translator')->get('l.Subject'); ?></th>
                                    <th><?php echo app('translator')->get('l.Support Type'); ?></th>
                                    <th><?php echo app('translator')->get('l.Description'); ?></th>
                                    <th><?php echo app('translator')->get('l.Status'); ?></th>
                                    <th><?php echo app('translator')->get('l.Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td class="capital"><?php echo e(Str::limit($ticket->subject, 18)); ?></td>
                                        <td class="capital"><?php echo e(__('l.' . ucfirst($ticket->support_type))); ?></td>
                                        <td class="capital"><?php echo e(Str::limit($ticket->description, 45)); ?></td>
                                        <td class="capital">
                                            <?php if($ticket->status == 'answered'): ?>
                                                <span class="badge bg-success"><?php echo app('translator')->get('l.Answered'); ?></span>
                                            <?php elseif($ticket->status == 'in_progress'): ?>
                                                <span class="badge bg-danger"><?php echo app('translator')->get('l.In Progress'); ?></span>
                                            <?php elseif($ticket->status == 'closed'): ?>
                                                <span class="badge bg-dark"><?php echo app('translator')->get('l.Closed'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="capital">
                                            <?php if($ticket->status == 'closed'): ?>
                                                <button class="btn rounded-pill btn-label-secondary waves-effect"
                                                    disabled><i class="bx bx-show bx-xs"></i></button>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('dashboard.users.tickets-show')); ?>?id=<?php echo e(encrypt($ticket->id)); ?>"
                                                    data-bs-toggle="tooltip" title="<?php echo app('translator')->get('l.Show'); ?>"
                                                    class="btn rounded-pill btn-info waves-effect"><i class="bx bx-show bx-xs"></i>
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        var table = $('#tickets-table').DataTable({
            ordering: true,
            order: [],
            searching: false
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRoleButton = document.querySelector('.add-new-product');
            const addRoleModal = document.querySelector('#addRoleModal');

            addRoleButton.addEventListener('click', function() {
                var modal = new bootstrap.Modal(addRoleModal);
                modal.show();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/tickets/tickets.blade.php ENDPATH**/ ?>