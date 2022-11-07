<div>
    <!-- Filters start-->
    <section class="users-list-wrapper">
        <div class="default-app-list-table">
            <div class="card">
                {{--Filters--}}
                <div class="card-header justify-content-start">
                    <span class="text-bold-700 font-medium-1 text-black-50">{{trans('applang.filters')}}</span>
                </div>
                <div class="card-body pt-2 pb-0">
                    <div class="form-row">
                        <div class="col-md-6">
                            <input wire:model="search" type="text" class="form-control mb-50" placeholder="{{trans('applang.search')}}">
                        </div>
                        <div class="col-md-6">
{{--                            <input
                                wire:model="filterByIssueDate"
                                type="text" class="form-control datepicker_ar" placeholder="{{trans('applang.issue_date')}}" autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="mm/dd/yyyy" data-date-today-highlight="true"
                                onchange="this.dispatchEvent(new InputEvent('input'))"
                            >--}}
                            <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                <input type="text"
                                       placeholder="{{trans('applang.issue_date')}}"
                                       class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}} mb-50"
                                       wire:model="filterByIssueDateStart"
                                       onchange="this.dispatchEvent(new InputEvent('input'))"
                                       style="border-top-right-radius: 3px; border-bottom-right-radius: 3px; background-color: #FFFFFF" readonly>
                                <span class="input-group-text mb-50" style="border-radius: 0px">{{trans('applang.to')}}</span>
                                <input type="text"
                                       placeholder="{{trans('applang.issue_date')}}"
                                       class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}} mb-50"
                                       wire:model="filterByIssueDateEnd"
                                       onchange="this.dispatchEvent(new InputEvent('input'))"
                                       style="border-top-left-radius: 3px; border-bottom-left-radius: 3px; background-color: #FFFFFF" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <select class="custom-select mb-50" wire:model="filterBySupplier">
                                <option value="" selected>{{trans('applang.select_supplier')}}</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->commercial_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="custom-select mb-50" wire:model="filterByWarehouse">
                                <option value="" selected="">{{trans('applang.select_warehouse')}}</option>
                                @foreach($warehouses as $key => $warehouse)
                                    <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="filterByReceivingStatus" class="custom-select mb-50">
                                <option selected value="">{{trans('applang.select_receiving_status')}}</option>
                                <option value="{{1}}">{{trans('applang.under_receive')}}</option>
                                <option value="{{2}}">{{trans('applang.received')}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="filterByPaymentStatus" class="custom-select mb-50">
                                <option selected value="">{{trans('applang.select_payment_status')}}</option>
                                <option value="{{1}}">{{trans('applang.unpaid')}}</option>
                                <option value="{{2}}">{{trans('applang.partially_paid')}}</option>
                                <option value="{{3}}">{{trans('applang.paid')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-3">
                            <select wire:model="sortAsc" class="custom-select mb-50">
                                <option selected>{{trans('applang.sort_by')}}</option>
                                <option value="1">{{trans('applang.ascending')}}</option>
                                <option value="0">{{trans('applang.descending')}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="sortField" class="custom-select mb-50">
                                <option selected>{{trans('applang.sort_column')}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="perPage" class="custom-select mb-50">
                                <option selected>{{trans('applang.per_page')}}</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button wire:click.prevent="resetSearch" class="btn btn-primary w-100">{{trans('applang.reset')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- filters ends -->

    <!-- products list start -->
    <section class="users-list-wrapper">
        <div class="default-app-list-table">
            <div class="card">
                {{-- Buttons--}}
                <div class="card-header justify-content-start">
                    <a href="{{route('purchase-invoices.create')}}" class="btn btn-success mb-0 mr-1">
                        <i class="bx bx-plus"></i> {{trans('applang.add')}}
                    </a>

                    <div class="btn-group">
                        <fieldset class="btn btn-bitbucket" style="padding: 4px 15px">
                            <label class="container-custom-checkbox">
                                <div class="d-flex justify-content-between align-content-center">
                                    <input type="checkbox" id="selectAll" wire:model="selectPage">
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">{{trans('applang.select_all')}}</span>
                                </div>
                            </label>
                        </fieldset>
                        @if(count($checked) > 0)
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-danger dropdown-toggle rounded-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        (<span class="d-none d-sm-inline-block">{{trans('applang.selected_rows_is')}}</span> {{count($checked)}})
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4" style="width: 100%">
                                        <a href="#" class="dropdown-item" wire:click.prevent="confirmBulkDelete()">
                                            <i class="bx bx-trash"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.delete')}}</span>
                                        </a>
                                        <a href="#" class="dropdown-item" wire:click.prevent="exportSelected()"
                                           onclick="confirm('{{trans('applang.export_confirm_message')}}') || event.stopImmediatePropagation()">
                                            <i class="bx bxs-file-export"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.export')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-info" wire:click.prevent="deselectSelected()">
                                <i class="bx bx-reset d-sm-inline-block"></i>
                                <span class="d-none d-sm-inline-block">{{trans('applang.deselect')}}</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-1 pb-1">
                    @if($selectPage)
                        <div class="col-md-12 mb-2 pl-0 pr-0">
                            <div class="d-flex justify-content-start align-items-center">
                                @if($selectAll)
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="mb-0">
                                            {{trans('applang.you_have_selected_all')}} ( <strong>{{$purchaseInvoices->total()}}</strong> {{trans('applang.items')}} ).
                                        </p>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="mb-0">
                                            {{trans('applang.you_have_selected')}} ( <strong>{{count($checked)}}</strong> {{trans('applang.items')}} ),
                                            {{trans('applang.do_you_want_to_select_all')}} ( <strong>{{$purchaseInvoices->total()}}</strong> {{trans('applang.items')}} ) ?
                                        </p>
                                        <a href="#" class="btn btn-sm btn-primary ml-1" wire:click="selectAll" title="{{trans('applang.select_all')}}">
                                            <i class="bx bx-select-multiple d-sm-inline-block"></i>
                                            <span class="d-none d-sm-inline-block">{{trans('applang.select_all')}}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    <ul class="day-view-entry-list">
                        @foreach($purchaseInvoices as $index => $purchaseInvoice)
                            <li class="day-view-entry product-index {{in_array($purchaseInvoice->id ,$checked)? 'lightyellow' : ''}}">

                                <label class="checkbox-container" style="display: {{in_array($purchaseInvoice->id ,$checked)? 'block' : ''}}">
                                    <input type="checkbox" class="product-input" value="{{$purchaseInvoice->id}}" wire:model="checked">
                                    <span class="checkmark"></span>
                                </label>

                                <div class="row align-items-center pr-2 pl-2">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <a href="{{route('purchase-invoices.show', $purchaseInvoice->id)}}" class="ml-1">
                                                <div class="project-client d-flex justify-content-start">
                                                    <div class="text-black-50">#{{$purchaseInvoice->inv_number}}</div>
                                                    <div class="font-weight-bolder font-size-base black" style="margin-left: 5px; margin-right: 5px">{{$purchaseInvoice->issue_date}}</div>
                                                </div>
                                                <div class="text-black-50 d-flex align-items-center">
                                                    <span class="text-black-50"><small>#{{$purchaseInvoice->supplier->full_code}}</small></span>
                                                    <span class="font-weight-bolder font-size-base black" style="margin-right: 5px; margin-left: 5px">{{$purchaseInvoice->supplier->commercial_name}}</span>
                                                </div>
                                                <div class="project-client">
                                                    <div class="font-weight-bolder font-size-base text-black-50">
                                                        {{$purchaseInvoice->supplier->street_address}}
                                                    </div>
                                                </div>
                                                <div class="text-black-50 d-flex align-items-center">
                                                    <span class="font-weight-bolder font-size-base">
                                                        {{$purchaseInvoice->supplier->city}},
                                                        {{$purchaseInvoice->supplier->state}},
                                                        {{$purchaseInvoice->supplier->country}},
                                                        {{$purchaseInvoice->supplier->postal_code}}
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center" >
                                                <div class="text-center">
                                                    <div class="project-client">
                                                        <span class="font-weight-bolder font-size-base text-black-50">{{trans('applang.created_in')}}</span>
                                                        <span class="font-weight-bolder font-size-base text-black-50 d-flex justify-content-between align-items-center">
                                                            <small><i class="bx bx-time"></i></small>
                                                            <small class="font-weight-bolder text-black-50">{{$purchaseInvoice->created_at}}</small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <span class="font-weight-bolder black mb-50" style="font-size: 20px">{{$purchaseInvoice->total_inv . ' ' . $currency_symbol }}</span>
                                                @if($purchaseInvoice->payment_status == 2)
                                                    @if($purchaseInvoice->due_amount_after_payments > 0.00)
                                                        <span class="d-block black" style="margin-top: 5px">{{trans('applang.due_amount')}} : {{number_format($purchaseInvoice->due_amount_after_payments, 0, '.', '')}} {{$currency_symbol}}</span>
                                                    @elseif($purchaseInvoice->due_amount_after_payments == 0.00 && $purchaseInvoice->down_payment > 0)
                                                        <span class="d-block black" style="margin-top: 5px">{{trans('applang.due_amount')}} : {{$purchaseInvoice->due_amount}}</span>
                                                    @endif
                                                @endif
                                                <div class="text-center" style="margin-top: 5px">
                                                    @if($purchaseInvoice->payment_status == 1)
                                                        <span class="badge" style="background-color: red ; color: #FFFFFF">{{trans('applang.unpaid')}}</span>
                                                    @elseif($purchaseInvoice->payment_status == 2)
                                                        <span class="badge" style="background-color: #ff7f00; color: #FFFFFF">{{trans('applang.partially_paid')}}</span>
                                                    @elseif($purchaseInvoice->payment_status == 3)
                                                        <span class="badge badge-success-custom">{{trans('applang.paid')}}</span>
                                                    @endif

                                                    @if($purchaseInvoice->receiving_status == 1)
                                                        <span class="badge" style="background-color: yellow; color: #333333" wire:model="receiving_status">{{trans('applang.under_receive')}}</span>
                                                    @elseif($purchaseInvoice->receiving_status == 2)
                                                        <span class="badge badge-success-custom" wire:model="receiving_status">{{trans('applang.received')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="dropdown" style="margin-right: 5px; margin-left: 5px">
                                                    <button class="btn btn-sm btn-light-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu {{app()->getLocale() == 'ar' ? 'dropdown-menu-right': ''}}">
                                                        <a class="dropdown-item" href="{{route('purchase-invoices.show', $purchaseInvoice->id)}}" title="{{trans('applang.show')}}" >
                                                            <i class="bx bx-search"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.show')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{route('purchase-invoices.edit', $purchaseInvoice->id)}}" title="{{trans('applang.edit')}}" >
                                                            <i class="bx bx-edit-alt"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.edit')}}</span>
                                                        </a>
                                                        @if($purchaseInvoice->receiving_status == 1 )
                                                            <a href="#" class="dropdown-item"  wire:click.prevent="receiptConfirmation({{$purchaseInvoice->id}})">
                                                                <i class="bx bx-check"></i>
                                                                <span class="font-weight-bold ml-1 mr-1">{{trans('applang.receipt_confirmation')}}</span>
                                                            </a>
                                                        @endif
                                                        <a class="dropdown-item" href="{{route('invoicePrint', $purchaseInvoice->id)}}" target="_blank" title="{{trans('applang.print')}}" >
                                                            <i class="bx bx-printer"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.print')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{route('invoicePDF', $purchaseInvoice->id)}}" target="_blank" title="PDF" >
                                                            <i class="bx bxs-file-pdf"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">PDF</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{route('sendToEmail', $purchaseInvoice->id)}}" title="{{trans('applang.send_to_supplier')}}" >
                                                            <i class="bx bxs-envelope"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.send_to_supplier')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="#" title="{{trans('applang.delete')}}"
                                                           wire:click.prevent="confirmDelete('{{$purchaseInvoice->id}}','{{$purchaseInvoice->inv_number}}')"
                                                        >
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
                    <div class="d-flex d-flex justify-content-between custom-pagination mt-1">
                        {!! $purchaseInvoices->links() !!}
                        <p>
                            {{trans('applang.showing')}}
                            {{count($purchaseInvoices)}}
                            {{trans('applang.from_original')}}
                            {{count(\App\Models\ERP\Purchases\PurchaseInvoice::all())}}
                            {{trans('applang.entries')}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- products list ends -->
</div>
