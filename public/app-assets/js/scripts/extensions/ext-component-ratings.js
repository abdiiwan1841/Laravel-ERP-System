/*=========================================================================================
    File Name: ext-component-ratings.js
    Description: extra components - ratings using RateYo! plugin
    --------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  var isRtl = $('html').attr('data-textdirection') === 'rtl',
    basicRatings = $('.basic-ratings'),
    readOnlyRatings = $('.read-only-ratings'),
    halfStar = $('.half-star-ratings'),
    fullStar = $('.full-star-ratings'),
    multiColor = $('.multi-color-ratings'),
    customSvg = $('.custom-svg-ratings'),
    onSetEvents = $('.onset-event-ratings'),
    onChangeEvents = $('.onChange-event-ratings'),
    ratingMethods = $('.methods-ratings'),
    initializeRatings = $('.btn-initialize'),
    destroyRatings = $('.btn-destroy'),
    getRatings = $('.btn-get-rating'),
    setRatings = $('.btn-set-rating');

  // Basic Ratings
  if (basicRatings.length) {
    basicRatings.rateYo({
      rating: 2.7,
      rtl: isRtl
    });
  }

  // Readonly Ratings
  if (readOnlyRatings.length) {
    readOnlyRatings.rateYo({
      rating: 2,
      rtl: isRtl
    });
  }

  // Half Star Ratings
  if (halfStar.length) {
    halfStar.rateYo({
      rating: 1.5,
      rtl: isRtl
    });
  }

  // Full Star Ratings
  if (fullStar.length) {
    fullStar.rateYo({
      rating: 3,
      rtl: isRtl
    });
  }

  // Multicolor Ratings
  if (multiColor.length) {
    multiColor.rateYo({
      rtl: isRtl,
      multiColor: {
        startColor: '#FF5B5C',
        endColor: '#5A8DEE'
      }
    });
  }

  // Custom SVG Ratings
  if (customSvg.length) {
    customSvg.rateYo({
      rating: 2.7,
      starSvg:
        "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>" +
        "<path d='M12 6.76l1.379 4.246h4.465l-3.612 2.625 1.379" +
        ' 4.246-3.611-2.625-3.612 2.625' +
        ' 1.379-4.246-3.612-2.625h4.465l1.38-4.246zm0-6.472l-2.833' +
        ' 8.718h-9.167l7.416 5.389-2.833 8.718 7.417-5.388' +
        ' 7.416 5.388-2.833-8.718' +
        " 7.417-5.389h-9.167l-2.833-8.718z'-></path>",
      rtl: isRtl
    });
  }

  // Rating Methods
  if (ratingMethods.length) {
    var $instance = ratingMethods.rateYo({
      rtl: isRtl
    });

    if (initializeRatings.length) {
      initializeRatings.on('click', function () {
        $instance.rateYo({
          rtl: isRtl
        });
      });
    }

    if (destroyRatings.length) {
      destroyRatings.on('click', function () {
        if ($instance.hasClass('jq-ry-container')) {
          $instance.rateYo('destroy');
        } else {
          window.alert('Please Initialize Ratings First');
        }
      });
    }

    if (getRatings.length) {
      getRatings.on('click', function () {
        if ($instance.hasClass('jq-ry-container')) {
          var rating = $instance.rateYo('rating');
          window.alert('Current Ratings are ' + rating);
        } else {
          window.alert('Please Initialize Ratings First');
        }
      });
    }

    if (setRatings.length) {
      setRatings.on('click', function () {
        if ($instance.hasClass('jq-ry-container')) {
          $instance.rateYo('rating', 1);
        } else {
          window.alert('Please Initialize Ratings First');
        }
      });
    }
  }

  // Rating onSet Event
  if (onSetEvents.length) {
    onSetEvents
      .rateYo({
        rtl: isRtl
      })
      .on('rateyo.set', function (e, data) {
        alert('The rating is set to ' + data.rating + '!');
      });
  }

  // Rating onChange Event
  if (onChangeEvents.length) {
    onChangeEvents
      .rateYo({
        rtl: isRtl
      })
      .on('rateyo.change', function (e, data) {
        var rating = data.rating;
        $(this).parent().find('.counter').text(rating);
      });
  }
});
