@extends('layouts.admin.admin_layout')
@section('title', trans('applang.client_show'))

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
                            {{$client->full_name .' '.'(# '.$client->full_code.')'}}
                        </h4>
                        @if($client->status == 1)
                            <span class="badge badge-success ml-1 mr-1">{{trans('applang.active')}}</span>
                        @else
                            <span class="badge badge-danger ml-1 mr-1"> {{trans('applang.suspended')}}</span>
                        @endif
                    </div>
                    <div class="card-body mt-1" style="padding-bottom: 13px">

                        <div class="custom-card mt-1 mb-5">
                            <div class="card-header border-bottom justify-content-start" style="background-color: #f9f9f9">
                                <a href="{{route('clients.edit', $client->id)}}" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-edit"></i> {{trans('applang.edit_details')}}</a>
                                @if($client->status == 1)
                                    <a href="#" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-money"></i> {{trans('applang.add_sales_invoice')}}</a>
                                    <a href="#" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bxs-calculator"></i> {{trans('applang.statement')}}</a>
                                    <a href="#"
                                       data-toggle="modal"
                                       data-target="#formModalEditClientOpeningBalance"
                                       data-client_id="{{$client->id}}"
                                       data-name="{{$client->full_name}}"
                                       data-opening_balance = "{{$client->opening_balance}}"
                                       data-opening_balance_date = "{{$client->opening_balance_date}}"
                                       class="btn btn-sm btn-light-secondary btn-card-header">
                                        <i class="bx bx-credit-card"></i>
                                        {{trans('applang.edit_opening_balance')}}
                                    </a>
                                    <a href="#"
                                       data-toggle="modal"
                                       data-target="#formModalSuspendClient"
                                       data-client_id="{{$client->id}}"
                                       data-name="{{$client->full_name}}"
                                       class="btn btn-sm btn-light-secondary btn-card-header">
                                        <i class="bx bxs-minus-circle"></i>
                                        {{trans('applang.suspend')}}
                                    </a>
                                @endif
                                @if($client->status == 0)
                                    <a href="#"
                                       data-toggle="modal"
                                       data-target="#formModalActivatingClient"
                                       data-client_id="{{$client->id}}"
                                       data-name="{{$client->full_name}}"
                                       class="btn btn-sm btn-light-secondary btn-card-header">
                                        <i class="bx bxs-check-circle"></i>
                                        {{trans('applang.activation')}}
                                    </a>
                                @endif
                                <a href="#"
                                   class="btn btn-sm btn-light-secondary btn-card-header-last"
                                   data-toggle="modal"
                                   data-target="#formModalDeleteClient"
                                   data-client_id="{{$client->id}}"
                                   data-name="{{$client->full_name}}">
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
                                            {{trans('applang.sales_invoices')}} ({{$client->sales_invoices()->count()}})
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
                                                            <span class="text-bold-700 font-medium-4">{{$client->full_name}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            {{$client->street_address}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            {{$client->city}}, {{$client->state}}, {{$client->country}}, {{$client->postal_code}}
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
                                                            <a href="mailto:{{$client->email}}" class=""><u>{{$client->email}}</u></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong>{{trans('applang.phone')}}:</strong>
                                                        </td>
                                                        <td>
                                                            ({{$client->phone_code}}){{$client->phone}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <strong>{{trans('applang.mobile')}}:</strong>
                                                        </td>
                                                        <td>
                                                            ({{$client->phone_code}}){{$client->mobile}}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        @if($client->contacts->count() > 0)
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
                                                    @foreach($client->contacts as $contact)
                                                        <tr>
                                                            <td class="no-wrap">{{$contact->client_cont_first_name}} {{$contact->client_cont_last_name}}</td>
                                                            <td class="no-wrap"><a href="mailto:{{$contact->client_cont_email}}" class=""><u>{{$contact->client_cont_email}}</u></a></td>
                                                            <td class="no-wrap">({{$client->phone_code}}){{$contact->client_cont_phone}}</td>
                                                            <td class="no-wrap">({{$client->phone_code}}){{$contact->client_cont_mobile}}</td>
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
                                                                <strong>{{trans('applang.sales_invoices_count')}}:</strong>
                                                            </td>

                                                            <td>
                                                                <u>{{$client->sales_invoices()->count()}}</u>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-wrap">
                                                                <strong>{{trans('applang.unpaid_sales_invoices_count')}}:</strong>
                                                            </td>
                                                            <td> {{$client->sales_invoices()->where('payment_status', 1)->count()}}</td>
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
                                                                <strong>{{trans('applang.last_sales_invoice')}}:</strong>
                                                            </td>
                                                            <td>
                                                                <u><a href="{{route('sales-invoices.show', $client->sales_invoices()->latest('id')->first())}}" target="_blank" title="">#{{$client->sales_invoices()->latest()->first()->inv_number}}</a></u>  (<u><a href="{{route('sales-invoices.show', $client->sales_invoices()->latest('id')->first())}}" class="" target="_blank">{{trans('applang.show')}}</a></u>)
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-purchases_invoices" role="tabpanel" aria-labelledby="pills-purchases_invoices-tab">
                                        @if($client->sales_invoices()->count() > 0)
                                            <h3 class="head-bar theme-color-a"><span class="details-info">{{trans('applang.client_sales_invoices')}}</span></h3>
                                            <div class="table-responsive">
                                                <table style="width: 100%" class="table-bordered table-sm">
                                                    <tbody>
                                                    <tr style="background: #fafbfc">
                                                        <th class="no-wrap">{{trans('applang.invoice_number')}}</th>
                                                        <th class="no-wrap">{{trans('applang.issue_date')}}</th>
                                                        <th class="no-wrap">{{trans('applang.payment_status')}}</th>
                                                        <th class="no-wrap">{{trans('applang.total')}}</th>
                                                    </tr>

                                                    @foreach($client->sales_invoices as $salesInvoice)
                                                        <tr>
                                                            <td class="no-wrap"><a href="{{route('sales-invoices.show', $salesInvoice->id)}}">{{$salesInvoice->inv_number}}</a></td>
                                                            <td class="no-wrap">{{$salesInvoice->issue_date}}</td>
                                                            <td class="no-wrap">
                                                                @if($salesInvoice->payment_status == 1)
                                                                    <span class="badge ml-1 mr-1" style="background-color: red ; color: #FFFFFF">{{trans('applang.unpaid')}}</span>
                                                                @elseif($salesInvoice->payment_status == 2)
                                                                    <span class="badge ml-1 mr-1" style="background-color: #ff7f00; color: #FFFFFF"> {{trans('applang.partially_paid')}}</span>
                                                                @elseif($salesInvoice->payment_status == 3)
                                                                    <span class="badge badge-success-custom ml-1 mr-1"> {{trans('applang.paid')}}</span>
                                                                @endif
                                                            </td>
                                                            <td class="no-wrap">{{$salesInvoice->total_inv}} {{$currency_symbol}}</td>
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
                            <a href="{{route('clients.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
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

    @include('erp.sales.clients.modals')

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
            $('#formModalEditClientOpeningBalance').on('show.bs.modal', function (event) {
                if (event.namespace === 'bs.modal') {
                    var button = $(event.relatedTarget)
                    var client_id = button.data('client_id')
                    var name = button.data('name')
                    var opening_balance = button.data('opening_balance')
                    var opening_balance_date = button.data('opening_balance_date')
                    var modal = $(this)
                    modal.find('.modal-body #client_id').val(client_id)
                    modal.find('.modal-body #name').val(name)
                    modal.find('.modal-body #opening_balance').val(opening_balance)
                    modal.find('.modal-body #opening_balance_date').val(opening_balance_date)
                }
            });

            $('#formModalDeleteClient').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var client_id = button.data('client_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #client_id').val(client_id)
                modal.find('.modal-body #name').val(name)
            });

            $('#formModalSuspendClient').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var client_id = button.data('client_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #client_id').val(client_id)
                modal.find('.modal-body #name').val(name)
            });

            $('#formModalActivatingClient').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var client_id = button.data('client_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #client_id').val(client_id)
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



