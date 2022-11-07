/*=========================================================================================
    File Name: widgets.js
    Description: widgets page content with different types of cards
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {

  var $primary = '#5A8DEE';
  var $success = '#39DA8A';
  var $danger = '#FF5B5C';
  var $warning = '#FDAC41';
  var $info = '#00CFDD';
  var $label_color = '#304156';
  var $danger_light = '#FFC1C1';
  var $gray_light = '#828D99';
  var $bg_light = "#f2f4f4";

  // Radial Followers Chart - Primary
  // --------------------------------
  var radialPrimaryoptions = {
    chart: {
      height: 180,
      type: "radialBar"
    },
    series: [86],
    plotOptions: {
      radialBar: {
        offsetY: 0,
        size: 70,
        hollow: {
          size: "70%"
        },
        dataLabels: {
          showOn: "always",
          name: {
            show: false
          },
          value: {
            colors: [$label_color],
            fontSize: "20px",
            show: true,
            offsetY: 8,
            fontFamily: "Rubik"
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    }
  };
  var radialPrimaryChart = new ApexCharts(
    document.querySelector("#radial-chart-primary"),
    radialPrimaryoptions
  );

  radialPrimaryChart.render();


  // Radial Users Chart - Success
  // ----------------------------
  var radialSuccessoptions = {
    chart: {
      height: 180,
      type: "radialBar"
    },
    series: [44],
    colors: [$success],
    plotOptions: {
      radialBar: {
        offsetY: 0,
        size: 70,
        hollow: {
          size: "70%"
        },

        dataLabels: {
          showOn: "always",
          name: {
            show: false
          },
          value: {
            colors: [$label_color],
            fontSize: "20px",
            show: true,
            offsetY: 8,
            fontFamily: "Rubik"
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    }
  };
  var radialSuccessChart = new ApexCharts(
    document.querySelector("#radial-chart-success"),
    radialSuccessoptions
  );

  radialSuccessChart.render();


  // Radial Registrations Chart - Danger
  // -----------------------------------
  var radialDangeroptions = {
    chart: {
      height: 180,
      type: "radialBar"
    },
    series: [63],
    colors: [$danger],
    plotOptions: {
      radialBar: {
        offsetY: 0,
        size: 70,
        hollow: {
          size: "70%"
        },

        dataLabels: {
          showOn: "always",
          name: {
            show: false
          },
          value: {
            colors: [$label_color],
            fontSize: "20px",
            show: true,
            offsetY: 8,
            fontFamily: "Rubik"
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    }
  };
  var radialDangerChart = new ApexCharts(
    document.querySelector("#radial-chart-danger"),
    radialDangeroptions
  );
  radialDangerChart.render();


  // Multi Radial Statistics
  // -----------------------
  var multiRadialOptions = {
    chart: {
      height: 270,
      width: 320,
      type: "radialBar",
    },
    colors: [$primary, $warning, $danger],
    series: [75, 80, 85],
    plotOptions: {
      radialBar: {
        hollow: {
          size: "55%"
        },
        track: {
          margin: 10,
          background: '#fff',
        },
        dataLabels: {
          name: {
            fontSize: '15px',
            color: [$gray_light],
            fontFamily: "IBM Plex Sans",
            offsetY: 25,
          },
          value: {
            fontSize: '32px',
            fontFamily: "Rubik",
            offsetY: -15,
          },
          total: {
            show: true,
            label: 'Instagram',
            fontSize: '15px',
            color: [$gray_light],
            fontFamily: "IBM Plex Sans",
            fontWeight: 400,
            color: $gray_light
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    },
    labels: ['Comments', 'Sharing', 'Replies'],
    responsive: [{
      breakpoint: 1200,
      options: {
        chart: {
          width: 290,
          height:250
        }
      }
    },
    {
      breakpoint: 1024,
      options: {
        chart: {
          width: 250,
          height:250
        }
      }
    },
    {
      breakpoint: 991,
      options: {
        chart: {
          width: 300,
          height:270
        }
      }
    },
    {
      breakpoint: 768,
      options: {
        chart: {
          width: 650,
          height:300
        }
      }
    },
    {
      breakpoint: 568,
      options: {
        chart: {
          width: 450,
          height:270
        }
      }
    },
    {
      breakpoint: 450,
      options: {
        chart: {
          width: 300,
          height:250
        }
      }
    },
    {
      breakpoint: 360,
      options: {
        chart: {
          width: 220,
          height:270
        }
      }
    }]
  };

  var multiradialChart = new ApexCharts(
    document.querySelector("#radial-chart-multi"),
    multiRadialOptions
  );
  multiradialChart.render();

  // Half Radial Chart
  // -----------------
  var radialHalfChartOptions = {
    chart: {
      height: 240,
      width: 310,
      type: "radialBar",
    },
    series: [67],
    labels: ["842k"],
    colors: [$warning],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: -5,
          size: '85%',
          image: '../../../app-assets/images/cards/face-regular-24.png',
          imageWidth: 32,
          imageHeight: 32,
          imageClipped: false,
        },
        startAngle: -120,
        endAngle: 130,
        track: {
          background: [$bg_light],
          startAngle: -100,
          endAngle: 120,
        },
        dataLabels: {
          name: {
            show: true,
            fontSize: "34px",
            offsetY: 50,
            color: $label_color
          },
          value: {
            fontSize: "28px",
            show: false
          }
        }
      }
    },
    stroke: {
      lineCap: "round"
    },
    responsive: [{
      breakpoint: 1200,
      options: {
        chart: {
          width: 290,
          height:250
        }
      }
    },
    {
      breakpoint: 1024,
      options: {
        chart: {
          width: 250,
          height:250
        }
      }
    },
    {
      breakpoint: 991,
      options: {
        chart: {
          width: 300,
          height:270
        }
      }
    },
    {
      breakpoint: 768,
      options: {
        chart: {
          width: 650,
          height:300
        }
      }
    },
    {
      breakpoint: 568,
      options: {
        chart: {
          width: 450,
          height:270
        }
      }
    },
    {
      breakpoint: 450,
      options: {
        chart: {
          width: 300,
          height:250
        }
      }
    },
    {
      breakpoint: 360,
      options: {
        chart: {
          width: 220,
          height:270
        }
      }
    }]
  };

  var radialHalfChart = new ApexCharts(
    document.querySelector("#radial-chart-half"),
    radialHalfChartOptions
  );
  radialHalfChart.render();


  // Donut Chart Spending
  // ---------------------
  var donustSpendingChart = {
    chart: {
      width: 270,
      type: 'donut',
    },
    dataLabels: {
      enabled: false
    },
    series: [44, 55, 13, 33],
    labels: ["Public Transport", "Cafe & Resturants", "Business Projects", "Traveling & Vocation"],
    stroke: {
      width: 0
    },
    colors: [$danger, $success, $warning, $primary],
    plotOptions: {
      pie: {
        donut: {
          size: '95%',
          labels: {
            show: true,
            name: {
              show: true,
              fontFamily: 'Rubik',
              color: $gray_light,
              offsetY: 30
            },
            value: {
              show: true,
              fontSize: '32px',
              fontFamily: 'Rubik',
              color: undefined,
              offsetY: -20,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              label: 'Total',
              color: $gray_light,
              formatter: function (w) {
                return w.globals.seriesTotals.reduce(function (a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    legend: {
      show: false
    },
    responsive: [{
      breakpoint: 1200,
      options: {
        chart: {
          width: 290,
          height:250
        }
      }
    },
    {
      breakpoint: 1024,
      options: {
        chart: {
          width: 250,
          height:250
        }
      }
    },
    {
      breakpoint: 991,
      options: {
        chart: {
          width: 300,
          height:270
        }
      }
    },
    {
      breakpoint: 768,
      options: {
        chart: {
          width: 650,
          height:300
        }
      }
    },
    {
      breakpoint: 568,
      options: {
        chart: {
          width: 450,
          height:270
        }
      }
    },
    {
      breakpoint: 450,
      options: {
        chart: {
          width: 300,
          height:250
        }
      }
    },
    {
      breakpoint: 360,
      options: {
        chart: {
          width: 190,
          height:190
        }
      }
    }]
  }

  var donustChartSpending = new ApexCharts(
    document.querySelector("#donut-chart-spending"),
    donustSpendingChart
  );

  donustChartSpending.render();


  // Donut Chart Statistics
  // -----------------------

  var donustChartStatistics = {
    chart: {
      width: 280,
      type: 'donut'
    },
    dataLabels: {
      enabled: false
    },
    series: [70, 30, 40],
    labels: ["Installation", "Page Views", "Active Users"],
    stroke: {
      width: 0
    },
    colors: [$primary, $warning, $danger],
    plotOptions: {
      pie: {
        donut: {
          size: '95%',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Rubik',
              color: $gray_light,
              offsetY: 20
            },
            value: {
              show: true,
              fontSize: '32px',
              fontFamily: 'Rubik',
              color: undefined,
              offsetY: -30,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              label: 'Copies',
              color: $gray_light,
              formatter: function (w) {
                return w.globals.seriesTotals.reduce(function (a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    legend: {
      show: false
    },
    responsive: [{
      breakpoint: 1200,
      options: {
        chart: {
          width: 290,
          height:250
        }
      }
    },
    {
      breakpoint: 1024,
      options: {
        chart: {
          width: 250,
          height:250
        }
      }
    },
    {
      breakpoint: 991,
      options: {
        chart: {
          width: 300,
          height:270
        }
      }
    },
    {
      breakpoint: 768,
      options: {
        chart: {
          width: 650,
          height:300
        }
      }
    },
    {
      breakpoint: 568,
      options: {
        chart: {
          width: 450,
          height:270
        }
      }
    },
    {
      breakpoint: 450,
      options: {
        chart: {
          width: 300,
          height:250
        }
      }
    },
    {
      breakpoint: 360,
      options: {
        chart: {
          width: 190,
          height:190
        }
      }
    }]
  }

  var donustChartStatistics = new ApexCharts(
    document.querySelector("#donut-chart-statistics"),
    donustChartStatistics
  );
  donustChartStatistics.render();


  // Bar Chart
  // ---------
  var barchartOptions = {
    chart: {
      height: 310,
      width: '100%',
      type: 'bar',
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '30%',
        endingShape: 'rounded'
      },
    },
    legend: {
      horizontalAlign: 'right',
      offsetY: 10,
      markers: {
        radius: 50,
        height: 8,
        width: 8
      }
    },
    dataLabels: {
      enabled: false
    },
    colors: [$danger, $danger_light],
    stroke: {
      show: true,
      width: 0,
      colors: ['transparent']
    },
    series: [{
      name: '2019',
      data: [120, 180, 250, 180, 290, 390, 330, 290, 220, 330, 280, 130]
    }, {
      name: '2018',
      data: [80, 150, 210, 120, 220, 320, 270, 240, 130, 270, 210, 110]
    }],
    xaxis: {
      categories: ['Ja', 'Fe', 'Ma', 'Ap', 'Ma', 'Ju', 'Ju', 'Au', 'Se', 'Oc', 'No', 'De'],
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      labels: {
        style: {
          colors: $gray_light
        }
      }
    },
    yaxis: {
      min: 0,
      max: 400,
      tickAmount: 4,
      labels: {
        style: {
          color: $gray_light
        }
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return "$ " + val + " thousands"
        }
      }
    }
  }

  var barChart = new ApexCharts(
    document.querySelector("#avg-order-chart"),
    barchartOptions
  );

  barChart.render();


  // Line Chart
  // ----------

  var lineChartoptions = {
    chart: {
      height: 300,
      type: 'line',
      zoom: {
        enabled: false
      },
      toolbar: {
        show: false
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'straight',
      width: 3,
    },
    legend: {
      horizontalAlign: 'right',
      position: 'top',
      markers: {
        radius: 50,
        height: 8,
        width: 8
      },
      itemMargin: {
        horizontal: 20,
      }
    },
    colors: [$info, $success],
    series: [{
      name: "Views",
      data: [40, 45, 39, 10, 40, 27, 30, 42]
    }, {
      name: "Likes",
      data: [25, 30, 31, 12, 28, 27, 22, 28]
    }],
    tooltip: {
      x: {
        show: false,
      }
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        style: {
          colors: $gray_light
        }
      }
    },
    yaxis: {
      labels: {
        style: {
          color: $gray_light
        }
      }
    },
    legend: {
      show: false
    }
  }

  var lineChart = new ApexCharts(
    document.querySelector("#statistics-line-chart"),
    lineChartoptions
  );

  lineChart.render();

  // Statistics Multi Radial
  // -----------------------
  var statisticsRadialChartOptions = {
    chart: {
      height: 270,
      type: "radialBar",
    },
    colors: [$primary, $success, $danger],
    series: [85, 90, 95],
    labels: ['Category', 'Service', 'Account'],
    plotOptions: {
      radialBar: {
        hollow: {
          offsetY: -50,
          size: "50%"
        },
        track: {
          margin: 10,
          background: '#fff',
        },
        dataLabels: {
          name: {
            fontSize: '15px',
            color: [$gray_light],
            fontFamily: "IBM Plex Sans",
            offsetY: 25,
          },
          value: {
            fontSize: '32px',
            fontFamily: "Rubik",
            offsetY: -15,
          },
          total: {
            show: true,
            color: $gray_light,
            label: 'Expense',
          }
        }
      }
    },
    stroke: {
      lineCap: "round",
    },
    responsive: [{
      breakpoint: 1360,
      options: {
        chart: {
          width: 250,
          height:230
        }
      }
    },
    {
      breakpoint: 1200,
      options: {
        chart: {
          width: 220,
          height:230
        }
      }
    },
    {
      breakpoint: 1024,
      options: {
        chart: {
          width: 250,
          height:250
        }
      }
    },
    {
      breakpoint: 991,
      options: {
        chart: {
          width: 300,
          height:270
        }
      }
    },
    {
      breakpoint: 768,
      options: {
        chart: {
          width: 650,
          height:300
        }
      }
    },
    {
      breakpoint: 568,
      options: {
        chart: {
          width: 450,
          height:270
        }
      }
    },
    {
      breakpoint: 450,
      options: {
        chart: {
          width: 300,
          height:250
        }
      }
    },
    {
      breakpoint: 360,
      options: {
        chart: {
          width: 250,
          height:250
        }
      }
    }]
  }

  var statisticsRadialChart = new ApexCharts(
    document.querySelector("#statistics-multi-radial-chart"),
    statisticsRadialChartOptions
  );
  statisticsRadialChart.render();


  // Order Activity Line Chart
  // -------------------------
  var orderActivityChartOptions = {
    chart: {
      height: 350,
      type: 'line',
      toolbar: {
        show: false
      }
    },
    colors: [$primary],
    dataLabels: {
      enabled: false,
    },
    series: [{
      data: [40, 60, 120, 100, 140, 80, 180, 180, 280, 190, 210, 190, 290, 290]
    }],
    markers: {
      size: 5,
      hover: {
        size: 7,
        sizeOffset: 7
      },
    },
    xaxis: {
      categories: [10.12, 10.12, 11.12, 11.12, 12.12, 12.12, 13.12, 13.12, 14.12, 14.12, 15.12, 15.12, 16.12, 16.12],
      axisTicks: {
        show: false
      },
      axisBorder: {
        show: false
      },
      labels: {
        style: {
          colors: $gray_light
        },
        offsetX: 3,
      }
    },
    yaxis: {
      min: 0,
      max: 300,
      tickAmount: 3,
      labels: {
        style: {
          color: $gray_light
        }
      }
    },
    grid: {
      padding: {
        left: 15
      }
    }
  }

  var orderActivityChart = new ApexCharts(
    document.querySelector("#order-activity-line-chart"),
    orderActivityChartOptions
  );
  orderActivityChart.render();

  // Followers Line Chart - Danger
  // -----------------------------
  var followerChartDangerOptions = {
    chart: {
      height: 100,
      type: 'line',
      toolbar: {
        show: false
      }
    },
    colors: [$danger],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: 3,
    },
    series: [{
      data: [16, 10, 15, 12, 22, 20, 25]
    }],
    markers: {
      size: 0
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      axisTicks: {
        show: true,
      },
      labels: {
        style: {
          colors: $gray_light,
        }
      },
      axisBorder: {
        height: 0.5,
      }
    },
    yaxis: {
      show: false
    },
    grid: {
      show: false
    }
  }

  var followerChartDanger = new ApexCharts(
    document.querySelector("#follower-danger-chart"),
    followerChartDangerOptions
  );
  followerChartDanger.render();

  // Followers Line Chart - Primary
  // ------------------------------
  var followerChartPrimaryOptions = {
    chart: {
      height: 100,
      type: 'line',
      toolbar: {
        show: false
      }
    },
    colors: [$primary],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: 3,
    },
    series: [{
      data: [24, 16, 27, 23, 12, 20, 23]
    }],
    markers: {
      size: 0
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      axisTicks: {
        show: true,
      },
      labels: {
        style: {
          colors: $gray_light,
        }
      },
      axisBorder: {
        height: 0.5,
      }
    },
    yaxis: {
      show: false
    },
    grid: {
      show: false
    }
  }

  var followerChartPrimary = new ApexCharts(
    document.querySelector("#follower-primary-chart"),
    followerChartPrimaryOptions
  );
  followerChartPrimary.render();

  // Followers Line Chart - Success
  // ------------------------------
  var followerChartSuccessOptions = {
    chart: {
      height: 100,
      type: 'line',
      toolbar: {
        show: false
      }
    },
    colors: [$success],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: 3,
    },
    series: [{
      data: [26, 19, 23, 10, 22, 30, 21]
    }],
    markers: {
      size: 0
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      axisTicks: {
        show: true,
      },
      labels: {
        style: {
          colors: $gray_light,
        }
      },
      axisBorder: {
        height: 0.5,
      }
    },
    yaxis: {
      show: false
    },
    grid: {
      show: false
    }
  }

  var followerChartSuccess = new ApexCharts(
    document.querySelector("#follower-success-chart"),
    followerChartSuccessOptions
  );
  followerChartSuccess.render();

  // Radar Multi Series Chart
  // ------------------------
  var radarMultiChartOptions = {
    chart: {
      height: 370,
      width: 350,
      type: 'radar',
      toolbar: {
        show: false
      }
    },
    colors: [$warning, $danger],
    series: [{
      name: 'Series 1',
      data: [15, 25, 30, 20, 15, 15, 12, 10],
    }, {
      name: 'Series 2',
      data: [30, 20, 20, 10, 30, 30, 35, 20],
    }],
    stroke: {
      width: 0,
      curve: ['smooth', 'straight']
    },
    fill: {
      opacity: 0.85
    },
    markers: {
      size: 3,
      colors: [$warning, $danger]
    },
    dataLabels: {
      style: {
        colors: [$label_color]
      }
    },
    labels: ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight'],
    yaxis: {
      show: false,
    },
    legend: {
      show: false,
    },
    responsive: [{
      breakpoint: 1360,
      options: {
        chart: {
          width: 270,
          height:370
        }
      }
    },
    {
      breakpoint: 1200,
      options: {
        chart: {
          width: 280,
          height:300
        }
      }
    },
    {
      breakpoint: 1024,
      options: {
        chart: {
          width: 270,
          height:270
        }
      }
    },
    {
      breakpoint: 991,
      options: {
        chart: {
          width: 300,
          height:300
        }
      }
    },
    {
      breakpoint: 768,
      options: {
        chart: {
          width: 650,
          height:300
        }
      }
    },
    {
      breakpoint: 568,
      options: {
        chart: {
          width: 450,
          height:270
        }
      }
    },
    {
      breakpoint: 450,
      options: {
        chart: {
          width: 300,
          height:250
        }
      }
    },
    {
      breakpoint: 360,
      options: {
        chart: {
          width: 220,
          height:220
        }
      }
    }]
  }

  var radarMultiChart = new ApexCharts(
    document.querySelector("#radar-multi-chart"),
    radarMultiChartOptions
  );
  radarMultiChart.render();

  // Gauge Chart
  // -----------
  var gaugeChartOptions = {
    chart: {
      height: 320,
      width: 360,
      type: 'radialBar',

    },
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 15,
          size: "60%"
        },
        startAngle: -135,
        endAngle: 135,
        dataLabels: {
          name: {
            fontSize: '22px',
            color: '#304156'
          },
          value: {
            fontSize: '20px',
            color: '#828d99',
            formatter: function (val) {
              return val + "min";
            }
          }
        }
      }
    },
    stroke: {
      lineCap: 'round'
    },
    fill: {
      colors: [$warning]
    },
    series: [67],
    labels: ['Time Spent'],
    responsive: [{
      breakpoint: 1360,
      options: {
        chart: {
          width: 280,
          height:320
        }
      }
    },
    {
      breakpoint: 1200,
      options: {
        chart: {
          width: 280,
          height:350
        }
      }
    },
    {
      breakpoint: 1024,
      options: {
        chart: {
          width: 250,
          height:320
        }
      }
    },
    {
      breakpoint: 991,
      options: {
        chart: {
          width: 300,
          height:270
        }
      }
    },
    {
      breakpoint: 768,
      options: {
        chart: {
          width: 650,
          height:300
        }
      }
    },
    {
      breakpoint: 568,
      options: {
        chart: {
          width: 450,
          height:270
        }
      }
    },
    {
      breakpoint: 450,
      options: {
        chart: {
          width: 300,
          height:250
        }
      }
    },
    {
      breakpoint: 360,
      options: {
        chart: {
          width: 220,
          height:270
        }
      }
    }]
  }
  var gaugeChart = new ApexCharts(
    document.querySelector("#gauge-chart"),
    gaugeChartOptions
  );
  gaugeChart.render();


  // Daily Sales States - Heat Map Chart
  // -----------------------------------
  function generateData(count, yrange) {
    var i = 0,
      series = [];
    while (i < count) {
      var x = 'w' + (i + 1).toString(),
        y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

      series.push({
        x: x,
        y: y
      });
      i++;
    }
    return series;
  }
  var heatChartOptions = {
    chart: {
      height: 300,
      type: 'heatmap',
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      heatmap: {
        enableShades: false,

        colorScale: {
          ranges: [{
              from: 0,
              to: 10,
              color: '#90B3F3'
            },
            {
              from: 11,
              to: 20,
              color: '#7EA6F1'
            },
            {
              from: 21,
              to: 30,
              color: '#6B9AEF'
            },
            {
              from: 31,
              to: 40,
              color: '#598DEE'
            },
            {
              from: 41,
              to: 50,
              color: '#4680EC'
            },
            {
              from: 51,
              to: 60,
              color: '#3474EA'

            }
          ]
        }
      }
    },
    dataLabels: {
      enabled: false
    },
    series: [{
        name: 'Sunday',
        data: generateData(24, {
          min: 0,
          max: 60
        })
      },
      {
        name: 'Monday',
        data: generateData(24, {
          min: 0,
          max: 60
        })
      },
      {
        name: 'Tuesday',
        data: generateData(24, {
          min: 0,
          max: 60
        })
      },
      {
        name: 'Wednesday',
        data: generateData(24, {
          min: 0,
          max: 60
        })
      },
      {
        name: 'Thursday',
        data: generateData(24, {
          min: 0,
          max: 60
        })
      },
      {
        name: 'Friday',
        data: generateData(24, {
          min: 0,
          max: 60
        })
      },
      {
        name: 'Saturday',
        data: generateData(24, {
          min: 0,
          max: 60
        })
      }
    ],
    xaxis: {
      labels: {
        show: false
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    yaxis: {
      labels: {
        style: {
          color: $gray_light,
          fontSize: '15px'
        }
      }
    }
  }
  var heatChart = new ApexCharts(
    document.querySelector("#sales-heatmap-chart"),
    heatChartOptions);
  heatChart.render();


  // Single Date Range
  //----------------------
  $('.single-daterange').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'), 10)
  });

  // Basic Date Range
  //---------------------
  $('.daterange').daterangepicker();


  // Widget Notification - List Group
  //--------------------------
  $('.readable-mark-icon').on('click', function () {
    $(this).addClass('mark-as-read').attr('data-original-title', 'Mark as Unread').children('i').removeClass('text-light-primary').addClass('text-light-secondary');
    $('.readable-mark-icon.mark-as-read').siblings('.list-left').find('.list-title').addClass('text-bold-500');
  });
  // Default mark-as-read shown
  $('.readable-mark-icon.mark-as-read').siblings('.list-left').find('.list-title').addClass('text-bold-500');



  // Widget Todo List
  // ------------------
  // Task List Widget - for completed todo item
  $(document).on('click', '.widget-todo-item input', function () {
    $(this).closest('.widget-todo-item').toggleClass("completed");
  });

  // Drag the task
  dragula([document.getElementById("widget-todo-list")], {
    moves: function (el, container, handle) {
      return handle.classList.contains("cursor-move");
    }
  });

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

  // Perfect Scrollbar
  //------------------
  // Widget - User Details -Perfect Scrollbar X
  if ($('.widget-user-details .table-responsive').length > 0) {
    var user_details = new PerfectScrollbar('.widget-user-details .table-responsive');
  }

  // Widget - Card Overlay - Perfect Scrollbar X - on initial level
  if ($('.widget-overlay-content .table-responsive').length > 0) {
    var card_overlay = new PerfectScrollbar('.widget-overlay-content .tab-pane.active .table-responsive');
  }

  // Widget - Card Overlay - Perfect Scrollbar X - on active tab-pane
  $('.widget-overlay-content a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var card_overlay = new PerfectScrollbar('.widget-overlay-content .tab-pane.active .table-responsive');
  })

  // Widget - timeline perfect scrollbar initialization
  if ($(".timeline").length > 0) {
    var widget_chat_scroll = new PerfectScrollbar(".timeline", {
      wheelPropagation: false
    });
  }
  // Widget - chat area perfect scrollbar initialization
  if ($(".widget-chat-scroll").length > 0) {
    var widget_chat_scroll = new PerfectScrollbar(".widget-chat-scroll", {
      wheelPropagation: false
    });
  }
  // Widget - earnings perfect scrollbar initialization
  if ($(".widget-earnings-scroll").length > 0) {
    var widget_earnings = new PerfectScrollbar(".widget-earnings-scroll",
      // horizontal scroll with mouse wheel
      {
        suppressScrollY: true,
        useBothWheelAxes: true
      });
  }
  // Widget - chat autoscroll to bottom of Chat area on page initialization
  $(".widget-chat-scroll").animate({
    scrollTop: $(".widget-chat-scroll")[0].scrollHeight
  }, 800);

});

// widget page chat
// ----------------
// Add message to chat
function widgetMessageSend(source) {
  var message = $(".widget-chat-message").val();
  if (message != "") {
    var html = '<div class="chat"><div class="chat-body"><div class="chat-message">' + "<p>" + message + "</p>" + "<div class=" + "chat-time" + ">3:35 AM</div></div></div></div>";
    $(".widget-chat-messages .chat-content").append(html);
    $(".widget-chat-message").val("");
    $(".widget-chat-scroll").scrollTop($(".widget-chat-scroll > .chat-content").height());
  }
}
