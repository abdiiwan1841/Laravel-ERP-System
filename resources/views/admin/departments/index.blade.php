@extends('layouts.admin.admin_layout')
@section('title', trans('applang.departments'))

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/pickers/pickadate/pickadate.css">
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
                    <a href="{{route('perm_categories.create')}}" class="btn btn-success mb-0">
                        <i class="bx bx-user-plus"></i> {{trans('applang.add')}}
                    </a>
                    <button type="button"
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
                    </button>
                </div>
                <div class="card-body pt-1">
                    <!-- datatable start -->
                    <div class="table-responsive">
                        <table id="default-app-datatable" class="stripe hover bordered datatable datatable-user" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="sorting_desc_disabled sorting_asc_disabled select_all no-wrap">
                                        <fieldset>
                                            {{-- <div class="checkbox checkbox-sm checkbox-glow checkbox-danger"> --}}
                                                <input type="checkbox" name="selectAllcheckbox" id="selectAllcheckbox" class="selectAllcheckbox">
                                                <label for="selectAllcheckbox"></label>
                                            {{-- </div> --}}
                                        </fieldset>
                                    </th>
                                    <th class="pl-10 no-wrap">{{trans('applang.id')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.name')}}</th>
                                    <th class="pl-10 no-wrap">{{trans('applang.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                              @if ($categories->count() > 0)
                                    @foreach ($categories as $category)
                                        <tr id="selected_row_{{$category->id}}">
                                            <td class="select_all normal-wrap">
                                                <fieldset>
                                                    {{-- <div class="checkbox checkbox-sm checkbox-glow checkbox-danger"> --}}
                                                        <input type="checkbox"
                                                                 name="itemId"
                                                                 id="{{$category->id}}"
                                                                 value="{{$category->id}}"
                                                                 class="selectItemCheckbox">
                                                        <label for="{{$category->id}}"></label>
                                                    {{-- </div> --}}
                                                </fieldset>
                                            </td>
                                            <td class="normal-wrap">{{$category->id}}</td>
                                            <td class="normal-wrap w-50">
                                                {{app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en}}
                                            </td>
                                            <td class="normal-wrap">
                                                <a  href="{{route('perm_categories.edit', $category->id)}}" title="{{trans('applang.edit')}}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>

                                                <a href="#"
                                                    title="{{trans('applang.delete')}}"
                                                    class="text-danger mr-1 ml-1"
                                                    data-toggle="modal"
                                                    data-target="#formModalDeletePermissionCategory"
                                                    data-category_id="{{$category->id}}"
                                                    data-name_ar="{{$category->name_ar}}"
                                                    data-name_en="{{$category->name_en}}"
                                                    >
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

<!-- users Modals -->
@include('admin.departments.modals')

@endsection
<!-- END: Content-->

@section('page-vendor-js')
<script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/forms/select/select2.full.min.js"></script>
@endsection

@section('page-js')
{{-- <script src="{{asset('app-assets')}}/js/scripts/pages/app-users.js"></script> --}}
<script src="{{asset('app-assets')}}/js/scripts/datatables/datatable-filters.js"></script>
<script src="{{asset('app-assets')}}/js/scripts/modal/components-modal.js"></script>
<script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/pickers/pickadate/picker.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/pickers/pickadate/picker.date.js"></script>
<script>
    // Basic date
    $('.pickadate').pickadate();
</script>
<!--Datatables js-->
<script src="{{asset('app-assets/cdns/js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.flash.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.colVis.min.js')}}"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
{{-- <script src="{{asset('app-assets/cdns/js/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/vfs_fonts.js')}}"></script> --}}
<script src="{{asset('app-assets/cdns/js/datatables/jszip.min.js')}}"></script>
@if (app()->getLocale() == 'ar')
    <script src="{{asset("app-assets/js/scripts/datatables/datatable-rtl.js")}}"></script>
@else
    <script src="{{asset("app-assets/js/scripts/datatables/datatable.js")}}"></script>
@endif

<script type="text/javascript">
    $(document).ready(function () {
        $('#formModalDeletePermissionCategory').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var category_id = button.data('category_id')
            var name_ar = button.data('name_ar')
            var name_en = button.data('name_en')
            var modal = $(this)
            modal.find('.modal-body #category_id').val(category_id)
            modal.find('.modal-body #name_ar').val(name_ar)
            modal.find('.modal-body #name_en').val(name_en)
        });
    })

    $(function(e){
        var allTableIds = [];
        var allIds = [];

        //click select all button
        $('#selectAllRecords').click(function() {
            var all = $("input#selectAllcheckbox")[0];
            all.checked = true;
            var checked = all.checked;
            var table = $('#default-app-datatable').dataTable();
            $("input.selectItemCheckbox", table.fnGetNodes()).each(function () {
                $(this).prop("checked", checked);
                $(this).closest("tr").addClass("table-secondary");
                allTableIds.push($(this).val());
            });
            // allTableIds = jQuery.grep(allTableIds, function(value) {
            //     return value != {{auth()->user()->id}};
            // });
            console.log(allTableIds);
            allIds = allTableIds;
            $('#deleteAllSelectedRecords').removeClass('disabled');
            $('#deleteAllSelectedRecords').attr("disabled",false);
            $('#deselectAllSelectedRecords').removeClass('disabled');
            $('#deselectAllSelectedRecords').attr("disabled",false);
        });

        //click select all checkbox
        $('#selectAllcheckbox').click(function(){
            //check or uncheck all checkboxes of the tabel
            $('.selectItemCheckbox').prop('checked', $(this).prop('checked'));

            //get all table rows ids
            var table = $('#default-app-datatable').DataTable();
            var checked = this.checked;
            table.column(0).nodes().to$().each(function(index) {
                if (checked) {
                    $(this).find('input:checkbox[name=itemId]').prop('checked', true);
                    $(this).find('input:checkbox[name=itemId]').prop('checked', true).closest("tr").addClass("table-secondary");
                    allTableIds.push($(this).find('input:checkbox[name=itemId]').prop('checked', true).val());
                }else{
                    $(this).find('input:checkbox[name=itemId]').removeProp('checked');
                    $(this).find('input:checkbox[name=itemId]').prop('checked', false).closest("tr").removeClass("table-secondary");
                }
            });

            if ($('#selectAllcheckbox').prop('checked') == true) {
                $('#deleteAllSelectedRecords').removeClass('disabled');
                $('#deleteAllSelectedRecords').attr("disabled",false);
                allIds = allTableIds

                $('#deselectAllSelectedRecords').removeClass('disabled');
                $('#deselectAllSelectedRecords').attr("disabled",false);
            } else {
                allTableIds = [];
                $('#deleteAllSelectedRecords').addClass('disabled');
                $('#deleteAllSelectedRecords').attr("disabled",true);
                $("input:checkbox[name=itemId]").closest("tr").removeClass("table-secondary");

                $('#deselectAllSelectedRecords').addClass('disabled');
                $('#deselectAllSelectedRecords').attr("disabled",true);
            }

        });

        //check single row or uncheck single row after checking all table rows
        $("#default-app-datatable tbody").on('click', "input:checkbox[name=itemId]", function(e){
            if($(this).prop("checked") == true || $("input:checkbox:checked").length > 1){
                $(this).closest("tr").toggleClass("table-secondary");
                $('#deleteAllSelectedRecords').removeClass('disabled');
                $('#deleteAllSelectedRecords').attr("disabled",false);

                $('#deselectAllSelectedRecords').removeClass('disabled');
                $('#deselectAllSelectedRecords').attr("disabled",false);
            }else {
                $(this).closest("tr").toggleClass("table-secondary");
                $('#deleteAllSelectedRecords').addClass('disabled');
                $('#deleteAllSelectedRecords').attr("disabled",true);

                $('#deselectAllSelectedRecords').addClass('disabled');
                $('#deselectAllSelectedRecords').attr("disabled",true);
            }
        });


        //delete selected rows
        $('#deleteAllSelectedRecords').click(function(e){
            var selectedSingleRowsIds = []
            var table = $('#default-app-datatable').dataTable();
            //if select all table rows and then ucheck specific rows get the id of only checked
            if ($('#selectAllcheckbox').prop('checked') == true) {
                // allTableIds = jQuery.grep(allTableIds, function(value) {
                //     return value != {{auth()->user()->id}};
                // });
                allIds = allTableIds
                if($("input:checkbox:not(:checked)")){
                    $("input:checkbox:not(:checked)", table.fnGetNodes()).each(function(){
                        allTableIds.pop($(this).val())
                    });
                }
            } else {
                //if select single rows from the begining get its ids
                allTableIds = [];
                $("input:checkbox[name=itemId]:checked", table.fnGetNodes()).each(function(){
                    selectedSingleRowsIds.push($(this).val());
                    allIds = selectedSingleRowsIds
                });
            }

            console.log(allIds);

            var totalRecords = allIds.length;

            Swal.fire({
                title: '{{trans("applang.swal_confirm")}}',
                text: "{{trans('applang.swal_confirm_txt1')}} " + totalRecords +  " {{trans('applang.swal_confirm_txt2')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{trans("applang.swal_confirm_btn")}}',
                cancelButtonText: '{{trans("applang.swal_cancel_btn")}}',
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url:"{{route('deleteSelectedPermissionsCategoies')}}",
                        type:"DELETE",
                        data:{
                            _token:$("input[name=_token]").val(),
                            ids:allIds
                        },
                        success:function(response){
                            $.each(allIds,function(key,val){
                                $("#selected_row_"+val).remove();
                            });
                            Swal.fire(
                                '{{trans("applang.swal_deleted")}}',
                                '{{trans("applang.swal_delete_success")}}',
                                'success'
                            );
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel || result.dismiss === Swal.DismissReason.backdrop){
                    Swal.fire(
                        '{{trans("applang.swal_canceled")}}!',
                        '{{trans("applang.swal_cancel_confirm")}}',
                        'error'
                    )
                    allTableIds = [];
                    selectedSingleRowsIds = [];
                    allIds = [];
                    $('.selectAllcheckbox').prop('checked', false);
                    $('#deleteAllSelectedRecords').addClass('disabled');
                    $('#deleteAllSelectedRecords').attr("disabled",true);
                    $('#deselectAllSelectedRecords').addClass('disabled');
                    $('#deselectAllSelectedRecords').attr("disabled",true);
                    var table = $('#default-app-datatable').DataTable();
                    var checked = this.checked;
                    table.column(0).nodes().to$().each(function(index) {
                        if (! checked) {
                            $(this).find('input:checkbox[name=itemId]').removeProp('checked');
                            $(this).find('input:checkbox[name=itemId]').prop('checked', false).closest("tr").removeClass("table-secondary");
                        }
                    });
                }
            });
        });

        //deselect all selected records
        $("#deselectAllSelectedRecords").click(function(e) {
            allTableIds = [];
            selectedSingleRowsIds = [];
            allIds = [];
            var table = $('#default-app-datatable').dataTable();
            if ($('#selectAllcheckbox').prop('checked') == true) {
                $("input:checkbox[name=itemId]:checked", table.fnGetNodes()).each(function(){
                        $(this).removeProp('checked');
                        $(this).prop('checked', false).closest("tr").removeClass("table-secondary");
                        $('#selectAllcheckbox').prop('checked', false);
                });
            } else {
                $("input:checkbox[name=itemId]:checked", table.fnGetNodes()).each(function(){
                    $(this).removeProp('checked');
                    $(this).prop('checked', false).closest("tr").removeClass("table-secondary");
                });
            }
            $('#deleteAllSelectedRecords').addClass('disabled');
            $('#deleteAllSelectedRecords').attr("disabled",true);
            $('#deselectAllSelectedRecords').addClass('disabled');
            $('#deselectAllSelectedRecords').attr("disabled",true);
        });

    });

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

