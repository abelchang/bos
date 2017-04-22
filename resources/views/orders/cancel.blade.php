@extends('layouts.master')
@section('title','取消訂單')
@section('content')
<?php
use Carbon\Carbon;
?>
<div class="container" id="swipePage">
	@foreach ($orders as $key=>$order)

	<div class="panel panel-default col-md-3 col-xs-12">
	    <div class="panel-body">
	        <div class="container-fluid" style="padding:0;">
	            <div class="row">
	                <div class="col-md-12">
	                    <h2 style="margin-top:0;">{{ $order->orderRoom->name }} - {{Carbon::parse($order->checkout)->diffInDays(Carbon::parse($order->checkin))}}夜</h2>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-md-8">
	                    @if($order->status!=null)
	                    <span class="badge" style="margin-left:10px;"> {{ $order->orderStatus->status }} </span>
	                    @endif
	                    @if($order->orderPlace!=null)
	                    <span class="badge" style="margin-left:10px;"> {{ $order->place->name }} </span>
	                    @endif
	                </div>
	                <div class="text-right">
	                    ${{ $order->backPay }}/${{ $order->price }}
	                </div>
	            </div>
	            <hr style="margin:10px 0;" />
	            <div class="row">
	                <div class="col-md-12" style="">
	                    {{ Carbon::parse($order->checkin)->format("m/d") }} - {{Carbon::parse($order->checkout)->format("m/d") }}
	                    <div class="panel-group">
	                        <div class="panel panel-default">
	                            <div class="panel-heading">
	                                <h4 class="panel-title">
	                                <a data-toggle="collapse" href="#orderCollapse{{$order->id}}">{{(!empty($order->customer))?"$order->customer":'info'}}</a>
	                                </h4>
	                                <br>
	                                <ul class="list-group">
	                                    <li class="list-group-item">memo:{{$order->memo}}</li>
	                                </ul>
	                            </div>
	                            <div id="orderCollapse{{$order->id}}" class="panel-collapse collapse">
	                                <ul class="list-group">
	                                    <li class="list-group-item">phone:<a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></li>
	                                    <!-- <li class="list-group-item">price:{{$order->price}}</li> -->
	                                    <li class="list-group-item">BD:{{$order->birthday}}</li>
	                                    <li class="list-group-item">BDP:{{$order->placeOfBirth}}</li>
	                                </ul>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="row" style="margin-top:10px;">
	                
	                <form method="POST" action="{{ route('orders.destroy',['order'=>$order->id]) }}" onsubmit="confirm("Are you sure?")">
	                    {{ csrf_field() }}
	                    <span style="padding-left: 10px;">
	                        <a class="btn btn-xs btn-primary" href="{{ route('orders.edit',['order'=>$order->id]) }}">
	                            <i class="glyphicon glyphicon-pencil"></i>
	                            <span style="padding-left: 5px;">edit order</span>
	                        </a>
	                        <input type="hidden" name="_method" value="DELETE" />
	                        <button type="submit" class="btn btn-xs btn-danger" data-submit-confirm-text="Are you sure?" >
	                        <i class="glyphicon glyphicon-trash"></i>
	                        <span style="padding-left: 5px;">delete order</span>
	                        </button>
	                    </span>
	                </form>
	                
	            </div>
	        </div>
	    </div>
	</div>
	@endforeach    
</div>
<script>
    $(function () {
        $("[data-submit-confirm-text]").click(function(e){
            var $el = $(this);
            e.preventDefault();
            var confirmText = $el.attr('data-submit-confirm-text');
            bootbox.confirm(confirmText, function(result) {
            if (result) {
                $el.closest('form').submit();
            }
            });
        });
    });
</script>
        
@endsection
