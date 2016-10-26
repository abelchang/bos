<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPlace extends Model
{
    //
	protected $table = 'orderPlace';

    protected $fillable = ['name'];

    public function orders() {
    	return $this->hasMany(Orders::class);
    }
}
