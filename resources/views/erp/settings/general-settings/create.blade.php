@extends('layouts.admin.admin_layout')
@section('title', trans('applang.general_settings'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
@endsection

@section('content')

    <!--Start Update -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('general-settings.update', 'create')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header modal-header bg-primary">
                            <h4 class="modal-title white">{{trans('applang.general_settings')}}</h4>
                        </div>
                        <div class="card-body mt-1" style="padding-bottom: 13px">

                            <!--Business Details-->
                            <div class="custom-card mt-1 mb-5">
                                <div class="card-header border-bottom" style="background-color: #f9f9f9">
                                    <span class="text-bold-700 pr-1 pl-1">{{trans('applang.business_details')}}</span>
                                </div>

                                <div class="card-body mt-1">

                                    <!--Business Name-->
                                    <div class="col-md-12 mb-50">
                                        <label class="required" for="business_name">{{ trans('applang.business_name') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="business_name"
                                                   type="text"
                                                   class="form-control @error('business_name') is-invalid @enderror"
                                                   name="business_name"
                                                   placeholder="{{trans('applang.business_name')}}"
                                                   autocomplete="business_name"
                                                   value="{{$gs->business_name ?? old('business_name')}}"
                                                   autofocus>
                                            <div class="form-control-position">
                                                <i class="bx bx-pen"></i>
                                            </div>
                                            @error('business_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!--First name & Last name-->
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="first_name">{{ trans('applang.first_name') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="first_name"
                                                           type="text"
                                                           class="form-control @error('first_name') is-invalid @enderror"
                                                           name="first_name"
                                                           placeholder="{{trans('applang.first_name')}}"
                                                           autocomplete="first_name"
                                                           value="{{$gs->first_name ?? old('first_name')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="last_name">{{ trans('applang.last_name') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="last_name"
                                                           type="text"
                                                           class="form-control @error('last_name') is-invalid @enderror"
                                                           name="last_name"
                                                           placeholder="{{trans('applang.last_name')}}"
                                                           autocomplete="last_name"
                                                           value="{{$gs->last_name ?? old('last_name')}}"
                                                    >
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Country & State & City-->
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="country">{{ trans('applang.country') }}</label>
                                                <fieldset class="form-group">
                                                    <select id="country" class="custom-select @error('country') is-invalid @enderror" name='country'>
                                                        <option value="" selected disabled>{{trans('applang.select_country')}}</option>
                                                        @foreach($countries as $key => $value)
                                                            <option value="{{$key}}" {{isset($gs) && $gs->country == $key ? 'selected' : ''}}>
                                                                {{app()->getLocale() == 'ar' ? $value['name'] : $value['en_name']}}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @if ($errors->has('country'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('country') }}</strong>
                                                        </span>
                                                    @endif
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="state">{{ trans('applang.state') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="state"
                                                           type="text"
                                                           class="form-control @error('state') is-invalid @enderror"
                                                           name="state"
                                                           placeholder="{{trans('applang.state')}}"
                                                           autocomplete="state"
                                                           value="{{$gs->state ?? old('state')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('state')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="city">{{ trans('applang.city') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="city"
                                                           type="text"
                                                           class="form-control @error('city') is-invalid @enderror"
                                                           name="city"
                                                           placeholder="{{trans('applang.city')}}"
                                                           autocomplete="city"
                                                           value="{{$gs->city ?? old('city')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Street Adress & Postal Code-->
                                    <div class="form-row">
                                        <div class="col-md-9">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="street_address">{{ trans('applang.street_address') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="street_address"
                                                           type="text"
                                                           class="form-control @error('street_address') is-invalid @enderror"
                                                           name="street_address"
                                                           placeholder="{{trans('applang.street_address')}}"
                                                           autocomplete="street_address"
                                                           value="{{$gs->street_address ?? old('street_address')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('street_address')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="postal_code">{{ trans('applang.postal_code') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="postal_code"
                                                           type="number"
                                                           class="form-control @error('postal_code') is-invalid @enderror"
                                                           name="postal_code"
                                                           placeholder="{{trans('applang.postal_code')}}"
                                                           autocomplete="postal_code"
                                                           value="{{$gs->postal_code ?? old('postal_code')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('postal_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Phone & Mobile-->
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="phone">{{ trans('applang.phone') }}</label>
                                                <div class="input-group" dir="ltr">
                                                    <div class="input-group-append" style="width: 20%">
                                                        <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                               placeholder="&#9872; &#9743;" value="{{$gs->phone_code ?? old('phone_code')}}">
                                                    </div>
                                                    <input id="phone"
                                                           type="number"
                                                           class="form-control @error('phone') is-invalid @enderror text-append-phone"
                                                           name="phone"
                                                           placeholder="{{trans('applang.phone')}}"
                                                           autocomplete="phone"
                                                           value="{{$gs->phone ?? old('phone')}}"
                                                           autofocus>
                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="mobile">{{ trans('applang.mobile') }}</label>
                                                <div class="input-group" dir="ltr">
                                                    <div class="input-group-append" style="width: 20%">
                                                        <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                               placeholder="&#9872; &#9743;" value="{{$gs->phone_code ?? old('phone_code')}}">
                                                    </div>
                                                    <input id="mobile"
                                                           type="number"
                                                           class="form-control @error('mobile') is-invalid @enderror text-append-phone"
                                                           name="mobile"
                                                           placeholder="{{trans('applang.mobile')}}"
                                                           autocomplete="mobile"
                                                           value="{{$gs->mobile ?? old('mobile')}}"
                                                           autofocus>
                                                    @error('mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Fax & Email-->
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="mobile">{{ trans('applang.fax') }}</label>
                                                <div class="input-group" dir="ltr">
                                                    <div class="input-group-append" style="width: 20%">
                                                        <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                               placeholder="&#9872; &#9743;" value="{{$gs->phone_code ?? old('phone_code')}}">
                                                    </div>
                                                    <input id="fax"
                                                           type="number"
                                                           class="form-control @error('fax') is-invalid @enderror text-append-phone"
                                                           name="fax"
                                                           placeholder="{{trans('applang.fax')}}"
                                                           autocomplete="fax"
                                                           value="{{$gs->fax ?? old('fax')}}"
                                                           autofocus>
                                                    @error('fax')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="email">{{ trans('applang.email') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="email"
                                                           type="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           name="email"
                                                           placeholder="{{trans('applang.email')}}"
                                                           autocomplete="email"
                                                           value="{{$gs->email ?? old('email')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Commercial Record & Tax Registration-->
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="commercial_record">{{ trans('applang.commercial_record') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="commercial_record"
                                                           type="text"
                                                           class="form-control @error('commercial_record') is-invalid @enderror"
                                                           name="commercial_record"
                                                           placeholder="{{trans('applang.commercial_record')}}"
                                                           autocomplete="commercial_record"
                                                           value="{{$gs->commercial_record ?? old('commercial_record')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('commercial_record')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="tax_registration">{{ trans('applang.tax_registration') }}</label>
                                                <div class="position-relative has-icon-left">
                                                    <input id="tax_registration"
                                                           type="text"
                                                           class="form-control @error('tax_registration') is-invalid @enderror"
                                                           name="tax_registration"
                                                           placeholder="{{trans('applang.tax_registration')}}"
                                                           autocomplete="tax_registration"
                                                           value="{{$gs->tax_registration ?? old('tax_registration')}}"
                                                           autofocus>
                                                    <div class="form-control-position">
                                                        <i class="bx bx-pen"></i>
                                                    </div>
                                                    @error('tax_registration')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!--App Settings-->
                            <div class="custom-card mt-1 mb-5">
                                <div class="card-header border-bottom" style="background-color: #f9f9f9">
                                    <span class="text-bold-700 pr-1 pl-1">{{trans('applang.app_settings')}}</span>
                                </div>

                                <div class="card-body mt-1">

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <!--Timezone-->
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="time_zone">{{ trans('applang.time_zone') }}</label>
                                                <fieldset class="form-group">
                                                    <select id="time_zone" class="custom-select @error('time_zone') is-invalid @enderror" name='time_zone'>
                                                        <option value="" selected disabled>{{trans('applang.select_time_zone')}}</option>
                                                        @foreach($timezones as $key => $value)
                                                            <option value="{{reset($value['utc'])}}" {{isset($gs) && $gs->time_zone ==  reset($value['utc']) ? 'selected' : '' }}>{{$value['text']}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('time_zone'))
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('time_zone') }}</strong>
                                                    </span>
                                                    @endif
                                                </fieldset>
                                            </div>
                                            <!--Language-->
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="language">{{ trans('applang.language') }}</label>
                                                <fieldset class="form-group">
                                                    <select id="language" class="custom-select @error('language') is-invalid @enderror" name='language'>
                                                        <option value="" selected disabled>{{trans('applang.select_language')}}</option>
                                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <option value="{{ $localeCode }}" {{isset($gs) && $gs->language ==  $localeCode ? 'selected' : '' }}>{{ $properties['native'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('language'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('language') }}</strong>
                                                        </span>
                                                    @endif
                                                </fieldset>
                                            </div>
                                            <!--basic currency-->
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="basic_currency">{{ trans('applang.basic_currency') }}</label>
                                                <fieldset class="form-group">
                                                    <div class="input-group-append">
                                                    <select id="basic_currency" class="custom-select @error('basic_currency') is-invalid @enderror text-append-currency" name='basic_currency'>
                                                        <option value="" selected disabled>{{trans('applang.select_basic_currency')}}</option>
                                                        @foreach($currencies as $key => $value)
                                                            <option value="{{$key}}" {{isset($gs) && $gs->basic_currency === $key ? 'selected' : '' }}>{{$value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" class="form-control text-append-currency-symbol basic-currency-symbol text-center" readonly name="basic_currency_symbol"
                                                           placeholder="{{trans('applang.symbol')}}" value="{{$gs->basic_currency_symbol ?? old('basic_currency_symbol')}}" style="width:20%">
                                                    </div>
                                                    @if ($errors->has('basic_currency'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('basic_currency') }}</strong>
                                                        </span>
                                                    @endif
                                                </fieldset>
                                            </div>
                                            <!--Extra Currencies-->
                                            <div class="col-md-12 mb-50">
                                                <label class="required" for="extra_currencies">{{ trans('applang.extra_currencies') }}</label>
                                                <div class="form-group extra_currencies">
                                                    <select id="extra_currencies" class="select2 form-control @error('extra_currencies') is-invalid @enderror" name='extra_currencies[]' multiple="multiple" style="width: 100% !important;">
                                                        @foreach($currencies as $key => $value)
                                                            <option value="{{$key}}" {{isset($gs) && in_array($key,$gs->extra_currencies) ? 'selected' : '' }}>{{$value['name']}} ( {{app()->getLocale() == 'ar' ? $value['symbol_native'] : $value['symbol']}} )</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('extra_currencies'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('extra_currencies') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!--Logo-->
                                            <div class="col-md-12 mb-50">
                                                <div id='img_contain'><img id="blah" align='middle' src="{{$gs->logo_path ?? asset('/uploads/logo_image/defaultLogo.png')}}" alt="your image" title=''/></div>
                                                <div class="input-group is-invalid">
                                                    <div class="custom-file">
                                                        <input type="file" id="inputGroupFile01" name="logo" class="imgInp custom-file-input" aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label text-append-logo" for="inputGroupFile01">{{trans('applang.choose_logo_file')}}</label>

                                                    </div>
                                                    <a href="#" class="btn btn-light-info btn-sm remove-logo text-append-reset" title="{{trans('applang.reset')}}">
                                                        <i class="bx bx-reset"></i>
                                                    </a>
                                                </div>
                                                @if ($errors->has('logo'))
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $errors->first('logo') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                            <input type="hidden" id="hidden-reset" name="reset">
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <hr class="hr modal-hr">
                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="{{route('dashboard')}}" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{trans('applang.back_btn')}}</span>
                                </a>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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
    <script src="{{asset('app-assets/js/scripts/forms/select/form-select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#extra_currencies').select2({
                placeholder: "{{trans('applang.select_extra_currencies')}}",
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            //get the country phone key
            $('#country').on('change', function () {
                var country = $(this).val()
                var url = "{{url('/app-assets/data/countries_ar.json')}}"
                $.getJSON(url, function(data) {
                    $.map(data, function(value, key) {
                        if (key === country)
                        {
                            // console.log(value.phone_code)
                            $('.phone_code').val( '+ ' + value.phone_code)
                        }
                    });
                });
            });

            //get the basic currency symbol
            $('#basic_currency').on('change', function () {
                var currency = $(this).val()
                var url = "{{url('/app-assets/data/currency-symbols.json')}}"
                $.getJSON(url, function(data) {
                    $.map(data, function(value, key) {
                        if (key === currency)
                        {
                            if(document.dir === 'rtl'){
                                // console.log(value.phone_code)
                                $('.basic-currency-symbol').val(value.symbol_native)
                            }else{
                                $('.basic-currency-symbol').val(value.symbol)
                            }
                        }
                    });
                });
            });

            //get the extra currencies symbols
            $('#extra_currencies').on('change', function () {
                var currencies = $(this).val();
                var url = "{{url('/app-assets/data/currency-symbols.json')}}"
                $.getJSON(url, function(data) {
                    $.map(data, function(value, key) {
                        if(document.dir === 'rtl'){
                            if ($.inArray(key, currencies) >= 0)
                            {
                                console.log(value.symbol_native)
                                if(! $(".ex_cur_"+key+"_input").val(value.symbol_native).length > 0){
                                    $('form .extra_currencies').append("<input type='hidden' class='ex_cur_"+key+"_input' name='extra_currencies_symbols[]' value="+value.symbol_native+">")
                                }
                            } else{
                                $(".ex_cur_"+key+"_input").remove()
                            }
                        }else{
                            if ($.inArray(key, currencies) >= 0)
                            {
                                console.log(value.symbol)
                                if(! $(".ex_cur_"+key+"_input").val(value.symbol).length > 0){
                                    $('form .extra_currencies').append("<input type='hidden' class='ex_cur_"+key+"_input' name='extra_currencies_symbols[]' value="+value.symbol+">")
                                }
                            } else{
                                $(".ex_cur_"+key+"_input").remove()
                            }
                        }

                    });
                })
            });

            //logo image preview
            $("#inputGroupFile01").change(function(event) {
                RecurFadeIn();
                readURL(this);
            });
            $("#inputGroupFile01").on('click',function(event){
                RecurFadeIn();
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var filename = $("#inputGroupFile01").val();
                    filename = filename.substring(filename.lastIndexOf('\\')+1);
                    reader.onload = function(e) {
                        debugger;
                        $('#blah').attr('src', e.target.result);
                        $('#blah').hide();
                        $('#blah').fadeIn(500);
                        $('.custom-file-label').text(filename);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            function RecurFadeIn(){}

            //reset logo image
            $('.remove-logo').on('click', function(e) {
                $("#hidden-reset").val('hidden-reset');
                var reader = new FileReader();
                e.preventDefault();
                $('#blah').attr('src', '{{asset('/uploads/logo_image/defaultLogo.png')}}');
                $('#blah').hide();
                $('#blah').fadeIn(500);
                $('.custom-file-label').text('defaultLogo.png');
                $("#inputGroupFile01").val();
                reader.readAsDataURL(input.files[0]);
            });
        });
    </script>
@endsection



