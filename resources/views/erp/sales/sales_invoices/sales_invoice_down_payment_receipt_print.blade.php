<!doctype html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans(trans('applang.down_payment'))}}-{{trans('applang.sales_invoice')}} # {{$salesInvoice->inv_number}}</title>

    @if(app()->getLocale() == 'ar')
        @include('layouts.admin.partials.styles-rtl')
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @else
        @include('layouts.admin.partials.styles')
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    @endif

    <style>
        .receipt{
            margin: auto;
            min-height: 300px;
            border: 1px solid #000000;
        }
        .receipt-header{
            border-bottom: 1px solid #D9D9D9;
        }
        .receipt-body{
            margin-top: 15px;
        }
        .receipt-body span{
            margin-bottom:3px;
        }
        .receipt-footer{
            padding: 10px;
            text-align: center;
            width: 40%;
            margin-top: 62px;
            border-top: 1px solid #DDDD;
        }
    </style>

</head>
<body style="background-color: rgb(195 195 195); font-family: 'Nunito', sans-serif !important; color: #333333" >
<div class="container-fluid" style="background-color: rgb(195 195 195);">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-5 col-md-10 col-12">
            <div class="card invoice-print-area mt-5 mb-5 black">
                <div class="card-body pb-0 mx-25">
                    <div class="receipt mb-5 p-1 ">
                        <div class="receipt-header d-flex justify-content-between">
                            <div class="mb-50">
                                <h3 class="text-bold-700 black">{{trans('applang.payment_receipt_down_payment')}}</h3>
                                <h6 class="text-bold-700 black d-block">{{$companyData->business_name}}</h6>
                                <span class="d-block font-small">{{$companyData->street_address}}</span>
                                <span class="font-small">{{$companyData->city}}, </span>
                                <span class="font-small">{{$companyData->state}}, </span>
                                <span class="font-small">{{$companyData->postal_code}}</span>
                            </div>
                            <div>
                                <span class="font-small mr-5 ml-5"><b>{{trans('applang.the_date')}}:</b> {{$salesInvoice->issue_date}}</span>
                                <span class="font-small"><b>{{trans('applang.number')}}:</b> {{$salesInvoice->number}}</span>
                            </div>
                        </div>

                        <div class="receipt-body">
                            <span class="font-small d-block"><b>{{trans('applang.from')}}: </b> {{$salesInvoice->client->full_name}}</span>
                            <span class="d-block">
                                    <span class="font-small "><b>{{trans('applang.amount')}}: </b> {{$down_payment}} {{$currency_symbol}}</span>
                                    <span class="font-small ml-2 mr-2"><b>{{trans('applang.paid_by')}}: </b> {{$salesInvoice->deposit_payment_method}}</span>
                                </span>
                            <span class="font-small d-block"><b>{{trans('applang.sales_invoice_number')}}: </b>#{{$salesInvoice->inv_number}}</span>
                            <span class="font-small d-block"><b>{{trans('applang.received_by')}}: </b> {{$salesInvoice->user->first_name}} {{$salesInvoice->user->last_name}}</span>
                            @if($salesInvoice->notes != null)
                                <span class="font-small d-block"><b>{{trans('applang.notes')}}: </b> {!!$salesInvoice->notes!!}</span>
                            @endif
                        </div>

                        <div class="receipt-footer">
                            <span  class="font-small">{{trans('applang.signature')}}</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex d-print-none {{app()->getLocale() == 'ar' ? 'justify-content-end' : 'justify-content-start'}}" style="font-family: 'Nunito', sans-serif !important">
                    @if(app()->getLocale() == 'ar')
                        <a href="javascript:window.print();" class="btn btn-instagram"><i class="bx bxs-printer"></i> {{trans('applang.print')}}</a>
                        <a href="{{route('SalesInvoiceDownPaymentReceiptPdf', $salesInvoice->id)}}" target="_blank" class="btn btn-instagram ml-50 mr-50"><i class="bx bxs-file-pdf"></i> PDF</a>
                        <a href="javascript:window.open('','_self').close();" class="btn btn-danger"><i class="bx bx-window-close"></i> {{trans('applang.close_it')}}</a>
                    @else
                        <a href="javascript:window.open('','_self').close();" class="btn btn-danger"><i class="bx bx-window-close"></i> {{trans('applang.close_it')}}</a>
                        <a href="{{route('SalesInvoiceDownPaymentReceiptPdf', $salesInvoice->id)}}" target="_blank" class="btn btn-instagram ml-50 mr-50"><i class="bx bxs-file-pdf"></i> PDF</a>
                        <a href="javascript:window.print();" class="btn btn-instagram"><i class="bx bxs-printer"></i> {{trans('applang.print')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>

@include('layouts.admin.partials.scripts')
</html>
