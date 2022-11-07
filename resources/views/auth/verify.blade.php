@extends('layouts.admin.auth_layout')

@section('title', 'Email Verification')

@section('vendor-css')
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/authentication.css">
@endsection

@section('content')
<section class="row flexbox-container">
    <div class="col-xl-7 col-10">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right d-flex justify-content-center mb-0 p-2 h-100">

                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center mb-2">{{ __('Verify Your Email Address') }}</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary glow w-100 position-relative">
                                    {{ __('Click here to request another') }}<i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                </button>.
                            </form>
                        </div>

                    </div>
                </div>

                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <img class="img-fluid" src="{{asset('app-assets')}}/images/pages/email-verfication.png" alt="branding logo">
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('page-vendor-js')
@endsection
@section('page-js')
@endsection
