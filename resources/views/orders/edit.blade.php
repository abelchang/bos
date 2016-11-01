@extends('layouts.master')

@section('title','edit order')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    edit order
                </div>
                <div class="panel-body">
                    <div class="container-fluid" style="padding:0;">
                        <form style="margin-top: 20px" class="form-horizontal" method="POST" action="{{ route('orders.update',['id'=>$order->id]) }}">
                        	 {{ csrf_field() }}
                        	 <input name="_method" type="hidden" value="PUT" />
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">CheckIN</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control " name="checkin" value="{{ $order->checkin }}">
                                </div>
                                <label for="title" class="col-sm-2 control-label">ChechOut</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control " name="checkout" value="{{ $order->checkout }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="room" class="col-sm-2 control-label">Room</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="room">
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ ($room->id==$order->room)?"selected='selected'":"" }}>
                                                {{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="status" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="status">
                                        @foreach($orderStatus as $orderStatusOne)
                                            <option value="{{ $orderStatusOne->id }}" {{ ($order->status==$orderStatusOne->id)?"selected='selected'":"" }}>
                                                {{ $orderStatusOne->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="place" class="col-sm-2 control-label">orderPlace</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="orderPlace">
                                        @foreach($orderPlaces as $orderPlace)
                                            <option value="{{ $orderPlace->id }}" {{ ($order->orderPlace==$orderPlace->id)?"selected='selected'":"" }}>
                                                {{ $orderPlace->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-2 control-label">price</label>
                                <div class="col-sm-4">
                                    <input type="text" pattern="\d*" class="form-control" name="price" value="{{ $order->price }}">
                                </div>
                                <label for="content" class="col-sm-2 control-label">backPay</label>
                                <div class="col-sm-4">
                                    <input type="text" pattern="\d*" class="form-control" name="backPay" value="{{ $order->backPay }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-2 control-label">Customer</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="customer" value="{{ $order->customer }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-2 control-label">Memo</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="5" name="memo" style="resize: vertical;">{{ $order->memo }}</textarea>
                                </div>
                            </div>
							<div class="form-group">
								<label for="content" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-4">
                                    <input type="tel" class="form-control" name="phone" value="{{ $order->phone }}">
                                </div>
                                <label for="content" class="col-sm-2 control-label">ID</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="idCard" value="{{ $order->idCard }}">
                                </div>
                                
							</div>
							<div class="form-group">
								<label for="content" class="col-sm-2 control-label">Birthday</label>
                                <div class="col-sm-4">
                                     <input type="date" class="form-control " name="birthday" value="{{ $order->birthday }}">
                                </div>
                                <label for="content" class="col-sm-2 control-label">Place Of Birth</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="placeOfBirth" value="{{ $order->placeOfBirth }}">
                                </div>
							</div>

							<div class="form-group">
                                <label for="content" class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="2" name="address" style="resize: vertical;">{{ $order->address }}</textarea>
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
                    
                });
        }
    });

</script>
@endsection
