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
use Illuminate\Support\Facades\DB;

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
        })->orderBy('checkout','DESC')->get();
    	$rooms = Rooms::orderBy('name','ASC')->get();
    	$orderStatus = OrderStatus::orderBy('id','ASC')->get();
    	$orderPlaces  = OrderPlace::orderBy('id','ASC')->get();
    	return view('orders.index',[ 'thisYear'=>$thisYear ,'thisMonth'=>$thisMonth, 'orders'=>$orders,'rooms'=>$rooms,'orderStatus'=>$orderStatus,'orderPlaces'=>$orderPlaces]);
    }

    public function statistics($thisYear = null,$thisMonth = null) {
        $index = "";
        $monthPrice = "";
        if(!isset($thisMonth) && !isset($thisYear)) {
            $thisYear = Carbon::now()->year;
            $thisMonth = Carbon::now()->month;
        }

        if (isset($thisYear) && !isset($thisMonth)) {
            $orders = Orders::whereYear('checkin','=',$thisYear)->get();
            $monthPrice = Orders::select(
                DB::raw('sum(price) as sums'), 
                DB::raw("DATE_FORMAT(checkin,'%m') as months"),
                DB::raw("DATE_FORMAT(checkin,'%Y') as year")
            )
            ->whereYear('checkin','=',$thisYear)
            ->whereNotIn('status',['4','5','6'])
            ->groupBy('year','months')
            ->orderBy('year','months','ASC')
            ->get();
            $index = "year";
        } else {
            $orders = Orders::whereYear('checkin','=',$thisYear)->whereMonth('checkin','=',$thisMonth)->get();
            $index = "month";
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
            if(($order->orderStatus->id != '4') and ($order->orderStatus->id != '5') and ($order->orderStatus->id != '6')) {
                $total += $order->price;
            }
            foreach ($rooms as $key => $room) {
                if(($room->id === $order->orderRoom->id) and ($order->orderStatus->id < '4'))  {
                    $roomSta[$room->name] += Carbon::parse($order->checkout)->diffInDays(Carbon::parse($order->checkin)); 
                }
            }

            foreach ($orderPlaces as $key => $orderPlace) {
                if(($orderPlace->id === $order->place->id) and ($order->orderStatus->id < '4')) {
                    $placeSta[$orderPlace->name] += 1; 
                }
            }
        }
        
        return view('orders.statistics',['total'=>$total,'roomSta'=>$roomSta, 'placeSta'=>$placeSta, 'thisYear'=>$thisYear ,'thisMonth'=>$thisMonth, 'index'=>$index, 'monthPrice'=>$monthPrice ]);  
           
    }

    public function staYear($thisYear = null) {
        if(!isset($thisYear)) {
            $thisYear = Carbon::now()->year;
        }

        $orders = Orders::select(
            DB::raw('sum(price) as sums'), 
            DB::raw("DATE_FORMAT(checkin,'%m') as months"),
            DB::raw("DATE_FORMAT(checkin,'%Y') as year")
        )
        ->whereYear('checkin','=',$thisYear)
        ->whereNotIn('status',['4','5','6'])
        ->groupBy('year','months')
        ->orderBy('year','months','ASC')
        ->get();

        return view('orders.staYear',['orders'=>$orders,'thisYear'=>$thisYear]);

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
        })->orderBy('checkout','DESC')->get();

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

    public function search(Request $request) {
        $orders = Orders::where('customer','like','%'.$request->keyword.'%')->orWhere('phone','like','%'.$request->keyword.'%')->orderBy('checkin','ASC')->get();
        return view('orders.search',['orders'=>$orders]);
    }

    public function chartjs() {
        $viewer = Orders::select(DB::raw("SUM(price) as count"))
        ->orderBy("created_at")
        ->groupBy(DB::raw("year(created_at)"))
        ->get()->toArray();
    $viewer = array_column($viewer, 'count');
    
    $click = Orders::select(DB::raw("SUM(room) as count"))
        ->orderBy("created_at")
        ->groupBy(DB::raw("year(created_at)"))
        ->get()->toArray();
    $click = array_column($click, 'count');
    
    return view('orders.chartjs')
            ->with('viewer',json_encode($viewer,JSON_NUMERIC_CHECK))
            ->with('click',json_encode($click,JSON_NUMERIC_CHECK));
    }
}
