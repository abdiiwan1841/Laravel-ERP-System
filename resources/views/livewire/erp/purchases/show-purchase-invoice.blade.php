<div>
    <div class="card">
        <div class="card-header modal-header bg-primary justify-content-between">
            <div class="d-flex align-items-center justify-content-start">
                <h4 class="modal-title white">
                    {{trans('applang.show_purchase_invoice') .' # ('. $purchaseInvoice->inv_number .')'}}
                </h4>
                @if($purchaseInvoice->payment_status == 1)
                    <span class="badge ml-1 mr-1" style="background-color: red ; color: #FFFFFF">{{trans('applang.unpaid')}}</span>
                @elseif($purchaseInvoice->payment_status == 2)
                    <span class="badge ml-1 mr-1" style="background-color: #ff7f00; color: #FFFFFF"> {{trans('applang.partially_paid')}}</span>
                @elseif($purchaseInvoice->payment_status == 3)
                    <span class="badge badge-success-custom ml-1 mr-1"> {{trans('applang.paid')}}</span>
                @endif

                @if($purchaseInvoice->receiving_status == 1)
                    <span class="badge " style="background-color: yellow; color: black" wire:model="receiving_status">{{trans('applang.under_receive')}}</span>
                @elseif($purchaseInvoice->receiving_status == 2)
                    <span class="badge badge-success" wire:model="receiving_status"> {{trans('applang.received')}}</span>
                @endif
            </div>

            @if($purchaseInvoice->receiving_status == 1 && $receiving_status == 1)
                <a href="#" class="btn btn-success" style="border: 2px solid yellow !important; font-weight: bold" wire:click.prevent="receiptConfirmation"> <i class="bx bx-check"></i> {{trans('applang.receipt_confirmation')}}</a>
            @endif
        </div>
        <div class="card-body mt-1" style="padding-bottom: 13px">

            <div class="custom-card mt-1 mb-1">
                <div class="card-header border-bottom justify-content-start" style="background-color: #f9f9f9">
                    <a href="{{route('purchase-invoices.edit', $purchaseInvoice->id)}}" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-edit"></i> {{trans('applang.edit')}}</a>

                    <a href="{{route('sendToEmail', $purchaseInvoice->id)}}"
                       class="btn btn-sm btn-light-secondary btn-card-header">
                        <i class="bx bx-envelope"></i>
                        {{trans('applang.send_to_supplier')}}
                    </a>
                    <a href="{{route('addPaymentTransaction', $purchaseInvoice->id)}}"
                       class="btn btn-sm btn-light-secondary btn-card-header">
                        <i class="bx bx-credit-card"></i>
                        {{trans('applang.add_payment_transaction')}}
                    </a>
                    <a href="#"
                       class="btn btn-sm btn-light-secondary btn-card-header">
                        <i class="bx bx-credit-card"></i>
                        {{trans('applang.create_purchase_return')}}
                    </a>
                    <a href="#"
                       class="btn btn-sm btn-light-secondary btn-card-header">
                        <i class="bx bxs-book-add"></i>
                        {{trans('applang.add_note_attachment')}}
                    </a>
                    <a href="#"
                       class="btn btn-sm btn-light-secondary btn-card-header" id="printInv" onclick="printInv()">
                        <i class="bx bxs-printer"></i>
                        {{trans('applang.print')}}
                    </a>
                    <a href="{{route('invoicePDF', $purchaseInvoice->id)}}" target="_blank"
                       class="btn btn-sm btn-light-secondary btn-card-header">
                        <i class="bx bxs-file-pdf"></i>
                        PDF
                    </a>
                    <a href="{{route('createInvoiceBarcodePDF', $purchaseInvoice->id)}}"
                       class="btn btn-sm btn-light-secondary btn-card-header">
                        <i class="bx bxs-file-pdf"></i>
                        {{trans('applang.pdf_barcode')}}
                    </a>
                    <a href="#"
                       wire:click.prevent="confirmDeleteInvoice('{{$purchaseInvoice->id}}','{{$purchaseInvoice->inv_number}}')"
                       class="btn btn-sm btn-light-secondary btn-card-header-last">
                        <i class="bx bxs-trash"></i>
                        {{trans('applang.delete')}}
                    </a>
                </div>

                <div class="card-body mt-1">
                    <ul class="nav nav-pills card-header-pills ml-0" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                {{trans('applang.purchase_invoice')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-payments-tab" data-toggle="pill" href="#pills-payments" role="tab" aria-controls="pills-payments" aria-selected="true">
                                {{trans('applang.payments')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-warehouse_permissions-tab" data-toggle="pill" href="#pills-warehouse_permissions" role="tab" aria-controls="pills-warehouse_permissions" aria-selected="true">
                                {{trans('applang.requisitions')}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <iframe frameborder="0" src="{{route('invoicePreview', $purchaseInvoice->id)}}" id="InvoicePreview" name="InvoicePreview" width="100%" height="1000"></iframe>
                        </div>

                        <div class="tab-pane fade" id="pills-payments" role="tabpanel" aria-labelledby="pills-payments-tab">
                            @include('erp.purchases.purchase_invoices.purchase_invoice_payments')
                        </div>

                        <div class="tab-pane fade" id="pills-warehouse_permissions" role="tabpanel" aria-labelledby="pills-warehouse_permissions-tab">
                            warehouse_permissions
                        </div>
                    </div>
                </div>
            </div>

            @if(count($purchaseInvoice->purchaseInvoiceAttachments) > 0)
                <div class="custom-card">
                    <div class="card-header border-bottom justify-content-start" style="background-color: #f9f9f9">
                        <h4>{{trans('applang.attachments')}}</h4>
                    </div>
                    <div class="card-body mt-1">
                        <table class="table table-responsive-sm table-sm table-striped inv-files shadow" style="width: 100%; text-align: center">
                            <thead class="" >
                                <tr>
                                    <th >#</th>
                                    <th >{{trans('applang.file_name')}}</th>
                                    <th >{{trans('applang.created_at')}}</th>
                                    <th>{{trans('applang.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseInvoice->purchaseInvoiceAttachments as $index => $file)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$file->attachments}}</td>
                                        <td>{{$file->created_at->format('d-m-Y')}}</td>
                                        <td>
                                            <a href="{{route('filePreview', [$purchaseInvoice->created_at->format('m-Y'), $purchaseInvoice->inv_number, $file->attachments])}}" target="_blank">
                                                <i class="bx bx-show-alt"></i>
                                            </a>
                                            <a href="{{route('fileDownload', [$purchaseInvoice->created_at->format('m-Y'), $purchaseInvoice->inv_number,$file->attachments])}}" class="mr-1 ml-1">
                                                <i class="bx bx-download"></i>
                                            </a>
                                            <a href="#" class="danger" wire:click.prevent="confirmDelete('{{$file->id}}','{{$file->attachments}}')">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <hr class="hr modal-hr">
            <div class="d-flex justify-content-end mt-2rem">
                <a href="{{route('purchase-invoices.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{trans('applang.back_btn')}}</span>
                </a>
            </div>
        </div>
    </div>
</div>
