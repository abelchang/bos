<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('checkin');
            $table->date('checkout');
            $table->string('customer');
            $table->unsignedInteger('room');
            $table->unsignedInteger('status');
            $table->unsignedInteger('orderPlace');
            $table->integer('price');
            $table->integer('backPay')->nullable()->default('0');
            $table->string('phone')->nullable()->default('');
            $table->string('idCard')->nullable()->default('');
            $table->string('memo')->nullable()->default('');
            $table->string('address')->nullable()->default('');
            $table->string('placeOfBirth')->nullable()->default('');
            $table->date('birthday')->nullable()->default('1987-01-01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
