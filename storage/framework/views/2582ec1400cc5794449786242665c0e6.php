<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Roles & Permissions'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-semibold mb-4"><?php echo app('translator')->get('l.Roles List'); ?></h4>

        <p class="mb-4">
            <?php echo app('translator')->get('l.A role provided access to predefined menus and features so that depending on'); ?> <br />
            <?php echo app('translator')->get('l.assigned role an administrator can have access to what user needs.'); ?>
        </p>
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
        <!-- Role cards -->
        <div class="row g-4">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show roles')): ?>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-normal mb-2"><?php echo app('translator')->get('l.Total'); ?> <?php echo e($role->users->count()); ?>

                                        <?php echo app('translator')->get('l.users'); ?></h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-end mt-1">
                                    
                                        <div class="role-heading">
                                            <h4 class="mb-1" style="text-transform:capitalize;"><?php echo e($role->name); ?></h4>
                                            <a href="<?php echo e(route('dashboard.admins.roles-edit')); ?>?id=<?php echo e(encrypt($role->id)); ?>"
                                                class="btn btn-dark"><span><?php echo app('translator')->get('l.Edit Role'); ?></span></a>
                                        </div>
                                    
                                    
                                        <a href="javascript:void(0);" class="text-muted delete-role"
                                            data-role-id="<?php echo e(encrypt($role->id)); ?>">
                                            <i class="fa fa-trash ti-md "></i>
                                        </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card h-100">
                        <div class="row h-100">
                            <div class="col-sm-5">
                                <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                    <img src="<?php echo e(asset('assets/themes/default/img/illustrations/lady-with-laptop-light.png')); ?>"
                                        class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83" />
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="card-body text-sm-end text-center ps-sm-0">
                                    <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                        class="btn btn-primary mb-2 text-nowrap add-new-role">
                                        <?php echo app('translator')->get('l.Add New Role'); ?>
                                    </button>
                                    <p class="mb-0 mt-1"><?php echo app('translator')->get('l.Add role, if it does not exist'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
        <!--/ Role cards -->

        
            <!-- Add Role Modal -->
            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                    <div class="modal-content p-3 p-md-5">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <h3 class="role-title mb-2"><?php echo app('translator')->get('l.Add New Role'); ?></h3>
                                <p class="text-muted"><?php echo app('translator')->get('l.Set role permissions'); ?></p>
                            </div>
                            <!-- Add role form -->
                            <form id="addRoleForm" class="row g-3" method="post"
                                action="<?php echo e(route('dashboard.admins.roles-store')); ?>"><?php echo csrf_field(); ?>
                                <div class="col-12 mb-4">
                                    <label class="form-label" for="modalRoleName"><?php echo app('translator')->get('l.Role Name'); ?></label>
                                    <input type="text" id="modalRoleName" name="name" class="form-control"
                                        placeholder="<?php echo app('translator')->get('l.Enter a role name'); ?>" tabindex="-1" required />
                                </div>
                                <div class="col-12">
                                    <h5><?php echo app('translator')->get('l.Role Permissions'); ?></h5>
                                    <!-- Permission table -->
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                                <tr>
                                                    <td class="text-nowrap fw-semibold">
                                                        <?php echo app('translator')->get('l.Administrator Access'); ?>
                                                        <i class="ti ti-info-circle" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Allows a full access to the system"></i>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="selectAll" />
                                                            <label class="form-check-label" for="selectAll">
                                                                <?php echo app('translator')->get('l.Select All'); ?>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $__currentLoopData = $groupedPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center"><?php echo app('translator')->get('l.Show'); ?></td>
                                                        <td class="text-center"><?php echo app('translator')->get('l.Add'); ?></td>
                                                        <td class="text-center"><?php echo app('translator')->get('l.Edit'); ?></td>
                                                        <td class="text-center"><?php echo app('translator')->get('l.Delete'); ?></td>
                                                        <td class="text-center"><?php echo app('translator')->get('l.Other'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap fw-semibold"><?php echo e(strtoupper($groupName)); ?></td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="show <?php echo e(strtolower($groupName)); ?>"
                                                                    id="show_<?php echo e($groupName); ?>"
                                                                    name="permissions[]"
                                                                    <?php echo e($group->contains('name', 'show ' . strtolower($groupName)) ? '' : 'disabled'); ?> />
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="add <?php echo e(strtolower($groupName)); ?>"
                                                                    id="add_<?php echo e($groupName); ?>"
                                                                    name="permissions[]"
                                                                    <?php echo e($group->contains('name', 'add ' . strtolower($groupName)) ? '' : 'disabled'); ?> />
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="edit <?php echo e(strtolower($groupName)); ?>"
                                                                    id="edit_<?php echo e($groupName); ?>"
                                                                    name="permissions[]"
                                                                    <?php echo e($group->contains('name', 'edit ' . strtolower($groupName)) ? '' : 'disabled'); ?> />
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="delete <?php echo e(strtolower($groupName)); ?>"
                                                                    id="delete_<?php echo e($groupName); ?>"
                                                                    name="permissions[]"
                                                                    <?php echo e($group->contains('name', 'delete ' . strtolower($groupName)) ? '' : 'disabled'); ?> />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $permissionName = strtolower($permission->name);
                                                                    $isStandardAction = Str::startsWith($permissionName, ['show ', 'add ', 'edit ', 'delete ']);
                                                                ?>

                                                                <?php if(!$isStandardAction): ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="<?php echo e($permission->name); ?>"
                                                                            id="<?php echo e(Str::slug($permission->name)); ?>"
                                                                            name="permissions[]" />
                                                                        <label class="form-check-label" for="<?php echo e(Str::slug($permission->name)); ?>">
                                                                            <?php echo e(ucfirst(str_replace($groupName, '', $permission->name))); ?>

                                                                        </label>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                        <?php echo app('translator')->get('l.Create'); ?>
                                    </button>
                                    <button type="reset" class="btn btn-label-primary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <?php echo app('translator')->get('l.Back'); ?>
                                    </button>
                                </div>
                            </form>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Add Role Modal -->
        
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');

            selectAllCheckbox.addEventListener('change', () => {
                checkboxes.forEach((checkbox) => {
                    if (!checkbox.disabled) {
                        checkbox.checked = selectAllCheckbox.checked;
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.delete-role', function(e) {
            e.preventDefault();
            const roleId = $(this).data('role-id');

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
                    window.location.href = '<?php echo e(route('dashboard.admins.roles-delete')); ?>?id=' + roleId;
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/roles/roles-list.blade.php ENDPATH**/ ?>