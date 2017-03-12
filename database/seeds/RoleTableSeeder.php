<?php

use Illuminate\Database\Seeder;
use App\Role as RoleEloquent;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        RoleEloquent::create([
    		'name'=>'super_admin'
    	]);
    	 RoleEloquent::create([
    		'name'=>'admin'
    	]);
    	  RoleEloquent::create([
    		'name'=>'concierge'
    	]);
    }
}
