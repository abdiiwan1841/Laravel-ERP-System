@extends('layouts.admin.admin_layout')
@section('title', trans('applang.products_settings'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
@endsection

@section('content')

    <!--Start Update -->
    <div class="container">
        <div class="row mt-3">
            <div class="col-xl-6 col-sm-6 col-12 zoom">
                <a href="{{route('sections.index')}}">
                    <div class="card text-center bg-success bg-lighten-1">
                        <div class="card-body text-white">
                            <img src="{{asset('app-assets/images/svg/category-1-svgrepo-com.svg')}}" alt="element 05" class="mb-1 w-100" height="200">
                            <h4 class="white font-weight-bold">{{trans('applang.sections')}}</h4>
                            <p class="card-text font-weight-bold">{{count($sections)}} {{trans('applang.section')}}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-6 col-sm-6 col-12 zoom">
                <a href="{{route('brands.index')}}">
                    <div class="card text-center bg-danger bg-lighten-2">
                        <div class="card-body">
                            <img src="{{asset('app-assets/images/svg/brand-svgrepo-com.svg')}}" alt="element 05" class="mb-1 w-100" height="200">
                            <h4 class="font-weight-bold white">{{trans('applang.brands')}}</h4>
                            <p class="card-text white font-weight-bold">{{count($brands)}} {{trans('applang.brand')}}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-6 col-sm-6 col-12 zoom">
                <a href="{{route('categories.index')}}">
                    <div class="card text-center bg-warning bg-lighten-2">
                        <div class="card-body">
                            <img src="{{asset('app-assets/images/svg/category-svgrepo-com.svg')}}" alt="element 05" class="mb-1 w-100" height="200">
                            <h4 class="font-weight-bold white">{{trans('applang.categories')}}</h4>
                            <p class="card-text white font-weight-bold">{{count($categories)}} {{trans('applang.cat')}}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-6 col-sm-6 col-12 zoom">
                <a href="{{route('subcategories.index')}}">
                    <div class="card text-center bg-primary bg-lighten-2">
                        <div class="card-body">
                            <img src="{{asset('app-assets/images/svg/tags-svgrepo-com.svg')}}" alt="element 05" class="mb-1 w-100" height="200">
                            <h4 class="font-weight-bold white">{{trans('applang.sub_categories')}}</h4>
                            <p class="card-text white font-weight-bold">{{count($subcategories)}} {{trans('applang.sub_cat')}}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!--End Update Form -->

@endsection



@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="{{asset('app-assets')}}/vendors/js/forms/select/select2.full.min.js"></script>
@endsection

@section('page-js')
    <script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>
    <script type="text/javascript">
        @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "{{app()->getLocale() == 'ar' ? 'toast-top-left' : 'toast-top-right'}}",
            }
        toastr.success("{{ session('success') }}");
        @endif

            @if ($errors->any())
            @foreach($errors->all() as $error)
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "{{app()->getLocale() == 'ar' ? 'toast-top-left' : 'toast-top-right'}}",
            }
        toastr.error("{{$error}}");
        @endforeach
        @endif
    </script>
@endsection

