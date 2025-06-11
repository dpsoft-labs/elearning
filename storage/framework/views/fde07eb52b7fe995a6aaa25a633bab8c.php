<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Team Members List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        #imagePreview {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            display: none;
            margin-top: 10px;
        }

        .team-card {
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .team-card .card-img-top {
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .team-card .card-body {
            padding: 1.25rem;
        }

        .team-card .card-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .team-card .card-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .team-social-icons {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .team-social-icons a {
            background: #f8f9fa;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .team-social-icons a:hover {
            transform: scale(1.1);
        }

        .team-social-icons .facebook:hover {
            background: #4267B2;
            color: white;
        }

        .team-social-icons .twitter:hover {
            background: #1DA1F2;
            color: white;
        }

        .team-social-icons .instagram:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: white;
        }

        .team-social-icons .linkedin:hover {
            background: #0077B5;
            color: white;
        }

        .team-actions {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12">
                <h5 class="card-title"><?php echo e(__('l.Team Members List')); ?></h5>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add team_members')): ?>
                    <div class="text-end mb-3">
                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addTeamMemberModal">
                            <i class="bx bx-plus me-1"></i> <?php echo e(__('l.Add New Member')); ?>

                        </a>
                    </div>
                <?php endif; ?>

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
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">
                            <?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="card team-card">
                                        <?php if($team->image): ?>
                                            <img src="<?php echo e(asset($team->image)); ?>" class="card-img-top"
                                                alt="<?php echo e($team->name); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('images/default-user.png')); ?>" class="card-img-top"
                                                alt="<?php echo e($team->name); ?>">
                                        <?php endif; ?>
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?php echo e($team->name); ?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted"><?php echo e($team->job); ?></h6>

                                            <div class="team-social-icons">
                                                <?php if($team->facebook): ?>
                                                    <a href="<?php echo e($team->facebook); ?>" target="_blank" class="facebook"><i
                                                            class="bx bxl-facebook"></i></a>
                                                <?php endif; ?>
                                                <?php if($team->twitter): ?>
                                                    <a href="<?php echo e($team->twitter); ?>" target="_blank" class="twitter"><i
                                                            class="bx bxl-twitter"></i></a>
                                                <?php endif; ?>
                                                <?php if($team->instagram): ?>
                                                    <a href="<?php echo e($team->instagram); ?>" target="_blank" class="instagram"><i
                                                            class="bx bxl-instagram"></i></a>
                                                <?php endif; ?>
                                                <?php if($team->linkedin): ?>
                                                    <a href="<?php echo e($team->linkedin); ?>" target="_blank" class="linkedin"><i
                                                            class="bx bxl-linkedin"></i></a>
                                                <?php endif; ?>
                                            </div>

                                            <div class="team-actions">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit team_members')): ?>
                                                    <a href="<?php echo e(route('dashboard.admins.teams-edit', ['id' => encrypt($team->id)])); ?>"
                                                        class="btn btn-sm btn-icon btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete team_members')): ?>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-sm btn-icon btn-danger delete-team"
                                                        data-id="<?php echo e(encrypt($team->id)); ?>">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12 text-center p-5">
                                    <div class="alert alert-info">
                                        <i class="bx bx-info-circle me-1"></i>
                                        <?php echo e(__('l.No data found')); ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Team Member Modal -->
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add team_members')): ?>
        <div class="modal fade" id="addTeamMemberModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e(__('l.Add New Team Member')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo e(route('dashboard.admins.teams-store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Name')); ?> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Job Title')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="job" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Profile Image')); ?></label>
                                    <input type="file" class="form-control" name="image" id="modalImageInput"
                                        accept="image/*">
                                    <small class="text-muted"><?php echo e(__('l.Allowed JPG, GIF or PNG. Max size of 800K')); ?></small>
                                    <div class="text-center">
                                        <img id="imagePreview" src="#" alt="<?php echo e(__('l.Image Preview')); ?>" width="150"
                                            height="150" class="rounded">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Facebook URL')); ?></label>
                                    <input type="url" class="form-control" name="facebook">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Twitter URL')); ?></label>
                                    <input type="url" class="form-control" name="twitter">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Instagram URL')); ?></label>
                                    <input type="url" class="form-control" name="instagram">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.LinkedIn URL')); ?></label>
                                    <input type="url" class="form-control" name="linkedin">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal"><?php echo e(__('l.Cancel')); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo e(__('l.Add Member')); ?></button>
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
            $('.delete-team').on('click', function() {
                var teamId = $(this).data('id');

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
                        window.location.href = "<?php echo e(route('dashboard.admins.teams-delete')); ?>?id=" +
                            teamId;
                    }
                });
            });

            $('#modalImageInput').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreview').css('display', 'block');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/pages/teams/teams-list.blade.php ENDPATH**/ ?>