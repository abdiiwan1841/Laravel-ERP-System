  /*=========================================================================================
    File Name: picker-date-time.js
    Description: Pick a date/time Picker, Date Range Picker JS
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
  'use strict';

  // ************************//
  // * Pick-a-date Picker *//
  // ************************//
  // Basic date
  $('.pickadate').pickadate();

  // Format Date Picker
  $('.format-picker').pickadate({
      format: 'mmmm, d, yyyy'
  });

  // Date limits
  $('.pickadate-limits').pickadate({
      min: [2019,7,20],
      max: [2019,7,28]
  });

  // Disabled Dates & Weeks

  $('.pickadate-disable').pickadate({
      disable: [
          1,
          [2019,6,6],
          [2019,6,20]
      ]
  });

  // Picker Translations
  $( '.pickadate-translations' ).pickadate({
      formatSubmit: 'dd/mm/yyyy',
      monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
      monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
      weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
      today: 'aujourd\'hui',
      clear: 'clair',
      close: 'Fermer'
  });

  // Month Select Picker
  $('.pickadate-months').pickadate({
      selectYears: false,
      selectMonths: true
  });

  // Month and Year Select Picker
  $('.pickadate-months-year').pickadate({
      selectYears: true,
      selectMonths: true
  });

  // Short String Date Picker
  $('.pickadate-short-string').pickadate({
      weekdaysShort: ['S', 'M', 'Tu', 'W', 'Th', 'F', 'S'],
      showMonthsShort: true
  });

  // Change first weekday
  $('.pickadate-firstday').pickadate({
      firstDay: 1
  });

  // Inline Date Picker
  $('.inlineDatePicker').pickadate({
    container : '#inlineDatePicker-container'
  });

  // ************************//
  // * Pick a Time Picker *//
  // ************************//
  // Basic time
  $('.pickatime').pickatime();

  // Format options
  $('.pickatime-format').pickatime({
      // Escape any “rule” characters with an exclamation mark (!).
      format: 'T!ime selected: h:i a',
      formatLabel: 'HH:i a',
      formatSubmit: 'HH:i',
      hiddenPrefix: 'prefix__',
      hiddenSuffix: '__suffix'
  });


  // Format options
  $('.pickatime-formatlabel').pickatime({
      formatLabel: function(time) {
          var hours = ( time.pick - this.get('now').pick ) / 60,
              label = hours < 0 ? ' !hours to now' : hours > 0 ? ' !hours from now' : 'now';
          return  'h:i a <sm!all>' + ( hours ? Math.abs(hours) : '' ) + label +'</sm!all>';
      }
  });

  // Min - Max Time to select
  $( '.pickatime-min-max').pickatime({

      // Using Javascript
      min: new Date(2015,3,20,7),
      max: new Date(2015,7,14,18,30)

      // Using Array
      // min: [7,30],
      // max: [14,0]
  });

  // Intervals
  $('.pickatime-intervals').pickatime({
      interval: 150
  });

  // Disable Time
  $('.pickatime-disable').pickatime({
      disable: [
      // Disable Using Integers
          3, 5, 7, 13, 17, 21

      /* Using Array */
          // [0,30],
          // [2,0],
          // [8,30],
          // [9,0]
      ]
  });

  // Close on a user action
  $('.pickatime-close-action').pickatime({
      closeOnSelect: false,
      closeOnClear: false
  });

  // ************************//
  // * Date Range Picker *//
  // ************************//

  // Basic Date Range Picker
  $('.daterange').daterangepicker();

  // Date & Time
  $('.datetime').daterangepicker({
    timePicker: true,
    timePickerIncrement: 30,
    locale: {
      format: 'MM/DD/YYYY h:mm A'
    }
  });

  // Single Date Picker
  $('.single-daterange').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');
    alert("You are " + years + " years old!");
  });

  // Date Ranges
  $('.dateranges').daterangepicker({
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  });

  // Date Ranges Initially Empty
  $('.initial-empty').daterangepicker({
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
  });

  $('.initial-empty').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  $('.initial-empty').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

  //Calendars are not linked
  $('.timeseconds').daterangepicker({
    timePicker: true,
    timePickerIncrement: 30,
    timePicker24Hour: true,
    timePickerSeconds: true,
    locale: {
      format: 'MM-DD-YYYY h:mm:ss'
    }
  });

  // Auto Apply Date Range
  $('.autoapply').daterangepicker({
    autoApply: true,
  });

  // Date Limit
  $('.dateLimit').daterangepicker({
    dateLimit: {
      days: 7
    },
  });

  // Show Dropdowns
  $('.showdropdowns').daterangepicker({
    showDropdowns: true,
    drops: "up"
  });

  // Show Week Numbers
  $('.showweeknumbers').daterangepicker({
    showWeekNumbers: true,
  });

  // Always Show Calendar on Ranges
  $('.showCalRanges').daterangepicker({
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    alwaysShowCalendars: true,
  });

  // Localization
  $('.localeRange').daterangepicker({
    ranges: {
      "Aujourd'hui": [moment(), moment()],
      'Hier': [moment().subtract('days', 1), moment().subtract('days', 1)],
      'Les 7 derniers jours': [moment().subtract('days', 6), moment()],
      'Les 30 derniers jours': [moment().subtract('days', 29), moment()],
      'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
      'le mois dernier': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
    },
    locale: {
      applyLabel: "Vers l'avant",
      cancelLabel: 'Annulation',
      startLabel: 'Date initiale',
      endLabel: 'Date limite',
      customRangeLabel: 'Sélectionner une date',
      // daysOfWeek: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi','Samedi'],
      daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
      monthNames: ['Janvier', 'février', 'Mars', 'Avril', 'Маi', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
      firstDay: 1
    }
  });

  // Date Range Alignment
  $('.openRight').daterangepicker({
    opens: "left" // left/right/center
  });

  // Date Range Open on Top
  $('.drops').daterangepicker({
    drops: "up" // up/down
  });

  // Change Buttons bg-color
  $('.buttonClass').daterangepicker({
    drops: "up",
    buttonClasses: "btn",
    applyClass: "btn-success",
    cancelClass: "btn-danger"
  });

  // Inline Date Picker
  var picker = $('.inlineDateRangePicker').daterangepicker({
    "parentEl": "#daterangepicker-container",
  });

  // To remain picker opened after date range applied
  picker.data('daterangepicker').hide = function () {};

  // show picker on load
  picker.data('daterangepicker').show();


})(window, document, jQuery);
