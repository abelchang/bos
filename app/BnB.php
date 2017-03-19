<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BnB extends Model
{
    //
	protected $table = 'bnb';
    protected $fillable = ['name','user_id'];

    public function post()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
