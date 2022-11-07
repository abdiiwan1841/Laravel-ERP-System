/*=========================================================================================
    File Name: dashboard-ecommerce.js
    Description: dashboard ecommerce page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on("load", function () {

  var $primary = '#5A8DEE';
  var $danger = '#FF5B5C';
  var $warning = '#FDAC41';
  var $info = '#00CFDD';
  var $secondary = '#828D99';
  var $secondary_light = '#e7edf3';
  var $light_primary = "#E2ECFF";


  // Multi Radial Statistics
  // -----------------------
  var multiRadialOptions = {
    chart: {
      height: 210,
      type: "radialBar",
    },
    colors: [$primary, $danger, $warning],
    series: [75, 80, 85],
    plotOptions: {
      radialBar: {
        offsetY: -10,
        hollow: {
          size: "40%"
        },
        track: {
          margin: 10,
          background: '#fff',
        },
        dataLabels: {
          name: {
            fontSize: '15px',
            colors: [$secondary],
            fontFamily: "IBM Plex Sans",
            offsetY: 25,
          },
          value: {
            fontSize: '30px',
            fontFamily: "Rubik",
            offsetY: -15,
          },
          total: {
            show: true,
            label: 'Total Visits',
            fontSize: '15px',
            fontWeight: 400,
            fontFamily: "IBM Plex Sans",
            color: $secondary
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    },
    labels: ['Target', 'Mart', 'Ebay']
  };

  var multiradialChart = new ApexCharts(
    document.querySelector("#multi-radial-chart"),
    multiRadialOptions
  );
  multiradialChart.render();


  // Revenue Growth Chart
  // ---------------------
  var revenueChartOptions = {
    chart: {
      height: 100,
      type: 'bar',
      stacked: true,
      toolbar: {
        show: false
      }
    },
    grid: {
      show: false,
      padding: {
        left: 0,
        right: 0,
        top: -20,
        bottom: -15
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '20%',
        endingShape: 'rounded'
      },
    },
    legend: {
      show: false
    },
    dataLabels: {
      enabled: false
    },
    colors: [$info, $secondary_light],
    series: [{
      name: '2020',
      data: [50, 70, 100, 120, 140, 100, 70, 80, 90, 110, 50, 70, 35, 110, 100, 105, 125, 80]
    }, {
      name: '2019',
      data: [70, 50, 20, 30, 20, 90, 90, 60, 50, 0, 50, 60, 140, 50, 20, 20, 10, 0]
    }],
    xaxis: {
      categories: ['0', '', '', '', '', "10", '', '', '', '', '', '15', '', '', '', '', '', '20'],
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      labels: {
        style: {
          colors: $secondary
        },
        offsetY: -5
      }
    },
    yaxis: {
      show: false,
      floating: true,
    },
    tooltip: {
      x: {
        show: false,
      },
    }
  }

  var revenueChart = new ApexCharts(
    document.querySelector("#revenue-growth-chart"),
    revenueChartOptions
  );

  revenueChart.render();

  // Order Summary Chart
  // --------------------
  var orderSummaryChartOptions = {
    chart: {
      height: 270,
      type: 'line',
      stacked: false,
      toolbar: {
        show: false,
      },
      sparkline: {
        enabled: true
      },
    },
    colors: [$primary, $primary],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2.5,
      dashArray: [0, 8]
    },
    fill: {
      type: 'gradient',
      gradient: {
        inverseColors: false,
        shade: 'light',
        type: "vertical",
        gradientToColors: [$light_primary, $primary],
        opacityFrom: 0.7,
        opacityTo: 0.55,
        stops: [0, 80, 100]
      }
    },
    series: [{
      name: 'This Month',
      data: [165, 175, 162, 173, 160, 195, 160, 170, 160, 190, 180],
      type: 'area',
    }, {
      name: 'Last Months',
      data: [168, 168, 155, 178, 155, 170, 190, 160, 150, 170, 140],
      type: 'line',
    }],

    xaxis: {
      offsetY: -50,
      categories: ['', 1, 2, 3, 4, 5, 6, 7, 8, 9, ''],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        show: true,
        style: {
          colors: $secondary
        }
      }
    },
    tooltip: {
      x: { show: false }
    },
  }

  var orderSummaryChart = new ApexCharts(
    document.querySelector("#order-summary-chart"),
    orderSummaryChartOptions
  );

  orderSummaryChart.render();

  // Marketing Campaigns Chart - Success
  // -----------------------------------
  var donutSuccessChartOption = {
    chart: {
      width: 60,
      height: 75,
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
        offsetY: 0,
        donut: {
          size: '70%',
        }
      }
    },
    legend: {
      show: false
    }
  }
  var donutSuccessChart = new ApexCharts(
    document.querySelector("#donut-success-chart"),
    donutSuccessChartOption
  );
  donutSuccessChart.render();

  // Marketing Campaigns Chart - Danger
  // -----------------------------------
  var donutDangerChartOption = {
    chart: {
      width: 60,
      height: 75,
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
    colors: [$danger, $secondary, $primary],
    plotOptions: {
      pie: {
        offsetY: 0,
        donut: {
          size: '70%',
        }
      }
    },
    legend: {
      show: false
    }
  }
  var donutDangerChart = new ApexCharts(
    document.querySelector("#donut-danger-chart"),
    donutDangerChartOption
  );
  donutDangerChart.render();

  // Earnings Swiper - Perfect Scrollbar
  if ($(".widget-earnings-scroll").length > 0) {
    var widget_earnings = new PerfectScrollbar(".widget-earnings-scroll");
  }

  // Earnings Swiper - Perfect Scrollbar
  if ($(".dashboard-latest-update .card-body").length > 0) {
    var widget_earnings = new PerfectScrollbar(".dashboard-latest-update .card-body");
  }

  // User Details - Perfect Scrollbar
  if ($('.marketing-campaigns .table-responsive').length > 0) {
    var user_details = new PerfectScrollbar('.marketing-campaigns .table-responsive');
  }
  // Earnings Swiper
  // ---------------
  var swiperLength = $(".swiper-slide").length;
  if (swiperLength) {
    swiperLength = Math.floor(swiperLength / 2)
  }

  // Swiper js for this page
  var mySwiper = new Swiper('.widget-earnings-swiper', {
    slidesPerView: 'auto',
    initialSlide: swiperLength,
    centeredSlides: true,
    spaceBetween: 30,
    // active slide on click
    slideToClickedSlide: true,
  });

  activeSlide(swiperLength);

  // Active slide change on swipe
  mySwiper.on('slideChange', function () {
    activeSlide(mySwiper.realIndex);
  });

  //add class active content of active slide
  function activeSlide(index) {
    var slideEl = mySwiper.slides[index]
    var slideId = $(slideEl).attr('id');
    $(".wrapper-content").removeClass("active");
    $("[data-earnings=" + slideId + "]").addClass('active')
  };
});
