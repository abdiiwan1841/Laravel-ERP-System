<!DOCTYPE html>
<html lang="{{app()->getLocale() == 'ar' ? 'ar' : 'en'}}">
<head>
    <meta charset="utf-8" />
    <title>{{trans('applang.purchase_invoice')}}: # {{$purchaseInvoice->inv_number}}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            font-size: 14px;
            line-height: 24px;
            font-family: 'XBRiyaz', sans-serif !important;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            font-size: 14px;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title-ltr {
            font-size: 45px;
            line-height: 45px;
            color: #333;
            text-align: right;
        }
        .invoice-box table tr.top table td.title-rtl {
            font-size: 45px;
            line-height: 45px;
            color: #333;
            text-align: left;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #D9D9D9;
            border-bottom: 2px solid black;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            border-bottom: 1px solid #ddd;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td.total-el{
            border-bottom: 1px solid black;
            font-weight: bold;
        }
        .invoice-box table tr.total td.total-el.due{
            background-color: #D9D9D9;
        }

        .invoice-box table tr.heading td.align-r{
            text-align: right;
        }
        .invoice-box table tr.details td.align-r{
            text-align: right;
        }
        .invoice-box table tr.total td.align-r{
            text-align: right;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: 'XBRiyaz', sans-serif !important;
        }

        .invoice-box.rtl table {
            text-align: right;
            font-size: 14px;
        }

        .invoice-box.rtl table.inv-header tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box.rtl table tr.details td:nth-child(2) {
            text-align: right;
        }

        .invoice-box.rtl table tr.heading td:nth-child(2) {
            text-align: right;
        }

        .invoice-box.rtl table tr.heading td.align-l{
            text-align: left;
        }
        .invoice-box.rtl table tr.details td.align-l{
            text-align: left;
        }
        .invoice-box.rtl table tr.total td.align-l{
            text-align: left;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }

        .invoice-box tr.top table.inv-header{
            border-bottom: 1px solid #D9D9D9 !important;
        }

        .invoice-box table tr.separator td{
            content: "";
            padding: 15px !important;
        }
        .invoice-box table tr.inv-notes td.label{
            border-top: 1px dotted #333333 !important;
        }
    </style>
</head>

