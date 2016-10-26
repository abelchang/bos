<?php

use Illuminate\Database\Seeder;
use App\Rooms as RoomsEloquent;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	RoomsEloquent::create([
    		'name'=>'昔時'
    	]);
    	RoomsEloquent::create([
    		'name'=>'白木'
    	]);
    	RoomsEloquent::create([
    		'name'=>'日常'
    	]);
    	RoomsEloquent::create([
    		'name'=>'單單'
    	]);
    }
}
