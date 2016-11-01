@extends('layouts.master')

@section('title','new order')

@section('content')

<?php
use Carbon\Carbon;
$checkin = Carbon::createFromDate($thisYear,$thisMonth,$thisDay);
$checkout = Carbon::createFromDate($thisYear,$thisMonth,$thisDay)->addDay();
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    new order
                </div>
                <div class="panel-body">
                    <div class="container-fluid" style="padding:0;">
                        <form style="margin-top: 20px" class="form-horizontal" method="POST" action="{{ route('orders.store') }}">
                        	 {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">CheckIN</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control " name="checkin" value="{{$checkin->year}}-{{$checkin->month}}-{{$checkin->day}}">
                                </div>
                                <label for="title" class="col-sm-2 control-label">ChechOut</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control " name="checkout" value="{{$checkout->year}}-{{$checkout->month}}-{{$checkout->day}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="room" class="col-sm-2 control-label">Room</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="room">
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">
                                                {{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="status" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="status">
                                        @foreach($orderStatus as $orderStatusOne)
                                            <option value="{{ $orderStatusOne->id }}">
                                                {{ $orderStatusOne->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="place" class="col-sm-2 control-label">orderPlace</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="orderPlace">
                                        @foreach($orderPlaces as $orderPlace)
                                            <option value="{{ $orderPlace->id }}">
                                                {{ $orderPlace->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-2 control-label">price</label>
                                <div class="col-sm-4">
                                    <input type="text" pattern="\d*" class="form-control" name="price" value="0" >
                                </div>
                                <label for="content" class="col-sm-2 control-label">backPay</label>
                                <div class="col-sm-4">
                                    <input type="text" pattern="\d*" class="form-control" name="backPay" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-2 control-label">Customer</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="customer">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-2 control-label">Memo</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="5" name="memo" style="resize: vertical;"></textarea>
                                </div>
                            </div>
							<div class="form-group">
								<label for="content" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-4">
                                    <input type="tel" class="form-control" name="phone">
                                </div>
                                <label for="content" class="col-sm-2 control-label">ID</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="idCard" >
                                </div>
							</div>
							<div class="form-group">
								<label for="content" class="col-sm-2 control-label">Birthday</label>
                                <div class="col-sm-4">
                                     <input type="date" class="form-control " name="birthday" value = "1984-01-01">
                                </div>
                                <label for="content" class="col-sm-2 control-label">Place Of Birth</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="placeOfBirth">
                                </div>
							</div>

							<div class="form-group">
                                <label for="content" class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="address" style="resize: vertical;"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-m btn-primary">save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {


        if ( $('[type="date"]').prop('type') != 'date' ) {
                $('[type="date"]').datetimepicker({
                    format: 'YYYY/MM/DD',
                    keepInvalid: true,
                    
                });
        }
    });

</script>
@endsection
