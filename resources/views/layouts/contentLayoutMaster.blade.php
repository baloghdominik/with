@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>With - @yield('title') - MyRestaurant</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}">
        <link rel="shortcut icon" href="{{ asset('images/logo/favicon.ico') }}">
        <link rel="icon" sizes="16x16 32x32 64x64" href="{{ asset('images/logo/favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="196x196" href="{{ asset('images/logo/favicon-192.png') }}">
        <link rel="icon" type="image/png" sizes="160x160" href="{{ asset('images/logo/favicon-160.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo/favicon-96.png') }}">
        <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('images/logo/favicon-64.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/favicon-32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo/favicon-16.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo/favicon-57.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/logo/favicon-114.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/logo/favicon-72.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/logo/favicon-144.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/logo/favicon-60.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/logo/favicon-120.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/logo/favicon-76.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/logo/favicon-152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo/favicon-180.png') }}">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="{{ asset('images/logo/favicon-144.png') }}">
        <meta name="msapplication-config" content="{{ asset('images/logo/browserconfig.xml') }}">

        {{-- Include core + vendor Styles --}}
        @include('panels/styles')

    </head>

    {{-- {!! Helper::applClasses() !!} --}}
    @php
        $configData = Helper::applClasses();
    @endphp

    @extends((( $configData["mainLayoutType"] === 'horizontal') ? 'layouts/horizontalLayoutMaster' : 'layouts.verticalLayoutMaster' ))
    