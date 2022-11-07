@extends('layouts.admin.admin_layout')
@section('title', trans('applang.edit_template'))

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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header modal-header bg-primary">
                        <h4 class="modal-title white">{{trans('applang.edit_template')}}</h4>
                    </div>
                    <div class="card-body mt-1" style="padding-bottom: 13px">
                        <form action="{{route('units-templates.update', $template->id)}}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="template_name_ar">{{ trans('applang.template_name_ar') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="template_name_ar"
                                                   type="text"
                                                   class="form-control @error('template_name_ar') is-invalid @enderror"
                                                   name="template_name_ar"
                                                   placeholder="{{trans('applang.template_name_ar')}}"
                                                   autocomplete="template_name_ar"
                                                   value="{{$template->template_name_ar}}"
                                                   autofocus>
                                            <div class="form-control-position">
                                                <i class="bx bxs-lock"></i>
                                            </div>
                                            @error('template_name_ar')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="template_name_en">{{ trans('applang.template_name_en') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="template_name_en"
                                                   type="text"
                                                   class="form-control @error('template_name_en') is-invalid @enderror"
                                                   name="template_name_en"
                                                   placeholder="{{trans('applang.template_name_en')}}"
                                                   autocomplete="template_name_en"
                                                   value="{{$template->template_name_en}}"
                                            >
                                            <div class="form-control-position">
                                                <i class="bx bxs-lock"></i>
                                            </div>
                                            @error('template_name_en')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="main_unit_ar">{{ trans('applang.main_unit_ar') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="main_unit_ar"
                                                   type="text"
                                                   class="form-control @error('main_unit_ar') is-invalid @enderror"
                                                   name="main_unit_ar"
                                                   placeholder="{{trans('applang.main_unit_ar')}}"
                                                   autocomplete="main_unit_ar"
                                                   value="{{$template->main_unit_ar}}"
                                                   autofocus>
                                            <div class="form-control-position">
                                                <i class="bx bx-pen"></i>
                                            </div>
                                            @error('main_unit_ar')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="main_unit_symbol_ar">{{ trans('applang.main_unit_symbol_ar') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="main_unit_symbol_ar"
                                                   type="text"
                                                   class="form-control @error('main_unit_symbol_ar') is-invalid @enderror"
                                                   name="main_unit_symbol_ar"
                                                   placeholder="{{trans('applang.main_unit_symbol_ar')}}"
                                                   autocomplete="main_unit_symbol_ar"
                                                   value="{{$template->main_unit_symbol_ar}}"
                                                   autofocus>
                                            <div class="form-control-position">
                                                <i class="bx bx-pen"></i>
                                            </div>
                                            @error('main_unit_symbol_ar')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="main_unit_en">{{ trans('applang.main_unit_en') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="main_unit_en"
                                                   type="text"
                                                   class="form-control @error('main_unit_en') is-invalid @enderror"
                                                   name="main_unit_en"
                                                   placeholder="{{trans('applang.main_unit_en')}}"
                                                   autocomplete="main_unit_en"
                                                   value="{{$template->main_unit_en}}"
                                                   autofocus>
                                            <div class="form-control-position">
                                                <i class="bx bx-pen"></i>
                                            </div>
                                            @error('main_unit_en')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="main_unit_symbol_en">{{ trans('applang.main_unit_symbol_en') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="main_unit_symbol_en"
                                                   type="text"
                                                   class="form-control @error('main_unit_symbol_en') is-invalid @enderror"
                                                   name="main_unit_symbol_en"
                                                   placeholder="{{trans('applang.main_unit_symbol_en')}}"
                                                   autocomplete="main_unit_symbol_en"
                                                   value="{{$template->main_unit_symbol_en}}"
                                                   autofocus>
                                            <div class="form-control-position">
                                                <i class="bx bx-pen"></i>
                                            </div>
                                            @error('main_unit_symbol_en')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <hr class="hr modal-hr">
                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="{{route('units-templates.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{trans('applang.back_btn')}}</span>
                                </a>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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



