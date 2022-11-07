@extends('layouts.admin.admin_layout')
@section('title', trans('applang.units_templates'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/app-users.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
    <!--Datatables css-->
    <link rel="stylesheet" href="{{asset('app-assets/cdns/css/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/cdns/css/datatables/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/cdns/css/datatables/buttons.dataTables.min.css')}}">
@endsection

@section('content')
    <div class="content-body">
        <!-- users list start -->
        <section class="users-list-wrapper">
            <div class="default-app-list-table">
                <div class="card">
                    <div class="card-header justify-content-start">
                        <a href="{{route('units-templates.create')}}" class="btn btn-success mb-0">
                            <i class="bx bx-plus"></i> {{trans('applang.add_new_template')}}
                        </a>
                    </div>
                    <div class="card-body pt-1">
                        <!-- datatable start -->
                        <div class="table-responsive">
                            <table id="default-app-datatable" class="stripe hover bordered datatable datatable-codes" style="width: 100%">
                                <thead>
                                <tr>
                                    <th class="pl-2 no-wrap ">{{trans('applang.id')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.template_name')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.main_unit')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.measurement_units')}}</th>
                                    <td class="pl-10 no-wrap">{{trans('applang.actions')}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($units_templates->count() > 0)
                                    @foreach ($units_templates as $template)
                                        <tr id="selected_row_{{$template->id}}">

                                            <td class="normal-wrap pl-2 pr-2">{{$template->id}}</td>

                                            <td class="normal-wrap w-25">
                                                <a href="{{route('units-templates.edit', $template->id)}}">
                                                    {{app()->getLocale() == 'ar' ? $template->template_name_ar : $template->template_name_en}}
                                                </a>
                                            </td>

                                            <td class="normal-wrap w-25">
                                                @if(app()->getLocale() == 'ar')
                                                    {{$template->main_unit_ar}}
                                                @else
                                                    {{$template->main_unit_en}}
                                                @endif
                                            </td>

                                            <td class="normal-wrap w-25">
                                                <a class="btn btn-warning btn-sm" href="{{route('measurement-units.create', $template->id)}}" title="{{trans('applang.adjust_measurement_units')}}">
                                                    <i class="fas fa-tools"></i> {{trans('applang.adjust_measurement_units')}}
                                                </a>
                                            </td>

                                            <td class="normal-wrap">
                                                <a href="{{route('units-templates.edit', $template->id)}}" title="{{trans('applang.edit')}}" class="mr-1 ml-1">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>

                                                <a href="#"
                                                   class="text-danger"
                                                   title="{{trans('applang.delete')}}"
                                                   data-toggle="modal"
                                                   data-target="#formModalDeleteTemplate"
                                                   data-template_id="{{$template->id}}"
                                                   data-template_name_ar="{{$template->template_name_ar}}"
                                                   data-template_name_en="{{$template->template_name_en}}">
                                                    <i class="bx bx-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </section>
        <!-- users list ends -->

    </div>

    @include('erp.settings.units-templates.modals')

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

    <!--Datatables js-->
    <script src="{{asset('app-assets/cdns/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/cdns/js/datatables/dataTables.responsive.min.js')}}"></script>

    @if (app()->getLocale() == 'ar')
        <script src="{{asset("app-assets/js/scripts/datatables/datatable-rtl.js")}}"></script>
    @else
        <script src="{{asset("app-assets/js/scripts/datatables/datatable.js")}}"></script>
    @endif

    <script>
        $(document).ready(function () {
            $('#formModalDeleteTemplate').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var template_id = button.data('template_id')
                var template_name_ar = button.data('template_name_ar')
                var template_name_en = button.data('template_name_en')
                var modal = $(this)
                modal.find('.modal-body #template_id').val(template_id)
                modal.find('.modal-body #template_name_ar').val(template_name_ar)
                modal.find('.modal-body #template_name_en').val(template_name_en)
            });
        });
    </script>

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


