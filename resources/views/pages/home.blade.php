
@extends('layouts/contentLayoutMaster')

@section('title', 'Irányítópult')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/tour/tour.css')) }}">
  @endsection

  @section('content')
    {{-- Dashboard Analytics Start --}}
    <section id="dashboard-analytics">
      <div class="row">
          <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="card bg-analytics text-white">
            <div class="card-content">
              <div class="card-body text-center">
                <img src="{{ asset('images/elements/decore-left.png') }}" class="img-left" alt="card-img-left">
                <img src="{{ asset('images/elements/decore-right.png')}}" class="img-right" alt="card-img-right">
                <div class="avatar avatar-xl bg-primary shadow mt-0">
                    <div class="avatar-content">
                        <i class="feather icon-zap white font-large-1"></i>
                    </div>
                </div>
                <div class="text-center">
                  <h1 class="mb-2 text-white">Frissítés</h1>
                  <p class="m-auto w-75 font- font-medium-1">Frissült a <span class="font-medium-3 with-logo">With</span> ! Tájékozódjon a <strong>0.0.51</strong> frissítés újdonságairól!</p>
                  <a href="#" class="mt-1 btn btn-sm btn-primary waves-effect waves-light">Újdonságok áttekintése</a>
                </div>
              </div>
            </div>
          </div>
        </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
              <div class="card-header d-flex flex-column align-items-start pb-0">
                  <div class="avatar bg-rgba-primary p-50 m-0">
                      <div class="avatar-content">
                          <i class="feather icon-users text-primary font-medium-5"></i>
                      </div>
                  </div>
                  <h2 class="text-bold-700 mt-1 mb-25">{{ $userNum }}</h2>
                  <p class="mb-0">Felhasználó</p>
              </div>
              <div class="card-content" style="height: 100px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-package text-primary font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">{{ $orderNum }}</h2>
                    <p class="mb-0">Rendelés</p>
                </div>
                <div class="card-content">
                    <div id="orders-received-chart"></div>
                </div>
            </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-content">
                  <div class="card-body">
                      @php 
                      $income = 0;
                      $profit = 0;
                      $orderN = 0;
                      @endphp
                      @foreach ($orders as $order)
                        @php 
                          $income = $income + $order->total_price;
                          $profit = $profit + $order->margin;
                          $orderN++;
                        @endphp
                      @endforeach
                      @php 
                        $roundedincome = $income / 100000;
                        $roundedincome = round($roundedincome) * 100000;
                        
                        if ($roundedincome == 0) {
                          $roundedincome = 100000;
                        }
                        $roundedincome = ($income / $roundedincome) * 100;
                        $roundedincome = round($roundedincome);

                        $roundedprofit = $profit / 100000;
                        $roundedprofit = round($roundedprofit) * 100000;
                        if ($roundedprofit == 0) {
                          $roundedprofit = 100000;
                        }
                        $roundedprofit = ($profit / $roundedprofit) * 100;
                        $roundedprofit = round($roundedprofit);

                        $orderN = number_format($orderN, 0);
                        $income = number_format($income, 0);
                        $profit = number_format($profit, 0);
                      @endphp
                      <div class="row pb-50">
                          <div class="col-lg-6 col-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">
                              <div>
                                  <h2 class="text-bold-700 mb-25">{{ $orderN }}</h2>
                                  <p class="text-bold-500 mb-75">Rendelés</p>
                                  <h5 class="font-medium-2">
                                      <span class="text-success"></span>
                                      <span>Az elmúlt 30 nap adatai. {{ $distance }}</span>
                                  </h5>
                              </div>
                              <!--<a href="#" class="btn btn-primary shadow">Statisztika <i class="feather icon-chevrons-right"></i></a>-->
                          </div>
                          <div class="col-lg-6 col-12 d-flex justify-content-between flex-column text-right order-lg-2 order-1">
                              <div id="avg-session-chart"></div>
                          </div>
                      </div>
                      <hr/>
                      <div class="row avg-sessions pt-50">
                          <div class="col-6">
                              <p class="mb-0">Bevétel: {{$income}} Ft</p>
                              <div class="progress progress-bar-primary mt-25">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$roundedincome}}" aria-valuemin="0" aria-valuemax="100"
                                  style="width:{{$roundedincome}}%"></div>
                              </div>
                          </div>
                          <div class="col-6">
                              <p class="mb-0">Potenciális profit: {{ $profit }} Ft</p>
                              <div class="progress progress-bar-primary mt-25">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$roundedprofit}}" aria-valuemin="00" aria-valuemax="100"
                                  style="width:{{$roundedprofit}}%"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
      
      @php
        $ordergraph = '[';
        $ordergraphdate = '[';
      @endphp

      @for ($i = 30; $i >= 0; $i--)
        @php
          date_default_timezone_set('Europe/Budapest');
          $datenow = new DateTime(date("Y-m-d"));
          $datenow->modify('-'.$i.' days');
          $datenow = date_format($datenow, 'Y-m-d');

          $count = 0;
        @endphp

        @foreach($orderCount as $oc)
            @if($datenow == $oc->date)
              @php 
              $count = $count + $oc->ordercount;
              @endphp
            @endif
        @endforeach

        @if($i == 0)
        @php
        $ordergraph = $ordergraph.$count;
        @endphp
        @else
        @php
        $ordergraph = $ordergraph.$count.', ';
        @endphp
        @endif

        @php 
        $count = 0;
        @endphp

      @endfor
      @php 
      $ordergraph = $ordergraph.']';
      $ordergraphdate = $ordergraphdate.']';
      @endphp


      
    </section>
  <!-- Dashboard Analytics end -->
  @endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.js')) }}"></script>
