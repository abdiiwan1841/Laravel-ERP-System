@extends('layouts.admin.admin_layout')
@section('title', trans('applang.sequential_codes'))

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
                        <a href="{{route('sequential-codes.create')}}" class="btn btn-success mb-0">
                            <i class="bx bx-user-plus"></i> {{trans('applang.add')}}
                        </a>
{{--                        <button type="button"
                                class="btn btn-primary mb-0 ml-1"
                                id="selectAllRecords">
                            <i class="bx bx-select-multiple"></i> {{trans('applang.select_all')}}
                        </button>
                        <button type="button"
                                class="btn btn-primary mb-0 ml-1 disabled"
                                id="deselectAllSelectedRecords"
                                disabled>
                            <i class="bx bx-reset"></i> {{trans('applang.deselect')}}
                        </button>
                        <button type="button"
                                class="btn btn-danger mb-0 mr-1 ml-1 disabled"
                                id="deleteAllSelectedRecords"
                                disabled>
                            <i class="bx bx-trash"></i> {{trans('applang.delete_selected')}}
                        </button>--}}
                    </div>
                    <div class="card-body pt-1">
                        <!-- datatable start -->
                        <div class="table-responsive">
                            <table id="default-app-datatable" class="stripe hover bordered datatable datatable-codes" style="width: 100%">
                                <thead>
                                <tr>
{{--                                    <th class="sorting_desc_disabled sorting_asc_disabled select_all no-wrap">
                                        <fieldset>
                                             <div class="checkbox checkbox-sm checkbox-glow checkbox-danger">
                                            <input type="checkbox" name="selectAllcheckbox" id="selectAllcheckbox" class="selectAllcheckbox">
                                            <label for="selectAllcheckbox"></label>
                                             </div>
                                        </fieldset>
                                    </th>--}}
                                    <th class="pl-2 no-wrap ">{{trans('applang.id')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.model')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.prefix')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.numbers_length')}}</th>
                                    <td class="pl-10 no-wrap">{{trans('applang.actions')}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($seq_codes->count() > 0)
                                    @foreach ($seq_codes as $seq_code)
                                        <tr id="selected_row_{{$seq_code->id}}">
{{--                                            <td class="select_all normal-wrap">
                                                    <fieldset>
                                                         <div class="checkbox checkbox-sm checkbox-glow checkbox-danger">
                                                        <input type="checkbox"
                                                               name="itemId"
                                                               id="{{$seq_code->id}}"
                                                               value="{{$seq_code->id}}"
                                                               class="selectItemCheckbox"
                                                                {{$seq_code->id == 1 ? "disabled" : ""}}>
                                                        <label for="{{$seq_code->id}}"></label>
                                                         </div>
                                                    </fieldset>
                                            </td>--}}

                                            <td class="normal-wrap pl-2 pr-2">{{$seq_code->id}}</td>

                                            <td class="normal-wrap w-25">
                                                <a href="{{route('sequential-codes.edit', $seq_code->id)}}">{{$seq_code->model}}</a>
                                            </td>

                                            <td class="normal-wrap w-25">
                                                {{$seq_code->prefix}}
                                            </td>

                                            <td class="normal-wrap w-25">
                                                {{$seq_code->numbers_length}}
                                            </td>

                                            <td class="normal-wrap">
                                                <a  href="{{route('sequential-codes.edit', $seq_code->id)}}" title="{{trans('applang.edit')}}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
{{--                                                @if($seq_code->id != 1)
                                                    <a href="#"
                                                       title="{{trans('applang.delete')}}"
                                                       class="text-danger mr-1 ml-1"
                                                       data-toggle="modal"
                                                       data-target="#formModalDeleteSeqCode"
                                                       data-seq_code_id="{{$seq_code->id}}"
                                                       data-prefix="{{$seq_code->prefix}}"
                                                       data-model="{{$seq_code->model}}"
                                                    >
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                @endif--}}
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

{{--    <!-- users Modals -->--}}
{{--    @include('erp.settings.sequential-codes.modals')--}}

@endsection
<!-- END: Content-->

@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
@endsection

@section('page-js')
    {{-- <script src="{{asset('app-assets')}}/js/scripts/pages/app-users.js"></script> --}}
    <script src="{{asset('app-assets')}}/js/scripts/datatables/datatable-filters.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/modal/components-modal.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>

    <!--Datatables js-->
    <script src="{{asset('app-assets/cdns/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/cdns/js/datatables/dataTables.responsive.min.js')}}"></script>
{{--    <script src="{{asset('app-assets/cdns/js/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/cdns/js/datatables/buttons.flash.min.js')}}"></script>
    <script src="{{asset('app-assets/cdns/js/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('app-assets/cdns/js/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('app-assets/cdns/js/datatables/buttons.colVis.min.js')}}"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    --}}{{-- <script src="{{asset('app-assets/cdns/js/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('app-assets/cdns/js/datatables/vfs_fonts.js')}}"></script> --}}{{--
    <script src="{{asset('app-assets/cdns/js/datatables/jszip.min.js')}}"></script>--}}

    @if (app()->getLocale() == 'ar')
        <script src="{{asset("app-assets/js/scripts/datatables/datatable-rtl.js")}}"></script>
    @else
        <script src="{{asset("app-assets/js/scripts/datatables/datatable.js")}}"></script>
    @endif

    <script type="text/javascript">
        $(document).ready(function () {
            $('#formModalDeleteSeqCode').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var seq_code_id = button.data('seq_code_id')
                var prefix = button.data('prefix')
                var model = button.data('model')
                var modal = $(this)
                modal.find('.modal-body #seq_code_id').val(seq_code_id)
                modal.find('.modal-body #prefix').val(prefix)
                modal.find('.modal-body #model').val(model)
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


