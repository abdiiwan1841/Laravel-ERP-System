@extends('layouts.admin.admin_layout')

@section('title', trans('applang.dashboard'))

@section('vendor-css')
@endsection
@section('page-css')
@endsection

@section('content')

<div class="container-fluid">
    <h3 class="mb-2">{{trans('applang.welcome') . ' ' . $current_user}}</h3>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 zoom">
            <a href="{{route('sales-invoices.index')}}" title="{{trans('applang.go_to_sales')}}">
                <div class="card text-center bg-rgba-success">
                    <div class="card-body py-1">
                        <div class="badge-circle badge-circle-lg bg-rgba-white mx-auto mb-50">
                            <img class="w-100 h-100" src="{{asset('app-assets/images/svg/invoice-svgrepo-com.svg')}}" alt="">
                        </div>
                        @if($totalSales)
                            <div class="text-dark line-ellipsis">
                                {{trans('applang.total_sales')}} ({{$thisYear}}) {{trans('applang.for_count') . ' ' . $totalSales->count .' '.trans('applang.invoice')}}
                            </div>
                            <h3 class="mb-0 text-dark text-bold">{{$totalSales->total .' '.$currency_symbol}}</h3>
                        @else
                            <div class="text-dark line-ellipsis">
                                {{trans('applang.total_sales')}} ({{$thisYear}}) {{trans('applang.for_count') . '0' .trans('applang.invoice')}}
                            </div>
                            <h3 class="mb-0 text-dark text-bold">Not Recorded Yet</h3>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 zoom">
            <a href="{{route('purchase-invoices.index')}}" title="{{trans('applang.go_to_purchases')}}">
                <div class="card text-center bg-rgba-danger">
                    <div class="card-body py-1">
                        <div class="badge-circle badge-circle-lg bg-rgba-white mx-auto mb-50">
                            <img class="w-100 h-100" src="{{asset('app-assets/images/svg/delivery-truck-truck-svgrepo-com.svg')}}" alt="">
                        </div>
                        @if($totalPurchases)
                            <div class="text-dark line-ellipsis">
                                {{trans('applang.total_purchases')}} ({{$thisYear}}) {{trans('applang.for_count') . ' ' . $totalPurchases->count .' '.trans('applang.invoice')}}
                            </div>
                            <h3 class="mb-0 text-dark text-bold">{{$totalPurchases->total .' '.$currency_symbol}}</h3>
                        @else
                            <div class="text-dark line-ellipsis">
                                {{trans('applang.total_purchases')}} ({{$thisYear}}) {{trans('applang.for_count') . ' 0 ' .trans('applang.invoice')}}
                            </div>
                            <h3 class="mb-0 text-dark text-bold">Not Recorded Yet</h3>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 zoom">
            <a href="{{route('products.show', $bestSellerProduct->product_id ?? 'test')}}" title="{{trans('applang.go_to_product_details')}}">
                <div class="card text-center bg-rgba-warning">
                    <div class="card-body py-1">
                        <div class="badge-circle badge-circle-lg bg-rgba-white mx-auto mb-50">
                            <img class="w-100 h-100" src="{{asset('app-assets/images/svg/star-svgrepo-com.svg')}}" alt="">
                        </div>
                        <div class="text-dark line-ellipsis">
                            {{trans('applang.best_seller_product')}} {{trans('applang.for_year')}} ({{$thisYear}})
                        </div>
                        <h3 class="mb-0 text-dark text-bold">{{$bestSellerProduct->product_name ?? 'Not Recorded Yet'}}</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 zoom">
            <a href="{{route('users.show', $bestSellerEmployee->user_id ??'test')}}" title="{{trans('applang.go_to_user_details')}}">
                <div class="card text-center bg-rgba-info">
                    <div class="card-body py-1">
                        <div class="badge-circle badge-circle-lg bg-rgba-white mx-auto mb-50">
                            <img src="{{asset('app-assets/images/svg/medal-reward-svgrepo-com.svg')}}" alt="">
                        </div>
                        <div class="text-dark line-ellipsis">
                            {{trans('applang.best_seller_employee')}} {{trans('applang.for_year')}} ({{$thisYear}})
                        </div>
                        @if($bestSellerEmployee)
                            <h3 class="mb-0 text-dark text-bold">{{$bestSellerEmployee->user_first_name . ' ' .$bestSellerEmployee->user_last_name}}</h3>
                        @else
                            <h3 class="mb-0 text-dark text-bold">Not recorded yet</h3>
                        @endif
                    </div>
                </div>
            </a>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header mb-1 justify-content-between align-items-center bg-rgba-primary">
                    <h5>{{trans('applang.sales_invoices_statistics')}} ({{$thisYear}})</h5>
                    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-light-primary">
                            <input type="radio" name="options" data-group="daily" id="option1"> {{trans('applang.daily')}}
                        </label>
                        <label class="btn btn-light-primary">
                            <input type="radio" name="options" data-group="weekly" id="option2"> {{trans('applang.weekly')}}
                        </label>
                        <label class="btn btn-light-primary active">
                            <input type="radio" name="options" data-group="monthly" id="option2" checked> {{trans('applang.monthly')}}
                        </label>
                        <label class="btn btn-light-primary">
                            <input type="radio" name="options" data-group="yearly" id="option3"> {{trans('applang.yearly')}}
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header mb-1 justify-content-between align-items-center bg-rgba-primary">
                    <h5>{{trans('applang.sales_payment_status_statistics')}}</h5>
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                            @foreach($years as $key => $year)
                                <button type="button" class="btn btn-light-primary {{$thisYear === $year ? 'active' : ''}}" data-year="{{$year}}">{{$year}}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('page-vendor-js')
