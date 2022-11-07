@extends('layouts.admin.admin_layout')
@section('title', trans('applang.suppliers'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/pages/app-users.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
    <!--Datatables css-->
    <link rel="stylesheet" href="{{asset('app-assets/cdns/css/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.dataTables.min.css">
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
                        <a href="{{route('suppliers.create')}}" class="btn btn-success">
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
                                    <th style="width:20px" class="sorting_desc_disabled sorting_asc_disabled select_all no-wrap">
                                        <fieldset>
                                            {{-- <div class="checkbox checkbox-sm checkbox-glow checkbox-danger"> --}}
                                            <input type="checkbox" name="selectAllcheckbox" id="selectAllcheckbox" class="selectAllcheckbox">
                                            <label for="selectAllcheckbox"></label>
                                            {{-- </div> --}}
                                        </fieldset>
                                    </th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.code')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.commercial_name')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.name')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.country')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.status')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.created_by')}}</th>
                                    <th class="pl-10 no-wrap ">{{trans('applang.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($suppliers->count())
                                    @foreach ($suppliers as $supplier)
                                        <tr id="selected_row_{{$supplier->id}}">
                                            <td style="width:20px" class="select_all normal-wrap middle-align">
                                                <fieldset>
                                                    <input type="checkbox"
                                                           name="itemId"
                                                           id="{{$supplier->id}}"
                                                           value="{{$supplier->id}}"
                                                           class="selectItemCheckbox">
                                                    <label for="{{$supplier->id}}"></label>
                                                </fieldset>
                                            </td>
                                            <td class="no-wrap middle-align">{{$supplier->full_code}}</td>
                                            <td class="no-wrap middle-align"><a href="{{route('suppliers.show', $supplier)}}">{{$supplier->commercial_name}}</a></td>
                                            <td class="no-wrap middle-align">{{$supplier->first_name}} {{$supplier->last_name}}</td>
                                            <td class="no-wrap middle-align">
                                                @foreach($countries as $key => $country)
                                                    @if($supplier->country == $key)
                                                        {{app()->getLocale() == 'ar' ? $country['name'] : $country['en_name']}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="no-wrap middle-align">
                                                @if($supplier->status == 1)
                                                    <span class="badge badge-light-success">{{trans('applang.active')}}</span>
                                                @else
                                                    <span class="badge badge-light-danger"> {{trans('applang.suspended')}}</span>
                                                @endif
                                            </td>
                                            <td class="no-wrap middle-align">{{$supplier->created_by}}</td>

                                            <td class="no-wrap middle-align" style="width: 10%">
                                                <a  href="{{route('suppliers.edit', $supplier)}}" title="{{trans('applang.edit')}}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>

                                                <a href="{{route('suppliers.show', $supplier)}}" title="{{trans('applang.show')}}" class="mr-1 ml-1">
                                                    <i class="bx bx-show-alt"></i>
                                                </a>

                                                <a href="#"
                                                   title="{{trans('applang.delete')}}"
                                                   class="text-danger"
                                                   data-toggle="modal"
                                                   data-target="#formModalDeleteSupplier"
                                                   data-supplier_id="{{$supplier->id}}"
                                                   data-name="{{$supplier->first_name}} {{$supplier->last_name}}">
                                                    <i class="bx bx-trash" ></i>
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

    <!-- suppliers Modals -->
    @include('erp.purchases.suppliers.modals')

@endsection
<!-- END: Content-->

@section('page-vendor-js')
    <script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
@endsection

@section('page-js')
    <script src="{{asset('app-assets')}}/js/scripts/modal/components-modal.js"></script>
    <script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>

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
    <script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>

    @if (app()->getLocale() == 'ar')
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
                                    }else if(title === 'Status' || title === 'اﻟﺤﺎﻟﺔ') {
                                        $(cell).html('<select class="form-control default-datatable-status" ><option value="">{{trans('applang.any')}}</option><option value="{{trans('applang.active')}}">{{trans('applang.active')}}</option><option value="{{trans('applang.suspended')}}">{{trans('applang.suspended')}}</option></select>');
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
                                $(".default-datatable-status").val("");
                                $(".text_input").val("");

                                table.columns().search($(".default-datatable-status").val()).draw();
                                table.columns().search($(".text_input").val()).draw();
                            });
                        },
                    });
                }
            });
        </script>
    @else
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
                                    }else if(title === 'Status' || title === 'الحالة') {
                                        $(cell).html('<select class="form-control default-datatable-status" ><option value="">{{trans('applang.any')}}</option><option value="{{trans('applang.active')}}">{{trans('applang.active')}}</option><option value="{{trans('applang.suspended')}}">{{trans('applang.suspended')}}</option></select>');
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

                                $(".default-datatable-status").val("");
                                $(".text_input").val("");

                                table.columns().search($(".default-datatable-status").val()).draw();
                                table.columns().search($(".text_input").val()).draw();

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

    <!--Datatable pullk delete js-->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#formModalDeleteSupplier').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var supplier_id = button.data('supplier_id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #supplier_id').val(supplier_id)
                modal.find('.modal-body #name').val(name)
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
                            url:"{{route('deleteSelectedSuppliers')}}",
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

