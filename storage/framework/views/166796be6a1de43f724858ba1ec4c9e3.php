<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Blog Articles'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add blog')): ?>
            <div class="card-action-element mb-2" style="text-align: end;">
                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                    data-bs-target="#addTicketModal">
                    <i class="fa fa-plus fa-xs me-1"></i> <?php echo app('translator')->get('l.Add New Article'); ?>
                </button>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>


            <!-- Modal -->
            <div class="modal fade" id="addTicketModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-header">
                            <h3 class="modal-title text-center"><?php echo app('translator')->get('l.Add New Article'); ?></h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addArticleForm" class="row g-3" method="post"
                                action="<?php echo e(route('dashboard.admins.blogs.articles-store')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="meta_keywords"><?php echo app('translator')->get('l.Meta Keywords'); ?><i
                                            class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i></label>
                                    <textarea id="meta_keywords" name="meta_keywords" class="form-control">tag1, tag2, tag3</textarea>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="meta_description"><?php echo app('translator')->get('l.Meta Description'); ?><i
                                            class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i></label>
                                    <textarea id="meta_description" name="meta_description" class="form-control" placeholder="<?php echo app('translator')->get('l.Enter a meta description'); ?>"></textarea>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="title"><?php echo app('translator')->get('l.Title'); ?><i
                                            class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i></label>
                                    <input type="text" id="title" name="title" class="form-control"
                                        placeholder="<?php echo app('translator')->get('l.Enter a title'); ?>" required />
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="blog_category_id"><?php echo app('translator')->get('l.Category'); ?></label>
                                    <select id="blog_category_id" name="blog_category_id" class="form-select select2">
                                        <option value=""><?php echo app('translator')->get('l.Select a category'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="content"><?php echo app('translator')->get('l.Content'); ?>
                                        <i class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i>
                                    </label>
                                    <div id="content"></div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="image"><?php echo app('translator')->get('l.Image'); ?></label>
                                    <div class="theme-upload-area" id="image-upload-area">
                                        <input type="file" id="image" name="image" class="theme-upload-input"
                                            accept="image/*">
                                        <label for="image" class="theme-upload-label">
                                            <div class="upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <div class="upload-text">
                                                <h5><?php echo app('translator')->get('l.Drop image here or click to upload'); ?></h5>
                                                <p class="text-muted"><?php echo app('translator')->get('l.Supported formats: JPG, PNG, GIF, WebP'); ?></p>
                                            </div>
                                        </label>
                                        <div class="upload-preview d-none">
                                            <div class="preview-content">
                                                <img src="" alt="" class="preview-image"
                                                    style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                                <span class="filename"></span>
                                            </div>
                                            <button type="button" class="btn-remove-file">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-2">
                                    <label class="form-label" for="status">
                                        <?php echo app('translator')->get('l.Status'); ?>
                                        <i class="fa fa-info-circle" data-bs-toggle="tooltip" data-bs-offset="0,8"
                                            data-bs-placement="top" data-bs-custom-class="tooltip-dark"
                                            data-bs-original-title="<?php echo app('translator')->get('l.Published'); ?>: <?php echo app('translator')->get('l.The article will be available to view for visitors.'); ?> <?php echo app('translator')->get('l.Draft'); ?>: <?php echo app('translator')->get('l.The article will be hidden from visitors and saved as a draft.'); ?>"></i>
                                    </label>
                                    <select name="status" class="form-select select2">
                                        <option value="published"><?php echo app('translator')->get('l.Published'); ?></option>
                                        <option value="draft"><?php echo app('translator')->get('l.Draft'); ?></option>
                                    </select>
                                </div>

                                <div class="col-12 mb-2">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                            name="auto_translate" />
                                        <label class="form-check-label"
                                            for="flexSwitchCheckDefault"><?php echo app('translator')->get('l.Auto Translate'); ?></label>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button type="button" class="btn btn-label-secondary"
                                        data-bs-dismiss="modal"><?php echo app('translator')->get('l.Cancel'); ?></button>
                                    <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Create'); ?></button>
                                </div>

                                <!-- إضافة حقل مخفي للمحتوى -->
                                <input type="hidden" name="content" id="content-input">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="card" style="padding: 15px;">
            <div class="card-datatable table-responsive">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($error); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete blog')): ?>
                        <button id="deleteSelected" class="btn btn-danger d-none">
                            <i class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete Selected'); ?>
                        </button>
                    <?php endif; ?>
                </div>
                <table class="table" id="articles-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th>#</th>
                            <th><?php echo app('translator')->get('l.Title'); ?></th>
                            <th><?php echo app('translator')->get('l.Category'); ?></th>
                            <th><?php echo app('translator')->get('l.Views'); ?></th>
                            <th><?php echo app('translator')->get('l.Author'); ?></th>
                            <th><?php echo app('translator')->get('l.Status'); ?></th>
                            <th><?php echo app('translator')->get('l.Created At'); ?></th>
                            <th><?php echo app('translator')->get('l.Updated At'); ?></th>
                            <th><?php echo app('translator')->get('l.Action'); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function() {
            // إضافة حقل مخفي للمحتوى
            $('#addTicketForm').append('<input type="hidden" name="content">');

            // معالجة إرسال النموذج
            $('#addTicketForm').on('submit', function() {
                // الحصول على محتوى المحرر
                var content = fullEditor.root.innerHTML;
                // تحديث قيمة الحقل المخفي
                $('input[name="content"]').val(content);
            });

            let table = $('#articles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(request()->fullUrl()); ?>',
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<input type="checkbox" class="form-check-input row-checkbox" value="${data.id}">`;
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'title',
                        name: 'title',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'category',
                        name: 'category',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'views',
                        name: 'views',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'author',
                        name: 'author',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [7, 'desc']
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "<?php echo app('translator')->get('l.All'); ?>"]
                ],
                dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex align-items-center"f>>rtip',
                language: {
                    search: "<?php echo app('translator')->get('l.Search'); ?>:",
                    lengthMenu: "<?php echo app('translator')->get('l.Show'); ?> _MENU_ <?php echo app('translator')->get('l.entries'); ?>",
                    paginate: {
                        next: '<?php echo app('translator')->get('l.Next'); ?>',
                        previous: '<?php echo app('translator')->get('l.Previous'); ?>'
                    },
                    info: "<?php echo app('translator')->get('l.Showing'); ?> _START_ <?php echo app('translator')->get('l.to'); ?> _END_ <?php echo app('translator')->get('l.of'); ?> _TOTAL_ <?php echo app('translator')->get('l.entries'); ?>",
                    infoEmpty: "<?php echo app('translator')->get('l.Showing'); ?> 0 <?php echo app('translator')->get('l.To'); ?> 0 <?php echo app('translator')->get('l.Of'); ?> 0 <?php echo app('translator')->get('l.entries'); ?>",
                    infoFiltered: "<?php echo app('translator')->get('l.Showing'); ?> 1 <?php echo app('translator')->get('l.Of'); ?> 1 <?php echo app('translator')->get('l.entries'); ?>",
                    zeroRecords: "<?php echo app('translator')->get('l.No matching records found'); ?>",
                    loadingRecords: "<?php echo app('translator')->get('l.Loading...'); ?>",
                    processing: "<?php echo app('translator')->get('l.Processing...'); ?>",
                    emptyTable: "<?php echo app('translator')->get('l.No data available in table'); ?>",
                }
            });

            // حدث تحديد/إلغاء تحديد الكل
            $('#select-all').on('change', function() {
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
                updateDeleteButton();
            });

            // تحديث حالة زر الحذف عند تغيير أي صندوق تحديد
            $(document).on('change', '.row-checkbox', function() {
                updateDeleteButton();
                let allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#select-all').prop('checked', allChecked);
            });

            function updateDeleteButton() {
                let checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#deleteSelected').removeClass('d-none');
                } else {
                    $('#deleteSelected').addClass('d-none');
                }
            }

            // حذف الملاحظات المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                        text: '<?php echo app('translator')->get('l.Selected articles will be deleted!'); ?>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete them!'); ?>',
                        cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                '<?php echo e(route('dashboard.admins.blogs.articles-deleteSelected')); ?>?ids=' +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // إضافة معالج حدث الحذف للأزرار التي يتم إنشاؤها ديناميكياً
            $(document).on('click', '.delete-article', function() {
                let articleId = $(this).data('id');

                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                    text: '<?php echo app('translator')->get('l.You will be delete this forever!'); ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete it!'); ?>',
                    cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href =
                            '<?php echo e(route('dashboard.admins.blogs.articles-delete')); ?>?id=' +
                            articleId;
                    }
                });
            });
        });

        const fullEditor = new Quill('#content', {
            bounds: '#content',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });


        // حفظ المحتوى في الحقل المخفي عند التقديم
        document.getElementById('addArticleForm').addEventListener('submit', function() {
            document.getElementById('content-input').value = fullEditor.root.innerHTML;
        });

        // إضافة كود معالجة تحميل الصورة
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const uploadArea = document.getElementById('image-upload-area');
            const uploadPreview = uploadArea.querySelector('.upload-preview');
            const previewImage = uploadArea.querySelector('.preview-image');
            const filename = uploadArea.querySelector('.filename');
            const uploadLabel = uploadArea.querySelector('.theme-upload-label');
            const removeButton = uploadArea.querySelector('.btn-remove-file');

            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    if (file.type.startsWith('image/')) {
                        imageInput.files = files;
                        showImagePreview(file);
                    } else {
                        alert('<?php echo app('translator')->get('l.Please upload an image file'); ?>');
                    }
                }
            });

            function showImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    filename.textContent = file.name;
                    uploadPreview.classList.remove('d-none');
                    uploadLabel.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }

            imageInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    showImagePreview(this.files[0]);
                }
            });

            removeButton.addEventListener('click', function() {
                imageInput.value = '';
                uploadPreview.classList.add('d-none');
                uploadLabel.classList.remove('d-none');
                previewImage.src = '';
                filename.textContent = '';
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/pages/blogs/articles-list.blade.php ENDPATH**/ ?>