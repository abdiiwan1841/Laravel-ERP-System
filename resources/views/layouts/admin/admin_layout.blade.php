<!DOCTYPE html>
<html class="loading"
        data-textdirection="{{LaravelLocalization::getCurrentLocaleDirection()}}"
        lang="{{app()->getLocale()}}"
        dir="{{LaravelLocalization::getCurrentLocaleDirection()}}">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="{{asset('app-assets')}}/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets')}}/images/ico/favicon.ico">
    {{-- <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet"> --}}

    @if (app()->getLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @else
        {{-- <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    @endif

    @if (app()->getLocale() == 'ar')
        @include('layouts.admin.partials.styles-rtl')
    @else
        @include('layouts.admin.partials.styles')
    @endif

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-sticky footer-static
            @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')arabic @else english @endif"
            data-open="click"
            data-menu="vertical-menu-modern"
            data-col="2-columns"
            data-layout="semi-dark-layout">

    @include('layouts.admin.partials.header')
    @include('layouts.admin.partials.sidebar')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-header row">
                @if(isset($breadcrumbs))
                    @include('layouts/admin/partials/breadcrumbs')
                @endif
            </div>

            <!-- Start Page Content -->
                @yield('content')
            <!-- End Page Content -->

        </div>
    </div>
    <!-- END: Content-->

{{--    @include('layouts.admin.partials.chat')--}}
    @include('layouts.admin.partials.footer')
    @include('layouts.admin.partials.scripts')

</body>
<!-- END: Body-->

</html>
