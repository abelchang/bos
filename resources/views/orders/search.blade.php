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
					<th>action</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach ($orders as $key=>$order)
				<tr>
					<th scope="row">{{$key+1}}</th>
					<td>
						<a class="" data-toggle="modal" data-target="#orderCollapse{{$order->id}}">{{$order->customer}}</a>
					</td>
					<td>{{Carbon::parse($order->checkin)->format('Y/m/d')}}</td>
					<td>{{Carbon::parse($order->checkout)->diffInDays(Carbon::parse($order->checkin))}}</td>
					<td>{{$order->place->name}}</td>
					<td>
						<a class="btn btn-xs btn-primary" href="{{ route('orders.edit',['order'=>$order->id]) }}">
	                        <i class="glyphicon glyphicon-pencil"></i>
	                        <!-- <span style="padding-left: 5px;">edit order</span> -->
	                    </a>
	                </td>
					  <!-- Modal -->
				  <div class="modal fade" id="orderCollapse{{$order->id}}" role="dialog">
				    <div class="modal-dialog">
				    
				      <!-- Modal content-->
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          <h4 class="modal-title">{{$order->customer}}</h4>
				          <h4>入住：{{Carbon::parse($order->checkin)->format('Y/m/d')}}</h4>
				          <h4>天數：{{Carbon::parse($order->checkout)->diffInDays(Carbon::parse($order->checkin))}}</h4>
				        </div>
				        <div class="modal-body">
				          <ul class="list-group">
								<li class="list-group-item">phone:<a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></li>
								<li class="list-group-item">MOME:{{$order->mome}}</li>
								<li class="list-group-item">price:{{$order->price}}</li>
								<li class="list-group-item">Place:{{$order->place->name}}</li>
								<li class="list-group-item">BD:{{$order->birthday}}</li>
								<li class="list-group-item">BDP:{{$order->placeOfBirth}}</li>
								<li class="list-group-item">ADR:{{$order->address}}</li>
							</ul>
				        </div>
				        <div class="modal-footer">
				        	<a class="btn btn-primary" href="{{ route('orders.edit',['order'=>$order->id]) }}" role="button">
								<i class="glyphicon glyphicon-pencil"></i>
	                        	<span style="padding-left: 5px;">edit order</span>
				        	</a>
				          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
				      </div>
				      
				    </div>
				  </div>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection