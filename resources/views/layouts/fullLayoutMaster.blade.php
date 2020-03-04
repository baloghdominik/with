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
        <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico">
        <link rel="shortcut icon" href="images/logo/favicon.ico">
        <link rel="icon" sizes="16x16 32x32 64x64" href="images/logo/favicon.ico">
        <link rel="icon" type="image/png" sizes="196x196" href="images/logo/favicon-192.png">
        <link rel="icon" type="image/png" sizes="160x160" href="images/logo/favicon-160.png">
        <link rel="icon" type="image/png" sizes="96x96" href="images/logo/favicon-96.png">
        <link rel="icon" type="image/png" sizes="64x64" href="images/logo/favicon-64.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/logo/favicon-32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/logo/favicon-16.png">
        <link rel="apple-touch-icon" href="images/logo/favicon-57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/logo/favicon-114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/logo/favicon-72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/logo/favicon-144.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/logo/favicon-60.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/logo/favicon-120.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/logo/favicon-76.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/logo/favicon-152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/logo/favicon-180.png">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="images/logo/favicon-144.png">
        <meta name="msapplication-config" content="images/logo/browserconfig.xml">

        {{-- Include core + vendor Styles --}}
        @include('panels/styles')

    </head>

    {{-- {!! Helper::applClasses() !!} --}}
    @php
    $configData = Helper::applClasses();
    date_default_timezone_set('Europe/Budapest');
    @endphp

    <body class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">

    <div class="app-content content">
      <!-- BEGIN: Header-->
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>


        <!-- BEGIN: Content-->
            <div class="content-wrapper">

                <div class="content-body">
                    {{-- Include Page Content --}}
                    @yield('content')
                </div>
            </div>
        <!-- End: Content-->
    </div>

        {{-- include footer --}}
        @include('panels/footer')

        {{-- include default scripts --}}
        @include('panels/scripts')

    </body>
</html>
