<?php

use Illuminate\Database\Seeder;
use App\OrderStatus as OrderStatusEloquent;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	OrderStatusEloquent::create([
    		'status'=>'預定'
    	]);
    	OrderStatusEloquent::create([
    		'status'=>'付訂'
    	]);
    	OrderStatusEloquent::create([
    		'status'=>'付清'
    	]);
    	OrderStatusEloquent::create([
    		'status'=>'取消'
    	]);
    	OrderStatusEloquent::create([
    		'status'=>'延期'
    	]);
    }
}
