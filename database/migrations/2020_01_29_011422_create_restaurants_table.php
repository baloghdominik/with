<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('zip');
            $table->string('address');
            $table->string('city');
            $table->string('country')->default('Magyarország');
            $table->string('phone');
            $table->string('email');
            $table->string('facebookpageurl');
            $table->longText('description')->default('');
            $table->time('mondayopen')->default('09:30');
            $table->time('mondayclose')->default('21:30');
            $table->time('tuesdayopen')->default('09:30');
            $table->time('tuesdayclose')->default('21:30');
            $table->time('wednesdayopen')->default('09:30');
            $table->time('wednesdayclose')->default('21:30');
            $table->time('thursdayopen')->default('09:30');
            $table->time('thursdayclose')->default('21:30');
            $table->time('fridayopen')->default('09:30');
            $table->time('fridayclose')->default('21:30');
            $table->time('saturdayopen')->default('10:00');
            $table->time('saturdayclose')->default('22:00');
            $table->time('sundayopen')->default('00:00');
            $table->time('sundayclose')->default('00:00');
            $table->integer('lastorder')->default(30);
            $table->integer('firstorder')->default(0);
            $table->integer('deliverymode')->default(1);
            $table->integer('timecalculationmode')->default(1);
            $table->integer('paymode')->default(1);
            $table->integer('minimumordervalue')->default(1000);
            $table->integer('basedeliverytime')->default(60);
            $table->longText('availablezipcodes');
            $table->longText('availablecities');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
