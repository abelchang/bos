<?php

use Illuminate\Database\Seeder;
use App\OrderPlace as OrderPlaceEloquent;

class OrderPlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	OrderPlaceEloquent::create([
    		'name'=>'Line'
    	]);
    	OrderPlaceEloquent::create([
    		'name'=>'FaceBook'
    	]);
    	OrderPlaceEloquent::create([
    		'name'=>'Booking'
    	]);
    	OrderPlaceEloquent::create([
    		'name'=>'AsiaYo'
    	]);
    	OrderPlaceEloquent::create([
    		'name'=>'other'
    	]);
    }
}
