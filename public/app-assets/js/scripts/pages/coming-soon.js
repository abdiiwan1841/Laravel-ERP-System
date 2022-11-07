/*=========================================================================================
    File Name: page-coming-soon.js
    Description: Coming Soon
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

/*******************************
*       js of Countdown        *
********************************/

$(document).ready(function() {

    var remainingTime = new Date()
    remainingTime.setDate(remainingTime.getDate() + 60)


    $('#clockFlat').countdown(remainingTime).on('update.countdown', function(event) {
      var $this = $(this).html(event.strftime(''
        + '<div class="clockCard px-1"> <span>%D</span> <br> <p class="bg-amber clockFormat lead px-1 black"> Day%!D </p> </div>'
        + '<div class="clockCard px-1"> <span>%H</span> <br> <p class="bg-amber clockFormat lead px-1 black"> Hour%!H </p> </div>'
        + '<div class="clockCard px-1"> <span>%M</span> <br> <p class="bg-amber clockFormat lead px-1 black"> Minute%!M </p> </div>'
        + '<div class="clockCard px-1"> <span>%S</span> <br> <p class="bg-amber clockFormat lead px-1 black"> Second%!S </p> </div>'))
    });


});