@endsection
@section('page-script')
        <!-- Page js files -->
        <!--<script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>-->
        <script>
        /*=========================================================================================
    File Name: dashboard-analytics.js
    Description: dashboard analytics page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on("load", function () {

var $primary = '#47b272';
var $danger = '#EA5455';
var $warning = '#FF9F43';
var $info = '#0DCCE1';
var $primary_light = '#62de94';
var $warning_light = '#FFC085';
var $danger_light = '#f29292';
var $info_light = '#1edec5';
var $strok_color = '#b9c3cd';
var $label_color = '#e7eef7';
var $white = '#fff';

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

var date = new Date(); //YYYY-MM-DD
var startDate = date.setDate(date.getDate() - 30);
var endDate = date.setDate(date.getDate() + 30);
var getDateArray = function(start, end) {
    var arr = new Array();
    var dt = new Date(start);
    while (dt <= end) {
        arr.push(formatDate(new Date(dt)));
        dt.setDate(dt.getDate() + 1);
    }
    return arr;
}

var dateArr = getDateArray(startDate, endDate);



// Subscribers Gained Chart starts //
// ----------------------------------

var gainedChartoptions = {
  chart: {
    height: 100,
    type: 'area',
    toolbar: {
      show: false,
    },
    sparkline: {
      enabled: true
    },
    grid: {
      show: false,
      padding: {
        left: 0,
        right: 0
      }
    },
  },
  colors: [$primary],
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth',
    width: 2.5
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 0.9,
      opacityFrom: 0.7,
      opacityTo: 0.5,
      stops: [0, 80, 100]
    }
  },
  series: [{
    name: 'Subscribers',
    data: [28, 40, 36, 52, 38, 60]
  }],

  xaxis: {
    categories: [
      "01 Jan",
      "02 Jan",
      "03 Jan",
      "04 Jan",
      "05 Jan",
      "06 Jan"
    ],
    labels: {
      show: false,
    },
    axisBorder: {
      show: false,
    }
  },
  yaxis: [{
    y: 0,
    offsetX: 0,
    offsetY: 0,
    padding: { left: 0, right: 0 },
  }],
  tooltip: {
    x: { show: true }
  },
}

var gainedChart = new ApexCharts(
  document.querySelector("#subscribe-gain-chart"),
  gainedChartoptions
);

gainedChart.render();

// Subscribers Gained Chart ends //



// Orders Received Chart starts //
// ----------------------------------

var orderChartoptions = {
  chart: {
    height: 100,
    type: 'area',
    toolbar: {
      show: false,
    },
    sparkline: {
      enabled: true
    },
    grid: {
      show: false,
      padding: {
        left: 0,
        right: 0
      }
    },
  },
  colors: [$primary],
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth',
    width: 2.5
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 0.9,
      opacityFrom: 0.7,
      opacityTo: 0.5,
      stops: [0, 80, 100]
    }
  },
  series: [{
    name: 'Rendelés',
    data: {{ $ordergraph }}
  }],

  xaxis: {
    categories: dateArr,
    labels: {
      show: false,
    },
    axisBorder: {
      show: false,
    }
  },
  yaxis: [{
    y: 0,
    offsetX: 0,
    offsetY: 0,
    padding: { left: 0, right: 0 },
  }],
  tooltip: {
    x: { show: true }
  },
}

var orderChart = new ApexCharts(
  document.querySelector("#orders-received-chart"),
  orderChartoptions
);

orderChart.render();

// Orders Received Chart ends //



// Avg Session Chart Starts
// ----------------------------------

var sessionChartoptions = {
  chart: {
    type: 'bar',
    height: 200,
    sparkline: { enabled: true },
    toolbar: { show: false },
  },
  states: {
    hover: {
      filter: 'none'
    }
  },
  colors: [$primary],
  series: [{
    name: 'Rendelések',
    data: {{ $ordergraph }}
  }],
  grid: {
    show: false,
    padding: {
      left: 0,
      right: 0
    }
  },

  plotOptions: {
    bar: {
      columnWidth: '75%',
      distributed: true,
      endingShape: 'rounded'
    }
  },
  tooltip: {
    x: { show: true }
  },
  xaxis: {
    categories: dateArr,
    labels: {
      show: false,
    },
    axisBorder: {
      show: false,
    }
  }
}

var sessionChart = new ApexCharts(
  document.querySelector("#avg-session-chart"),
  sessionChartoptions
);

sessionChart.render();

// Avg Session Chart ends //


// Support Tracker Chart starts
// -----------------------------

var supportChartoptions = {
  chart: {
    height: 270,
    type: 'radialBar',
  },
  plotOptions: {
    radialBar: {
      size: 150,
      startAngle: -150,
      endAngle: 150,
      offsetY: 20,
      hollow: {
        size: '65%',
      },
      track: {
        background: $white,
        strokeWidth: '100%',

      },
      dataLabels: {
        value: {
          offsetY: 30,
          color: '#99a2ac',
          fontSize: '2rem'
        }
      }
    },
  },
  colors: [$primary],
  fill: {
    type: 'gradient',
    gradient: {
      // enabled: true,
      shade: 'dark',
      type: 'horizontal',
      shadeIntensity: 0.5,
      gradientToColors: [$danger],
      inverseColors: true,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100]
    },
  },
  stroke: {
    dashArray: 8
  },
  series: [98],
  labels: ['Sikeres rendelés'],

}

var supportChart = new ApexCharts(
  document.querySelector("#support-tracker-chart"),
  supportChartoptions
);

supportChart.render();

// Support Tracker Chart ends


// Product Order Chart starts
// -----------------------------

var productChartoptions = {
  chart: {
    height: 325,
    type: 'radialBar',
  },
  colors: [$danger, $warning, $primary],
  fill: {
    type: 'gradient',
    gradient: {
      // enabled: true,
      shade: 'dark',
      type: 'vertical',
      shadeIntensity: 0.5,
      gradientToColors: [$primary_light, $warning_light, $danger_light],
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100]
    },
  },
  stroke: {
    lineCap: 'round'
  },
  plotOptions: {
    radialBar: {
      size: 1894,
      hollow: {
        size: '20%'
      },
      track: {
        strokeWidth: '100%',
        margin: 15,
      },
      dataLabels: {
        name: {
          fontSize: '18px',
        },
        value: {
          fontSize: '16px',
        },
        total: {
          show: true,
          label: 'Total',

          formatter: function (w) {
            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
            return 42459
          }
        }
      }
    }
  },
  series: [1889, 3, 2],
  labels: ['Sikeres', 'Folyamatban', 'Sikertelen'],

}

var productChart = new ApexCharts(
  document.querySelector("#product-order-chart"),
  productChartoptions
);

productChart.render();

// Product Order Chart ends //


// Sales Chart starts
// -----------------------------

var salesChartoptions = {
  chart: {
    height: 400,
    type: 'radar',
    dropShadow: {
      enabled: true,
      blur: 8,
      left: 1,
      top: 1,
      opacity: 0.2
    },
    toolbar: {
      show: false
    },
  },
  toolbar: { show: false },
  series: [{
    name: 'Sales',
    data: [90, 50, 86, 40, 100, 20],
  }, {
    name: 'Visit',
    data: [70, 75, 70, 76, 20, 85],
  }],
  stroke: {
    width: 0
  },
  colors: [$primary, $info],
  plotOptions: {
    radar: {
      polygons: {
        strokeColors: ['#e8e8e8', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent'],
        connectorColors: 'transparent'
      }
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'dark',
      gradientToColors: ['#9f8ed7', $info_light],
      shadeIntensity: 1,
      type: 'horizontal',
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100, 100, 100]
    },
  },
  markers: {
    size: 0,
  },
  legend: {
    show: true,
    position: 'top',
    horizontalAlign: 'left',
    fontSize: '16px',
    markers: {
      width: 10,
      height: 10,
    }
  },
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
  dataLabels: {
    style: {
      colors: [$strok_color, $strok_color, $strok_color, $strok_color, $strok_color, $strok_color]
    }
  },
  yaxis: {
    show: false,
  },
  grid: {
    show: false,
  },

}

var salesChart = new ApexCharts(
  document.querySelector("#sales-chart"),
  salesChartoptions
);

salesChart.render();

// Sales Chart ends //

/***** TOUR ******/
var tour = new Shepherd.Tour({
  classes: 'shadow-md bg-purple-dark',
  scrollTo: true
})

