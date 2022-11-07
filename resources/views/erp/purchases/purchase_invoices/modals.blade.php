@if(isset($purchaseInvoice))
{{--show down payment--}}
<div class="modal fade text-left" id="formModalShowDownPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-instagram bg-lighten-4">
                <div class="d-flex justify-content-start align-items-center">
                    <h4 class="modal-title text-white" id="myModalLabel17">{{trans('applang.down_payment_details')}}</h4>
{{--                    <span id="payment_status" class="badge mr-1 ml-1"></span>--}}
                </div>
                <div id="modal_buttons">
                    <a href="{{route('downPaymentReceiptPrint', $purchaseInvoice->id)}}" target="_blank" class="btn btn-primary btn-sm d-inline-flex align-items-center">
                        <i class="bx bx-printer"></i>
                        <span style="margin-right: 3px; margin-left: 3px">{{trans('applang.receipt')}}</span>
                    </a>
                    <a href="{{route('purchase-invoices.edit', $purchaseInvoice->id)}}"
                       class="btn btn-primary btn-sm d-inline-flex align-items-center">
                        <i class="bx bx-edit"></i>
                        <span style="margin-right: 3px; margin-left: 3px">{{trans('applang.edit')}}</span>
                    </a>
                    <button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="bg-primary modal-header">
                        <h6 class="modal-title white">{{trans('applang.supplier_details')}}</h6>
                    </div>
                    <div class="card-body">
                        <table class="user-view table-responsive" style="width: 100%">
                            <tbody>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.supplier_name')}} :</th>
                                <td class="w-25"></td>
                                <td class="">{{$purchaseInvoice->supplier->commercial_name}}</td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.street_address')}} :</th>
                                <td class="w-25"></td>
                                <td class="">{{$purchaseInvoice->supplier->street_address}}</td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.city')}} :</th>
                                <td class="w-25"></td>
                                <td class="">{{$purchaseInvoice->supplier->city}}</td>
                            </tr>

                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.state')}} :</th>
                                <td class="w-25"></td>
                                <td class="">{{$purchaseInvoice->supplier->state}}</td>
                            </tr>

                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.postal_code')}} :</th>
                                <td class="w-25"></td>
                                <td class="">{{$purchaseInvoice->supplier->postal_code}}</td>
                            </tr>

                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.phone_number')}} :</th>
                                <td class="w-25"></td>
                                <td class="">{{$purchaseInvoice->supplier->phone}}</td>
                            </tr>

                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.country')}} :</th>
                                <td class="w-25"></td>
                                <td class="w-100">{{$purchaseInvoice->supplier->country}}</td>
                            </tr>

                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.currency')}} :</th>
                                <td class="w-25"></td>
                                <td class="w-100">{{$purchaseInvoice->supplier->currency}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="bg-primary modal-header">
                        <h6 class="modal-title white">{{trans('applang.payment_details')}}</h6>
                    </div>
                    <div class="card-body">
                        <table class="user-view table-responsive" style="width: 100%">
                            <tbody>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.purchase_invoice_number')}} :</th>
                                <td class="w-25"></td>
                                <td class="">{{$purchaseInvoice->inv_number}}</td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.deposit_payment_method')}} :</th>
                                <td class="w-25"></td>
                                <td id="down_deposit_payment_method"></td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.payment_value')}} :</th>
                                <td class="w-25"></td>
                                <td id="down_payment_amount"></td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.transaction_id')}} :</th>
                                <td class="w-25"></td>
                                <td id="down_transaction_id"></td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.payment_status')}} :</th>
                                <td class="w-25"></td>
                                <td id="down_pmt_status"></td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.payment_date')}} :</th>
                                <td class="w-25"></td>
                                <td id="down_payment_date"></td>
                            </tr>
                            <tr>
                                <th class="no-wrap" scope="row">{{trans('applang.added_by')}} :</th>
                                <td class="w-25"></td>
                                <td class="w-100" id="down_added_by"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--show payment--}}
