<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Translate SEO Page'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .nav-tabs .nav-link {
        position: relative;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #696cff;
    }
    .nav-tabs .nav-link:hover:not(.active) {
        background-color: rgba(105, 108, 255, 0.05);
        border-color: transparent;
    }
    .back-btn {
        transition: all 0.3s ease;
    }
    .back-btn:hover {
        transform: translateX(-5px);
    }
    .textarea-counter {
        position: absolute;
        bottom: 10px;
        right: 10px;
        font-size: 0.75rem;
        color: #697a8d;
        background: rgba(255,255,255,0.9);
        padding: 0 5px;
        border-radius: 4px;
    }
    .textarea-wrapper {
        position: relative;
    }
    .auto-translate-btn {
        transition: all 0.3s ease;
    }
    .auto-translate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(33, 37, 41, 0.25);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="<?php echo e(route('dashboard.admins.seo')); ?>" class="btn btn-icon btn-outline-primary back-btn me-3">
                <i class="bx bx-arrow-back"></i>
            </a>
            <h4 class="fw-bold py-3 mb-0">
                <i class="bx bx-globe text-primary me-1"></i>
                <?php echo app('translator')->get('l.Translate SEO Page'); ?>: <?php echo e($seoPage->getTranslation('title', $defaultLanguage)); ?>

            </h4>
        </div>

        <a href="<?php echo e(route('dashboard.admins.seo-auto-translate', ['id' => encrypt($seoPage->id)])); ?>" class="btn btn-dark auto-translate-btn">
            <i class="bx bx-bulb me-1"></i> <?php echo app('translator')->get('l.Auto Translate'); ?>
        </a>
    </div>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bx bx-info-circle me-1"></i>
        <?php echo app('translator')->get('l.Please note that automatic translation for large content is not efficient and may take some time, so we do not recommend using it for large content'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0"><?php echo app('translator')->get('l.Translate SEO Content'); ?></h5>
        </div>

        <div class="card-body">
            <form id="translateForm" method="post" action="<?php echo e(route('dashboard.admins.seo-translate')); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="id" value="<?php echo e(encrypt($seoPage->id)); ?>">

                <ul class="nav nav-tabs mb-4" role="tablist">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link d-flex align-items-center <?php echo e($loop->first ? 'active' : ''); ?>"
                                role="tab" data-bs-toggle="tab" data-bs-target="#lang-<?php echo e($language->code); ?>"
                                aria-controls="lang-<?php echo e($language->code); ?>"
                                aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                <i class="fi fi-<?php echo e(strtolower($language->flag)); ?> me-2"></i>
                                <?php echo e($language->native); ?>

                            </button>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <div class="tab-content">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>"
                            id="lang-<?php echo e($language->code); ?>" role="tabpanel">

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-text text-primary me-2"></i>
                                        <?php echo app('translator')->get('l.Meta Title'); ?> (<?php echo e($language->native); ?>)
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <input
                                            type="text"
                                            class="form-control translation-input"
                                            name="title-<?php echo e($language->code); ?>"
                                            required
                                            placeholder="<?php echo app('translator')->get('l.Enter title in'); ?> <?php echo e($language->native); ?>"
                                            id="title-<?php echo e($language->code); ?>"
                                            maxlength="255"
                                            value="<?php echo e($seoPage->getTranslation('title', $language->code, false)); ?>"
                                        >
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-detail text-primary me-2"></i>
                                        <?php echo app('translator')->get('l.Meta Description'); ?> (<?php echo e($language->native); ?>)
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <textarea
                                            class="form-control translation-input"
                                            name="description-<?php echo e($language->code); ?>"
                                            rows="3"
                                            required
                                            placeholder="<?php echo app('translator')->get('l.Enter description in'); ?> <?php echo e($language->native); ?>"
                                            id="description-<?php echo e($language->code); ?>"
                                            maxlength="500"
                                        ><?php echo e($seoPage->getTranslation('description', $language->code, false)); ?></textarea>
                                        <div class="textarea-counter">
                                            <span id="description-count-<?php echo e($language->code); ?>">0</span>/500
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-tag text-primary me-2"></i>
                                        <?php echo app('translator')->get('l.Meta Keywords'); ?> (<?php echo e($language->native); ?>)
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <textarea
                                            class="form-control translation-input"
                                            name="keywords-<?php echo e($language->code); ?>"
                                            rows="2"
                                            required
                                            placeholder="<?php echo app('translator')->get('l.Enter keywords in'); ?> <?php echo e($language->native); ?>"
                                            id="meta_keywords-<?php echo e($language->code); ?>"
                                            maxlength="500"
                                        ><?php echo e($seoPage->getTranslation('keywords', $language->code, false)); ?></textarea>
                                        <div class="textarea-counter">
                                            <span id="keywords-count-<?php echo e($language->code); ?>">0</span>/500
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-share-alt text-primary me-2"></i>
                                        <?php echo app('translator')->get('l.OG Title'); ?> (<?php echo e($language->native); ?>)
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <input
                                            type="text"
                                            class="form-control translation-input"
                                            name="og_title-<?php echo e($language->code); ?>"
                                            required
                                            placeholder="<?php echo app('translator')->get('l.Enter OG title in'); ?> <?php echo e($language->native); ?>"
                                            id="og_title-<?php echo e($language->code); ?>"
                                            maxlength="255"
                                            value="<?php echo e($seoPage->getTranslation('og_title', $language->code, false)); ?>"
                                        >
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label d-flex align-items-center">
                                        <i class="bx bx-detail text-primary me-2"></i>
                                        <?php echo app('translator')->get('l.OG Description'); ?> (<?php echo e($language->native); ?>)
                                        <span class="text-danger ms-1">*</span>
                                    </label>
                                    <div class="textarea-wrapper">
                                        <textarea
                                            class="form-control translation-input"
                                            name="og_description-<?php echo e($language->code); ?>"
                                            rows="3"
                                            required
                                            placeholder="<?php echo app('translator')->get('l.Enter OG description in'); ?> <?php echo e($language->native); ?>"
                                            id="og_description-<?php echo e($language->code); ?>"
                                            maxlength="500"
                                        ><?php echo e($seoPage->getTranslation('og_description', $language->code, false)); ?></textarea>
                                        <div class="textarea-counter">
                                            <span id="og_description-count-<?php echo e($language->code); ?>">0</span>/500
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="<?php echo e(route('dashboard.admins.seo')); ?>" class="btn btn-outline-secondary me-2">
                        <i class="bx bx-x me-1"></i> <?php echo app('translator')->get('l.Cancel'); ?>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> <?php echo app('translator')->get('l.Save Translations'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function() {
        // تحديث عدادات النصوص
        function updateTextCounter(element) {
            const id = $(element).attr('id');
            if ($(element).is('textarea')) {
                const length = $(element).val().length;
                $(`#${id.replace(/(description|keywords|og_description)/, '$1-count')}`).text(length);
            }
        }

        // تحديث جميع العدادات عند تحميل الصفحة
        $('.translation-input').each(function() {
            updateTextCounter(this);
        });

        // تحديث العدادات عند الكتابة
        $('.translation-input').on('input', function() {
            updateTextCounter(this);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/seo/seo-translations.blade.php ENDPATH**/ ?>