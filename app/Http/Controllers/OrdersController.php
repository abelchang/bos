<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Requests;
use App\Http\Controllers\Input;
use View;
use Carbon\Carbon;
use Redirect;
use App\Orders;
use App\OrderStatus;
use App\Rooms;
use App\OrderPlace;

class OrdersController extends Controller
{
    //
    public function index() {

        $thisYear = Carbon::now()->year;
        $thisMonth = Carbon::now()->month;
    	$orders = Orders::where(function ($query) use ($thisYear,$thisMonth){
            $query->whereYear('checkin','=',$thisYear)
                ->whereMonth('checkin','=',$thisMonth);
        })->orWhere(function($query) use ($thisYear,$thisMonth) {
            $query->whereYear('checkout','=',$thisYear)
                ->whereMonth('checkout','=',$thisMonth);
        })->orderBy('checkin','ASC')->get();
    	$rooms = Rooms::orderBy('name','ASC')->get();
    	$orderStatus = OrderStatus::orderBy('id','ASC')->get();
    	$orderPlaces  = OrderPlace::orderBy('id','ASC')->get();
    	return view('orders.index',[ 'thisYear'=>$thisYear ,'thisMonth'=>$thisMonth, 'orders'=>$orders,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);
    }

    public function statistics($thisYear = null,$thisMonth = null) {
        if(!isset($thisMonth) && !isset($thisYear)) {
            $thisYear = Carbon::now()->year;
            $thisMonth = Carbon::now()->month;
        }

        if (isset($thisYear) && !isset($thisMonth)) {
            $orders = Orders::whereYear('checkin','=',$thisYear)->get();
        } else {
            $orders = Orders::whereYear('checkin','=',$thisYear)->whereMonth('checkin','=',$thisMonth)->get();
        }
        
        $rooms = Rooms::orderBy('id','ASC')->get();
        $orderPlaces  = OrderPlace::orderBy('id','ASC')->get();
        $total = 0;

        foreach ($orderPlaces as $key => $orderPlace) {
            $placeSta[$orderPlace->name] = 0;
        }

        foreach ($rooms as $key => $room) {
            $roomSta[$room->name] = 0;
        }

        foreach ($orders as $key => $order) {
            $total += $order->price;
            foreach ($rooms as $key => $room) {
                if($room->id === $order->orderRoom->id) {
                    $roomSta[$room->name] += 1; 
                }
            }

            foreach ($orderPlaces as $key => $orderPlace) {
                if($orderPlace->id === $order->place->id) {
                    $placeSta[$orderPlace->name] += 1; 
                }
            }
        }
        
        return view('orders.statistics',['total'=>$total,'roomSta'=>$roomSta, 'placeSta'=>$placeSta, 'thisYear'=>$thisYear ,'thisMonth'=>$thisMonth]);  
           
    }

    public function showByMonth($thisYear, $thisMonth) {
        if(!isset($thisMonth) || !isset($thisYear)) {
            $thisMonth = Carbon::now()->month;
            $thisYear = Carbon::now()->year;
        } 

        $orders = Orders::where(function ($query) use ($thisYear,$thisMonth){
            $query->whereYear('checkin','=',$thisYear)
                ->whereMonth('checkin','=',$thisMonth);
        })->orWhere(function($query) use ($thisYear,$thisMonth) {
            $query->whereYear('checkout','=',$thisYear)
                ->whereMonth('checkout','=',$thisMonth);
        })->orderBy('checkin','ASC')->get();

        $rooms = Rooms::orderBy('name','ASC')->get();
        $orderStatus = OrderStatus::orderBy('id','ASC')->get();
        $orderPlaces  = OrderPlace::orderBy('id','ASC')->get();
        return view('orders.index',[  'thisYear'=>$thisYear ,'thisMonth'=>$thisMonth, 'orders'=>$orders,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);
    }

    public function create() {
    	$rooms = Rooms::orderBy('name','ASC')->get();
    	$orderStatus = OrderStatus::orderBy('id','ASC')->get();
    	$orderPlaces  = OrderPlace::orderBy('id','ASC')->get();

    	return view('orders.create',['rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);
    }

    public function store(Request $request) {
    	$order = new Orders($request->all());
        if(!isset($order->birthday)) {
            $order->birthday = Carbon::create(2012, 1, 31, 0);
        }
    	$order->save();
    	return Redirect::route('orders.index');
    }

    public function edit($id) {
        $order = Orders::findOrFail($id);
        $rooms = Rooms::orderBy('name','ASC')->get();
        $orderStatus = OrderStatus::orderBy('id','ASC')->get();
        $orderPlaces  = OrderPlace::orderBy('id','ASC')->get();

        return view('orders.edit',[ 'order'=>$order ,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);

    }

    public function update(OrderRequest $request, $id)
    {
        $order = Orders::findOrFail($id);
        $order->fill($request->all());
        $order->save();
        return Redirect::route('orders.index');
    }

    public function destroy($id)
    {
        $order=Orders::findOrFail($id);
        $order->delete();
        return Redirect::route('orders.index');
    }
}