<div class="modal fade text-left" id="formModalShowPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-instagram bg-lighten-4">
                <div class="d-flex justify-content-start align-items-center">
                    <h4 class="modal-title text-white" id="myModalLabel17">{{trans('applang.payment_transaction')}} # <b id="payment_id"></b></h4>
                    <span id="payment_status" class="badge mr-1 ml-1"></span>
                </div>
                <div id="modal_buttons">
                    <a href="{{route('paymentReceiptPrint', 'test')}}" target="_blank" class="btn btn-primary btn-sm d-inline-flex align-items-center print-receipt-ajax">
                        <i class="bx bx-printer"></i>
                        <span style="margin-right: 3px; margin-left: 3px">{{trans('applang.receipt')}}</span>
                    </a>
                    <a href=""
                       class="btn btn-primary btn-sm d-inline-flex align-items-center edit-payment"
                       data-toggle="modal"
                       data-target="#formModalEditPayment">
                        <i class="bx bx-edit"></i>
                        <span style="margin-right: 3px; margin-left: 3px">{{trans('applang.edit')}}</span>
                    </a>
                    <a href="" class="btn btn-success btn-sm d-inline-flex align-items-center confirm-completed" id="check" style="display: none !important;">
                        <i class="bx bx-check-circle"></i>
                        <span style="margin-right: 3px; margin-left: 3px">{{trans('applang.complete_transaction')}}</span>
                    </a>
                    <button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="bg-primary modal-header">
                        <h6 class="modal-title white">{{trans('applang.supplier_details')}}</h6>
                    </div>
                    <div class="card-body">
                        <table class="user-view table-responsive" style="width: 100%">
                            <tbody>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.supplier_name')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="">{{$purchaseInvoice->supplier->commercial_name}}</td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.street_address')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="">{{$purchaseInvoice->supplier->street_address}}</td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.city')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="">{{$purchaseInvoice->supplier->city}}</td>
                                </tr>

                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.state')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="">{{$purchaseInvoice->supplier->state}}</td>
                                </tr>

                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.postal_code')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="">{{$purchaseInvoice->supplier->postal_code}}</td>
                                </tr>

                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.phone_number')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="">{{$purchaseInvoice->supplier->phone}}</td>
                                </tr>

                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.country')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="w-100">{{$purchaseInvoice->supplier->country}}</td>
                                </tr>

                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.currency')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="w-100">{{$purchaseInvoice->supplier->currency}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="bg-primary modal-header">
                        <h6 class="modal-title white">{{trans('applang.payment_details')}}</h6>
                    </div>
                    <div class="card-body">
                        <table class="user-view table-responsive" style="width: 100%">
                            <tbody>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.purchase_invoice_number')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="">{{$purchaseInvoice->inv_number}}</td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.deposit_payment_method')}} :</th>
                                    <td class="w-25"></td>
                                    <td id="deposit_payment_method"></td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.payment_value')}} :</th>
                                    <td class="w-25"></td>
                                    <td id="payment_amount"></td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.transaction_id')}} :</th>
                                    <td class="w-25"></td>
                                    <td id="transaction_id"></td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.payment_status')}} :</th>
                                    <td class="w-25"></td>
                                    <td id="pmt_status"></td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.payment_date')}} :</th>
                                    <td class="w-25"></td>
                                    <td id="payment_date"></td>
                                </tr>
                                <tr>
                                    <th class="no-wrap" scope="row">{{trans('applang.added_by')}} :</th>
                                    <td class="w-25"></td>
                                    <td class="w-100" id="added_by"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--edit payment--}}
