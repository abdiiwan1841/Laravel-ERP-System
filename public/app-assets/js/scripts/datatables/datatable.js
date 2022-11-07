/*=========================================================================================
    File Name: datatables-basic.js
    Description: Basic Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    /****************************************
    *       js of zero configuration        *
    ****************************************/

    $('.zero-configuration').DataTable();

    /********************************************
     *        js of Order by the grouping        *
     ********************************************/

    var groupingTable = $('.row-grouping').DataTable({
        "columnDefs": [{
            "visible": false,
            "targets": 2
        }],
        "order": [
            [2, 'asc']
        ],
        "displayLength": 10,
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;

            api.column(2, {
                page: 'current'
            }).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        }
    });

    $('.row-grouping tbody').on('click', 'tr.group', function() {
        var currentOrder = groupingTable.order()[0];
        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            groupingTable.order([2, 'desc']).draw();
        }
        else {
            groupingTable.order([2, 'asc']).draw();
        }
    });

    /*************************************
    *       js of complex headers        *
    *************************************/

    $('.complex-headers').DataTable();


    /*****************************
    *       js of Add Row        *
    ******************************/

    var t = $('.add-rows').DataTable();
    var counter = 2;

    $('#addRow').on( 'click', function () {
        t.row.add( [
            counter +'.1',
            counter +'.2',
            counter +'.3',
            counter +'.4',
            counter +'.5'
        ] ).draw( false );

        counter++;
    });


    /**************************************************************
    * js of Tab for COLUMN SELECTORS WITH EXPORT AND PRINT OPTIONS *
    ***************************************************************/

    $('.dataex-html5-selectors').DataTable( {
        columnDefs: [
            {
                orderable: false,
                searchable: false,
                targets: 0
            },
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                text: 'JSON',
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();

                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });

    /**************************************************
    *       js of scroll horizontal & vertical        *
    **************************************************/

    $('.scroll-horizontal-vertical').DataTable( {
        "scrollY": 200,
        "scrollX": true
    });


    /**************************************************
    *           js of default app datatable           *
    **************************************************/
    $("#default-app-datatable").dataTable().fnDestroy();
    loadTable();
    function loadTable() {
        $('#default-app-datatable').DataTable({
            lengthChange: true,
            responsive: true,
            // columnDefs: [{
            //     orderable: false,
            //     targets: 0
            // }],
            dom: 'lfrtip',
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
                {
                    extend: 'colvis',
                    className: 'custom-button show_clmns_btn',
                    text: "show <i class='fas fa-sort-down show_clmns'></i>",
                    exportOptions: {
                      columns: ':visible'
                    }
                },
            ],
            language:{
                "searchPlaceholder": "  search...  "
            }
        });

    }

});