<body>
<div class="invoice-box {{app()->getLocale() == 'ar' ? 'rtl' : ''}}">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table class="inv-header">
                    <tr>
                        <td class="inv-type">
                            <h3>{{trans('applang.purchase_invoice')}}</h3>
                            <span>{{$companyData->business_name}}</span>
                        </td>
                        <td class="{{app()->getLocale() == 'ar' ? 'title-rtl' : 'title-ltr'}}">
                            <img src="{{$logoPath}}" alt="logo" style="width: 100%; max-width: 50px; height: 100%; max-height: 50px">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="6">
                <table>
                    <tr>
                        <td width="60%">
                            <h6 class="invoice-from black">{{trans('applang.supplier')}}</h6>
                            <span><b>{{$purchaseInvoice->supplier->commercial_name}}.</b></span><br/>
                            <span>{{$purchaseInvoice->supplier->first_name}} {{$purchaseInvoice->supplier->last_name}}</span><br/>
                            <span><b>{{trans('applang.commercial_record')}}:</b> {{$purchaseInvoice->supplier->commercial_record}}</span><br/>
                            <span><b>{{trans('applang.tax_registration')}}:</b> {{$purchaseInvoice->supplier->tax_registration}}</span><br/>
                            <span>{{$purchaseInvoice->supplier->street_address}}</span><br/>
                            <span>{{$purchaseInvoice->supplier->state}}, {{$purchaseInvoice->supplier->city}}, {{$purchaseInvoice->supplier->postal_code}}</span><br/>
                        </td>

                        <td align="start" width="40%">
                            <span><b>{{trans('applang.invoice_number')}}# </b>{{$purchaseInvoice->inv_number}}</span><br/>
                            <span><b>{{trans('applang.issue_date')}}: </b>{{$purchaseInvoice->issue_date}}</span><br/>
                            <span><b>{{trans('applang.due_date')}}: </b>{{$purchaseInvoice->due_date}}</span><br/>
                            <span><b>{{trans('applang.print_date')}}: </b>{{\Carbon\Carbon::now()->format('Y-m-d')}}</span><br/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td width="3%">#</td>
            <td >{{trans('applang.item')}}</td>
            <td width="35%">{{trans('applang.description')}}</td>
            <td >{{trans('applang.unit_price')}}</td>
            <td >{{trans('applang.quantity')}}</td>
            <td class="{{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}"><b>{{trans('applang.total')}}</b></td>
        </tr>

        @foreach($purchaseInvoice->purchaseInvoiceDetails as $index => $item)
            <tr class="details">
                <td>{{$index +1}}</td>
                <td>{{\App\Models\ERP\Inventory\Product::where('id', $item->product_id)->pluck('name')->first()}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->unit_price}} {{$currency_symbol}}</td>
                <td>{{$item->quantity}}</td>
                <td class="{{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$item->row_total}}</td>
            </tr>
        @endforeach

        <tr class="total">
            <td colspan="3"><p>{{trans('applang.invoice-thanks')}}.</p></td>
            <td colspan="2" class="total-el">{{trans('applang.total_before')}}</td>
            <td class="total-el {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$purchaseInvoice->subtotal}}</td>
        </tr>
        @if($purchaseInvoice->discount_inv != null)
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el">{{trans('applang.discount')}}</td>
                <td class="total-el {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$purchaseInvoice->discount_inv}}</td>
            </tr>
        @endif
        @foreach($purchaseInvoice->purchaseInvoiceTaxes as $key => $tax)
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el">{{$tax->total_tax_inv}}</td>
                <td class="total-el {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$tax->total_tax_inv_sum}}</td>
            </tr>
        @endforeach
        @if($purchaseInvoice->shipping_expense_inv != null)
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el">{{trans('applang.shipping_expense')}}</td>
                <td class="total-el {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$purchaseInvoice->shipping_expense_inv}}</td>
            </tr>
        @endif
        @if($purchaseInvoice->down_payment_inv != null)
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el">{{trans('applang.down_payment')}}</td>
                <td class="total-el {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$purchaseInvoice->down_payment_inv}}</td>
            </tr>
        @endif
        <tr class="total">
            <td colspan="3"></td>
            <td colspan="2" class="total-el due">{{trans('applang.due_amount')}}</td>
            <td class="total-el due {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$purchaseInvoice->due_amount}}</td>
        </tr>
        @if($purchaseInvoice->paid_to_supplier_inv != null)
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el">{{trans('applang.paid')}}</td>
                <td class="total-el {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$purchaseInvoice->paid_to_supplier_inv}}</td>
            </tr>
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el due">{{trans('applang.due_amount_after_paid')}}</td>
                <td class="total-el due {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{$purchaseInvoice->due_amount_after_paid}}</td>
            </tr>
        @endif
        @if($purchaseInvoice->payments_total > 0.00)
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el">{{trans('applang.payments_total')}}</td>
                <td class="total-el {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">-{{number_format($purchaseInvoice->payments_total,0,'.','')}} {{$companyData->basic_currency_symbol}}</td>
            </tr>
            <tr class="total">
                <td colspan="3"></td>
                <td colspan="2" class="total-el due">{{trans('applang.due_amount_after_payments')}}</td>
                <td class="total-el due {{app()->getLocale() == 'ar' ? 'align-l' : 'align-r'}}">{{number_format($purchaseInvoice->due_amount_after_payments, 0, '.', '')}} {{$companyData->basic_currency_symbol}}</td>
            </tr>
        @endif

        <!-- invoice notes -->
        @if($purchaseInvoice->notes != '')
            <tr class="separator">
                <td colspan="6"></td>
            </tr>
            <tr class="inv-notes">
                <td colspan="6" class="label">{{trans('applang.notes')}}</td>
            </tr>
            <tr class="inv-notes">
                <td colspan="6" class="text">{!! $purchaseInvoice->notes !!}</td>
            </tr>
        @endif
    </table>
</div>

</body>
</html>
