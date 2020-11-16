<?php

use Illuminate\Database\Seeder;
use App\User as UserEloquent;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = UserEloquent::create([
            'name' => 'abel',
            'email'    => 'abel@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->makeRole('admin');
    }
}