<div class="modal fade text-left" id="formModalEditPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-instagram bg-lighten-4">
                <div class="d-flex justify-content-start align-items-center">
                    <h4 class="modal-title text-white" id="myModalLabel17">{{trans('applang.edit_payment_transaction')}} # <b id="payment_id-edit"></b></h4>
                    <span id="payment_status" class="badge mr-1 ml-1"></span>
                </div>
                <button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('updatePaymentTransaction')}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-row">
                        <input type="hidden" value="{{$purchaseInvoice->id}}" name="purchase_invoice_id">
                        <input type="hidden" value="" name="id" id="payment_id_input">
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
                            <label class="required" for="payment_amount">{{ trans('applang.amount') }}</label>
                            <div class="position-relative has-icon-left">
                                <input id="payment_amount"
                                       type="number"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       name="payment_amount"
                                       placeholder="{{trans('applang.amount')}}"
                                       autocomplete="amount"
                                       value=""
                                       autofocus
                                       onkeypress="restrictMinus(event);">
                                <div class="form-control-position">
                                    <i class="bx bxs-pen"></i>
                                </div>
                                @error('payment_amount')
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
                                       id="payment_date"
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
                            <label class="required" for="payment_status">{{trans('applang.payment_status')}}</label>
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
                                       value=""
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
                        <textarea class="form-control " name="receipt_notes" id="receipt_notes" rows="5" placeholder="{{trans('applang.receipt_notes')}}"></textarea>
                    </div>


                    <hr class="hr modal-hr">
                    <div class="d-flex justify-content-end mt-2rem">
                        <a href="{{route('purchase-invoices.show', $purchaseInvoice)}}" class="btn btn-light-secondary" data-dismiss="modal">
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

{{--edit payment direct--}}
<div class="modal fade text-left" id="formModalEditPaymentDirect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-instagram bg-lighten-4">
                <div class="d-flex justify-content-start align-items-center">
                    <h4 class="modal-title text-white" id="myModalLabel17">{{trans('applang.edit_payment_transaction')}} # <b id="payment_id_edit_direct"></b></h4>
                    <span id="payment_status" class="badge mr-1 ml-1"></span>
                </div>
                <button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('updatePaymentTransaction')}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-row">
                        <input type="hidden" value="{{$purchaseInvoice->id}}" name="purchase_invoice_id">
                        <input type="hidden" value="" name="id" id="payment_id_input_direct">
                        <div class="col-md-6">
                            <label class="required" for="deposit_payment_method">{{trans('applang.deposit_payment_method')}}</label>
                            <fieldset class="form-group">
                                <select id="deposit_payment_method_direct" class="custom-select @error('deposit_payment_method') is-invalid @enderror" name="deposit_payment_method">
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
                            <label class="required" for="payment_amount">{{ trans('applang.amount') }}</label>
                            <div class="position-relative has-icon-left">
                                <input id="payment_amount_direct"
                                       type="number"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       name="payment_amount"
                                       placeholder="{{trans('applang.amount')}}"
                                       autocomplete="amount"
                                       value=""
                                       autofocus
                                       onkeypress="restrictMinus(event);">
                                <div class="form-control-position">
                                    <i class="bx bxs-pen"></i>
                                </div>
                                @error('payment_amount')
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
                                       id="payment_date_direct"
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
                            <label class="required" for="payment_status">{{trans('applang.payment_status')}}</label>
                            <fieldset class="form-group">
                                <select id="payment_status_direct" class="custom-select @error('payment_status') is-invalid @enderror" name="payment_status">
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
                                <select id="collected_by_id_direct" class="custom-select @error('collected_by_id') is-invalid @enderror" name="collected_by_id">
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
                                <input id="transaction_id_direct"
                                       type="number"
                                       class="form-control @error('transaction_id') is-invalid @enderror"
                                       name="transaction_id"
                                       placeholder="{{trans('applang.transaction_id')}}"
                                       autocomplete="transaction_id"
                                       value=""
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
                        <textarea class="form-control " name="receipt_notes" id="receipt_notes_direct" rows="5" placeholder="{{trans('applang.receipt_notes')}}"></textarea>
                    </div>


                    <hr class="hr modal-hr">
                    <div class="d-flex justify-content-end mt-2rem">
                        <a href="{{route('purchase-invoices.show', $purchaseInvoice)}}" class="btn btn-light-secondary" data-dismiss="modal">
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
@endif
