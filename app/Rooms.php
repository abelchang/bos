<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    //

    protected $fillable = ['naem','price'];

    public function orders() {
    	return $this->hasMany(Orders::class);
    }
}
