(function(window, undefined) {
  'use strict';

  /*
  NOTE:
  ------
  PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
  WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */

  //Prevent negative, plus, dots, commas, slash for phone inputs
  // Listen for input event on numInput.
  var phone = document.querySelector("input[name='phone']");
  if(phone){
      phone.onkeydown = function(e) {
          if(!((e.keyCode > 95 && e.keyCode < 106)
          || (e.keyCode > 47 && e.keyCode < 58)
          || e.keyCode == 8)) {
              return false;
          }
      }
  }


  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

})(window);


// // //Add active class to nav links based on page url
// jQuery(function($) {
//     var path = window.location.href
//     // because the 'href' property of the DOM element is the absolute path
//     $('aside ul a').each(function() {
//       if (this.href === path) {
//         $(this).parent("li").addClass("active");
//       }
//     });
//     $('nav ul a').each(function() {
//         if (this.href === path) {
//           $(this).parent("li").addClass("active");
//         }
//     });
// });



