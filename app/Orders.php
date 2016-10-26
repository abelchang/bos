<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
	protected $table = 'orders';

    protected $fillable = ['checkin','checkout','customer','room','status','orderPlace','price','phone','memo','address','placeOfBirth','birthday','idCard','backPay'];

    public function orderRoom() {
    	return $this->belongsTo(Rooms::class,'room','id');
    }

    public function orderStatus() {
    	return $this->belongsTo(OrderStatus::class,'status','id');
    }

    public function place() {
    	return $this->belongsTo(OrderPlace::class,'orderPlace','id');
    }

}
