@extends('layouts.admin.admin_layout')
@section('title', trans('applang.create_purchase_invoice_barcode_pdf'))

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
                                {{trans('applang.create_purchase_invoice_barcode_pdf').trans('applang.purchase_invoice') . '# (' . $purchaseInvoice->inv_number . ')'}}
                            </h4>
                        </div>

                        <div class="card-body mt-1" style="padding-bottom: 13px">
                            <form action="{{route('invoiceBarcodePDF')}}" method="POST" target="_blank">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="branch_id">{{ trans('applang.products') }}</label>
                                        <fieldset class="form-group">
                                            <select id="product_id" class="custom-select @error('product_id') is-invalid @enderror" name='product_id'>
                                                <option value="" selected disabled>{{trans('applang.select_product')}}</option>
                                                @foreach($purchaseInvoice->purchaseInvoiceDetails as $item)
                                                    <option value="{{  $item->product_id }}">
                                                        {{\App\Models\ERP\Inventory\Product::whereId($item->product_id)->pluck('name')->first()}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('product_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('product_id') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>

                                    <div class="form-group col-md-12 mb-50">
                                        <label class="required" for="print_qty">{{ trans('applang.print_qty') }}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="print_qty"
                                                   type="number"
                                                   class="form-control @error('print_qty') is-invalid @enderror"
                                                   name="print_qty"
                                                   placeholder="{{trans('applang.print_qty')}}"
                                                   autocomplete="print_qty"
                                                   value="{{old('print_qty')}}"
                                                   autofocus>
                                            <div class="form-control-position">
                                                <i class="bx bxs-pen"></i>
                                            </div>
                                            @error('print_qty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr class="hr modal-hr">
                                <div class="d-flex justify-content-end mt-2rem">
                                    <a href="{{route('purchase-invoices.show', $purchaseInvoice)}}" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{trans('applang.back_btn')}}</span>
                                    </a>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{trans('applang.pdf_barcode')}}</span>
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
{{--    @include('erp.purchases.purchase_invoices.modals')--}}

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

@endsection
