
<?php
use Carbon\Carbon;
$indexDate = Carbon::now()->addMonth(4);
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('orders.index') }}">花蓮好書室</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{route('orders.statistics')}}">統計資料</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">月份查詢 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            @for($i = 0; $i <= 7; $i++)
            <li><a href=" {{ route('orders.showByMonth',['thisYear'=>$indexDate->subMonth()->year, '$thisMonth'=>$indexDate->month]) }} "> {{$indexDate->year}}/{{$indexDate->month}} </a></li>
            @endfor
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>