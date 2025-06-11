<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Import Students'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .drop-zone {
            width: 100%;
            height: 200px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
            color: #777;
            border: 4px dashed #ddd;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .drop-zone--over {
            border-style: solid;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .drop-zone__input {
            display: none;
        }

        .drop-zone__thumb {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
            background-color: #cccccc;
            background-size: cover;
            position: relative;
        }

        .drop-zone__thumb::after {
            content: attr(data-label);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 5px 0;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.75);
            font-size: 14px;
            text-align: center;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header"><?php echo app('translator')->get('l.Import Students'); ?></h5>
                    <div class="card-body">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('warning')): ?>
                            <div class="alert alert-warning">
                                <?php echo session('warning'); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($error); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <form action="<?php echo e(route('dashboard.admins.students-import-post')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="drop-zone">
                                        <span class="drop-zone__prompt"><?php echo app('translator')->get('l.Drop CSV or Excel file here or click to upload'); ?></span>
                                        <input type="file" name="file" class="drop-zone__input" accept=".csv,.txt,.xlsx,.xls">
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Import'); ?></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title"><?php echo app('translator')->get('l.File Format Instructions'); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <p><?php echo app('translator')->get('l.The file should have the following columns in order:'); ?></p>
                                        <ol>
                                            <li><?php echo app('translator')->get('l.First Name'); ?></li>
                                            <li><?php echo app('translator')->get('l.Last Name'); ?></li>
                                            <li><?php echo app('translator')->get('l.Email'); ?></li>
                                            <li><?php echo app('translator')->get('l.Phone'); ?></li>
                                            <li><?php echo app('translator')->get('l.Password'); ?> (<?php echo app('translator')->get('l.optional'); ?>)</li>
                                            <li><?php echo app('translator')->get('l.Address'); ?> (<?php echo app('translator')->get('l.optional'); ?>)</li>
                                            <li><?php echo app('translator')->get('l.State'); ?> (<?php echo app('translator')->get('l.optional'); ?>)</li>
                                            <li><?php echo app('translator')->get('l.Zip Code'); ?> (<?php echo app('translator')->get('l.optional'); ?>)</li>
                                            <li><?php echo app('translator')->get('l.Country'); ?> (<?php echo app('translator')->get('l.optional'); ?>)</li>
                                            <li><?php echo app('translator')->get('l.City'); ?> (<?php echo app('translator')->get('l.optional'); ?>)</li>
                                        </ol>
                                        <p class="text-muted"><?php echo app('translator')->get('l.If password is not provided, a default password will be set.'); ?></p>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(asset('templates/students-import-template.csv')); ?>" target="_blank" class="btn btn-outline-primary">
                                                <i class="bx bx-download me-1"></i><?php echo app('translator')->get('l.Download CSV Template'); ?>
                                            </a>
                                            <a href="<?php echo e(asset('templates/students-import-template.xlsx')); ?>" target="_blank" class="btn btn-outline-primary">
                                                <i class="bx bx-download me-1"></i><?php echo app('translator')->get('l.Download Excel Template'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        document.querySelectorAll(".drop-zone").forEach(dropZone => {
            const input = dropZone.querySelector(".drop-zone__input");
            const prompt = dropZone.querySelector(".drop-zone__prompt");

            dropZone.addEventListener("click", e => {
                input.click();
            });

            input.addEventListener("change", e => {
                if (input.files.length) {
                    updateThumbnail(dropZone, input.files[0]);
                } else {
                    prompt.textContent = "<?php echo app('translator')->get('l.Drop CSV or Excel file here or click to upload'); ?>";
                }
            });

            dropZone.addEventListener("dragover", e => {
                e.preventDefault();
                dropZone.classList.add("drop-zone--over");
            });

            ["dragleave", "dragend"].forEach(type => {
                dropZone.addEventListener(type, e => {
                    dropZone.classList.remove("drop-zone--over");
                });
            });

            dropZone.addEventListener("drop", e => {
                e.preventDefault();

                if (e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;
                    updateThumbnail(dropZone, e.dataTransfer.files[0]);
                }

                dropZone.classList.remove("drop-zone--over");
            });
        });

        function updateThumbnail(dropZone, file) {
            let thumbnailElement = dropZone.querySelector(".drop-zone__thumb");

            if (thumbnailElement) {
                thumbnailElement.remove();
            }

            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            thumbnailElement.dataset.label = file.name;

            dropZone.querySelector(".drop-zone__prompt").remove();
            dropZone.appendChild(thumbnailElement);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/students/students-import.blade.php ENDPATH**/ ?>