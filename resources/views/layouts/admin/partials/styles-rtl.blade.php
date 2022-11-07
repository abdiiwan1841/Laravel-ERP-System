    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/vendors-rtl.min.css">
    @yield('vendor-css')
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/custom-rtl.css">
    @yield('page-css')
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css-rtl/core/menu/menu-types/vertical-menu.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/css/style-rtl.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/css/style.css">
    <!-- END: Custom CSS-->

    <!--CDNs-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <!--CDNs-->

    @stack('styles')

    @livewireStyles
