/*=========================================================================================
	File Name: toastr.js
	Description: Toastr notifications
	----------------------------------------------------------------------------------------
	Item Name: Frest HTML Admin Template
	Version: 1.0
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  var isRtl = $('html').attr('data-textdirection') === 'rtl',
    typeSuccess = $('#type-success'),
    typeInfo = $('#type-info'),
    typeWarning = $('#type-warning'),
    typeError = $('#type-error'),
    positionTopLeft = $('#position-top-left'),
    positionTopCenter = $('#position-top-center'),
    positionTopRight = $('#position-top-right'),
    positionTopFull = $('#position-top-full'),
    positionBottomLeft = $('#position-bottom-left'),
    positionBottomCenter = $('#position-bottom-center'),
    positionBottomRight = $('#position-bottom-right'),
    positionBottomFull = $('#position-bottom-full'),
    textNotification = $('#text-notification'),
    closeButton = $('#close-button'),
    progressBar = $('#progress-bar'),
    clearToastBtn = $('#clear-toast-btn'),
    showRemoveToast = $('#show-remove-toast'),
    removeToast = $('#remove-toast'),
    showClearToast = $('#show-clear-toast'),
    clearToast = $('#clear-toast'),
    fastDuration = $('#fast-duration'),
    slowDuration = $('#slow-duration'),
    toastrTimeout = $('#timeout'),
    toastrSticky = $('#sticky'),
    slideToast = $('#slide-toast'),
    fadeToast = $('#fade-toast'),
    clearToastObj;

  // Success Type
  typeSuccess.on('click', function () {
    toastr['success']('Have fun storming the castle!', 'Miracle Max Says', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // Info Type
  typeInfo.on('click', function () {
    toastr['info']('We do have the Kapua suite available.', 'Turtle Bay Resort', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // Warning Type
  typeWarning.on('click', function () {
    toastr['warning']('My name is Inigo Montoya. You killed my father, prepare to die!', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // Error Type
  typeError.on('click', function () {
    toastr['error']('I do not think that word means what you think it means.', 'Inconceivable!', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // Position Top Left
  positionTopLeft.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Left!', {
      positionClass: 'toast-top-left',
      rtl: isRtl
    });
  });

  // Position Top Center
  positionTopCenter.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Center!', {
      positionClass: 'toast-top-center',
      rtl: isRtl
    });
  });

  // Position Top Right
  positionTopRight.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Right!', {
      positionClass: 'toast-top-right',
      rtl: isRtl
    });
  });

  // Position Top Full Width
  positionTopFull.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Full Width!', {
      positionClass: 'toast-top-full-width',
      rtl: isRtl
    });
  });

  // Position Bottom Left
  positionBottomLeft.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Left!', {
      positionClass: 'toast-bottom-left',
      rtl: isRtl
    });
  });

  // Position Bottom Center
  positionBottomCenter.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Center!', {
      positionClass: 'toast-bottom-center',
      rtl: isRtl
    });
  });

  // Position Bottom Right
  positionBottomRight.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Right!', {
      positionClass: 'toast-bottom-right',
      rtl: isRtl
    });
  });

  // Position Bottom Full Width
  positionBottomFull.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Full Width!', {
      positionClass: 'toast-bottom-full-width',
      rtl: isRtl
    });
  });

  // Text Notification
  textNotification.on('click', function () {
    toastr['info']('Have fun storming the castle!', 'Miracle Max Says',{
      rtl: isRtl
    });
  });

  // Close Button
  closeButton.on('click', function () {
      toastr['success']('Have fun storming the castle!', 'With Close Button', { closeButton: true, rtl: isRtl });
  });

  // Progress Bar
  progressBar.on('click', function () {
    toastr['success']('Have fun storming the castle!', 'Progress Bar', {
      closeButton: true,
      tapToDismiss: false,
      progressBar: true,
      rtl: isRtl
    });
  });

  // Close Toast On Button Click
  clearToastBtn.on('click', function () {
    if (!clearToastObj) {
      clearToastObj = toastr['info'](
        'Clear itself?<br /><br /><button type="button" class="btn btn-primary clear">Yes</button>', 'Clear Toast Button',
        {
          closeButton: true,
          timeOut: 0,
          extendedTimeOut: 0,
          tapToDismiss: false,
          rtl: isRtl
        }
      );
    }

    if (clearToastObj.find('.clear').length) {
      clearToastObj.delegate('.clear', 'click', function () {
        toastr.clear(clearToastObj, { force: true });
        clearToastObj = undefined;
      });
    }
  });



  // Immediately remove current toasts without using animation
  showRemoveToast.on('click', function () {
    toastr.info('Have fun storming the castle!', 'Miracle Max Says',{
      rtl: isRtl
    });
  });

  removeToast.on('click', function () {
    toastr.remove();
  });

  // Remove current toasts using animation
  showClearToast.on('click', function () {
    toastr.info('Have fun storming the castle!', 'Miracle Max Says',{
      rtl: isRtl
    });
  });

  clearToast.on('click', function () {
    toastr.clear();
  });

  // Fast Duration
  fastDuration.on('click', function () {
    toastr['success']('Have fun storming the castle!', 'Fast Duration', { showDuration: 500, rtl: isRtl });
  });

  // Slow Duration
  slowDuration.on('click', function () {
    toastr['warning']('Have fun storming the castle!', 'Slow Duration', { hideDuration: 3000, rtl: isRtl });
  });

  // Timeout
  toastrTimeout.on('click', function () {
    toastr['error']('I do not think that word means what you think it means.', 'Timeout!', {
      timeOut: 5000,
      rtl: isRtl
    });
  });

  // Sticky
  toastrSticky.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Sticky!', { timeOut: 0, rtl: isRtl });
  });

  // Slide Down / Slide Up
  slideToast.on('click', function () {
    toastr['success']('I do not think that word means what you think it means.', 'Slide Down / Slide Up!', {
      showMethod: 'slideDown',
      hideMethod: 'slideUp',
      timeOut: 2000,
      rtl: isRtl
    });
  });

  // Fade In / Fade Out
  fadeToast.on('click', function () {
    toastr['success']('I do not think that word means what you think it means.', 'Slide Down / Slide Up!', {
      showMethod: 'fadeIn',
      hideMethod: 'fadeOut',
      timeOut: 2000,
      rtl: isRtl
    });
  });
});
