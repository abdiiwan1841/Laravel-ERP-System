@extends('layouts.admin.admin_layout')
@section('title', trans('applang.users'))

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
{{-- <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/pickers/pickadate/pickadate.css"> --}}
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/app-users.css">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
<!--Datatables css-->
{{--<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">--}}
<link rel="stylesheet" href="{{asset('app-assets/cdns/css/datatables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" href="{{asset('app-assets/cdns/css/datatables/responsive.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('app-assets/cdns/css/datatables/buttons.dataTables.min.css')}}">

<link rel="stylesheet" href="{{asset('app-assets/datepicker/css/bootstrap-datepicker3.standalone.min.css')}}">
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">--}}
@endsection

@section('content')
<div class="content-body">
    <!-- users list start -->
    <section class="users-list-wrapper">
        <div class="default-app-list-table">
            <div class="card">
                <div class="card-header justify-content-start">
                    <a href="{{route('users.create')}}" class="btn btn-success">
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
                    <!-- datatable flters -->
                    {{-- <div class="datatable-list-filter">
                        <form>
                            <div class="row mb-2">
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="default-datatable-userCreateDate">{{trans('applang.creation_date')}}</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input id="default-datatable-userCreateDate" type="text" class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}}" placeholder="{{trans('applang.select_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
                                        <div class="form-control-position">
                                            <i class='bx bx-calendar'></i>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="default-datatable-role">{{trans('applang.roles')}}</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="default-datatable-role">
                                            <option value="">{{trans('applang.any')}}</option>
                                            @if(request()->is(app()->getLocale().'/admin/users/role*'))
                                                @foreach ($roles as $role)
                                                    <option value="{{transRoleName($role->id)}}" {{transRoleName($role->id) == $roleQuery ? 'selected' : ''}}
                                                        >
                                                        {{transRoleName($role->id)}}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($roles as $role)
                                                    <option value="{{transRoleName($role->id)}}">{{transRoleName($role->id)}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="default-datatable-status">{{trans('applang.status')}}</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="default-datatable-status">
                                            <option value="">{{trans('applang.any')}}</option>
                                            <option value="{{app()->getLocale() == 'ar' ? 'مفعل' : 'Active'}}">{{trans('applang.active')}}</option>
                                            <option value="{{app()->getLocale() == 'ar' ? 'مغلق' : 'Close'}}">{{trans('applang.close')}}</option>
                                            <option value="{{app()->getLocale() == 'ar' ? 'محظور' : 'Banned'}}">{{trans('applang.banned')}}</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                                    <button type="reset" class="btn btn-primary btn-block glow default-datatable-clear mb-0">{{trans('applang.reset')}}</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                    <!-- datatable start -->
                    <div class="table-responsive">
                        <table id="default-app-datatable" class="stripe hover bordered datatable datatable-user" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width:20px" class="sorting_desc_disabled sorting_asc_disabled select_all no-wrap">
                                        <fieldset>
                                            {{-- <div class="checkbox checkbox-sm checkbox-glow checkbox-danger"> --}}
                                                <input type="checkbox" name="selectAllcheckbox" id="selectAllcheckbox" class="selectAllcheckbox">
                                                <label for="selectAllcheckbox"></label>
                                            {{-- </div> --}}
                                        </fieldset>
                                    </th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.code')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.name')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.created_at')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.phone')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.roles')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.department')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.status')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                              @if ($users->count())
                                    @foreach ($users as $user)
                                        <tr id="selected_row_{{$user->id}}">
                                            <td style="width:20px" class="select_all normal-wrap middle-align">
                                                <fieldset>
                                                    {{-- <div class="checkbox checkbox-sm checkbox-glow checkbox-danger"> --}}
                                                        <input type="checkbox"
                                                                 name="itemId"
                                                                 id="{{$user->id}}"
                                                                 value="{{$user->id}}"
                                                                 class="selectItemCheckbox"
                                                                 {{auth()->user()->id == $user->id ? "disabled" : ""}}>
                                                        <label for="{{$user->id}}"></label>
                                                    {{-- </div> --}}
                                                </fieldset>
                                            </td>
                                            <td class="no-wrap middle-align">{{$user->full_code}}</td>
                                            <td class="no-wrap middle-align"><a href="{{route('users.show', $user->id)}}">{{$user->first_name}} {{$user->last_name}}</a></td>
                                            <td class="no-wrap middle-align">{{dateHelper($user->created_at)}}</td>
                                            <td class="no-wrap middle-align">{{$user->phone}}</td>
                                            <td class="normal-wrap middle-align">
                                                @if (Spatie\Permission\Models\Role::count() > 0 && userRolesIds($user->id)->count() > 0)
                                                    {!! "<span class='badge badge-light-primary mr-1 badge-lower'>"
                                                    .implode('</span><span class="badge badge-light-primary mr-1 badge-lower">', userRolesName($user->id))
                                                    ."</span>"!!}
                                                @else
                                                    <span>{{trans('applang.not_found')}}</span>
                                                @endif
                                            </td>
                                            <td class="normal-wrap middle-align">
                                                {{app()->getLocale() == 'ar' ? $user->department->name_ar : $user->department->name_en}}
                                            </td>
                                            <td class="no-wrap middle-align">
                                                @if ($user->status == 1)
                                                    <span class="badge badge-light-success">{{trans('applang.active')}}</span>
                                                @elseif ($user->status == 2)
                                                    <span class="badge badge-light-warning">{{trans('applang.close')}}</span>
                                                @elseif ($user->status == 3)
                                                    <span class="badge badge-light-danger">{{trans('applang.banned')}}</span>
                                                @endif
                                            </td>
                                            <td class="no-wrap middle-align" style="width: 10%">
                                                <a  href="{{route('users.edit', $user)}}" title="{{trans('applang.edit')}}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>

                                                <a href="{{route('users.show', $user)}}" title="{{trans('applang.show')}}" class="mr-1 ml-1">
                                                    <i class="bx bx-show-alt"></i>
                                                </a>
                                                @if(auth()->user()->id != $user->id)
                                                    <a href="#"
                                                        title="{{trans('applang.delete')}}"
                                                        class="text-danger"
                                                        data-toggle="modal"
                                                        data-target="#formModalDeleteUser"
                                                        data-userid="{{$user->id}}"
                                                        data-full_name="{{$user->first_name}} {{$user->last_name}}"
                                                        >
                                                        <i class="bx bx-trash" ></i>
                                                    </a>
                                                @endif
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
@include('admin.users.modals')

@endsection
<!-- END: Content-->

@section('page-vendor-js')
<script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
{{-- <script src="{{asset('app-assets')}}/vendors/js/forms/select/select2.full.min.js"></script> --}}
@endsection

@section('page-js')
{{-- <script src="{{asset('app-assets')}}/js/scripts/pages/app-users.js"></script> --}}
<script src="{{asset('app-assets')}}/js/scripts/modal/components-modal.js"></script>
<script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>
{{-- <script src="{{asset('app-assets')}}/vendors/js/pickers/pickadate/picker.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/pickers/pickadate/picker.date.js"></script>
<script>
   // Basic date
   $('.pickadate').pickadate({
       format: 'yyyy-mm-dd',
       labelMonthNext: 'next month',
       labelMonthPrev: 'previous month',
       labelMonthSelect: 'Pick a month from the dropdown',
       labelYearSelect: 'Pick a year from the dropdown',
       selectMonths: true,
       selectYears: 60
   });

   $( '.pickadate_ar' ).pickadate({
       format: 'yyyy-mm-dd',
       monthsFull: [ 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر' ],
       weekdaysShort: [ 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت' ],
       today: 'اليوم',
       clear: 'مسح',
       close: 'إغلاق',
       labelMonthNext: 'الشهر التالى',
       labelMonthPrev: 'الشهر السابق',
       labelMonthSelect: 'إختر الشهر',
       labelYearSelect: 'إختر السنة',
       selectMonths: true,
       selectYears: 60
   })
</script> --}}

<!--Datatables js-->
<script src="{{asset('app-assets/cdns/js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.flash.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/buttons.colVis.min.js')}}"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
 <script src="{{asset('app-assets/cdns/js/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('app-assets/cdns/js/datatables/jszip.min.js')}}"></script>
{{-- <script src="{{asset('app-assets')}}/js/scripts/datatables/datatable-filters.js"></script> --}}
<script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>

@if (app()->getLocale() == 'ar')
    {{-- <script src="{{asset("app-assets/js/scripts/datatables/datatable-rtl.js")}}"></script> --}}
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#default-app-datatable thead tr th')
                .clone(true)
                .addClass('filters')
                .appendTo('#default-app-datatable thead');

            $("#default-app-datatable").dataTable().fnDestroy();
            loadTable();
            function loadTable() {
                $('#default-app-datatable').DataTable({
                    lengthChange: true,
                    responsive: true,
                    columnDefs: [{
                        orderable: false,
                        targets: 0
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            className: 'custom-button',
                            text: "<i class='far fa-copy'></i> نسخ",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'custom-button',
                            text: "<i class='fas fa-file-csv'></i> csv",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'custom-button',
                            text: "<i class='far fa-file-excel'></i> excel",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'custom-button',
                            text: "<i class='far fa-file-pdf'></i> pdf",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            className: 'custom-button',
                            text: "<i class='fas fa-print'></i> طباعة",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                    ],

                    language: {
                        "emptyTable": "ليست هناك بيانات متاحة في الجدول",
                        "loadingRecords": "جارٍ التحميل...",
                        "processing": "جارٍ التحميل...",
                        "lengthMenu": "أظهر _MENU_ مدخلات",
                        "zeroRecords": "لم يعثر على أية سجلات",
                        "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                        "infoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                        "infoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                        "search": "ابحث:",
                        "paginate": {
                            "first": "الأول",
                            "previous": "السابق",
                            "next": "التالي",
                            "last": "الأخير"
                        },
                        "aria": {
                            "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                            "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
                        },
                        "select": {
                            "rows": {
                                "_": "%d قيمة محددة",
                                "0": "",
                                "1": "1 قيمة محددة"
                            },
                            "1": "%d سطر محدد",
                            "_": "%d أسطر محددة",
                            "cells": {
                                "1": "1 خلية محددة",
                                "_": "%d خلايا محددة"
                            },
                            "columns": {
                                "1": "1 عمود محدد",
                                "_": "%d أعمدة محددة"
                            }
                        },
                        "buttons": {
                            "print": "طباعة",
                            "copyKeys": "زر <i>ctrl<\/i> أو <i>⌘<\/i> + <i>C<\/i> من الجدول<br>ليتم نسخها إلى الحافظة<br><br>للإلغاء اضغط على الرسالة أو اضغط على زر الخروج.",
                            "copySuccess": {
                                "_": "%d قيمة نسخت",
                                "1": "1 قيمة نسخت"
                            },
                            "pageLength": {
                                "-1": "اظهار الكل",
                                "_": "إظهار %d أسطر"
                            },
                            "collection": "مجموعة",
                            "copy": "نسخ",
                            "copyTitle": "نسخ إلى الحافظة",
                            "csv": "CSV",
                            "excel": "Excel",
                            "pdf": "PDF",
                            "colvis": "إظهار الأعمدة",
                            "colvisRestore": "إستعادة العرض"
                        },
                        "autoFill": {
                            "cancel": "إلغاء",
                            "info": "مثال عن الملئ التلقائي",
                            "fill": "املأ جميع الحقول بـ <i>%d&lt;\\\/i&gt;<\/i>",
                            "fillHorizontal": "تعبئة الحقول أفقيًا",
                            "fillVertical": "تعبئة الحقول عموديا"
                        },
                        "searchBuilder": {
                            "add": "اضافة شرط",
                            "clearAll": "ازالة الكل",
                            "condition": "الشرط",
                            "data": "المعلومة",
                            "logicAnd": "و",
                            "logicOr": "أو",
                            "title": [
                                "منشئ البحث"
                            ],
                            "value": "القيمة",
                            "conditions": {
                                "date": {
                                    "after": "بعد",
                                    "before": "قبل",
                                    "between": "بين",
                                    "empty": "فارغ",
                                    "equals": "تساوي",
                                    "not": "ليس",
                                    "notBetween": "ليست بين",
                                    "notEmpty": "ليست فارغة"
                                },
                                "moment": {
                                    "after": "بعد",
                                    "before": "قبل",
                                    "between": "بين",
                                    "empty": "فارغة",
                                    "equals": "تساوي",
                                    "not": "ليس",
                                    "notBetween": "ليست بين",
                                    "notEmpty": "ليست فارغة"
                                },
                                "number": {
                                    "between": "بين",
                                    "empty": "فارغة",
                                    "equals": "تساوي",
                                    "gt": "أكبر من",
                                    "gte": "أكبر وتساوي",
                                    "lt": "أقل من",
                                    "lte": "أقل وتساوي",
                                    "not": "ليست",
                                    "notBetween": "ليست بين",
                                    "notEmpty": "ليست فارغة"
                                },
                                "string": {
                                    "contains": "يحتوي",
                                    "empty": "فاغ",
                                    "endsWith": "ينتهي ب",
                                    "equals": "يساوي",
                                    "not": "ليست",
                                    "notEmpty": "ليست فارغة",
                                    "startsWith": " تبدأ بـ "
                                }
                            },
                            "button": {
                                "0": "فلاتر البحث",
                                "_": "فلاتر البحث (%d)"
                            },
                            "deleteTitle": "حذف فلاتر"
                        },
                        "searchPanes": {
                            "clearMessage": "ازالة الكل",
                            "collapse": {
                                "0": "بحث",
                                "_": "بحث (%d)"
                            },
                            "count": "عدد",
                            "countFiltered": "عدد المفلتر",
                            "loadMessage": "جارِ التحميل ...",
                            "title": "الفلاتر النشطة"
                        },
                        "searchPlaceholder": " بحث... "

                    },

                    orderCellsTop: true,
                    fixedHeader: true,
                    initComplete: function () {
                        var api = this.api();

                        // For each column
                        api
                            .columns()
                            .eq(0)
                            .each(function (colIdx) {
                                // Set the header cell to contain the input element
                                var cell = $('.filters').eq(
                                    $(api.column(colIdx).header()).index()
                                );
                                var title = $(cell).text();
                                if (title === 'Actions' || title === 'اﻟﻌﻤﻠﻴﺎﺕ') {
                                    $(cell).html('<button type="reset" class="btn btn-primary btn-block glow default-datatable-clear mb-0">{{trans('applang.reset')}}</button>');
                                }else if(title === 'Created At' || title === 'ﺗﺎﺭﻳﺦ اﻹﺿﺎﻓﺔ'){
                                    $(cell).html('<input type="text" class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}} default-datatable-created_date" placeholder="{{trans('applang.select_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">')
                                }else if(title === 'Status' || title === 'اﻟﺤﺎﻟﺔ') {
                                    $(cell).html('<select class="form-control default-datatable-status" ><option value="">{{trans('applang.any')}}</option><option value="{{app()->getLocale() == 'ar' ? 'مفعل' : 'Active'}}">{{trans('applang.active')}}</option><option value="{{app()->getLocale() == 'ar' ? 'مغلق' : 'Close'}}">{{trans('applang.close')}}</option><option value="{{app()->getLocale() == 'ar' ? 'محظور' : 'Banned'}}">{{trans('applang.banned')}}</option></select>');
                                }else if(title === 'Roles' || title === 'اﻷﺩﻭاﺭ') {
                                    $(cell).html('<select class="form-control default-datatable-role"><option value="">{{trans('applang.any')}}</option> <option value="{{trans('applang.not_found')}}">{{trans('applang.not_found')}}</option> @if(request()->is(app()->getLocale().'/admin/users/role*'))@foreach ($roles as $role)<option value="{{transRoleName($role->id)}}" {{transRoleName($role->id) == $roleQuery ? 'selected' : ''}}>{{transRoleName($role->id)}}</option>@endforeach @else @foreach ($roles as $role)<option value="{{transRoleName($role->id)}}">{{transRoleName($role->id)}}</option>@endforeach @endif</select>');
                                }else if(title === 'Department' || title === 'اﻟﻘﺴﻢ'){
                                    $(cell).html('<select class="form-control default-datatable-department"><option value="">{{trans('applang.any')}}</option> @foreach ($departments as $department)<option value="{{app()->getLocale() == 'ar' ? $department->name_ar : $department->name_en}}"> {{app()->getLocale() == 'ar' ? $department->name_ar : $department->name_en}} </option> @endforeach </select>');
                                }else {
                                    $(cell).html('<input class="form-control text_input" type="text" placeholder="' + title + '" />');
                                }
                                // On every keypress in this input
                                $(
                                    'input',
                                    $('.filters').eq($(api.column(colIdx).header()).index())
                                )
                                    .off('keyup change')
                                    .on('keyup change', function (e) {
                                        e.stopPropagation();

                                        // Get the search value
                                        $(this).attr('title', $(this).val());
                                        var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                        var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();

                                        $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                    });

                                $(
                                    'select',
                                    $('.filters').eq($(api.column(colIdx).header()).index())
                                )
                                    .off('change')
                                    .on('change', function (e) {
                                        e.stopPropagation();

                                        // Get the search value
                                        // $(this).attr('title', $(this).val());
                                        var regexr = '({search})';
                                        $(this).parents('th').find('select').val();

                                        // var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();

                                        $(this).focus()[0];
                                        // .setSelectionRange(cursorPosition, cursorPosition);
                                        // console.log(this.value)
                                    });

                                });

                        var table = $('#default-app-datatable').DataTable();
                        $(".default-datatable-clear").on('click', function (e) {

                            $(".default-datatable-role").val("");
                            $(".default-datatable-created_date").val("");
                            $(".default-datatable-department").val("");
                            $(".default-datatable-status").val("");
                            $(".text_input").val("");

                            table.columns().search($(".default-datatable-role").val()).draw();
                            table.columns().search($(".default-datatable-created_date").val()).draw();
                            table.columns().search($(".default-datatable-department").val()).draw();
                            table.columns().search($(".default-datatable-status").val()).draw();
                            table.columns().search($(".text_input").val()).draw();

                            $(".default-datatable-role option").removeAttr('selected');
                            $('.datepicker_ar').datepicker('clearDates');
                            $('.datepicker_en').datepicker('clearDates');
                        });

                        $('.datepicker_ar').datepicker({
                            format: "yyyy-mm-dd",
                            maxViewMode: 3,
                            todayBtn: "linked",
                            clearBtn: true,
                            orientation: "bottom auto",
                            autoclose: true,
                            todayHighlight: true,
                            language: "ar",
                        });

                        $('.datepicker_en').datepicker({
                            format: "yyyy-mm-dd",
                            maxViewMode: 3,
                            todayBtn: "linked",
                            clearBtn: true,
                            orientation: "bottom auto",
                            autoclose: true,
                            todayHighlight: true,
                        });
                    },
                });
            }
        });
    </script>
@else
    {{-- <script src="{{asset("app-assets/js/scripts/datatables/datatable.js")}}"></script> --}}
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#default-app-datatable thead tr th')
                .clone(true)
                .addClass('filters')
                .appendTo('#default-app-datatable thead');

            $("#default-app-datatable").dataTable().fnDestroy();
            loadTable();
            function loadTable() {
                $('#default-app-datatable').DataTable({
                    lengthChange: true,
                    responsive: true,
                    columnDefs: [{
                        orderable: false,
                        targets: 0
                    }],
                    dom: 'lBfrtip',
                    lengthMenu: [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                    ],
                    buttons: [
                        {
                            extend: 'copy',
                            className: 'custom-button',
                            text: "<i class='far fa-copy'></i> copy",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'custom-button',
                            text: "<i class='fas fa-file-csv'></i> csv",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'custom-button',
                            text: "<i class='far fa-file-excel'></i> excel",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'custom-button',
                            text: "<i class='far fa-file-pdf'></i> pdf",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            className: 'custom-button',
                            text: "<i class='fas fa-print'></i> print",
                            exportOptions: {
                            columns: ':visible'
                            }
                        },
                    ],
                    language:{
                        "searchPlaceholder": "  search...  "
                    },
                    orderCellsTop: true,
                    fixedHeader: true,
                    initComplete: function () {
                        var api = this.api();

                        // For each column
                        api
                            .columns()
                            .eq(0)
                            .each(function (colIdx) {
                                // Set the header cell to contain the input element
                                var cell = $('.filters').eq(
                                    $(api.column(colIdx).header()).index()
                                );
                                var title = $(cell).text();
                                if (title === 'Actions' || title === 'العمليات') {
                                    $(cell).html('<button type="reset" class="btn btn-primary btn-block glow default-datatable-clear mb-0">{{trans('applang.reset')}}</button>');
                                }else if(title === 'Created At' || title === 'تاريخ الإضافة'){
                                    $(cell).html('<input type="text" class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}} default-datatable-created_date" placeholder="{{trans('applang.select_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">')
                                }else if(title === 'Status' || title === 'الحالة') {
                                    $(cell).html('<select class="form-control default-datatable-status" ><option value="">{{trans('applang.any')}}</option><option value="{{app()->getLocale() == 'ar' ? 'مفعل' : 'Active'}}">{{trans('applang.active')}}</option><option value="{{app()->getLocale() == 'ar' ? 'مغلق' : 'Close'}}">{{trans('applang.close')}}</option><option value="{{app()->getLocale() == 'ar' ? 'محظور' : 'Banned'}}">{{trans('applang.banned')}}</option></select>');
                                }else if(title === 'Roles' || title === 'الأدوار') {
                                    $(cell).html('<select class="form-control default-datatable-role"><option value="">{{trans('applang.any')}}</option> <option value="{{trans('applang.not_found')}}">{{trans('applang.not_found')}}</option> @if(request()->is(app()->getLocale().'/admin/users/role*'))@foreach ($roles as $role)<option value="{{transRoleName($role->id)}}" {{transRoleName($role->id) == $roleQuery ? 'selected' : ''}}>{{transRoleName($role->id)}}</option>@endforeach @else @foreach ($roles as $role)<option value="{{transRoleName($role->id)}}">{{transRoleName($role->id)}}</option>@endforeach @endif</select>');
                                }else if(title === 'Department' || title === 'القسم'){
                                    $(cell).html('<select class="form-control default-datatable-department"><option value="">{{trans('applang.any')}}</option> @foreach ($departments as $department)<option value="{{app()->getLocale() == 'ar' ? $department->name_ar : $department->name_en}}"> {{app()->getLocale() == 'ar' ? $department->name_ar : $department->name_en}} </option> @endforeach </select>');
                                }else {
                                    $(cell).html('<input class="form-control text_input" type="text" placeholder="' + title + '" />');
                                }
                                // On every keypress in this input
                                $(
                                    'input',
                                    $('.filters').eq($(api.column(colIdx).header()).index())
                                )
                                    .off('keyup change')
                                    .on('keyup change', function (e) {
                                        e.stopPropagation();

                                        // Get the search value
                                        $(this).attr('title', $(this).val());
                                        var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                        var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();

                                        $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                    });

                                $(
                                    'select',
                                    $('.filters').eq($(api.column(colIdx).header()).index())
                                )
                                    .off('change')
                                    .on('change', function (e) {
                                        e.stopPropagation();

                                        // Get the search value
                                        // $(this).attr('title', $(this).val());
                                        var regexr = '({search})';
                                        $(this).parents('th').find('select').val();

                                        // var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();

                                        $(this).focus()[0];
                                        // .setSelectionRange(cursorPosition, cursorPosition);
                                        // console.log(this.value)
                                    });

                                });

                        var table = $('#default-app-datatable').DataTable();
                        $(".default-datatable-clear").on('click', function (e) {

                            $(".default-datatable-role").val("");
                            $(".default-datatable-created_date").val("");
                            $(".default-datatable-department").val("");
                            $(".default-datatable-status").val("");
                            $(".text_input").val("");

                            table.columns().search($(".default-datatable-role").val()).draw();
                            table.columns().search($(".default-datatable-created_date").val()).draw();
                            table.columns().search($(".default-datatable-department").val()).draw();
                            table.columns().search($(".default-datatable-status").val()).draw();
                            table.columns().search($(".text_input").val()).draw();

                            $(".default-datatable-role option").removeAttr('selected');
                            $('.datepicker_ar').datepicker('clearDates');
                            $('.datepicker_en').datepicker('clearDates');
                        });

                        $('.datepicker_ar').datepicker({
                            format: "yyyy-mm-dd",
                            maxViewMode: 3,
                            todayBtn: "linked",
                            clearBtn: true,
                            orientation: "bottom auto",
                            autoclose: true,
                            todayHighlight: true,
                            language: "ar",
                        });

                        $('.datepicker_en').datepicker({
                            format: "yyyy-mm-dd",
                            maxViewMode: 3,
                            todayBtn: "linked",
                            clearBtn: true,
                            orientation: "bottom auto",
                            autoclose: true,
                            todayHighlight: true,
                        });
                    },
                });
            }
        });
    </script>
@endif

<script>
    $(document).ready(function () {
        $( ".select_all.no-wrap.filters" ).append( "<i class='fas fa-filter dt-filter-icone'></i>" );
    });
</script>

<!--DatePicker js-->
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.ar.min.js" charset="UTF-8"></script>
<script>
    $('.datepicker_ar').datepicker({
        format: "yyyy-mm-dd",
        maxViewMode: 3,
        todayBtn: "linked",
        clearBtn: true,
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true,
        language: "ar",
    });

    $('.datepicker_en').datepicker({
        format: "yyyy-mm-dd",
        maxViewMode: 3,
        todayBtn: "linked",
        clearBtn: true,
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true,
    });
</script>

<!--Datatable pullk delete js-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#formModalDeleteUser').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var userid = button.data('userid')
            var full_name = button.data('full_name')
            var modal = $(this)
            modal.find('.modal-body #userid').val(userid)
            modal.find('.modal-body #full_name').val(full_name)
        });
    })

    $(function(e){

        //filter roles if request from roles index
        if($(".default-datatable-role")){
            var table = $('#default-app-datatable').DataTable();
            var usersRoleSelect = $(".default-datatable-role").val();
            if(usersRoleSelect != ''){
                console.log(usersRoleSelect);
                // table.columns([6]).search( usersRoleSelect ? '^'+usersRoleSelect+'$' : '', true, false).draw();
                table.columns([5]).search(usersRoleSelect).draw();
            }
        }

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
            allTableIds = jQuery.grep(allTableIds, function(value) {
                return value != {{auth()->user()->id}};
            });
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
                console.log(allIds);
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
                allTableIds = jQuery.grep(allTableIds, function(value) {
                    return value != {{auth()->user()->id}};
                });
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
                        url:"{{route('deleteSelectedUsers')}}",
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

