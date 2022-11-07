/*- =========================================================================
File Name: bootstrap-toast.js
Description: This Page contains Icon toast and Progress bars.
--------------------------------------------------------------------------
  Item Name: Frest HTML Admin Template
Version: 1.0
Author: PIXINVENT
Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================*/

'use strict';

// Basic toast
$('.toast-basic-toggler').on('click', function () {
  $('.toast-basic').toast('show');
});
// Basic toast light
$('.toast-light-toggler').on('click', function () {
  $('.toast-light').toast('show');
});

// Auto Hide Off toast
$('.toast-autohide-toggler').on('click', function () {
  $('.toast-autohide').toast('show');
});

// Auto Hide Off toast
$('.toast-stacked-toggler').on('click', function () {
  $('.toast-stacked').toast('show');
});

// Placement toast
$('.placement').on('click', function () {
  $('.toast-placement .toast').toast('show');
});