// tour steps
tour.addStep('step-1', {
  text: 'Toggle Collapse Sidebar.',
  attachTo: '.modern-nav-toggle .collapse-toggle-icon bottom',
  buttons: [

    {
      text: "Skip",
      action: tour.complete
    },
    {
      text: 'Next',
      action: tour.next
    },
  ]
});

tour.addStep('step-2', {
  text: 'Create your own bookmarks. You can also re-arrange them using drag & drop.',
  attachTo: '.bookmark-icons .icon-mail bottom',
  buttons: [

    {
      text: "Skip",
      action: tour.complete
    },

    {
      text: "previous",
      action: tour.back
    },
    {
      text: 'Next',
      action: tour.next
    },
  ]
});

tour.addStep('step-3', {
  text: 'You can change language from here.',
  attachTo: '.dropdown-language .flag-icon bottom',
  buttons: [

    {
      text: "Skip",
      action: tour.complete
    },

    {
      text: "previous",
      action: tour.back
    },
    {
      text: 'Next',
      action: tour.next
    },
  ]
});

tour.addStep('step-4', {
  text: 'Try fuzzy search to visit pages in flash.',
  attachTo: '.nav-link-search .icon-search bottom',
  buttons: [

    {
      text: "Skip",
      action: tour.complete
    },

    {
      text: "previous",
      action: tour.back
    },
    {
      text: 'Next',
      action: tour.next
    },
  ]
});

tour.addStep('step-5', {
  text: 'Buy this awesomeness at affordable price!',
  attachTo: '.buy-now bottom',
  buttons: [

    {
      text: "previous",
      action: tour.back
    },

    {
      text: "Finish",
      action: tour.complete
    },
  ]
});

if ($(window).width() > 1200 && !$("body").hasClass("menu-collapsed")) {
  tour.start()
}
else {
  tour.cancel()
}
if($("body").hasClass("horizontal-menu")){
  tour.cancel()
}
$(window).on("resize", function () {
  tour.cancel()
})

});

        </script>
@endsection
