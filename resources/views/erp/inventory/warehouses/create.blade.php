@extends('layouts.admin.admin_layout')
@section('title', trans('applang.add_warehouse'))

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
                        <h4 class="modal-title white">{{trans('applang.add_warehouse')}}</h4>
                    </div>
                    <div class="card-body mt-1" style="padding-bottom: 13px">
                        <form action="{{route('warehouses.store')}}" method="POST">
                            @csrf

                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="branch_id">{{ trans('applang.branch') }}</label>
                                <fieldset class="form-group">
                                    <select id="branch_id" class="custom-select @error('branch_id') is-invalid @enderror" name='branch_id'>
                                        <option value="" selected disabled>{{trans('applang.select_branch')}}</option>
                                        @foreach($branches as $branch)
                                                <option value="{{  $branch->id }}">
                                                    {{app()->getLocale() == 'ar' ? $branch->name_ar  : $branch->name_en}}
                                                </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('branch_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>

                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="name">{{ trans('applang.name') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           placeholder="{{trans('applang.warehouse_name')}}"
                                           autocomplete="name"
                                           value="{{old('name')}}"
                                           autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bxs-pen"></i>
                                    </div>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="shipping_address">{{ trans('applang.shipping_address') }}</label>
                                <textarea id="shipping_address"
                                          rows="5"
                                          class="form-control @error('shipping_address') is-invalid @enderror"
                                          name="shipping_address"
                                          placeholder="{{trans('applang.shipping_address')}}"
                                          autocomplete="shipping_address"
                                >{{old('shipping_address')}}</textarea>

                                @error('shipping_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="status">{{ trans('applang.status') }}</label>
                                <fieldset class="form-group mb-50">
                                    <select id="status" class="custom-select @error('status') is-invalid @enderror" name='status'>
                                        <option value="" selected disabled>{{trans('applang.status')}}</option>
                                        <option value="0" >{{trans('applang.suspended')}}</option>
                                        <option value="1" >{{trans('applang.active')}}</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>

                            <hr class="hr modal-hr">
                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="{{route('warehouses.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
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

