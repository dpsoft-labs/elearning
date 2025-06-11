@extends('themes.default.layouts.front.master')

@section('title', $seoPage->title)
@section('description', $seoPage->description)
@section('keywords', $seoPage->keywords)
@section('og_title', $seoPage->og_title)
@section('og_description', $seoPage->og_description)
@section('og_image', asset($seoPage->og_image))
@section('structured_data')
    <script type="application/ld+json">
        {!! $seoPage->structured_data !!}
    </script>
@endsection

@section('css')

@endsection

@php
    $currency = $_COOKIE['currency'] ?? null;
    $symbol = $_COOKIE['currency_symbol'] ?? null;
@endphp

@section('content')

@endsection

@section('js')
@endsection
