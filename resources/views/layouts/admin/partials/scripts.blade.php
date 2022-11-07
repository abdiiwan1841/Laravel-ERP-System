    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets')}}/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @yield('page-vendor-js')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets')}}/js/scripts/configs/vertical-menu-dark.js"></script>
    <script src="{{asset('app-assets')}}/js/core/app-menu.js"></script>
    <script src="{{asset('app-assets')}}/js/core/app.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/components.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    @yield('page-js')
    <!-- END: Page JS-->

    <!-- BEGIN: Custom js-->
    <script src="{{asset('assets')}}/js/scripts.js"></script>
    <script src="{{asset('assets/js/custome_livewire.js')}}"></script>
    <!-- END: Custom js-->

    <!--BEGIN: CDNs-->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!--END: CDNs-->


    @stack('scripts')

    @livewireScripts

