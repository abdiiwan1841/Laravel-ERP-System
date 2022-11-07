@extends('layouts.admin.auth_layout')

@section('title', 'Confirm Password')

@section('vendor-css')
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/authentication.css">
@endsection

@section('content')
<!-- Confirm password start -->
<section class="row flexbox-container">
    <div class="col-xl-7 col-10">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right d-flex justify-content-center mb-0 p-2 h-100">

                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center mb-2">{{ __('Confirm Password') }}</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="text-muted mb-2">
                                <p>{{__('Please confirm your password before continuing.')}}</p>
                            </div>

                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="text-bold-600" for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Enter your password') }}" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary glow position-relative w-100">
                                    {{ __('Confirm Password') }}<i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="card-link" href="{{ route('password.request') }}">
                                        <small>{{ __('Forgot Your Password?') }}</small>
                                    </a>
                                @endif
                            </form>

                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <img class="img-fluid" src="{{asset('app-assets')}}/images/pages/confirm-password.png" alt="branding logo">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- confirm password ends -->
@endsection

@section('page-vendor-js')
@endsection
@section('page-js')
@endsection
