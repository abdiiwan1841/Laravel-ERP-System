<!doctype html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{trans(trans('applang.down_payment'))}}-{{trans('applang.purchase_invoice')}} # {{$purchaseInvoice->inv_number}}</title>
    <style>
        .receipt{
            margin: auto;
            min-height: 300px;
            border: 1px solid #000000;
            padding: 15px;
            font-size: 14px;
            line-height: 24px;
            font-family: 'XBRiyaz', sans-serif !important;
            color: #555;
        }

        hr{
            color: #D9D9D9 !important;
        }

        /*        .receipt-footer{
                    padding: 10px;
                    text-align: center;
                    width: 40%;
                    margin-top: 62px;
                    !*border-top: 1px solid #DDDD;*!
                }*/

        table.receipt-body tr td{
            padding-bottom: 5px !important;
        }
    </style>
</head>
<body>
<div class="receipt">
    <table cellpadding="0" cellspacing="0" width="100%" class="receipt-header">
        <tr>
            <td>
                <h2 >{{trans('applang.payment_receipt_down_payment')}}</h2>
                <h4 >{{$companyData->business_name}}</h4>
                <div style="font-size: 14px;">
                    <p >{{$companyData->street_address}}</p>
                    <span >{{$companyData->city}}, </span>
                    <span >{{$companyData->state}}, </span>
                    <span >{{$companyData->postal_code}}</span>
                </div>
            </td>
            <td align="start" width="30%" style="vertical-align: top !important">
                <span ><b>{{trans('applang.the_date')}}:</b> {{$purchaseInvoice->issue_date}}</span>
            </td>
            <td align="start" width="10%" style="vertical-align: top !important">
                <span ><b>{{trans('applang.number')}}:</b> {{$purchaseInvoice->number}}</span>
            </td>
        </tr>
    </table>
    <hr>
    <table cellpadding="0" cellspacing="0" width="100%" class="receipt-body">
        <tr>
            <td>
                <span><b>{{trans('applang.to')}}: </b> {{$purchaseInvoice->supplier->first_name}} {{$purchaseInvoice->supplier->last_name}}</span>
            </td>
        </tr>
        <tr>
            <td width="25%">
                <span ><b>{{trans('applang.amount')}}: </b> {{$down_payment}} {{$currency_symbol}}</span>
            </td>
            <td width="75%">
                <span ><b>{{trans('applang.paid_by')}}: </b> {{$purchaseInvoice->deposit_payment_method}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <span ><b>{{trans('applang.purchase_invoice_number')}}: </b>#{{$purchaseInvoice->inv_number}}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span ><b>{{trans('applang.received_by')}}: </b> {{$purchaseInvoice->user->first_name}} {{$purchaseInvoice->user->last_name}}</span>
            </td>
        </tr>
        <tr>
            <td>
                @if($purchaseInvoice->notes != null)
                    <span ><b>{{trans('applang.purpose')}}: </b> {!!$purchaseInvoice->notes!!}</span>
                @endif
            </td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" width="40%" style="margin-top: 50px;margin-bottom: 15px; text-align: center" class="receipt-footer">
        <tr width="100%">
            <td>
                <div>
                    <hr>
                    <span  class="font-small-3">{{trans('applang.signature')}}</span>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
