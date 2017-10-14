@extends('layouts.master')
@section('title','new order')
@section('content')
<?php
use Carbon\Carbon;
$staDate = Carbon::now()->addMonth(4);
$olderDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->subMonth();
$nextDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->addMonth();
$thisDate = Carbon::createFromDate($thisYear,$thisMonth,'1');
$thisMonthTotalRooms = $thisDate->daysInMonth*count($roomSta);
$thisYearTotalRooms = $thisDate->dayOfYear*count($roomSta);
?>
<div class="container">
    <div class="jumbotron col-md-6 col-md-offset-3 col-xs-12">
        <nav aria-label="...">
            <ul class="pager">
                <li class="previous"><a href="{{ route('orders.statistics',['thisYear'=>$olderDate->year,'thisMonth'=>$olderDate->month]) }}"><span aria-hidden="true">&larr;</span> Older</a></li>
                <li class="next"><a href="{{ route('orders.statistics',['thisYear'=>$nextDate->year,'thisMonth'=>$nextDate->month]) }}">Newer <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
        <div class="btn-group">
            <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="glyphicon glyphicon-calendar"></i>
            其他月份 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @for($i = 0; $i <= 7; $i++)
                <li><a href=" {{ route('orders.statistics',['thisYear'=>$staDate->subMonth()->year, '$thisMonth'=>$staDate->month]) }} "> {{$staDate->year}}/{{$staDate->month}} </a></li>
                @endfor
                <li role="separator" class="divider"></li>
                <li><a href=" {{ route('orders.statistics',['thisYear'=>Carbon::now()->year, '$thisMonth'=>'']) }} "> {{Carbon::now()->year}} </a></li>
                <li><a href=" {{ route('orders.statistics',['thisYear'=>Carbon::now()->subYear()->year, '$thisMonth'=>'']) }} "> {{Carbon::now()->subYear()->year}} </a></li>
            </ul>
        </div>
        <h1>{{ $thisYear }} / {{ $thisMonth }} 總結</h1>
        <p>
            Total : {{$total}}
        </p>
        <!-- Single button -->
        <div class="panel panel-success" id="orderRooms">
            <!-- Default panel contents -->
            <div class="panel-heading">房型</div>
            <ul class="list-group">
                <?php $countTotal = 0; ?>
                @foreach($roomSta as $roomName => $count)
                <a href="#orderRooms" class="list-group-item">
                    @if($index == "year")
                    <span class="badge">{{number_format($count/$thisDate->dayOfYear*100).'%'}}</span>
                    @elseif($index == "month")
                    <span class="badge">{{number_format($count/$thisDate->daysInMonth*100).'%'}}</span>
                    @endif
                    <span class="badge">{{$count}}</span>
                    {{$roomName}}
                    <?php $countTotal+=$count; ?>
                </a>
                @endforeach
                <li class="list-group-item list-group-item-warning">
                    @if($index == "year")
                    <span class="badge">{{number_format($countTotal/$thisYearTotalRooms*100).'%'}}</span>
                    @elseif($index == "month")
                    <span class="badge">{{number_format($countTotal/$thisMonthTotalRooms*100).'%'}}</span>
                    @endif
                    <span class="badge">{{$countTotal}}</span>
                    Total
                </li>
            </ul>
        </div>
        @if($index == "year")
        <div class="panel panel-success" id="orderRooms">
            <!-- Default panel contents -->
            <div class="panel-heading">月份</div>
            <ul class="list-group">
                <?php $countTotal = 0; ?>
                @foreach($monthPrice as $key => $month)
                <a href="" class="list-group-item">
                    <span class="badge">{{$month->sums}}</span>
                    {{$month->months}}
                    <?php $countTotal+=$month->sums; ?>
                </a>
                @endforeach
                <li class="list-group-item list-group-item-warning">
                    <span class="badge">{{$countTotal}}</span>
                    Total
                </li>
            </ul>
        </div>
        @endif
        <div class="panel panel-info" id="orderPlace">
            <!-- Default panel contents -->
            <div class="panel-heading">訂單管道</div>
            <ul class="list-group">
                <?php $countTotal = 0; ?>
                @foreach($placeSta as $placeName => $count)
                <a href="#orderPlace" class="list-group-item">
                    <span class="badge">{{$count}}</span>
                    {{$placeName}}
                    <?php $countTotal+=$count; ?>
                </a>
                @endforeach
                <li class="list-group-item list-group-item-warning">
                    <span class="badge">{{$countTotal}}</span>
                    Total
                </li>
            </ul>
        </div>
        <script type="text/javascript" src="{{ asset('bower/chart.js/dist/chart.bundle.min.js') }}" ></script>
        <canvas id="myChart" width="800" height="400"></canvas>
        <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'line',
        data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
        }]
        },
        options: {
        scales: {
        yAxes: [{
        ticks: {
        beginAtZero:true
        }
        }]
        }
        }
        });
        </script>
    </div>
</div>
@endsection