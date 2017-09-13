@extends('layouts.master')
@section('title','所有訂單')
@section('content')
<?php
use Carbon\Carbon;
$indexDate = Carbon::today()->addMonth(4);
$thisDay = Carbon::create($thisYear,$thisMonth,1,0,0,0);
$olderDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->subMonth();
$nextDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->addMonth();
?>
<div class="container" id="swipePage">
    <nav aria-label="..." >
        <ul class="pager" >
            <li class="previous"><a id="previousLink" href="{{ route('orders.showByMonth',['thisYear'=>$olderDate->year,'thisMonth'=>$olderDate->month]) }}"><span aria-hidden="true">&larr;</span> Older</a></li>
            <li class="next"><a  id="nextLink" href="{{ route('orders.showByMonth',['thisYear'=>$nextDate->year,'thisMonth'=>$nextDate->month]) }}">Newer <span aria-hidden="true">&rarr;</span></a></li>
        </ul>
    </nav>
    <div id="gotop-left">
        <a href="{{ route('orders.showByMonth',['thisYear'=>$olderDate->year,'thisMonth'=>$olderDate->month]) }}"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    </div>
    <div id="gotop-right">
        <a href="{{ route('orders.showByMonth',['thisYear'=>$nextDate->year,'thisMonth'=>$nextDate->month]) }}"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
    </div>

    <div class="row">
        <h4>
        <div class="pull-right">
            <a class="btn btn-xs btn-danger" href="{{ route('orders.create') }}" style="margin-left: 20px;">
                <i class="glyphicon glyphicon-plus"></i>
                <!-- <span style="padding-left: 5px;">新訂單</span> -->
            </a>
            <div class="btn-group">
              <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="glyphicon glyphicon-search"></i>
                月份 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                @for($i = 0; $i <= 7; $i++)
                <li><a href=" {{ route('orders.showByMonth',['thisYear'=>$indexDate->subMonth()->year, '$thisMonth'=>$indexDate->month]) }} "> {{$indexDate->year}}/{{$indexDate->month}} </a></li>
                @endfor
              </ul>
            </div>  
            <a class="btn btn-xs btn-primary" href="{{ route('orders.statistics',['thisYear'=>$thisDay->year,'thisMonth'=>$thisDay->month]) }}">
                <!-- <i class="glyphicon glyphicon-plus"></i> -->
                <span style="padding-left: 5px;">本月統計</span>
            </a>
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

        @if((count($orders) > 0) and ($thisDay->month == Carbon::now()->month))
        <a class="btn btn-xs btn-default" id="showOrders" style="margin-left: 6px;">
            <span>+</span>
        </a>
        @endif
        <br>     
        </h4>
        <hr />
        @if(count($orders) == 0)
        <p class="text-center">
            沒有任何訂單
        </p>
        @endif
        
        @while ($thisDay->month == $thisMonth)
        <section id="{{ $thisDay->toDateString() }}" class="{{ ( ($thisDay < Carbon::today()) and ($thisDay->month == Carbon::now()->month) )?'overDateOrders':''}}" >
        @if($thisDay->lt(Carbon::today()))
        <div class="panel panel-default">
            <!-- 2017 -->
            <!-- 2017 元旦 2016/12/31 - 01/02 -->
            @elseif ( $thisDay->between(Carbon::create(2016, 12, 31), Carbon::create(2017, 1, 2)) )
            <div class="panel panel-danger">
            <!-- 2017 春節 01/27 - 02/01 -->
            @elseif ( $thisDay->between(Carbon::create(2017, 1, 27), Carbon::create(2017, 2, 1)) )
            <div class="panel panel-danger">
            <!-- 2017 228紀念日 02/25 - 02/28 -->
            @elseif ( $thisDay->between(Carbon::create(2017, 2, 25), Carbon::create(2017, 2, 28)) )
            <div class="panel panel-danger">
            <!-- 2017 兒童節 04/01 - 04/04 -->
            @elseif ( $thisDay->between(Carbon::create(2017, 4, 1), Carbon::create(2017, 4, 4)) )
            <div class="panel panel-danger">
            <!-- 2017 勞動節 04/29 - 05/01 -->
            @elseif ( $thisDay->between(Carbon::create(2017, 4, 29), Carbon::create(2017, 5, 1)) )
            <div class="panel panel-danger">
            <!-- 2017 端午節 05/27 - 05/30 -->
            @elseif ( $thisDay->between(Carbon::create(2017, 5, 27), Carbon::create(2017, 5, 30)) )
            <div class="panel panel-danger">
            <!-- 2017 中秋節 10/04 -->
            @elseif ( $thisDay == (Carbon::create(2017, 10, 4)) )
            <div class="panel panel-danger">
            <!-- 2017 國慶日 10/07 - 10/10 -->
            @elseif ( $thisDay->between(Carbon::create(2017, 10, 7), Carbon::create(2017, 10, 10)) )
            <div class="panel panel-danger">
            <!-- 2018 -->
            <!-- 2018 元旦 2017/12/30 - 01/01 -->
            @elseif ( $thisDay->between(Carbon::create(2017, 12, 30), Carbon::create(2018, 1, 1)) )
            <div class="panel panel-danger">
            <!-- 2018 春節 02/15 - 02/20 -->
            @elseif ( $thisDay->between(Carbon::create(2018, 2, 15), Carbon::create(2018, 2, 20)) )
            <div class="panel panel-danger">
            <!-- 2018 228紀念日 02/28 - 02/28 -->
            @elseif ( $thisDay->between(Carbon::create(2018, 2, 27), Carbon::create(2018, 2, 28)) )
            <div class="panel panel-danger">
            <!-- 2018 兒童節 04/04 - 04/08 -->
            @elseif ( $thisDay->between(Carbon::create(2018, 4, 4), Carbon::create(2018, 4, 8)) )
            <div class="panel panel-danger">
            <!-- 2018 勞動節 05/01 -->
            @elseif ( $thisDay->between(Carbon::create(2018, 4, 30), Carbon::create(2018, 5, 1)) )
            <div class="panel panel-danger">
            <!-- 2018 端午節 6/16 - 6/18-->
            @elseif ( $thisDay->between(Carbon::create(2018, 6, 16), Carbon::create(2018, 6, 18)) )
            <div class="panel panel-danger">
            <!-- 2018 中秋節 9/22 - 9/24-->
            @elseif ( $thisDay->between(Carbon::create(2018, 9, 22), Carbon::create(2018, 9, 24)) )
            <div class="panel panel-danger">
            <!-- 2018 國慶日 10/10 -->
            @elseif ( $thisDay->between(Carbon::create(2018, 10, 9), Carbon::create(2018, 10, 10)) )
            <div class="panel panel-danger">
            <!-- 2018 元旦 12/29 - 1/1 -->
            @elseif ( $thisDay->between(Carbon::create(2018, 12, 29), Carbon::create(2019, 1, 1)) )
            <div class="panel panel-danger">
            <!-- 一般週末 -->
            @elseif ( ($thisDay->dayOfWeek == (Carbon::FRIDAY)) || ($thisDay->dayOfWeek == (Carbon::SATURDAY)) )
            <div class="panel panel-danger">
                @else
                <div class="panel panel-success">
                    @endif
                    
                    <div class="panel-heading">
                        <h3 class="panel-title">
                        <a data-toggle="collapse" href="#collapse{{$thisDay->year}}{{$thisDay->month}}{{$thisDay->day}}"><span class="titleDate">{{$thisDay->format('D m/d')}}</span>
                            @if ($thisDay == Carbon::today())
                                <span class="label label-default label-as-badge holidayBadge">Today</span>
                            @endif
                            <!-- 2017 元旦 2016/12/31 - 01/02 -->
                            @if ( $thisDay->between(Carbon::create(2016, 12, 31), Carbon::create(2017, 1, 2)) )
                                <span class="label label-primary label-as-badge holidayBadge">元旦</span>
                            <!-- 2017 春節 01/27 - 02/01 -->
                            @elseif ( $thisDay->between(Carbon::create(2017, 1, 27), Carbon::create(2017, 2, 1)) )
                                <span class="label label-primary label-as-badge holidayBadge">春節</span>
                            <!-- 2017 228紀念日 02/25 - 02/28 -->
                            @elseif ( $thisDay->between(Carbon::create(2017, 2, 25), Carbon::create(2017, 2, 28)) )
                                <span class="label label-primary label-as-badge holidayBadge">228</span>
                            <!-- 2017 兒童節 04/01 - 04/04 -->
                            @elseif ( $thisDay->between(Carbon::create(2017, 4, 1), Carbon::create(2017, 4, 4)) )
                                <span class="label label-primary label-as-badge holidayBadge">兒童節</span>
                            <!-- 2017 勞動節 04/29 - 05/01 -->
                            @elseif ( $thisDay->between(Carbon::create(2017, 4, 29), Carbon::create(2017, 5, 1)) )
                                <span class="label label-primary label-as-badge holidayBadge">勞動節</span>
                            <!-- 2017 端午節 05/27 - 05/30 -->
                            @elseif ( $thisDay->between(Carbon::create(2017, 5, 27), Carbon::create(2017, 5, 30)) )
                                <span class="label label-primary label-as-badge holidayBadge">端午節</span>
                            <!-- 2017 中秋節 10/04 -->
                            @elseif ( $thisDay == (Carbon::create(2017, 10, 4)) )
                                <span class="label label-primary label-as-badge holidayBadge">中秋節</span>
                            <!-- 2017 國慶日 10/07 - 10/10 -->
                            @elseif ( $thisDay->between(Carbon::create(2017, 10, 7), Carbon::create(2017, 10, 10)) )
                                <span class="label label-primary label-as-badge holidayBadge">國慶日</span>
                            <!-- 2018 -->
                            <!-- 2018 元旦 2017/12/30 - 01/01 -->
                            @elseif ( $thisDay->between(Carbon::create(2017, 12, 30), Carbon::create(2018, 1, 1)) )
                                <span class="label label-primary label-as-badge holidayBadge">元旦</span>
                            <!-- 2018 春節 02/15 - 02/20 -->
                            @elseif ( $thisDay->between(Carbon::create(2018, 2, 15), Carbon::create(2018, 2, 20)) )
                                <span class="label label-primary label-as-badge holidayBadge">春節</span>
                            <!-- 2018 228紀念日 02/28 - 02/28 -->
                            @elseif ( $thisDay->between(Carbon::create(2018, 2, 27), Carbon::create(2018, 2, 28)) )
                                <span class="label label-primary label-as-badge holidayBadge">228</span>
                            <!-- 2018 兒童節 04/04 - 04/08 -->
                            @elseif ( $thisDay->between(Carbon::create(2018, 4, 4), Carbon::create(2018, 4, 8)) )
                                <span class="label label-primary label-as-badge holidayBadge">兒童節</span>
                            <!-- 2018 勞動節 05/01 -->
                            @elseif ( $thisDay->between(Carbon::create(2018, 4, 30), Carbon::create(2018, 5, 1)) )
                                <span class="label label-primary label-as-badge holidayBadge">勞動節</span>
                            <!-- 2018 端午節 6/16 - 6/18-->
                            @elseif ( $thisDay->between(Carbon::create(2018, 6, 16), Carbon::create(2018, 6, 18)) )
                                <span class="label label-primary label-as-badge holidayBadge">端午節</span>
                            <!-- 2018 中秋節 9/22 - 9/24-->
                            @elseif ( $thisDay->between(Carbon::create(2018, 9, 22), Carbon::create(2018, 9, 24)) )
                                <span class="label label-primary label-as-badge holidayBadge">中秋節</span>
                            <!-- 2018 國慶日 10/10 -->
                            @elseif ( $thisDay->between(Carbon::create(2018, 10, 9), Carbon::create(2018, 10, 10)) )
                                <span class="label label-primary label-as-badge holidayBadge">國慶日</span>
                            <!-- 2018 元旦 12/29 - 1/1 -->
                            @elseif ( $thisDay->between(Carbon::create(2018, 12, 29), Carbon::create(2019, 1, 1)) )
                                 <span class="label label-primary label-as-badge holidayBadge">元旦</span>
                            @endif
                            @if($thisDay >= Carbon::today())
                            <a class="btn btn-xs btn-danger pull-right" href="{{ route('orders.create',['thisYear'=>$thisDay->year ,'thisMonth'=>$thisDay->month ,'thisDay'=>$thisDay->day]) }}" style="margin-left: 5px; color: white;">
                                <i class="glyphicon glyphicon-plus"></i>                      
                            </a>
                            @endif
                            @foreach ($orders as $key=>$order)
                            @if(Carbon::parse($order->checkout)->eq($thisDay))
                                <span class="label label-default label-as-badge checkoutBadge" >{{$order->orderRoom->name}}</span>
                            @endif
                            @endforeach
                            <br>
                            @foreach ($orders as $key=>$order)
                            <!-- @if(Carbon::parse($order->checkin)->eq($thisDay))
                                <span class="badge roomsBadge" >{{$order->orderRoom->name}}</span>
                            @endif -->
                            @if(
                            (
                            ( (Carbon::parse($order->checkin)->year === $thisDay->year) and (Carbon::parse($order->checkin)->month === $thisDay->month) )
                            or( (Carbon::parse($order->checkout)->year === $thisDay->year) and (Carbon::parse($order->checkout)->month === $thisDay->month) )
                            )
                            and ((Carbon::parse($order->checkin)->lte($thisDay)) and (Carbon::parse($order->checkout)->gt($thisDay)))
                            
                            )
                                <span class="badge roomsBadge" >{{$order->orderRoom->name}}{{Carbon::parse($order->checkin)->diffInDays($thisDay)+1}}</span>
                            @endif
                            <!-- @if(Carbon::parse($order->checkout)->eq($thisDay))
                                <span class="badge roomsBadge checkoutBadge" >{{$order->orderRoom->name}}</span>
                            @endif -->
                            @endforeach
                        </a>
                        </h3>
                    </div>
                    
                    <div id="collapse{{$thisDay->year}}{{$thisDay->month}}{{$thisDay->day}}" class="panel-collapse collapse {{($thisDay == Carbon::today())?'in':''}} ">
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
                                                <span id="status{{$order->id}}" class="badge" style="margin-left:10px;"> {{ $order->orderStatus->status }} </span>
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
                                                            <a data-toggle="collapse" href="#orderCollapse{{$order->id}}{{$thisDay->day}}">{{(!empty($order->customer))?"$order->customer":'info'}}</a>
                                                            </h4>
                                                            <br>
                                                            <ul class="list-group">
                                                                <li class="list-group-item">memo:{{$order->memo}}</li>
                                                            </ul>
                                                        </div>
                                                        <div id="orderCollapse{{$order->id}}{{$thisDay->day}}" class="panel-collapse collapse">
                                                            <ul class="list-group">
                                                                <li class="list-group-item">phone:<a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></li>
                                                                <!-- <li class="list-group-item">price:{{$order->price}}</li> -->
                                                                <li class="list-group-item">BD:{{$order->birthday}}</li>
                                                                <li class="list-group-item">BDP:{{$order->placeOfBirth}}</li>
                                                                <li class="list-group-item">ADR:{{$order->address}}</li>
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
                                                    <!-- <input type="hidden" name="_method" value="DELETE" />
                                                    <button type="submit" class="btn btn-xs btn-danger" data-submit-confirm-text="Are you sure?" >
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                    <span style="padding-left: 5px;">delete order</span>
                                                    </button> -->
                                                    <div class="btn-group dropup">
                                                      <button type="button" class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="glyphicon glyphicon-eye-open"></i>
                                                        訂單狀態 <span class="caret"></span>
                                                      </button>
                                                      <ul class="dropdown-menu">
                                                        @foreach( $orderStatus as $thisStatus)
                                                        <li class="statusAjax" data-id="{{$order->id}}" data-value="{{$thisStatus->id}}" data-url="{{route('orders.updateStatus')}}">{{$thisStatus->status}}</li>
                                                        @endforeach
                                                      </ul>
                                                    </div>
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
                </section>
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