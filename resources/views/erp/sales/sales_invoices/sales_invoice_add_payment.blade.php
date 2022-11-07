@extends('layouts.admin.admin_layout')
@section('title', trans('applang.add_payment_transaction'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" href="{{asset('app-assets/datepicker/css/bootstrap-datepicker3.standalone.min.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="content-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header modal-header bg-primary justify-content-start">
                            <h4 class="modal-title white">
                                {{trans('applang.add_payment_transaction').' '.trans('applang.sales_invoice') . ' # (' . $salesInvoice->inv_number . ')'}}
                            </h4>
                        </div>

                        <div class="card-body mt-1" style="padding-bottom: 13px">
                            <form action="{{route('SalesInvoiceStorePaymentTransaction')}}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <input type="hidden" value="{{$salesInvoice->id}}" name="salesInvoice_id">
                                    <div class="col-md-6">
                                        <label class="required" for="deposit_payment_method">{{trans('applang.deposit_payment_method')}}</label>
                                        <fieldset class="form-group">
                                            <select id="deposit_payment_method" class="custom-select @error('deposit_payment_method') is-invalid @enderror" name="deposit_payment_method">
                                                <option value="" selected="">{{trans('applang.select_deposit_payment_method')}}</option>
                                                <option value="cash">{{trans('applang.cash_amount')}}</option>
                                                <option value="cheque">{{trans('applang.cheque')}}</option>
                                                <option value="bank_transfer">{{trans('applang.bank_transfer')}}</option>
                                            </select>
                                            @if ($errors->has('deposit_payment_method'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('deposit_payment_method') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>

                                    <div class="form-group col-md-6 mb-50">
                                        <label class="required" for="amount">{{ trans('applang.amount') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="amount"
                                                   type="number"
                                                   class="form-control @error('amount') is-invalid @enderror"
                                                   name="payment_amount"
                                                   placeholder="{{trans('applang.amount')}}"
                                                   autocomplete="amount"
                                                   value="{{$due_after_payments}}"
                                                   autofocus
                                                   onkeypress="restrictMinus(event);">
                                            <div class="form-control-position">
                                                <i class="bx bxs-pen"></i>
                                            </div>
                                            @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label class="required" for="due_date">{{ trans('applang.the_date') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text"
                                                   class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}} @error('payment_date') is-invalid @enderror"
                                                   placeholder="{{trans('applang.the_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}"
                                                   name="payment_date"
                                                   value="{{date('Y-m-d')??old('payment_date')}}"
                                            >
                                            <div class="form-control-position">
                                                <i class="bx bx-calendar"></i>
                                            </div>
                                            @if ($errors->has('payment_date'))
                                                <span class="text-danger ">
                                                    <strong class="small font-weight-bolder">{{ $errors->first('payment_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="required" for="deposit_payment_method">{{trans('applang.payment_status')}}</label>
                                        <fieldset class="form-group">
                                            <select id="payment_status" class="custom-select @error('payment_status') is-invalid @enderror" name="payment_status">
                                                <option value="">{{trans('applang.select_payment_status')}}</option>
                                                <option value="completed" selected>{{trans('applang.completed')}}</option>
                                                <option value="uncompleted">{{trans('applang.uncompleted')}}</option>
                                                <option value="under_revision">{{trans('applang.under_revision')}}</option>
                                                <option value="failed">{{trans('applang.failed')}}</option>
                                            </select>
                                            @if ($errors->has('payment_status'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('payment_status') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label class="required" for="collected_by_id">{{trans('applang.collected_by')}}</label>
                                        <fieldset class="form-group">
                                            <select id="collected_by_id" class="custom-select @error('collected_by_id') is-invalid @enderror" name="collected_by_id">
                                                <option value="" selected="">{{trans('applang.select_employee')}}</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{$employee->id}}" {{auth()->user()->id == $employee->id ? 'selected' : ''}}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('collected_by_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('collected_by_id') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>

                                    <div class="form-group col-md-6 mb-50">
                                        <label class="required" for="transaction_id">{{ trans('applang.transaction_id') }}</label>
                                        <div class="position-relative has-icon-left ">
                                            <input id="transaction_id"
                                                   type="number"
                                                   class="form-control @error('transaction_id') is-invalid @enderror"
                                                   name="transaction_id"
                                                   placeholder="{{trans('applang.transaction_id')}}"
                                                   autocomplete="transaction_id"
                                                   value="{{old('transaction_id')}}"
                                                   autofocus
                                                   onkeypress="restrictMinus(event);">
                                            <div class="form-control-position">
                                                <i class="bx bxs-pen"></i>
                                            </div>
                                            @error('transaction_id')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-1">
                                    <!--Notes-->
                                    <label class="" for="receipt_notes">{{trans('applang.receipt_notes')}}</label>
                                    <textarea class="form-control " name="receipt_notes" id="receipt_notes" rows="5" placeholder="{{trans('applang.receipt_notes')}}">
                                    </textarea>
                                </div>


                                <hr class="hr modal-hr">
                                <div class="d-flex justify-content-end mt-2rem">
                                    <a href="{{route('sales-invoices.show', $salesInvoice)}}" class="btn btn-light-secondary" data-dismiss="modal">
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
    </div>
    <!-- purchase invoices Modals -->
    @include('erp.purchases.purchase_invoices.modals')

@endsection
<!-- END: Content-->

@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
@endsection

@section('page-js')
    <script src="{{asset('app-assets')}}/js/scripts/modal/components-modal.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>

    <script type="text/javascript">
        @if (count($errors) > 0)
        $('#formModal').modal('show');
        @endif

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
        @if(Session::has('MsgError'))
        const Toast = Swal.mixin({
            toast: true,
            position: document.dir === 'rtl' ? "top-start" : "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "<h5 style='color:white'>" + '{{ session('MsgError') }}' + "</h5>",
            background:'#e82b2b',
            iconColor: '#FFF',
        })
        @endif
    </script>

    <!--Prevent negative input-->
    <script>
        function restrictMinus(e) {
            const inputKeyCode = e.keyCode ? e.keyCode : e.which;
            if (inputKeyCode != null) {
                if (inputKeyCode === 45) e.preventDefault();
            }
        }
    </script>

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

@endsection
