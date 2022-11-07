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
                    <h4 class="modal-title white">{{trans('applang.warehouse_summary')}} ({{$warehouse->name}})</h4>
                </div>
                <div class="card-body mt-1" style="padding-bottom: 13px">
                    <div class="table-responsive">
                        <table class="user-view hover table-bordered table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" >{{trans('applang.product_name')}}</th>
                                    <th colspan="3">{{trans('applang.incoming')}}</th>
                                    <th colspan="3">{{trans('applang.outgoing')}}</th>
                                    <th rowspan="2">{{trans('applang.total_transaction')}}</th>
                                </tr>
                                <tr>
                                    <!--in-->
                                    <th>{{trans('applang.purchase_invoices')}}</th>
                                    <th>{{trans('applang.sales_returns')}}</th>
                                    <th>{{trans('applang.the_total')}}</th>
                                    <!--out-->
                                    <th>{{trans('applang.sales_invoices')}}</th>
                                    <th>{{trans('applang.purchase_returns')}}</th>
                                    <th>{{trans('applang.the_total')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warehouseTotals as $total)
                                    @if($total->total_quantity_purchased > 0.00 || $total->total_quantity_sold > 0.00)
                                        @foreach($total->product as $product)
                                            <tr>
                                                <td><u><strong><a href="{{route('products.show', $product->id)}}">{{$product->name}}</a></strong></u></td>
                                                <!--in-->
                                                <td>{{$total->total_quantity_purchased}}</td>
                                                <td>0</td>
                                                <td>{{$total->total_quantity_purchased + 0}}</td> <!--فواتير الشراء + مرتجع مبيعات-->
                                                <!--out-->
                                                <td>{{$total->total_quantity_sold}}</td>
                                                <td>0</td>
                                                <td>{{$total->total_quantity_sold + 0}}</td><!--فواتير البيع + مرتجع مشتريات-->

                                                <td><a href="#"><u><strong>{{$total->total_quantity_remain}}</strong></u></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
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


