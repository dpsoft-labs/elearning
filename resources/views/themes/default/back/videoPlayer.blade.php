@extends('themes.default.layouts.back.master')

@section('title')
    test
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/plyr/plyr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/css/pages/app-academy-details.css') }}" />
    <!-- أضف هذا CSS في رأس الصفحة أو ملف CSS منفصل -->
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
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="pt-3 mb-0"><span class="text-muted fw-light">Academy /</span> Course Details</h4>
        <!-- ... existing code ... -->
        <div class="p-2">
            <div class="cursor-pointer">
                <div id="plyr-video-player" class="w-100" data-plyr-provider="youtube" data-plyr-embed-id="lOlrHGpHxJo"
                    data-plyr-config='{"controls": ["play-large", "play", "progress", "current-time", "mute", "volume", "fullscreen", "settings"], "settings": ["speed"], "youtube": {"noCookie": true, "rel": 0, "showinfo": 0, "modestbranding": 1}}'>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('assets/themes/default/vendor/libs/plyr/plyr.js') }}"></script>
    <script src="{{ asset('assets/themes/default/js/app-academy-course-details.js') }}"></script>
@endsection
