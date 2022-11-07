@extends('layouts.admin.auth_layout')

@section('title', 'Password Update')

@section('vendor-css')
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/authentication.css">
@endsection

@section('content')
<!-- Update password start -->
<section class="row flexbox-container">
    <div class="col-xl-7 col-10">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right d-flex justify-content-center mb-0 p-2 h-100">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center mb-2">{{ __('Reset Your Password') }}</h4>
                            </div>
                        </div>

                        <div class="card-body">

                            <form class="mb-2" method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label class="text-bold-600" for="email">{{ __('Email address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  placeholder="{{ __('Email address') }}" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-2">
                                    <label class="text-bold-600" for="password">{{ __('New Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('Enter a new password')}}" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-2">
                                    <label class="text-bold-600" for="password-confirm">{{ __('Confirm New Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{__('Confirm your new password')}}" required autocomplete="new-password">
                                </div>

                                <button type="submit" class="btn btn-primary glow position-relative w-100">
                                    {{ __('Reset my password') }}<i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                </button>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <img class="img-fluid" src="{{asset('app-assets')}}/images/pages/reset-password.png" alt="branding logo">
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Update password ends -->
@endsection

@section('page-vendor-js')
@endsection
@section('page-js')
@endsection
