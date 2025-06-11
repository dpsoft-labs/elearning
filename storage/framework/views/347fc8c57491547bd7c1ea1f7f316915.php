<?php $__env->startSection('seo'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php echo e($lecture->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <style>
        /* منع النقر بزر الماوس الأيمن */
        .plyr {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .plyr__video-wrapper {
            pointer-events: none;
        }

        .plyr__controls {
            pointer-events: auto;
        }

        /* إخفاء شعار YouTube وعناصر التحكم العلوية */
        .plyr--youtube .plyr__video-wrapper iframe {
            top: -50px;
            height: calc(100% + 50px);
        }

        /* إخفاء واجهة يوتيوب الافتراضية */
        .plyr--youtube .plyr__video-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #000;
            z-index: 1;
        }

        .plyr--playing .plyr__video-wrapper::before {
            display: none;
        }

        /* تعديل موضع الفيديو */
        .plyr--youtube .plyr__video-wrapper iframe {
            top: -50px;
            height: calc(100% + 100px);
        }
    </style>
    <script>
        // منع استخدام زر الماوس الأيمن
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // منع استخدام مفاتيح الاختصار للـ Inspect Element
        document.addEventListener('keydown', function(e) {
            // منع F12
            if (e.key === 'F12' || e.keyCode === 123) {
                e.preventDefault();
                return false;
            }

            // منع Ctrl+Shift+I / Cmd+Shift+I
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.keyCode === 73)) {
                e.preventDefault();
                return false;
            }

            // منع Ctrl+Shift+C / Cmd+Shift+C
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && (e.key === 'C' || e.key === 'c' || e.keyCode === 67)) {
                e.preventDefault();
                return false;
            }

            // منع Ctrl+U / Cmd+U (View Source)
            if ((e.ctrlKey || e.metaKey) && (e.key === 'U' || e.key === 'u' || e.keyCode === 85)) {
                e.preventDefault();
                return false;
            }
        });

        // منع السحب والإفلات للصور والنصوص
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 col-lg-10 offset-lg-1">
                <!-- عنوان المحاضرة -->
                <h1 class="mb-4 text-center text-primary"><?php echo e($lecture->name); ?></h1>

                <!-- مشغل الفيديو -->
                <div class="video-container mb-4">
                    <div id="plyr-video-player" data-plyr-provider="youtube"
                        data-plyr-embed-id="<?php echo e(\Illuminate\Support\Str::after($lecture->video, 'v=')); ?>"
                        data-plyr-config='{
                             "controls": ["play-large", "play", "progress", "current-time", "mute", "volume", "fullscreen", "settings"],
                             "settings": ["speed"],
                             "youtube": {"noCookie": true, "rel": 0, "showinfo": 0, "modestbranding": 1}
                         }'>
                    </div>
                </div>

                <!-- وصف المحاضرة -->
                <?php if(!empty($lecture->description)): ?>
                    <div class="description-section mb-4">
                        <h4 class="text-primary"><?php echo app('translator')->get('l.Description'); ?>:</h4>
                        <p class="text-muted"><?php echo e($lecture->description); ?></p>
                    </div>
                <?php endif; ?>

                <!-- رابط تحميل الملف -->
                <?php if(!empty($lecture->files)): ?>
                    <div class="download-section mb-4">
                        <h4 class="text-primary"><?php echo app('translator')->get('l.Download File'); ?>:</h4>
                        <a href="<?php echo e(asset($lecture->files)); ?>" class="btn btn-outline-primary btn-lg" download>
                            <i class="fas fa-download"></i> <?php echo app('translator')->get('l.Download Now'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        .row.mt-5>.col-md-12.col-lg-10 {
            margin-left: auto;
            margin-right: auto;
        }

        html[dir="rtl"] .row.mt-5>.col-md-12.col-lg-10 {
            /* margin-left: 0; */
            margin-right: auto;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            max-width: 100%;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .description-section,
        .download-section {
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-primary {
            display: flex;
            align-items: center;
        }

        .btn-outline-primary i {
            margin-right: 8px;
        }
    </style>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const player = new Plyr('#plyr-video-player');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/lectures/lectures-show.blade.php ENDPATH**/ ?>