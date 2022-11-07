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
    <div class="container">
        <div class="content-body">
            <!-- warehouses list start -->
            <section class="users-list-wrapper">
                <div class="default-app-list-table">
                    <div class="card">
                        <div class="card-header justify-content-start">
                            <a href="{{route('warehouses.create')}}" class="btn btn-success mb-0">
                                <i class="bx bx-plus"></i> {{trans('applang.add')}}
                            </a>
                        </div>
                        <div class="card-body pt-1 pb-1">
                            <ul class="day-view-entry-list">
                                @foreach($warehouses as $index => $warehouse)
                                    <li class="day-view-entry">
                                        <div class="row align-items-center">

                                            <div class="col-md-8">
                                                <a href="{{route('warehouses.edit', $warehouse->id)}}">
                                                    <div class="project-client">
                                                        <span class="text-black-50">#{{$index + 1}}</span>
                                                        <span class="font-weight-bolder font-size-base black">{{$warehouse->name}}</span>
                                                    </div>
                                                    <div class=""><span class="text-black-50">{{$warehouse->shipping_address}}</span></div>
                                                </a>
                                            </div>

                                            <div class="col-md-2" style="text-align: end">
                                                @if($warehouse->status == 1)
                                                    <span class="badge badge-success-custom">{{trans('applang.active')}}</span>
                                                @else
                                                    <span class="badge badge-danger"> {{trans('applang.suspended')}}</span>
                                                @endif
                                            </div>

                                            <div class="col-md-2">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu {{app()->getLocale() == 'ar' ? 'dropdown-menu-right': ''}}">
                                                        <a class="dropdown-item" href="{{route('warehouses.edit', $warehouse->id)}}" title="{{trans('applang.edit')}}" >
                                                            <i class="bx bx-edit-alt"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.edit')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="#" title="{{trans('applang.delete')}}"
                                                           data-toggle="modal"
                                                           data-target="#formModalDeleteWarehouse"
                                                           data-warehouse_id="{{$warehouse->id}}"
                                                           data-name="{{$warehouse->name}}">
                                                            <i class="bx bx-trash"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.delete')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{route('warehouses.show', $warehouse->id)}}" title="{{trans('applang.inventory_transactions_summary')}}">
                                                            <i class="bx bx-bar-chart-square"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.inventory_transactions_summary')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{route('inventoryValue', $warehouse->id)}}" title="{{trans('applang.inventory_value')}}">
                                                            <i class="bx bx-line-chart"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.inventory_value')}}</span>
                                                        </a>
{{--                                                        <a class="dropdown-item" href="#" title="{{trans('applang.stocktaking_sheet')}}">
                                                            <i class="bx bx-spreadsheet"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.stocktaking_sheet')}}</span>
                                                        </a>--}}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- datatable ends -->

                            <div class="d-flex d-flex justify-content-start custom-pagination">
                                {!! $warehouses->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- warehouses list ends -->
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
        $(document).ready(function () {
            $('#formModalDeleteWarehouse').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var warehouse_id = button.data('warehouse_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #warehouse_id').val(warehouse_id)
                modal.find('.modal-body #name').val(name)
            });
        })

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


