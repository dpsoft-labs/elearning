@extends('themes.default.layouts.back.master')

@section('seo')
@endsection

@section('title')
    @lang('l.Lives')
@endsection

@section('css')
    <style>
        .image-container {
            width: 100%;
            height: 200px;
            /* تحديد ارتفاع ثابت للصور */
            overflow: hidden;
            /* لإخفاء الأجزاء الزائدة من الصور */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            width: 100%;
            /* تضمن أن العرض يغطي الحاوية بالكامل */
            height: auto;
            /* تحافظ على التناسب */
            object-fit: cover;
            /* لضبط الصورة لتملأ الحاوية بدون تشويه */
        }

        .image-container {
            position: relative;
            overflow: hidden;
        }

        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            /* خلفية شبه شفافة */
            color: white;
            opacity: 0;
            /* مخفي افتراضيًا */
            transition: opacity 0.3s ease-in-out;
            /* تأثير الانتقال */
        }

        .image-container:hover .card-overlay {
            opacity: 1;
            /* يظهر عند الوقوف */
        }
    </style>
@endsection


@section('content')
    <div class="container mt-5">
        <div class="page-category">

            <div class="row">
                @foreach ($lives as $live)
                    <div class="col-md-4 mb-4">
                        @php
                            $current_time = now();
                            $live_start_time = \Carbon\Carbon::parse($live->date);
                            $is_live_now = $live_start_time->isPast();
                        @endphp

                        <div class="card position-relative">
                            <div class="image-container">
                                <img src="{{ asset($live->course->image) }}" class="card-img-top" alt="{{ $live->name }}">
                                <div
                                    class="card-overlay d-flex flex-column justify-content-center align-items-center text-center">
                                    @if ($is_live_now)
                                        <a href="{{ $live->link }}" class="btn btn-primary">
                                            @lang('l.Join Now')
                                        </a>
                                    @else
                                        <div id="countdown-{{ $live->id }}" class="text-white"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $live->name }}</h5>
                            </div>
                        </div>
                    </div>

                    <script>
                        // JavaScript for Countdown Timer
                        const countdown{{ $live->id }} = document.getElementById('countdown-{{ $live->id }}');
                        const liveStartTime{{ $live->id }} = new Date("{{ Carbon\Carbon::parse($live->date)->toIso8601String() }}")
                            .getTime();

                        const timer{{ $live->id }} = setInterval(function() {
                            const now = new Date().getTime();
                            const distance = liveStartTime{{ $live->id }} - now;

                            if (distance > 0) {
                                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                countdown{{ $live->id }}.innerText =
                                    `@lang('l.Time remaining'): ${days} @lang('l.days') ${hours} @lang('l.hours') ${minutes} @lang('l.minutes') ${seconds} @lang('l.seconds')`;
                            } else {
                                clearInterval(timer{{ $live->id }});
                                countdown{{ $live->id }}.innerText = "@lang('l.Live Started')!";
                            }
                        }, 1000);
                    </script>
                @endforeach

            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection


@section('js')
@endsection
