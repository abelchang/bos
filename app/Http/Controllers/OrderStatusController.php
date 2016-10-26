<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use Redirect;
use App\Orders;
use App\OrderStatus;
use App\OrderPlace;
use App\Rooms;

class OrderStatusController extends Controller
{
    //
	public function show($statusType_id) {
    	$statusType = OrderStatus::findOrFail($statusType_id);
    	$orders = Orders::where('status',$statusType_id)->orderBy("checkin",'DESC')->paginate(10);
    	$rooms = Rooms::orderBy('name','ASC')->get();
    	$orderStatus = OrderStatus::orderBy('id','ASC')->get();
    	$orderPlaces  = OrderPlace::orderBy('id','ASC')->get();
    	$keyword = "";
    	return view('orders.index',['orders'=>$orders,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces,'keyword'=>$keyword,'statusType'=>$statusType]);
    }
}
