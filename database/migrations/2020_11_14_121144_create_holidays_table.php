<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('date')->unique();
            $table->string('name')->nullable();
            $table->boolean('isHoliday');
            $table->string('holidayCategory');
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('holidays');
    }
}
