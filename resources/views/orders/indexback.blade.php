@extends('layouts.master')

@section('title','所有訂單')

@section('content')

<?php

use Carbon\Carbon;
$now = Carbon::now();

?>

<div class="container">
    <a href="{{ route('orders.showByMonth',['month'=>$now->month]) }}" >showbymonth orders</a>
    
    <div class="row">    
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rooms
            <span class="caret"></span> 
            </button>
            <ul class="dropdown-menu">
                <li><a href="{{ route('orders.index') }}" >All Rooms</a></li>
                @foreach ($rooms as $room)
                <li><a href="{{ route('rooms.show',['roomsType'=>$room->id]) }}" >
                    {{ $room->name }}
                </a></li>
                @endforeach
                <li>
                    <a href="{{ route('rooms.create') }}" class="list-group-item">create new room</a>
                </li>
            </ul>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OrderPlace
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="{{ route('orders.index') }}" >All OrderPlace</a></li>
                @foreach ($orderPlaces as $orderPlace)
                <li><a href="{{ route('orderPlace.show',['placeType'=>$orderPlace->id]) }}" >
                    {{ $orderPlace->name }}
                </a></li>
                @endforeach
                <li>
                    <a href="{{ route('orderPlace.create') }}" class="list-group-item">create new place</a>
                </li>
            </ul>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OrderStatus
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('orders.index') }}">All Status</a>
                </li>
                @foreach ($orderStatus as $orderStatusOne)
                <li><a href="{{ route('orderStatus.show',['statusType'=>$orderStatusOne->id]) }}" >
                    {{ $orderStatusOne->status }}
                </a></li>
                @endforeach
                <li>
                    <a href="{{ route('orderStatus.create') }}" class="list-group-item">create new status</a>
                </li>
            </ul>
        </div>

		<!-- <div class="col-xs-12 col-md-4 pull-right">
			<div class="row">
				<div class="col-xs-4 col-md-12">
					<div class="list-group">
		                <a href="{{ route('orders.index') }}" class="list-group-item {{ (isset($roomType))?'':'active' }}">All Rooms</a>
		                @foreach ($rooms as $room)
		                    <a href="{{ route('rooms.show',['roomsType'=>$room->id]) }}" class="list-group-item {{ (isset($roomType))?(($roomType->id == $room->id)?'active':''):'' }}">
		                        {{ $room->name }}
		                    </a>
		                @endforeach
		                <a href="{{ route('rooms.create') }}" class="list-group-item">create new room</a>
		            </div>
		        </div>

				<div class="col-xs-4 col-md-12">
		            <div class="list-group">
		                <a href="{{ route('orders.index') }}" class="list-group-item {{ (isset($placeType))?'':'active' }}">All OrderPlace</a>
		                @foreach ($orderPlaces as $orderPlace)
		                    <a href="{{ route('orderPlace.show',['placeType'=>$orderPlace->id]) }}" class="list-group-item {{ (isset($placeType))?(($placeType->id == $orderPlace->id)?'active':''):'' }}">
		                        {{ $orderPlace->name }}
		                    </a>
		                @endforeach
		                <a href="{{ route('orderPlace.create') }}" class="list-group-item">create new place</a>
		            </div>
		        </div>

		        <div class="col-xs-4 col-md-12">
		            <div class="list-group">
		                <a href="{{ route('orders.index') }}" class="list-group-item {{ (isset($statusType))?'':'active' }}">All Status</a>
		                @foreach ($orderStatus as $orderStatusOne)
		                    <a href="{{ route('orderStatus.show',['statusType'=>$orderStatusOne->id]) }}" class="list-group-item {{ (isset($statusType))?(($statusType->id == $orderStatusOne->id)?'active':''):'' }}">
		                        {{ $orderStatusOne->status }}
		                    </a>
		                @endforeach
		                <a href="{{ route('orderStatus.create') }}" class="list-group-item">create new status</a>
		            </div>
		        </div>
			</div>
        </div> -->
        
        
        <div class="col-xs-12 ">
            <h4>

                <div class="pull-right">
                    <a class="btn btn-xs btn-default" href="{{ route('orders.create') }}" style="margin-left: 20px;">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span style="padding-left: 5px;">create order</span>
                    </a>
                </div>
                @if(isset($roomType))
                    Room: {{$roomType->name}}
                @elseif(isset($placeType))
                    Order Place: {{$placeType->name}}
                @elseif(isset($statusType))
                    Status: {{$statusType->status}}
                @else
                    All Orders
                @endif
                
            </h4>
            <hr />
            @if(count($orders) == 0)
                <p class="text-center">
                    沒有任何訂單
                </p>
            @endif
            @foreach ($orders as $order)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="container-fluid" style="padding:0;">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 style="margin-top:0;">{{ Carbon::parse($order->checkin)->format("l m/d") }}:住{{Carbon::parse($order->checkout)->diffInDays(Carbon::parse($order->checkin))}}晚 - {{ $order->orderRoom->name }}</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    @if($order->status!=null)
                                        <span class="badge" style="margin-left:10px;"> {{ $order->orderStatus->status }} </span>
                                    @endif
                                    <span class="badge" style="margin-left:10px;">{{ Carbon::parse($order->checkout)->diffInDays(Carbon::parse($order->checkin)) }}</span>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a>
                                </div>
                            </div>
                            <hr style="margin:10px 0;" />
                            <div class="row">
                                <div class="col-md-12" style="height:100px;overflow:hidden;">
                                    {{ $order->memo }}
                                </div>  
                            </div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-8">
                                    <form method="POST" action="{{ route('orders.destroy',['order'=>$order->id]) }}">
                                        {{ csrf_field() }}
                                        <span style="padding-left: 10px;">
                                            <a class="btn btn-xs btn-primary" href="{{ route('orders.edit',['order'=>$order->id]) }}">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                                <span style="padding-left: 5px;">edit order</span>
                                            </a>
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="glyphicon glyphicon-trash"></i>
                                                <span style="padding-left: 5px;">delete order</span>
                                            </button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
		
    </div>
    <div class="row">
        <div class="col-xs-8">
            @if(isset($keyword))
                {{ $orders->appends(['keyword' => $keyword])->render() }}
            @else
                {{ $orderss->render() }}
            @endif
        </div>
    </div>
</div>



@endsection