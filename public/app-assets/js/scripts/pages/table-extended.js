/*=========================================================================================
    File Name: table-extended.js
    Description: table extended js
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function (window, document, $) {

  var $primary = '#5A8DEE';
  var $danger = '#FF5B5C';
  var $warning = '#FDAC41';
  var $info = '#00CFDD';
  var $gray_light = '#828D99';

  // table extended transactions
  $('#table-extended-transactions').DataTable({
    "responsive": true,
    "searching": false,
    "lengthChange": false,
    "paging": false,
    "bInfo": false,
    "columnDefs": [
      { "orderable": false, "targets": 2 },
    ]
  }
  );
  // table extended success
  $('#table-extended-success').DataTable({
    "responsive": true,
    "searching": false,
    "lengthChange": false,
    "paging": false,
    "bInfo": false,
    "columnDefs": [
      { "orderable": false, "targets": [1, 2, 3, 4, 5] },
    ]
  }
  );

  // table extended checkbox
  var tablecheckbox = $('#table-extended-chechbox').DataTable({
    "searching": false,
    "lengthChange": false,
    "paging": false,
    "bInfo": false,
    'columnDefs': [
      { "orderable": false, "targets": [0, 3, 4] },   //to disable sortying in col 0,3 & 4
      {
        'targets': 0,
        'render': function (data, type, row, meta) {
          if (type === 'display') {
            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'; //body checkbox
          }
          return data;
        },
        'checkboxes': {
          'selectRow': true,
          'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" checked=""><label></label></div >'  //head checkbox
        }
      }],
    'select': 'multi',
    'order': [[1, 'asc']]
  });
  // Single Date Picker
  // -----------------
  $('.single-daterange').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1990,
    maxYear: parseInt(moment().format('YYYY'), 10)
  });

  // Table Donut Chart Statistics-1
  // ------------------------------
  var donustChartStatistics_1 = {
    chart: {
      width: 80,
      height: 100,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    series: [70, 30, 40],
    labels: ["Installation", "Page Views", "Active Users"],
    stroke: {
      width: 2
    },
    colors: [$warning, $info, $primary],
    plotOptions: {
      pie: {
        offsetY: 15,
        donut: {
          size: '70%',
        }
      }
    },
    legend: {
      show: false
    }
  }
  var donustChartStatistics_1 = new ApexCharts(
    document.querySelector("#table-donut-chart-1"),
    donustChartStatistics_1
  );
  donustChartStatistics_1.render();

  // Table Donut Chart Statistics-2
  // ------------------------------
  var donustChartStatistics_2 = {
    chart: {
      width: 80,
      height: 100,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    series: [70, 40, 30],
    labels: ["Installation", "Page Views", "Active Users"],
    stroke: {
      width: 2
    },
    colors: [$danger, $gray_light, $primary],
    plotOptions: {
      pie: {
        offsetY: 15,
        donut: {
          size: '70%',
        }
      }
    },
    legend: {
      show: false
    }
  }
  var donustChartStatistics_2 = new ApexCharts(
    document.querySelector("#table-donut-chart-2"),
    donustChartStatistics_2
  );
  donustChartStatistics_2.render();
})(window, document, jQuery);
