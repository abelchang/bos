@extends('layouts.master')
@section('title','search')
@section('content')
<?php
use Carbon\Carbon;
?>
<div class="container">
	<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">search</div>
		<!-- Table -->
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>#</th>
					<th>姓名</th>
					<th>入住日期</th>
					<th>天數</th>
					<th>訂房管道</th>
					<!-- <th>mome</th> -->
					<!-- <th>電話</th> -->
					<!-- <th>出生地</th> -->
					<!-- <th>地址</th> -->
				</tr>
			</thead>
			
			<tbody>
				@foreach ($orders as $key=>$order)
				<tr>
					<th scope="row">{{$key+1}}</th>
					<td>
						<a data-toggle="collapse" href="#orderCollapse{{$order->id}}">{{$order->customer}}</a>
						<div id="orderCollapse{{$order->id}}" class="panel-collapse collapse">
							<ul class="list-group">
								<li class="list-group-item">phone:<a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></li>
								<li class="list-group-item">MOME:{{$order->mome}}</li>
								<li class="list-group-item">price:{{$order->price}}</li>
								<li class="list-group-item">BD:{{$order->birthday}}</li>
								<li class="list-group-item">BDP:{{$order->placeOfBirth}}</li>
								<li class="list-group-item">ADR:{{$order->address}}</li>
							</ul>
						</div>
					</td>
					<td>{{Carbon::parse($order->checkin)->format('m/d')}}</td>
					<td>{{Carbon::parse($order->checkout)->diffInDays(Carbon::parse($order->checkin))}}</td>
					<td>{{$order->place->name}}</td>
					<!-- <td>{{$order->mome}}</td> -->
					<!-- <td>{{$order->phone}}</td> -->
					<!-- <td>{{$order->placeOfBirth}}</td> -->
					<!-- <td>{{$order->address}}</td> -->
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection