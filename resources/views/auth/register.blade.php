@extends('layouts.admin.auth_layout')

@section('title', 'Register')

@section('vendor-css')
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/authentication.css">
@endsection

@section('content')
    <!-- register section starts -->
    <section class="row flexbox-container">
        <div class="col-xl-8 col-10">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- register section left -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2">{{ __('Register') }}</h4>
                                </div>
                            </div>
                            <div class="text-center">
                                <p>
                                    <small> {{ __('Please enter your details to register and be part of our great community') }}</small>
                                </p>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-50">
                                            <label for="first_name">{{ __('First Name') }}</label>
                                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="{{__('First Name')}}" required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 mb-50">
                                            <label for="last_name">{{ __('Last Name') }}</label>
                                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="{{__('Last Name')}}" required autocomplete="last_name" autofocus>
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mb-50">
                                        <label class="text-bold-600" for="email">{{ __('Email Address') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-50">
                                        <label class="text-bold-600" for="phone">{{ __('Phone Number') }}</label>
                                        <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="{{ __('Must start with (010, 011, 012, 015) ex: 010XXXXXXXX') }}" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="text-bold-600" for="password">{{ __('Password') }}</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="text-bold-600" for="password-confirm">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                                    </div>

                                    <button type="submit" class="btn btn-primary glow position-relative w-100">
                                        {{__('Register')}}<i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <small class="mr-25">{{__('Already have an account?')}}</small>
                                    <a href="{{route('login')}}">
                                        <small>{{__('Login')}}</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- image section right -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <img class="img-fluid" src="{{asset('app-assets')}}/images/pages/register.png" alt="branding logo">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- register section ends -->
@endsection

@section('page-vendor-js')
@endsection
@section('page-js')
@endsection
