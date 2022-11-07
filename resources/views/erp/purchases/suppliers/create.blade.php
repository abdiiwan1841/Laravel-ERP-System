@extends('layouts.admin.admin_layout')
@section('title', trans('applang.add_supplier'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/datepicker/css/bootstrap-datepicker3.standalone.min.css')}}">
@endsection

@section('content')
    <!--Start Update -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('suppliers.store')}}" method="POST" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-header modal-header bg-primary">
                            <h4 class="modal-title white">{{trans('applang.add_supplier')}}</h4>
                        </div>
                        <div class="card-body mt-1" style="padding-bottom: 13px">

                            <div class="row">
                                <div class="col-md-6">
                                    <!--Supplier Details-->
                                    <div class="custom-card mt-1 mb-5">
                                        <div class="card-header border-bottom" style="background-color: #f9f9f9">
                                            <span class="text-bold-700">{{trans('applang.supplier_details')}}</span>
                                        </div>

                                        <div class="card-body mt-1">

                                            <!--Commercial Name-->
                                            <label class="required" for="commercial_name">{{ trans('applang.commercial_name') }}</label>
                                            <div class="position-relative has-icon-left mb-50">
                                                <input id="commercial_name"
                                                       type="text"
                                                       class="form-control @error('commercial_name') is-invalid @enderror"
                                                       name="commercial_name"
                                                       placeholder="{{trans('applang.commercial_name')}}"
                                                       autocomplete="commercial_name"
                                                       value="{{old('commercial_name')}}"
                                                       autofocus>
                                                <div class="form-control-position">
                                                    <i class="bx bx-pen"></i>
                                                </div>
                                                @error('commercial_name')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <!--First name & Last name-->
                                            <div class="form-row mb-50">
                                                <div class="col-md-6">
                                                    <label class="required" for="first_name">{{ trans('applang.first_name') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="first_name"
                                                               type="text"
                                                               class="form-control @error('first_name') is-invalid @enderror"
                                                               name="first_name"
                                                               placeholder="{{trans('applang.first_name')}}"
                                                               autocomplete="first_name"
                                                               value="{{old('first_name')}}"
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
                                                <div class="col-md-6">
                                                    <label class="required" for="last_name">{{ trans('applang.last_name') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="last_name"
                                                               type="text"
                                                               class="form-control @error('last_name') is-invalid @enderror"
                                                               name="last_name"
                                                               placeholder="{{trans('applang.last_name')}}"
                                                               autocomplete="last_name"
                                                               value="{{old('last_name')}}"
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

                                            <!--Country & State & City-->
                                            <div class="form-row mb-50">
                                                <div class="col-md-4">
                                                    <label class="required" for="country">{{ trans('applang.country') }}</label>
                                                    <fieldset class="form-group">
                                                        <select id="country" class="custom-select @error('country') is-invalid @enderror" name='country'>
                                                            <option value="" selected disabled>{{trans('applang.select_country')}}</option>
                                                            @foreach($countries as $key => $value)
                                                                <option value="{{$key}}">
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
                                                <div class="col-md-4">
                                                    <label class="required" for="state">{{ trans('applang.state') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="state"
                                                               type="text"
                                                               class="form-control @error('state') is-invalid @enderror"
                                                               name="state"
                                                               placeholder="{{trans('applang.state')}}"
                                                               autocomplete="state"
                                                               value="{{old('state')}}"
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
                                                <div class="col-md-4">
                                                    <label class="required" for="city">{{ trans('applang.city') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="city"
                                                               type="text"
                                                               class="form-control @error('city') is-invalid @enderror"
                                                               name="city"
                                                               placeholder="{{trans('applang.city')}}"
                                                               autocomplete="city"
                                                               value="{{old('city')}}"
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

                                            <!--Street Adress & Postal Code-->
                                            <div class="form-row mb-50">
                                                <div class="col-md-9">
                                                    <label class="required" for="street_address">{{ trans('applang.street_address') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="street_address"
                                                               type="text"
                                                               class="form-control @error('street_address') is-invalid @enderror"
                                                               name="street_address"
                                                               placeholder="{{trans('applang.street_address')}}"
                                                               autocomplete="street_address"
                                                               value="{{old('street_address')}}"
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
                                                <div class="col-md-3">
                                                    <label for="postal_code">{{ trans('applang.postal_code') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="postal_code"
                                                               type="number"
                                                               class="form-control @error('postal_code') is-invalid @enderror"
                                                               name="postal_code"
                                                               placeholder="{{trans('applang.postal_code')}}"
                                                               autocomplete="postal_code"
                                                               value="{{old('postal_code')}}"
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

                                            <!--Phone & Mobile-->
                                            <div class="form-row mb-50">
                                                <div class="col-md-6">
                                                    <label class="required" for="phone">{{ trans('applang.phone') }}</label>
                                                    <div class="input-group" dir="ltr">
                                                        <div class="input-group-append" style="width: 20%">
                                                            <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                                   placeholder="&#9872; &#9743;" value="{{old('phone_code')}}">
                                                        </div>
                                                        <input id="phone"
                                                               type="number"
                                                               class="form-control @error('phone') is-invalid @enderror text-append-phone"
                                                               name="phone"
                                                               placeholder="{{trans('applang.phone')}}"
                                                               autocomplete="phone"
                                                               value="{{old('phone')}}"
                                                               autofocus>
                                                        @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="mobile">{{ trans('applang.mobile') }}</label>
                                                    <div class="input-group" dir="ltr">
                                                        <div class="input-group-append" style="width: 20%">
                                                            <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                                   placeholder="&#9872; &#9743;" value="{{old('phone_code')}}">
                                                        </div>
                                                        <input id="mobile"
                                                               type="number"
                                                               class="form-control @error('mobile') is-invalid @enderror text-append-phone"
                                                               name="mobile"
                                                               placeholder="{{trans('applang.mobile')}}"
                                                               autocomplete="mobile"
                                                               value="{{old('mobile')}}"
                                                               autofocus>
                                                        @error('mobile')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!--Fax & Email-->
                                            <div class="form-row mb-50">
                                                <div class="col-md-6">
                                                    <label for="fax">{{ trans('applang.fax') }}</label>
                                                    <div class="input-group" dir="ltr">
                                                        <div class="input-group-append" style="width: 20%">
                                                            <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                                   placeholder="&#9872; &#9743;" value="{{old('phone_code')}}">
                                                        </div>
                                                        <input id="fax"
                                                               type="number"
                                                               class="form-control @error('fax') is-invalid @enderror text-append-phone"
                                                               name="fax"
                                                               placeholder="{{trans('applang.fax')}}"
                                                               autocomplete="fax"
                                                               value="{{old('fax')}}"
                                                               autofocus>
                                                        @error('fax')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email">{{ trans('applang.email') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="email"
                                                               type="email"
                                                               class="form-control @error('email') is-invalid @enderror"
                                                               name="email"
                                                               placeholder="{{trans('applang.email')}}"
                                                               autocomplete="email"
                                                               value="{{old('email')}}"
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

                                            <!--Commercial Record & Tax Registration-->
                                            <div class="form-row mb-50">
                                                <div class="col-md-6">
                                                    <label for="commercial_record">{{ trans('applang.commercial_record') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="commercial_record"
                                                               type="text"
                                                               class="form-control @error('commercial_record') is-invalid @enderror"
                                                               name="commercial_record"
                                                               placeholder="{{trans('applang.commercial_record')}}"
                                                               autocomplete="commercial_record"
                                                               value="{{old('commercial_record')}}"
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
                                                <div class="col-md-6">
                                                    <label for="tax_registration">{{ trans('applang.tax_registration') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="tax_registration"
                                                               type="text"
                                                               class="form-control @error('tax_registration') is-invalid @enderror"
                                                               name="tax_registration"
                                                               placeholder="{{trans('applang.tax_registration')}}"
                                                               autocomplete="tax_registration"
                                                               value="{{old('tax_registration')}}"
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

                                            <div id="supplier_contacts" class="mt-2">
                                                <h3 id="supplier_contacts_head" class="font-medium-4 font-weight-bolder hidden">{{trans('applang.contact_list')}}</h3>
                                            </div>
                                            <a href="javascript:void(0);" id="add_contact" class="btn btn-light-primary btn-sm">
                                                <i class="bx bx-plus"></i>
                                                {{trans('applang.add_contact')}}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--Account details-->
                                    <div class="custom-card mt-1 mb-5">
                                        <div class="card-header border-bottom" style="background-color: #f9f9f9">
                                            <span class="text-bold-700">{{trans('applang.account_details')}}</span>
                                        </div>

                                        <div class="card-body mt-1">
                                            <!--Status-->
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

                                            <!--currency-->
                                            <label class="required" for="currency">{{ trans('applang.currency') }}</label>
                                            <fieldset class="form-group mb-50">
                                                <div class="input-group-append">
                                                    <select id="currency" class="custom-select @error('currency') is-invalid @enderror text-append-currency" name='currency'>
                                                        <option value="" selected disabled>{{trans('applang.select_currency')}}</option>
                                                        @foreach($currencies as $key => $value)
                                                            <option value="{{$key}}" >{{$value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" class="form-control text-append-currency-symbol basic-currency-symbol text-center" readonly name="currency_symbol"
                                                           placeholder="{{trans('applang.symbol')}}" value="{{old('currency_symbol')}}" style="width:20%">
                                                </div>
                                                @if ($errors->has('currency'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('currency') }}</strong>
                                                    </span>
                                                @endif
                                            </fieldset>

                                            <!--Opening balance & opening balance date-->
                                            <div class="form-row mb-50">
                                                <div class="col-md-6">
                                                    <label class="required" for="opening_balance">{{ trans('applang.opening_balance') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="opening_balance"
                                                               type="number"
                                                               class="form-control @error('opening_balance') is-invalid @enderror"
                                                               name="opening_balance"
                                                               placeholder="{{trans('applang.opening_balance')}}"
                                                               autocomplete="opening_balance"
                                                               value="{{old('opening_balance')}}"
                                                               autofocus>
                                                        <div class="form-control-position">
                                                            <i class="bx bx-pen"></i>
                                                        </div>
                                                        @error('opening_balance')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="required" for="opening_balance_date">{{ trans('applang.opening_balance_date') }}</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text"
                                                               class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}} @error('opening_balance_date') is-invalid @enderror"
                                                               placeholder="{{trans('applang.select_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}"
                                                               name="opening_balance_date"

                                                        >
                                                        <div class="form-control-position">
                                                            <i class="bx bx-calendar"></i>
                                                        </div>
                                                        @if ($errors->has('opening_balance_date'))
                                                            <span class="text-danger ">
                                                                <strong class="small font-weight-bolder">{{ $errors->first('opening_balance_date') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!--Notes-->
                                            <label for="currency">{{ trans('applang.notes') }}</label>
                                            <fieldset class="form-group">
                                                <textarea name="notes" class="form-control" id="basicTextarea" rows="5" placeholder="{{ trans('applang.notes') }}">
                                                    {{old('notes')}}
                                                </textarea>
                                            </fieldset>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <hr class="hr modal-hr">
                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="{{route('suppliers.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
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
    <!--DatePicker js-->
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.ar.min.js" charset="UTF-8"></script>
    <script>
        $('.datepicker_ar').datepicker({
            format: "yyyy-mm-dd",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true,
            language: "ar",
        });

        $('.datepicker_en').datepicker({
            format: "yyyy-mm-dd",
            maxViewMode: 3,
            todayBtn: "linked",
            clearBtn: true,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true,
        });
    </script>
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
            $('#currency').on('change', function () {
                var currency = $(this).val()
                var url = "{{url('/app-assets/data/currency-symbols.json')}}"
                $.getJSON(url, function(data) {
                    $.map(data, function(value, key) {
                        if (key === currency)
                        {
                            // console.log(value.phone_code)
                            $('.basic-currency-symbol').val(value.symbol_native)
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $('#add_contact').on('click',function(e) {
            $('#supplier_contacts_head').removeClass('hidden');
            var row =
                '<div class="supplier_contact_row">' +
                '<a class="btn btn-danger btn-xs remove-item remove-contact" href="javascript:void(0)"><i class="bx bx-x"></i></a>' +
                '<div class="row">' +
                '<div class="col-md-6 col-xs-12 form-group">' +
                '<label for="supp_cont_first_name">{{trans('applang.first_name')}}</label>' +
                '<input name="supp_cont_first_name[]" type="text" class="form-control @error("supp_cont_first_name.*") is-invalid @enderror" id="supp_cont_first_name">' +
                '@error('supp_cont_first_name.*')'+
                '<span class="invalid-feedback" role="alert">'+
                '<strong>{{ $message }}</strong>'+
                '</span>'+
                '@enderror'+
                '</div>' +
                '<div class="col-md-6 col-xs-12 form-group">' +
                '<label for="supp_cont_last_name">{{trans('applang.last_name')}}</label>' +
                '<input name="supp_cont_last_name[]" type="text" class="form-control @error("supp_cont_last_name.*") is-invalid @enderror" id="supp_cont_last_name">' +
                '@error('supp_cont_last_name.*')'+
                '<span class="invalid-feedback" role="alert">'+
                '<strong>{{ $message }}</strong>'+
                '</span>'+
                '@enderror'+
                '</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="supp_cont_email">{{trans('applang.email')}}</label>' +
                '<input name="supp_cont_email[]" type="email" class="form-control @error("supp_cont_email.*") is-invalid @enderror" id="supp_cont_email">' +
                '@error('supp_cont_email.*')'+
                '<span class="invalid-feedback" role="alert">'+
                '<strong>{{ $message }}</strong>'+
                '</span>'+
                '@enderror'+
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6 col-xs-12 form-group">' +
                '<label for="supp_cont_phone">{{trans('applang.phone')}}</label>' +
                '<input name="supp_cont_phone[]" type="number" class="form-control @error("supp_cont_phone.*") is-invalid @enderror" id="supp_cont_phone">' +
                '@error('supp_cont_phone.*')'+
                '<span class="invalid-feedback" role="alert">'+
                '<strong>{{ $message }}</strong>'+
                '</span>'+
                '@enderror'+
                '</div>' +
                '<div class="col-md-6 col-xs-12 form-group">' +
                '<label for="supp_cont_mobile">{{trans('applang.mobile')}}</label>' +
                '<input name="supp_cont_mobile[]" type="number" class="form-control @error("supp_cont_mobile.*") is-invalid @enderror" id="supp_cont_mobile">' +
                '@error('supp_cont_mobile.*')'+
                '<span class="invalid-feedback" role="alert">'+
                '<strong>{{ $message }}</strong>'+
                '</span>'+
                '@enderror'+
                '</div>' +
                '</div>' +
                '</div>';
            $('#supplier_contacts').append(row);
        });

        $('body').on('click', '.remove-item', function (e){
            $(this).closest('.supplier_contact_row').remove();
            if($('.supplier_contact_row').length === 0){
                $('#supplier_contacts_head').addClass('hidden');
            }
        });
    </script>
@endsection



