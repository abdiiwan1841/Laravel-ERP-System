@extends('layouts.admin.admin_layout')
@section('title', trans('applang.my_account'))

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
    <!--Start Update Name And Email-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header modal-header bg-primary">
                    <h4 class="modal-title white">{{trans('applang.update_user_account')}}</h4>
                </div>
                <div class="card-body mt-1" style="padding-bottom: 13px">
                    <form action="{{route('editUserAccountNameEmail')}}" method="POST">
                        @csrf
                        <div class="form-row mb-50">
                            <div class="form-group col-md-4">
                                <label class="required" for="first_name">{{ trans('applang.first_name') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="first_name"
                                            type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name"
                                            placeholder="{{trans('applang.first_name')}}"
                                            autocomplete="first_name"
                                            value="{{$user->first_name}}"
                                            autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bxs-user"></i>
                                    </div>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="required" for="middle_name">{{ trans('applang.middle_name') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="middle_name"
                                            type="text"
                                            class="form-control @error('middle_name') is-invalid @enderror"
                                            name="middle_name"
                                            placeholder="{{trans('applang.middle_name')}}"
                                            autocomplete="middle_name"
                                            value="{{$user->middle_name}}"
                                            autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bxs-user"></i>
                                    </div>
                                    @error('middle_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="required" for="last_name">{{ trans('applang.last_name') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="last_name"
                                            type="text"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            name="last_name"
                                            placeholder="{{trans('applang.last_name')}}"
                                            autocomplete="last_name"
                                            value="{{$user->last_name}}"
                                            autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bxs-user"></i>
                                    </div>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="email">{{ trans('applang.email') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="email"
                                            type="text"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email"
                                            placeholder="{{trans('applang.email')}}"
                                            autocomplete="email"
                                            value="{{$user->email}}"
                                            autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bx-mail-send"></i>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-2rem">
                            <a href="{{route('dashboard')}}" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.dashboard')}}</span>
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

    <!--Start Update Password-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header modal-header bg-primary">
                    <h4 class="modal-title white">{{trans('applang.update_password')}}</h4>
                </div>
                <div class="card-body mt-1" style="padding-bottom: 13px">
                    <form action="{{route('changePassword')}}" method="POST">
                        @csrf

                        <div class="form-row mb-50">
                            <div class="form-group col-md-4">
                                <label class="required" for="current_password">{{ trans('applang.current_password') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="current_password"
                                            type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            name="current_password"
                                            placeholder="{{trans('applang.current_password')}}"
                                            >
                                    <div class="form-control-position">
                                        <i class="bx bxs-key"></i>
                                    </div>
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="required" for="password">{{ trans('applang.new_password') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="{{trans('applang.new_password')}}"
                                            >
                                    <div class="form-control-position">
                                        <i class="bx bxs-key"></i>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="required" for="password_confirmation">{{ trans('applang.password_confirmation') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="password_confirmation"
                                            type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation"
                                            placeholder="{{trans('applang.password_confirmation')}}"
                                            >
                                    <div class="form-control-position">
                                        <i class="bx bxs-key"></i>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-2rem">
                            <a href="{{route('dashboard')}}" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.dashboard')}}</span>
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
@endsection

@section('page-js')
<script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>
<script type="text/javascript">
    @if(Session::has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
  		toastr.success("{{ session('success') }}");
    @endif

    @if ($errors->any())
        @foreach($errors->all() as $error)
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.error("{{$error}}");
        @endforeach
    @endif
</script>
@endsection
