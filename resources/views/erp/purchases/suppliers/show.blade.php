@extends('layouts.admin.admin_layout')
@section('title', trans('applang.supplier_show'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" href="{{asset('app-assets/datepicker/css/bootstrap-datepicker3.standalone.min.css')}}">
@endsection

@section('content')
    @php
        //get general settings currency
        $gs = \App\Models\ERP\Settings\GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $gs->basic_currency_symbol;
        }else{
            $currency_symbol = $gs->basic_currency;
        }
    @endphp

    <!--Start Update -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-header modal-header bg-primary justify-content-start">
                            <h4 class="modal-title white">
                                {{$supplier->commercial_name .' '.'(# '.$supplier->full_code.')'}}
                            </h4>
                            @if($supplier->status == 1)
                                <span class="badge badge-success ml-1 mr-1">{{trans('applang.active')}}</span>
                            @else
                                <span class="badge badge-danger ml-1 mr-1"> {{trans('applang.suspended')}}</span>
                            @endif
                        </div>
                        <div class="card-body mt-1" style="padding-bottom: 13px">

                            <div class="custom-card mt-1 mb-5">
                                <div class="card-header border-bottom justify-content-start" style="background-color: #f9f9f9">
                                    <a href="{{route('suppliers.edit', $supplier->id)}}" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-edit"></i> {{trans('applang.edit_details')}}</a>
                                    @if($supplier->status == 1)
                                        <a href="#" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-money"></i> {{trans('applang.add_purchase_invoice')}}</a>
                                        <a href="#" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bxs-calculator"></i> {{trans('applang.statement')}}</a>
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#formModalEditSupplierOpeningBalance"
                                           data-supplier_id="{{$supplier->id}}"
                                           data-name="{{$supplier->first_name}} {{$supplier->last_name}}"
                                           data-opening_balance = "{{$supplier->opening_balance}}"
                                           data-opening_balance_date = "{{$supplier->opening_balance_date}}"
                                           class="btn btn-sm btn-light-secondary btn-card-header">
                                            <i class="bx bx-credit-card"></i>
                                            {{trans('applang.edit_opening_balance')}}
                                        </a>
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#formModalSuspendSupplier"
                                           data-supplier_id="{{$supplier->id}}"
                                           data-name="{{$supplier->first_name}} {{$supplier->last_name}}"
                                           class="btn btn-sm btn-light-secondary btn-card-header">
                                            <i class="bx bxs-minus-circle"></i>
                                            {{trans('applang.suspend')}}
                                        </a>
                                    @endif
                                    @if($supplier->status == 0)
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#formModalActivatingSupplier"
                                           data-supplier_id="{{$supplier->id}}"
                                           data-name="{{$supplier->first_name}} {{$supplier->last_name}}"
                                           class="btn btn-sm btn-light-secondary btn-card-header">
                                            <i class="bx bxs-check-circle"></i>
                                            {{trans('applang.activation')}}
                                        </a>
                                    @endif
                                    <a href="#"
                                       class="btn btn-sm btn-light-secondary btn-card-header-last"
                                       data-toggle="modal"
                                       data-target="#formModalDeleteSupplier"
                                       data-supplier_id="{{$supplier->id}}"
                                       data-name="{{$supplier->first_name}} {{$supplier->last_name}}">
                                        <i class="bx bx-trash"></i>
                                        {{trans('applang.delete')}}
                                    </a>
                                </div>

                                <div class="card-body mt-1">
                                        <ul class="nav nav-pills card-header-pills ml-0" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                                    {{trans('applang.profile')}}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-purchases_invoices-tab" data-toggle="pill" href="#pills-purchases_invoices" role="tab" aria-controls="pills-purchases_invoices" aria-selected="true">
                                                    {{trans('applang.purchase_invoices')}} ({{$supplier->purchase_invoices()->count()}})
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <table class="user-view table-responsive " style="width: 100%">
                                                            <tbody style="display: inline-table; width: 100%">
                                                                <tr>
                                                                    <td style="padding: 11px 20px;">
                                                                        <span class="text-bold-700 font-medium-4">{{$supplier->first_name}} {{$supplier->last_name}}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <b>{{trans('applang.commercial_record')}}:</b> {{$supplier->commercial_record}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <b>{{trans('applang.tax_registration')}}:</b> {{$supplier->tax_registration}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        {{$supplier->street_address}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        {{$supplier->state}}, {{$supplier->city}}, {{$supplier->postal_code}}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="user-view table-responsive" style="width: 100%">
                                                            <tbody style="display: inline-table; width: 100%">
                                                                <tr>
                                                                    <td>
                                                                        <strong>{{trans('applang.email_address')}}:</strong>
                                                                    </td>
                                                                    <td>
                                                                        <a href="mailto:{{$supplier->email}}" class=""><u>{{$supplier->email}}</u></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <strong>{{trans('applang.phone')}}:</strong>
                                                                    </td>
                                                                    <td>
                                                                        ({{$supplier->phone_code}}){{$supplier->phone}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <strong>{{trans('applang.mobile')}}:</strong>
                                                                    </td>
                                                                    <td>
                                                                        ({{$supplier->phone_code}}){{$supplier->mobile}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <strong>{{trans('applang.fax')}}:</strong>
                                                                    </td>
                                                                    <td>
                                                                        ({{$supplier->phone_code}}){{$supplier->fax}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <strong>{{trans('applang.notes')}}:</strong>
                                                                    </td>
                                                                    <td>
                                                                        {{$supplier->notes}}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                @if($supplier->contacts->count() > 0)
                                                    <h3 class="head-bar theme-color-a"><span class="details-info">{{trans('applang.contact_list')}}</span></h3>
                                                    <div class="table-responsive">
                                                        <table style="width: 100%" class="table-bordered table-sm">
                                                            <tbody>
                                                                <tr style="background: #fafbfc">
                                                                    <th class="no-wrap">{{trans('applang.name')}}</th>
                                                                    <th class="no-wrap">{{trans('applang.email_address')}}</th>
                                                                    <th class="no-wrap">{{trans('applang.phone_number')}}</th>
                                                                    <th class="no-wrap">{{trans('applang.mobile')}}</th>
                                                                </tr>
                                                                @foreach($supplier->contacts as $contact)
                                                                    <tr>
                                                                        <td class="no-wrap">{{$contact->supp_cont_first_name}} {{$contact->supp_cont_last_name}}</td>
                                                                        <td class="no-wrap"><a href="mailto:{{$contact->supp_cont_email}}" class=""><u>{{$contact->supp_cont_email}}</u></a></td>
                                                                        <td class="no-wrap">({{$supplier->phone_code}}){{$contact->supp_cont_phone}}</td>
                                                                        <td class="no-wrap">({{$supplier->phone_code}}){{$contact->supp_cont_mobile}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif

                                                <h3 class="head-bar theme-color-a"><span class="details-info">{{trans('applang.quick_info')}}</span></h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table style="width: 100%">

                                                                <tbody>
                                                                <tr>
                                                                    <td class="no-wrap">
                                                                        <strong>{{trans('applang.purchase_invoices_count')}}:</strong>
                                                                    </td>

                                                                    <td>
                                                                        <u>{{$supplier->purchase_invoices()->count()}}</u>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="no-wrap">
                                                                        <strong>{{trans('applang.unpaid_purchase_invoices_count')}}:</strong>
                                                                    </td>
                                                                    <td> {{$supplier->purchase_invoices()->where('payment_status', 1)->count()}}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table  style="width: 100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="no-wrap" style="width: 30%">
                                                                        <strong>{{trans('applang.last_purchase_invoice')}}:</strong>
                                                                    </td>
                                                                    <td>
                                                                        <u><a href="{{route('purchase-invoices.show', $supplier->purchase_invoices()->latest('id')->first())}}" target="_blank" title="">#{{$supplier->purchase_invoices()->latest()->first()->inv_number}}</a></u>  (<u><a href="{{route('purchase-invoices.show', $supplier->purchase_invoices()->latest('id')->first())}}" class="" target="_blank">{{trans('applang.show')}}</a></u>)
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="pills-purchases_invoices" role="tabpanel" aria-labelledby="pills-purchases_invoices-tab">
                                                @if($supplier->purchase_invoices()->count() > 0)
                                                    <h3 class="head-bar theme-color-a"><span class="details-info">{{trans('applang.supplier_purchase_invoices')}}</span></h3>
                                                    <div class="table-responsive">
                                                        <table style="width: 100%" class="table-bordered table-sm">
                                                            <tbody>
                                                            <tr style="background: #fafbfc">
                                                                <th class="no-wrap">{{trans('applang.invoice_number')}}</th>
                                                                <th class="no-wrap">{{trans('applang.issue_date')}}</th>
                                                                <th class="no-wrap">{{trans('applang.payment_status')}}</th>
                                                                <th class="no-wrap">{{trans('applang.total')}}</th>
                                                            </tr>

                                                            @foreach($supplier->purchase_invoices as $purchaseInvoice)
                                                                <tr>
                                                                    <td class="no-wrap"><a href="{{route('purchase-invoices.show', $purchaseInvoice->id)}}">{{$purchaseInvoice->inv_number}}</a></td>
                                                                    <td class="no-wrap">{{$purchaseInvoice->issue_date}}</td>
                                                                    <td class="no-wrap">
                                                                        @if($purchaseInvoice->payment_status == 1)
                                                                            <span class="badge ml-1 mr-1" style="background-color: red ; color: #FFFFFF">{{trans('applang.unpaid')}}</span>
                                                                        @elseif($purchaseInvoice->payment_status == 2)
                                                                            <span class="badge ml-1 mr-1" style="background-color: #ff7f00; color: #FFFFFF"> {{trans('applang.partially_paid')}}</span>
                                                                        @elseif($purchaseInvoice->payment_status == 3)
                                                                            <span class="badge badge-success-custom ml-1 mr-1"> {{trans('applang.paid')}}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="no-wrap">{{$purchaseInvoice->total_inv}} {{$currency_symbol}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
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
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!--End Update Form -->

    @include('erp.purchases.suppliers.modals')

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
    <script>
        $(document).ready(function () {
            $('#formModalEditSupplierOpeningBalance').on('show.bs.modal', function (event) {
                if (event.namespace === 'bs.modal') {
                    var button = $(event.relatedTarget)
                    var supplier_id = button.data('supplier_id')
                    var name = button.data('name')
                    var opening_balance = button.data('opening_balance')
                    var opening_balance_date = button.data('opening_balance_date')
                    var modal = $(this)
                    modal.find('.modal-body #supplier_id').val(supplier_id)
                    modal.find('.modal-body #name').val(name)
                    modal.find('.modal-body #opening_balance').val(opening_balance)
                    modal.find('.modal-body #opening_balance_date').val(opening_balance_date)
                }
            });

            $('#formModalDeleteSupplier').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var supplier_id = button.data('supplier_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #supplier_id').val(supplier_id)
                modal.find('.modal-body #name').val(name)
            });

            $('#formModalSuspendSupplier').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var supplier_id = button.data('supplier_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #supplier_id').val(supplier_id)
                modal.find('.modal-body #name').val(name)
            });

            $('#formModalActivatingSupplier').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var supplier_id = button.data('supplier_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #supplier_id').val(supplier_id)
                modal.find('.modal-body #name').val(name)
            });
        })
    </script>
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
@endsection



