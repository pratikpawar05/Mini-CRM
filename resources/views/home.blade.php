@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Dashboard</h2><br><br>
            <div class="card" id="disappear">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card" style="width: 25rem;">
                        <div class="card-header bg-success">
                            Yesterday Added Employee Record&#128525;
                        </div>
                        <ul class="list-group list-group-flush scroll-view">
                            @foreach($employees as $emp)
                            <li class="list-group-item">{{$emp->first_name}} {{$emp->last_name}} </li>
                            @endforeach
                        </ul>
                        <div class="card-footer bg-success">
                            Total Employees:- {{$total_employees}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 25rem;">
                        <div class="card-header bg-success">
                            Yesterday Added Companies Record&#128525;
                        </div>
                        @if(count($companies)==0)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">No Companies Found</li>
                        </ul>
                        @else
                        <ul class="list-group list-group-flush scroll-view">
                            @foreach($companies as $company)
                            <li class="list-group-item">{{$company->name}}</li>
                            @endforeach
                        </ul>
                        @endif
                        <div class="card-footer bg-success">
                            Total Companies:-{{$total_companies}}
                        </div>
                    </div>
                </div>
            </div><br><br>
            <div class="row">
                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    setTimeout(function() {
        $('#disappear').hide('slow', function(e) {
            $(this).remove();
        });
    }, 1500);

    window.onload = function() {
        var options = {
            series: [{
                    name: "Companies",
                    data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
                },
                {
                    name: "Employees",
                    data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
                }
            ],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [5, 7, 5],
                curve: 'straight',
                dashArray: [0, 8, 5]
            },
            title: {
                text: 'Page Statistics',
                align: 'left'
            },
            legend: {
                tooltipHoverFormatter: function(val, opts) {
                    return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                }
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
                    '10 Jan', '11 Jan', '12 Jan'
                ],
            },
            tooltip: {
                y: [{
                    title: {
                        formatter: function(val) {
                            return val + " (mins)"
                        }
                    }
                }, {
                    title: {
                        formatter: function(val) {
                            return val;
                        }
                    }
                }]
            },
            grid: {
                borderColor: '#f1f1f1',
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
        chart.render();

    }
</script>
@endsection