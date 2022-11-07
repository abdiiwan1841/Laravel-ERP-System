<div>
    <div class="row">
        <div class="col-md-12">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-header modal-header bg-primary justify-content-start">
                        <h4 class="modal-title white mr-1">
                            {{'(# '.$product->number.')'}}
                        </h4>
                        <h4 class="modal-title white mr-1">
                            {{$product->name }}
                        </h4>
                        @if($product->total_quantity > $product->lowest_stock_alert)
                            <span class="badge badge-success-custom">{{trans('applang.available_stock')}}</span>
                        @elseif($product->total_quantity <= $product->lowest_stock_alert  && $product->total_quantity > 0.00)
                            <span class="badge badge-warning">{{trans('applang.low_stock')}}</span>
                        @elseif($product->total_quantity == 0.00)
                            <span class="badge badge-danger">{{trans('applang.out_of_stock')}}</span>
                        @endif
                    </div>
                    <div class="card-body mt-1" style="padding-bottom: 13px">

                        <div class="custom-card mt-1 mb-5">
                            <div class="card-header border-bottom justify-content-start" style="background-color: #f9f9f9">
                                <a href="{{route('products.edit', $product->id)}}" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-edit"></i> {{trans('applang.edit_details')}}</a>
                                <a href="#"
                                   class="btn btn-sm btn-light-secondary btn-card-header"
                                   data-toggle="modal"
                                   data-target="#formModalDeleteProduct"
                                   data-supplier_id="{{$product->id}}"
                                   data-name="{{$product->name}}">
                                    <i class="bx bx-trash"></i>
                                    {{trans('applang.delete')}}
                                </a>
                                <a href="#" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-repost"></i> {{trans('applang.move_stock')}}</a>
                                <a href="#" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-plus"></i> {{trans('applang.add_transaction')}}</a>
                                <a href="#" class="btn btn-sm btn-light-secondary btn-card-header"><i class="bx bx-minus"></i> {{trans('applang.dismissal_transaction')}}</a>
                                <a href="#" class="btn btn-sm btn-light-secondary btn-card-header-last"><i class="bx bx-printer"></i> {{trans('applang.prints')}}</a>
                            </div>

                            <div class="card-body mt-1">
                                <ul class="nav nav-pills card-header-pills ml-0" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-info-tab" data-toggle="pill" href="#pills-info" role="tab" aria-controls="pills-info" aria-selected="false">
                                            {{trans('applang.info')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-inventory-movement-tab" data-toggle="pill" href="#pills-inventory-movement" role="tab" aria-controls="pills-inventory-movement" aria-selected="true">
                                            {{trans('applang.inventory_movement')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-timetable-tab" data-toggle="pill" href="#pills-timetable" role="tab" aria-controls="pills-timetable" aria-selected="true">
                                            {{trans('applang.timetable')}}
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active show" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="product-section-data">
                                                    <h6 class="text-primary">{{trans('applang.inventory_quantity')}}</h6>
                                                    <h5>{{number_format($product->total_quantity, 0) . ' ' . $measurementUnit}}</h5>
                                                    @foreach($product->warehouseTotal as $total)
                                                        <span class="font-small-3 d-block">{{\App\Models\ERP\Inventory\Warehouse::where('id',$total->warehouse_id)->pluck('name')->first()}}: {{number_format($total->total_quantity_remain,0).' '.$measurementUnit}}</span>
                                                    @endforeach
                                                    <button class="btn btn-foursquare font-small-3 mt-50">{{trans('applang.add_inventory_transaction')}}</button>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="product-section-data">
                                                    <h6 class="text-primary">{{trans('applang.total_sold_quantity')}}</h6>
                                                    <h5>{{number_format($total_quantity_sold,0)}} {{$measurementUnit}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="product-section-data">
                                                    <h6 class="text-primary">{{trans('applang.last_7_days')}}</h6>
                                                    <h5>0 {{$measurementUnit}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="product-section-data">
                                                    <h6 class="text-primary">{{trans('applang.weighted_average_cost')}}</h6>
                                                    <h5>{{$total_weighted_average_cost}}&nbsp;{{$currency_symbol}} {{trans('applang.for_each')}} {{$measurementUnit}}</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <h3 class="head-bar theme-color-a"><span class="details-info">{{trans('applang.details')}}</span></h3>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="product-img-container">
                                                    <img style="width: 100%; height: 100%; object-fit: cover" src="{{asset('uploads/products/images/'. $product->product_image)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.product_number')}}:</span>
                                                    <span style="width: 50%">{{$product->number}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.sell_price')}}: </span>
                                                    <span style="width: 50%">{{$product->sell_price}}&nbsp;{{$currency_symbol}} {{trans('applang.for_each')}} {{$measurementUnit}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.price_after_discount')}}: </span>
                                                    <span style="width: 50%">{{$price_after_discount }} ({{trans('applang.discount')}} {{number_format($product->discount, 1) . ' ' . $discount_type}})</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.lowest_sell_price')}}: </span>
                                                    <span style="width: 50%">{{$product->lowest_sell_price}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.description')}}: </span>
                                                    <span style="width: 50%">{{$product->description}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.notes')}}: </span>
                                                    <span style="width: 50%">{{$product->notes}}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.purchase_price')}}: </span>
                                                    <span style="width: 50%">{{$product->purchase_price}}&nbsp;{{$currency_symbol}} {{trans('applang.for_each')}} {{$measurementUnit}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.barcode')}}: </span>
                                                    <span style="width: 50%">{{$product->sku}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.supplier')}}: </span>
                                                    <span style="width: 50%"><a target="_blank" href="{{route('suppliers.show', $product->supplier->id)}}"><u>{{$product->supplier->first_name .' '. $product->supplier->last_name}}</u></a></span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.supplier_code')}}: </span>
                                                    <span style="width: 50%">{{$product->supplier->full_code}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.brand')}}: </span>
                                                    <span style="width: 50%">{{$product->brand->name}}</span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.category')}}: </span>
                                                    <span style="width: 50%"><a href="{{route('categories.index')}}" target="_blank"><u>{{$product->category->name}}</u></a></span>
                                                </div>
                                                <div class="d-flex mt-50">
                                                    <span class="font-weight-bold text-dark" style="width: 50%">{{trans('applang.lowest_stock_alert_reach')}}: </span>
                                                    <span style="width: 50%">{{number_format($product->lowest_stock_alert, 0)}}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-inventory-movement" role="tabpanel" aria-labelledby="pills-purchases_invoices-tab">
                                        pills-inventory-movement
                                    </div>

                                    <div class="tab-pane fade" id="pills-timetable" role="tabpanel" aria-labelledby="pills-purchases_invoices-tab">
                                        pills-timetable
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-2rem">
                            <a href="{{route('products.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.back_btn')}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
