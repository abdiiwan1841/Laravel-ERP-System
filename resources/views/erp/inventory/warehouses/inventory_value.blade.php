@extends('layouts.admin.admin_layout')
@section('title', trans('applang.warehouses'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="content-body">
            <div class="card">
                <div class="card-header modal-header bg-primary">
                    <h4 class="modal-title white">{{trans('applang.warehouse_inventory_value')}} ({{$warehouse->name}})</h4>
                </div>
                <div class="card-body mt-1" style="padding-bottom: 13px">
                    <div class="table-responsive">
                        <table class="user-view hover table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr class="">
                                    <th class="" style="">#</th>
                                    <th class="" style="">{{trans('applang.name')}}</th>
                                    <th class="" style="">{{trans('applang.barcode')}}</th>
                                    <th class="" style="">{{trans('applang.quantity')}}</th>
                                    <th class="" style="">{{trans('applang.current_selling_price')}}</th>
                                    <th class="" style="">{{trans('applang.average_purchase_price')}}</th>
                                    <th class="" style="">{{trans('applang.expected_total_selling_price')}}</th>
                                    <th class="" style="">{{trans('applang.total_purchase_price')}}</th>
                                    <th class="" style="">{{trans('applang.expected_profit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($warehouseTotals as $index => $total)
                                        @if($total->total_quantity_purchased > 0.00 || $total->total_quantity_sold > 0.00)
                                            @foreach($total->product as $product)
                                                <tr class="" height="15px;">
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$product->name}}</td>

                                                    <td>{{$product->sku}}</td>

                                                    <td>{{$total->total_quantity_remain}}</td>
                                                    <td>{{$product->sell_price}}</td>

                                                    <td>{{$total->weighted_average_cost}}</td>
                                                    <td>{{$total->total_sales_value_of_remain}}</td>
                                                    <td>{{$total->total_remain_cost}}</td>
                                                    <td>{{$total->expected_profit_of_remain}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    <!--<tfoot>-->
                                    <tbody>
                                        <tr >
                                            <th colspan="6">{{trans('applang.total')}}</th>
                                            <th>{{$warehouseTotalsSellPrice}}</th>
                                            <th>{{$warehouseTotalsPurchasePrice}}</th>
                                            <th>{{$warehouseTotalsExpectedProfit}}</th>
                                        </tr>
                                    </tbody>
                                    <!--</tfoot>-->
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Warehouses Modals -->
    @include('erp.inventory.warehouses.modals')

@endsection
<!-- END: Content-->

@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
@endsection

@section('page-js')
    <script src="{{asset('app-assets')}}/js/scripts/datatables/datatable-filters.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/modal/components-modal.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>

    <script type="text/javascript">
        @if (count($errors) > 0)
        $('#formModal').modal('show');
        @endif

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
@endsection


