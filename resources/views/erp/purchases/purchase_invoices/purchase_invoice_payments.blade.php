<div style="background-color: #edf1f2; padding: 15px">
    <div class="d-flex justify-content-between">
        <h5>{{trans('applang.payments_on_purchase_invoice')}} # ({{$purchaseInvoice->inv_number}})</h5>
        <a href="{{route('addPaymentTransaction', $purchaseInvoice->id)}}" class="btn btn-success">{{trans('applang.add_payment_transaction')}}</a>
    </div>

    <ul class="day-view-entry-list mt-1">
        @if($purchaseInvoice->down_payment)
        <li class="day-view-entry product-index border">
                <div class="row align-items-center pr-2 pl-2">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <a href="#" class="ml-1">
                                <div class="text-black-50 d-flex align-items-center">
                                    <span class="text-black-50"><b>({{trans('applang.d_payment')}}) </b></span>
                                    <span class="font-weight-bolder font-size-base black" style="margin-right: 5px; margin-left: 5px">{{$purchaseInvoice->supplier->commercial_name}}</span>
                                    <span class="font-weight-bolder font-size-base text-black-50"><small>{{$purchaseInvoice->supplier->first_name .' '. $purchaseInvoice->supplier->last_name }}</small></span>
                                </div>
                                <div class="project-client">
                                    <div class="font-small-3 text-black-50 mt-25">
                                        <span>دائن</span>
                                        <span>{{$purchaseInvoice->issue_date}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center" >
                                <div class="text-center">
                                    <div class="project-client">
                                        <span class="text-black-50 d-flex justify-content-between align-items-center font-size-base">
                                            <i class="bx bx-credit-card" style="font-size: 22px"></i>
                                            @if($purchaseInvoice->deposit_payment_method == 'cash')
                                                <span class="text-black-50 ml-50 mr-50">{{trans('applang.cash')}}</span>
                                            @elseif($purchaseInvoice->deposit_payment_method == 'cheque')
                                                <span class="text-black-50 ml-50 mr-50">{{trans('applang.cheque')}}</span>
                                            @else
                                                <span class="text-black-50 ml-50 mr-50">{{trans('applang.bank_transfer')}}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <span class="font-weight-bolder black mb-50" style="font-size: 20px"> {{$down_payment}} {{$currency_symbol}}</span>
                                <div class="" style="margin-top: 5px">
                                    <span class="badge badge-success-custom">{{trans('applang.completed')}}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="dropdown" style="margin-right: 5px; margin-left: 5px">
                                    <button class="btn btn-sm btn-light-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu {{app()->getLocale() == 'ar' ? 'dropdown-menu-right': ''}}">
                                        <a class="dropdown-item"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#formModalShowDownPayment"
                                           data-purchase_invoice_id="{{$purchaseInvoice->id}}"
                                           title="{{trans('applang.show')}}">
                                            <i class="bx bx-search"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.show')}}</span>
                                        </a>
                                        <a class="dropdown-item" href="{{route('purchase-invoices.edit', $purchaseInvoice->id)}}" title="{{trans('applang.edit')}}" >
                                            <i class="bx bx-edit-alt"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.edit')}}</span>
                                        </a>
                                        <a class="dropdown-item" href="{{route('downPaymentReceiptPrint', $purchaseInvoice->id)}}" target="_blank" title="{{trans('applang.print')}}" >
                                            <i class="bx bx-printer"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.print')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endif

        @foreach($purchaseInvoice->payments as $payment)
            <li class="day-view-entry product-index border">
                <div class="row align-items-center pr-2 pl-2">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <a href="#" class="ml-1">

                                <div class="text-black-50 d-flex align-items-center">
                                    <span class="text-black-50"><b># {{$payment->id}} - </b></span>
                                    <span class="font-weight-bolder font-size-base black" style="margin-right: 5px; margin-left: 5px">{{$purchaseInvoice->supplier->commercial_name}}</span>
                                    <span class="font-weight-bolder font-size-base text-black-50"><small>{{$purchaseInvoice->supplier->first_name .' '. $purchaseInvoice->supplier->last_name }}</small></span>
                                </div>
                                <div class="project-client">
                                    <div class="font-small-3 text-black-50 mt-25">
                                        <span>دائن</span>
                                        <span>{{$payment->payment_date}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center" >
                                <div class="text-center">
                                    <div class="project-client">
                                        <span class="text-black-50 d-flex justify-content-between align-items-center font-size-base">
                                            <i class="bx bx-credit-card" style="font-size: 22px"></i>
                                            @if($payment->deposit_payment_method == 'cash')
                                                <span class="text-black-50 ml-50 mr-50">{{trans('applang.cash')}}</span>
                                            @elseif($payment->deposit_payment_method == 'cheque')
                                                <span class="text-black-50 ml-50 mr-50">{{trans('applang.cheque')}}</span>
                                            @elseif($payment->deposit_payment_method == 'bank_transfer')
                                                <span class="text-black-50 ml-50 mr-50">{{trans('applang.bank_transfer')}}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <span class="font-weight-bolder black mb-50" style="font-size: 20px">{{$payment->payment_amount}} {{$currency_symbol}}</span>
                                <div class="" style="margin-top: 5px">
                                    @if($payment->payment_status == 'completed')
                                        <span class="badge badge-success-custom">{{trans('applang.completed')}}</span>
                                    @elseif($payment->payment_status == 'uncompleted')
                                        <span class="badge badge-danger">{{trans('applang.uncompleted')}}</span>
                                    @elseif($payment->payment_status == 'under_revision')
                                        <span class="badge badge-warning">{{trans('applang.under_revision')}}</span>
                                    @elseif($payment->payment_status == 'failed')
                                        <span class="badge badge-danger">{{trans('applang.failed')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="dropdown" style="margin-right: 5px; margin-left: 5px">
                                    <button class="btn btn-sm btn-light-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu {{app()->getLocale() == 'ar' ? 'dropdown-menu-right': ''}}">
                                        <a class="dropdown-item"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#formModalShowPayment"
                                           data-payment_id="{{$payment->id}}"
                                           title="{{trans('applang.show')}}">
                                            <i class="bx bx-search"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.show')}}</span>
                                        </a>
                                        <a class="dropdown-item"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#formModalEditPaymentDirect"
                                           data-payment_id="{{$payment->id}}"
                                           title="{{trans('applang.edit')}}">
                                            <i class="bx bx-edit-alt"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.edit')}}</span>
                                        </a>
                                        <a class="dropdown-item" href="{{route('paymentReceiptPrint', $payment->id)}}" target="_blank" title="{{trans('applang.print')}}" >
                                            <i class="bx bx-printer"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.print')}}</span>
                                        </a>
                                        <a class="dropdown-item" href="#" title="{{trans('applang.delete')}}"
                                           wire:click.prevent="confirmDeletePayment('{{$payment->id}}','{{$purchaseInvoice->inv_number}}')">
                                            <i class="bx bx-trash"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.delete')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div>
        <h5>{{trans('applang.payment_summary')}}</h5>
        <table class="table table-responsive-sm  shadow" style="width: 100%; background-color: #FFFFFF">
            <thead class="" style="background-color: #fafbfc;">
            <tr>
                <th >{{trans('applang.purchase_invoice_number')}}</th>
                <th>{{trans('applang.currency')}}</th>
                <th>{{trans('applang.total_end')}}</th>
                <th>{{trans('applang.paid_amount_end')}}</th>
                <th>{{trans('applang.rest_amount_end')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$purchaseInvoice->inv_number}}</td>
                <td>{{$basic_currency}}</td>
                <td>{{$invoiceValue}} {{$currency_symbol}}</td>
                <td>{{$allPayments}} {{$currency_symbol}}</td>
                <td>{{$due_after_payments}} {{$currency_symbol}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
