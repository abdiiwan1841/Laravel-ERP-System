form = $('.validate-form'),/*=========================================================================================
    File Name: page-account-settings.js
    Description: page user account settings
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function (window, document, $) {
  'use strict';
  var form = $('.validate-form');
    // language select
    var languageselect = $("#languageselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // music select
    var musicselect = $("#musicselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // movies select
    var moviesselect = $("#moviesselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // birthdate date
    $('.birthdate-picker').pickadate({
        format: 'mmmm, d, yyyy'
    });
    // Input, Select, Textarea validations except submit button
  // jQuery Validation
  // --------------------------------------------------------------------
  if (form.length) {
    form.each(function () {
      var $this = $(this);

      $this.validate({
        rules: {
          username: {
            required: true
          },
          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          password: {
            required: true
          },
          company: {
            required: true
          },
          'new-password': {
            required: true,
            minlength: 6
          },
          'confirm-new-password': {
            required: true,
            minlength: 6,
            equalTo: '#account-new-password'
          },
          dob: {
            required: true
          },
          phone: {
            required: true
          },
          website: {
            required: true
          }
        }
      });
      $this.on('submit', function (e) {
        e.preventDefault();
      });
    });
  }
})(window, document, jQuery);
