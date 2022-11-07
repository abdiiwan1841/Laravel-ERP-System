<!doctype html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if(app()->getLocale() == 'ar')
        @include('layouts.admin.partials.styles-rtl')
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @else
        @include('layouts.admin.partials.styles')
        {{-- <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    @endif

    <title>Document</title>
</head>
<body style="background-color: rgb(195 195 195);; font-family: 'Nunito', sans-serif !important; color: #333333" >
<div class="container-fluid" style="background-color: rgb(195 195 195);">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-9 col-md-10 col-12">
            <div class="card invoice-print-area mt-5 mb-5 black" id="printArea">
                <div class="card-body pb-0 mx-25">
                    <!-- logo and title -->
                    <div class="row">
                        <div class="col-sm-6 print-col-sm-6 col-12 text-center print-text-sm-left text-sm-left print-order-1 order-2 order-sm-1">
                            <div>
                                <h3 class="black text-bold-700">{{trans('applang.sales_invoice')}}</h3>
                                <span>{{$companyData->business_name}}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 print-col-sm-6 col-12 text-center print-text-sm-right text-sm-right print-order-2 order-1 order-sm-2 print-flex d-sm-flex justify-content-end mb-1 mb-sm-0">
                            <div style="width: 60px; height: 60px">
                                <img style="width: 100%; height: 100%" src="{{$companyData->logo ? asset('uploads/logo_image/'.$companyData->logo ) : asset('uploads/logo_image/defaultLogo.png')}}" alt="logo" height="46" width="164">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- invoice address and contact -->
                    <div class="row invoice-info">
                        <div class="col-sm-6 print-col-sm-6 col-12 mt-1">
                            <h6 class="invoice-from black">{{trans('applang.the_client')}}: </h6>
                            <div class="mb-50">
                                <span>{{$salesInvoice->client->full_name}}</span>
                            </div>
                            @if($salesInvoice->client->street_address != null)
                                <div class="mb-50">
                                    <span>{{$salesInvoice->client->street_address}}</span>
                                </div>
                                <div class="mb-50">
                                    <span>{{$salesInvoice->client->state}}, {{$salesInvoice->client->city}}, {{$salesInvoice->client->postal_code}}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-6 print-col-sm-6 col-12 mt-1">
                            <div class="mb-1">
                                <span><b>{{trans('applang.invoice_number')}}# </b>{{$salesInvoice->inv_number}}</span>
                            </div>
                            <div class="mb-1">
                                <span><b>{{trans('applang.issue_date')}}: </b>{{$salesInvoice->issue_date}}</span>
                            </div>
                            <div class="mb-1">
                                <span><b>{{trans('applang.due_date')}}: </b>{{$salesInvoice->due_date}}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>


                <!-- invoice subtotal  and notes-->
                <div class="card-body pt-0 mx-25">
                    <!-- product details table-->
                    <div class="invoice-product-details table-responsive">
                        <table class="table table-bordered mb-0 black inv-table-border">
                            <thead style="background-color: #D9D9D9">
                            <tr class="border-0">
                                <th scope="col" class="table-invoice-head border-left-right-none">#</th>
                                <th class="table-invoice-head border-left-right-none" scope="col">{{trans('applang.item')}}</th>
                                <th class="table-invoice-head border-left-right-none" scope="col">{{trans('applang.description')}}</th>
                                <th class="table-invoice-head border-left-right-none" scope="col">{{trans('applang.unit_price')}}</th>
                                <th class="table-invoice-head border-left-right-none" scope="col">{{trans('applang.quantity')}}</th>
                                <th class="table-invoice-head text-right border-left-right-none" scope="col">{{trans('applang.total')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($salesInvoice->salesInvoiceDetails as $index => $item)
                                <tr>
                                    <td class="table-invoice-body">{{$index +1}}</td>
                                    <td class="table-invoice-body">{{\App\Models\ERP\Inventory\Product::where('id', $item->product_id)->pluck('name')->first()}}</td>
                                    <td class="table-invoice-body">{{$item->description}}</td>
                                    <td class="table-invoice-body">{{$item->unit_price}} {{$currency_symbol}}</td>
                                    <td class="table-invoice-body">{{$item->quantity}}</td>
                                    <td class="table-invoice-body text-right text-bold-700">{{$item->row_total}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- invoice subtotal -->
                    <div class="row">
                        <div class="col-4 col-sm-6 print-col-sm-6 col-12 mt-75">
                            <p>{{trans('applang.invoice-thanks')}}.</p>
                        </div>
                        <div class="col-8 col-sm-6 print-col-sm-6 col-12 d-flex justify-content-end mt-75">
                            <div class="invoice-subtotal w-75 print-w-75">
                                <div class="invoice-calc d-flex justify-content-between">
                                    <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.total_before')}}</span>
                                    <span class="invoice-value pt-25 pb-25">{{$salesInvoice->subtotal}}</span>
                                </div>
                                <hr class="inv-hr">
                                @if($salesInvoice->discount_inv != null)
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.discount')}}</span>
                                        <span class="invoice-value pt-25 pb-25">{{$salesInvoice->discount_inv}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                @endif
                                @foreach($salesInvoice->salesInvoiceTaxes as $key => $tax)
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{$tax->total_tax_inv}}</span>
                                        <span class="invoice-value pt-25 pb-25">{{$tax->total_tax_inv_sum}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                @endforeach
                                @if($salesInvoice->shipping_expense_inv != null)
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.shipping_expense')}}</span>
                                        <span class="invoice-value pt-25 pb-25">{{$salesInvoice->shipping_expense_inv}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                @endif

                                @if($salesInvoice->down_payment_inv != null)
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.down_payment')}}</span>
                                        <span class="invoice-value pt-25 pb-25">{{$salesInvoice->down_payment_inv}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                @endif
                                <hr class="print-inv-hr" style="display: none">
                                <div class="invoice-calc d-flex justify-content-between print-bg-gray" style="background-color: #D9D9D9">
                                    <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.due_amount')}}</span>
                                    <span class="invoice-value pt-25 pb-25">{{$salesInvoice->due_amount}}</span>
                                </div>
                                <hr class="inv-hr">
                                @if($salesInvoice->paid_to_supplier_inv != null)
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.paid')}}</span>
                                        <span class="invoice-value pt-25 pb-25">{{$salesInvoice->paid_to_supplier_inv}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                    <hr class="print-inv-hr" style="display: none">
                                    <div class="invoice-calc d-flex justify-content-between print-bg-gray" style="background-color: #D9D9D9">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.due_amount_after_paid')}}</span>
                                        <span class="invoice-value pt-25 pb-25">{{$salesInvoice->due_amount_after_paid}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                @endif
                                @if($salesInvoice->payments_total > 0.00)
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.payments_total')}}</span>
                                        <span class="invoice-value pt-25 pb-25">-{{number_format($salesInvoice->payments_total,0,'.','')}} {{$companyData->basic_currency_symbol}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                    <hr class="print-inv-hr" style="display: none">
                                    <div class="invoice-calc d-flex justify-content-between print-bg-gray" style="background-color: #D9D9D9">
                                        <span class="invoice-title pt-25 pb-25 text-bold-700">{{trans('applang.due_amount_after_payments')}}</span>
                                        <span class="invoice-value pt-25 pb-25">{{number_format($salesInvoice->due_amount_after_payments, 0, '.', '')}} {{$companyData->basic_currency_symbol}}</span>
                                    </div>
                                    <hr class="inv-hr">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- invoice notes -->
                    @if($salesInvoice->notes != '')
                        <hr class="hr-dotted">
                        <div class="inv-notes">
                            <label for="notes" class="black">{{trans('applang.notes')}}</label>
                            <div id="notes">{!! $salesInvoice->notes !!}</div>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>
</body>

@include('layouts.admin.partials.scripts')
</html>
