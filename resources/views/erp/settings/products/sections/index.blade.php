@extends('layouts.admin.admin_layout')
@section('title', trans('applang.sections'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
@endsection

@section('content')
    <div class="container">
        @livewire('erp.products-settings.sections')
    </div>
@endsection



@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
@endsection

@section('page-js')

@endsection

