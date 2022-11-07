/*=========================================================================================
    File Name: popover.js
    Description: Popovers are an updated version, which don’t rely on images,
                use CSS3 for animations, and data-attributes for local title storage.
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
'use strict';
    $('[data-toggle="popover"]').popover();


    /******************/
    // Popover events //
    /******************/

    // onShow event
    $('#show-popover').popover({
        title: 'Show Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping.',
        trigger: 'click',
        placement: 'right'
        }).on('show.bs.popover', function() {
            alert('Show event fired.');
    });

    // onShown event
    $('#shown-popover').popover({
        title: 'Shown Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping.',
        trigger: 'click',
        placement: 'bottom'
    }).on('shown.bs.popover', function() {
        alert('Shown event fired.');
    });

    // onHide event
    $('#hide-popover').popover({
        title: 'Hide Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping.',
        trigger: 'click',
        placement: 'bottom'
    }).on('hide.bs.popover', function() {
        alert('Hide event fired.');
    });

    // onHidden event
    $('#hidden-popover').popover({
        title: 'Hidden Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping.',
        trigger: 'click',
        placement: 'left'
    }).on('hidden.bs.popover', function() {
        alert('Hidden event fired.');
    });

    /*******************/
    // Tooltip methods //
    /*******************/

    // Show method
    $('#show-method').on('click', function() {
        $(this).popover('show');
    });
    // Hide method
    $('#hide-method').on('mouseenter', function() {
        $(this).popover('show');
    });
    $('#hide-method').on('click', function() {
        $(this).popover('hide');
    });
    // Toggle method
    $('#toggle-method').on('click', function() {
        $(this).popover('toggle');
    });
    // Dispose method
    $('#dispose').on('click', function() {
        $('#dispose-method').popover('dispose');
    });


    /* Trigger*/
    $('.manual').on('click', function() {
        $(this).popover('show');
    });
    $('.manual').on('mouseout', function() {
        $(this).popover('hide');
    });

})(window, document, jQuery);
