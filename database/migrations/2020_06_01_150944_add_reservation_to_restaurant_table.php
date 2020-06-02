<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReservationToRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant', function (Blueprint $table) {
            $table->boolean('isreservation')->default(0);
            $table->integer('maxreservationperson')->default(20);
            $table->integer('reservationtime')->default(4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant', function (Blueprint $table) {
            $table->dropColumn('isreservation');
            $table->dropColumn('maxreservationperson');
            $table->dropColumn('reservationtime');
        });
    }
}
