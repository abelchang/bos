<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(HolidaysTableSeeder::class);
        $this->call(OrderPlaceTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
