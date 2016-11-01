@extends('layouts.master')
@section('title','所有訂單')
@section('content')
<?php
use Carbon\Carbon;
$indexDate = Carbon::now()->addMonth(4);
$thisDay = Carbon::createFromDate($thisYear,$thisMonth,'1');
$olderDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->subMonth();
$nextDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->addMonth();
?>
<div class="container">
    <nav aria-label="...">
        <ul class="pager">
            <li class="previous"><a href="{{ route('orders.showByMonth',['thisYear'=>$olderDate->year,'thisMonth'=>$olderDate->month]) }}"><span aria-hidden="true">&larr;</span> Older</a></li>
            <li class="next"><a href="{{ route('orders.showByMonth',['thisYear'=>$nextDate->year,'thisMonth'=>$nextDate->month]) }}">Newer <span aria-hidden="true">&rarr;</span></a></li>
        </ul>
    </nav>
    <div class="row">
        <!-- <div class="btn-group">
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
        </div> -->
        
        <h4>
        <div class="pull-right">
            <a class="btn btn-xs btn-danger" href="{{ route('orders.create') }}" style="margin-left: 20px;">
                <i class="glyphicon glyphicon-plus"></i>
                <span style="padding-left: 5px;">新訂單</span>
            </a>
            <div class="btn-group">
              <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="glyphicon glyphicon-search"></i>
                月份查詢 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                @for($i = 0; $i <= 7; $i++)
                <li><a href=" {{ route('orders.showByMonth',['thisYear'=>$indexDate->subMonth()->year, '$thisMonth'=>$indexDate->month]) }} "> {{$indexDate->year}}/{{$indexDate->month}} </a></li>
                @endfor
              </ul>
            </div>
            
        </div>
        @if(isset($roomType))
        Room: {{$roomType->name}}
        @elseif(isset($placeType))
        Order Place: {{$placeType->name}}
        @elseif(isset($statusType))
        Status: {{$statusType->status}}
        @else
        {{$thisYear}}/{{$thisMonth}}月
        @endif
        
        </h4>
        <hr />
        @if(count($orders) == 0)
        <p class="text-center">
            沒有任何訂單
        </p>
        @endif
        
        @while ($thisDay->month == $thisMonth)
        @if($thisDay < Carbon::now())
        <div class="panel panel-default">
            @elseif ( ($thisDay->dayOfWeek == (Carbon::FRIDAY)) || ($thisDay->dayOfWeek == (Carbon::SATURDAY)) )
            <div class="panel panel-danger">
                @else
                <div class="panel panel-success">
                    @endif
                    
                    <div class="panel-heading">
                        <h3 class="panel-title">
                        <a data-toggle="collapse" href="#collapse{{$thisDay->year}}{{$thisDay->month}}{{$thisDay->day}}">{{$thisDay->format('l m/d')}}
                            @if ($thisDay == Carbon::now())
                                <span class="badge">Today</span>
                            @endif

                            @foreach ($orders as $key=>$order)
                            @if(
                            (
                            ( (Carbon::parse($order->checkin)->year === $thisDay->year) and (Carbon::parse($order->checkin)->month === $thisDay->month) )
                            or( (Carbon::parse($order->checkout)->year === $thisDay->year) and (Carbon::parse($order->checkout)->month === $thisDay->month) )
                            )
                            and ((Carbon::parse($order->checkin)->lte($thisDay)) and (Carbon::parse($order->checkout)->gt($thisDay)))
                            )
                            <span class="badge">{{$order->orderRoom->name}}</span>
                            @endif
                            @endforeach
                            <a class="btn btn-xs btn-danger pull-right" href="{{ route('orders.create',['thisYear'=>$thisDay->year ,'thisMonth'=>$thisDay->month ,'thisDay'=>$thisDay->day]) }}" style="margin-left: 20px; color: white;">
                                <i class="glyphicon glyphicon-plus"></i>
                                        
                            </a>
 
                        
                        </a>
                        </h3>
                    </div>
                    
                    <div id="collapse{{$thisDay->year}}{{$thisDay->month}}{{$thisDay->day}}" class="panel-collapse collapse {{($thisDay == Carbon::now())?'in':''}} ">
                        <div class="panel-body">
                            @foreach ($orders as $key=>$order)
                            @if(
                            (
                            ( (Carbon::parse($order->checkin)->year === $thisDay->year) and (Carbon::parse($order->checkin)->month === $thisDay->month) )
                            or( (Carbon::parse($order->checkout)->year === $thisDay->year) and (Carbon::parse($order->checkout)->month === $thisDay->month) )
                            )
                            and ((Carbon::parse($order->checkin)->lte($thisDay)) and (Carbon::parse($order->checkout)->gt($thisDay)))
                            )
                            
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
                                                ${{ $order->backPay }}
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
                                                            <a data-toggle="collapse" href="#orderCollapse{{$order->id}}{{$thisDay->day}}">{{(!empty($order->customer))?"$order->customer":'info'}}</a>
                                                            </h4>
                                                        </div>
                                                        <div id="orderCollapse{{$order->id}}{{$thisDay->day}}" class="panel-collapse collapse">
                                                            <ul class="list-group">
                                                                <li class="list-group-item">memo:{{$order->memo}}</li>
                                                                <li class="list-group-item">phone:<a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></li>
                                                                <li class="list-group-item">price:{{$order->price}}</li>
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
                            @endif
                            @endforeach
                            <?php
                            $thisDay->addDay();
                            ?>
                        </div>
                    </div>
                </div>
                @endwhile
                
            </div>
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