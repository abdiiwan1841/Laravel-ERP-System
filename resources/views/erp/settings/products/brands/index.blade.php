@extends('layouts.admin.admin_layout')
@section('title', trans('applang.brands'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
{{--    <link rel="stylesheet" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">--}}
@endsection

@section('content')
    <div class="container">
        @livewire('erp.products-settings.brands')
    </div>
@endsection



@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
{{--    <script src="{{asset('app-assets')}}/vendors/js/forms/select/select2.full.min.js"></script>--}}
@endsection

@section('page-js')
{{--    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.min.js')}}"></script>--}}
@endsection
