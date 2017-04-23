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
                ->whereMonth('checkin','=',$thisMonth)
                ->whereNotIn('status',['4','5']);
        })->orWhere(function($query) use ($thisYear,$thisMonth) {
            $query->whereYear('checkout','=',$thisYear)
                ->whereMonth('checkout','=',$thisMonth)
                ->whereNotIn('status',['4','5']);
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
            if(($order->orderStatus->id != '4') and ($order->orderStatus->id != '5')) {
                $total += $order->price;
            }
            foreach ($rooms as $key => $room) {
                if(($room->id === $order->orderRoom->id) and ($order->orderStatus->id < '4'))  {
                    $roomSta[$room->name] += 1; 
                }
            }

            foreach ($orderPlaces as $key => $orderPlace) {
                if(($orderPlace->id === $order->place->id) and ($order->orderStatus->id < '4')) {
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
                ->whereMonth('checkin','=',$thisMonth)
                ->whereNotIn('status',['4','5']);;
        })->orWhere(function($query) use ($thisYear,$thisMonth) {
            $query->whereYear('checkout','=',$thisYear)
                ->whereMonth('checkout','=',$thisMonth)
                ->whereNotIn('status',['4','5']);;
        })->orderBy('checkin','ASC')->get();

        $rooms = Rooms::orderBy('name','ASC')->get();
        $orderStatus = OrderStatus::orderBy('id','ASC')->get();
        $orderPlaces  = OrderPlace::orderBy('id','ASC')->get();
        return view('orders.index',[  'thisYear'=>$thisYear ,'thisMonth'=>$thisMonth, 'orders'=>$orders,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);
    }

    public function create($thisYear = null,$thisMonth = null,$thisDay = null) {
        if(!isset($thisMonth)) {
            $thisMonth = Carbon::now()->month;
        } 

        if(!isset($thisYear)) {
            $thisYear = Carbon::now()->year;
        }

        if(!isset($thisDay)) {
            $thisDay = Carbon::now()->day;
        }

    	$rooms = Rooms::orderBy('name','ASC')->get();
    	$orderStatus = OrderStatus::orderBy('id','ASC')->get();
    	$orderPlaces  = OrderPlace::orderBy('id','ASC')->get();

    	return view('orders.create',['thisYear'=>$thisYear ,'thisMonth'=>$thisMonth,'thisDay'=>$thisDay ,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);
    }

    public function edit($id) {
        $order = Orders::findOrFail($id);
        $rooms = Rooms::orderBy('name','ASC')->get();
        $orderStatus = OrderStatus::orderBy('id','ASC')->get();
        $orderPlaces  = OrderPlace::orderBy('id','ASC')->get();

        return view('orders.edit',[ 'order'=>$order ,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);

    }

    public function store(Request $request) {
        $order = new Orders($request->all());
        if(!isset($order->birthday)) {
            $order->birthday = Carbon::create(2012, 1, 31, 0);
        }
        $order->save();
        $orderDate = Carbon::parse($order->checkin);
        return Redirect::route('orders.showByMonth',['thisYear'=>$orderDate->year,'thisMonth'=>$orderDate->month]);
    }

    public function update(OrderRequest $request, $id)
    {
        $order = Orders::findOrFail($id);
        $order->fill($request->all());
        $order->save();
        $orderDate = Carbon::parse($order->checkin);
        return Redirect::route('orders.showByMonth',['thisYear'=>$orderDate->year,'thisMonth'=>$orderDate->month]);
    }

    public function destroy($id)
    {
        $order=Orders::findOrFail($id);
        $order->delete();
        return Redirect::route('orders.index');
    }

    public function cancel() {
        $orders = Orders::where('status','=','4')->orderBy('checkin','ASC')->get();
        return view('orders.cancel',[ 'orders'=>$orders]);
    }

    public function delay() {
        $orders = Orders::where('status','=','5')->orderBy('checkin','ASC')->get();
        return view('orders.cancel',[ 'orders'=>$orders]);
    }

    public function updateStatus(Request $request) {
        $order = Orders::findOrFail($request->orderID);
        $order->status = $request->orderStatus;
        $order->save();
        $response = array(
            'id' => $order->id,
            'status' => $order->orderStatus->status,
        );
        return response()->json($response);
    }
}
