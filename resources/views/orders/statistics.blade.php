@extends('layouts.master')
@section('title','new order')
@section('content')

<?php
use Carbon\Carbon;
$staDate = Carbon::now()->addMonth(4);
?>
<div class="container">
    <div class="jumbotron col-md-6 col-md-offset-3 col-xs-12">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            其他月份 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @for($i = 0; $i <= 7; $i++)
                <li><a href=" {{ route('orders.statistics',['thisYear'=>$staDate->subMonth()->year, '$thisMonth'=>$staDate->month]) }} "> {{$staDate->year}}/{{$staDate->month}} </a></li>
                @endfor
            </ul>
        </div>
        <h1>{{ $thisYear }} / {{ $thisMonth }} 總結</h1>
        <p>
            Total : {{$total}}
        </p>
        <!-- Single button -->
        <div class="panel panel-success">
            <!-- Default panel contents -->
            <div class="panel-heading">房型</div>
            <ul class="list-group">
                @foreach($roomSta as $roomName => $count)
                <li class="list-group-item">
                    <span class="badge">{{$count}}</span>
                    {{$roomName}}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">訂單管道</div>
            <ul class="list-group">
                @foreach($placeSta as $placeName => $count)
                <li class="list-group-item">
                    <span class="badge">{{$count}}</span>
                    {{$placeName}}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection