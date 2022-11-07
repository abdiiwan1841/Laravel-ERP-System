@extends('layouts.admin.auth_layout')

@section('title', 'Reset Password')

@section('vendor-css')
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/authentication.css">
@endsection

@section('content')
<!-- forgot password start -->
<section class="row flexbox-container">
    <div class="col-xl-7 col-md-9 col-10  px-0">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-forgot password -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center mb-2">{{ __('Reset Password') }}</h4>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center mb-2">
                            <div class="text-left">
                                <div class="ml-3 ml-md-2 mr-1">
                                    <a href="{{route('login')}}" class="card-link btn btn-outline-primary text-nowrap">{{__('Login')}}</a>
                                </div>
                            </div>
                            <div class="mr-3">
                                <a href="{{route('register')}}" class="card-link btn btn-outline-primary text-nowrap">{{__('Register')}}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-muted text-center mb-2">
                                <small>{{__('Enter the email you used when you joined and we will send you password reset Link')}}</small>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group mb-2">
                                    <label class="text-bold-600" for="email">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('Email Address') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <button type="submit" class="btn btn-primary glow position-relative w-100">
                                    {{ __('Send Password Reset Link') }} <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                </button>
                            </form>

                            <div class="text-center mb-2">
                                <a href="{{route('login')}}">
                                    <small class="text-muted">{{__('I remembered my password')}}</small>
                                </a>
                            </div>

                            <div class="divider mb-2">
                                <div class="divider-text">Or Sign in as</div>
                            </div>
                            <div class="d-flex flex-md-row flex-column">
                                <a href="javascript:void(0);" class="btn btn-social btn-google btn-block font-small-3 mb-1 mb-sm-1 mb-md-0 mr-md-1 text-center">
                                    <i class="bx bxl-google font-medium-3"></i>
                                    <span class="pl-1">Google</span>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-social btn-facebook btn-block font-small-3 text-center mt-0">
                                    <i class="bx bxl-facebook-square font-medium-3"></i>
                                    <span class="pl-1">Facebook</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center">
                    <img class="img-fluid" src="{{asset('app-assets')}}/images/pages/forgot-password.png" alt="branding logo" width="300">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- forgot password ends -->
@endsection

@section('page-vendor-js')
@endsection
@section('page-js')
@endsection
