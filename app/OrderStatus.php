<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    //
	protected $table = 'orderStatus';

	protected $fillable = ['status'];

	public function orders() {
		return $this->hasMany(Orders::class);
	}
}
