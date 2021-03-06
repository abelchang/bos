@extends('layouts.master')
@section('title','年度統計')
@section('content')
<?php
use Carbon\Carbon;
// $staDate = Carbon::now()->addMonth(4);
// $olderDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->subMonth();
// $nextDate = Carbon::createFromDate($thisYear,$thisMonth,'1')->addMonth();
// $thisDate = Carbon::createFromDate($thisYear,$thisMonth,'1');
// $thisMonthTotalRooms = $thisDate->daysInMonth*count($roomSta);
// $thisYearTotalRooms = $thisDate->dayOfYear*count($roomSta);
?>
<div class="container">
	<div class="jumbotron col-md-6 col-md-offset-3 col-xs-12">
		<nav aria-label="...">
            <ul class="pager">
                <li class="previous"><a href="{{ route('orders.staYear',['thisYear'=>$thisYear - 1]) }}"><span aria-hidden="true">&larr;</span> Older</a></li>
                <li class="next"><a href="{{ route('orders.staYear',['thisYear'=>$thisYear + 1]) }}">Newer <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
		<h2>{{$thisYear}}年度總結</h2>
		<!-- Single button -->
		<div class="panel panel-success" id="orderRooms">
			<!-- Default panel contents -->
			<div class="panel-heading">年度營業額</div>
			<ul class="list-group">
				<?php $countTotal = 0; ?>
				@foreach($orders as $key => $count)
				<a href="#orderRooms" class="list-group-item">
					<span class="badge">{{$orders[$key]->sums}}</span>
					{{$orders[$key]->year}}/{{$orders[$key]->months}}
					<?php $countTotal += $orders[$key]->sums ?>
				</a>
				@endforeach
				<li class="list-group-item list-group-item-warning">
					<span class="badge">{{$countTotal}}</span>
					Total
				</li>
			</ul>
		</div>
</div>
@endsection