@endsection
@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Any of the following formats may be used
        //const ctx = document.getElementById('myChart2');
        const ctx = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx, {
            type: 'line',
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'black',
                            font: {
                                family: "'Nunito', sans-serif",
                            }
                        },
                    },
                    y: {
                        ticks: {
                            color: 'black',
                            font: {
                                family: "'Nunito', sans-serif",
                            }
                        },
                        beginAtZero: true,
                        type: 'linear',
                        position: 'left'
                    },
                    invoices_count: {
                        ticks: {
                            color: 'black',
                            font: {
                                family: "'Nunito', sans-serif",
                            }
                        },
                        beginAtZero: true,
                        type: 'linear',
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                },
                stacked: false,
                plugins: {
                    legend: {
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                size: 14,
                                family: "'Nunito', sans-serif",
                                weight: 'bold'
                            }
                        },
                    }
                }
            }
        });
        // const ctx = $('#myChart2');
        // const ctx = 'myChart2';

        function displayChart(group = 'monthly'){
            fetch("{{route('sales-charts')}}?group="+group)
                .then(response => response.json())
                .then(json => {
                    myChart2.data.labels = json.labels;
                    myChart2.data.datasets= json.datasets;
                    myChart2.update();
                });
        }

        $('.btn-group .btn input').on('click', function (e){
            e.preventDefault();
            displayChart($(this).data('group'));
        });

        displayChart();


    </script>

    <script>
        const ctx2 = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx2, {
            type: 'bar',
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: 'black',
                            font: {
                                family: "'Nunito', sans-serif",
                            }
                        },
                    },
                    y: {
                        ticks: {
                            color: 'black',
                            font: {
                                family: "'Nunito', sans-serif",
                            }
                        },
                        beginAtZero: true,
                        type: 'linear',
                        position: 'left'
                    },
                    payment_status_count: {
                        ticks: {
                            color: 'black',
                            font: {
                                family: "'Nunito', sans-serif",
                            }
                        },
                        beginAtZero: true,
                        type: 'linear',
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                size: 14,
                                family: "'Nunito', sans-serif",
                                weight: 'bold'
                            }
                        },
                    }
                }
            }
        });

        function paymentStatusChart(year = {{$thisYear}}) {
            fetch("{{route('sales-payment-status-charts')}}?year="+year)
                .then(response => response.json())
                .then(json => {
                    myChart.data.labels = json.labels;
                    myChart.data.datasets= json.datasets;
                    myChart.update();
                });
        }

        $('.btn-toolbar .btn-group button').on('click', function (e){
            e.preventDefault();
            paymentStatusChart($(this).data('year'));
            $(this).addClass('active').siblings().removeClass('active');
        });

        paymentStatusChart();
    </script>


@endsection
