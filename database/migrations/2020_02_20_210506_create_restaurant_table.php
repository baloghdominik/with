<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lowercasename');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('facebook')->nullable();
            $table->longText('description')->default('');
            $table->boolean('monday')->default(1);
            $table->time('mondayopen')->default('09:30');
            $table->time('mondayclose')->default('21:30');
            $table->boolean('tuesday')->default(1);
            $table->time('tuesdayopen')->default('09:30');
            $table->time('tuesdayclose')->default('21:30');
            $table->boolean('wednesday')->default(1);
            $table->time('wednesdayopen')->default('09:30');
            $table->time('wednesdayclose')->default('21:30');
            $table->boolean('thursday')->default(1);
            $table->time('thursdayopen')->default('09:30');
            $table->time('thursdayclose')->default('21:30');
            $table->boolean('friday')->default(1);
            $table->time('fridayopen')->default('09:30');
            $table->time('fridayclose')->default('21:30');
            $table->boolean('saturday')->default(1);
            $table->time('saturdayopen')->default('09:30');
            $table->time('saturdayclose')->default('21:30');
            $table->boolean('sunday')->default(0);
            $table->time('sundayopen')->default('09:30');
            $table->time('sundayclose')->default('21:30');
            $table->integer('firstorder')->default(0);
            $table->integer('lastorder')->default(-30);
            $table->boolean('delivery')->default(1);
            $table->boolean('pickup')->default(0);
            $table->integer('minimumordervalue')->default(1000);
            $table->integer('deliveryprice')->default(0);
            $table->integer('deliverymode')->default(1);
            $table->integer('deliverytime')->default(60);
            $table->integer('deliverytimecalculation')->default(1);
            $table->integer('pickuptimecalculation')->default(1);
            $table->integer('deliverypayingmethod')->default(3);
            $table->integer('pickuppayingmethod')->default(3);
            $table->boolean('szepcard')->default(0);
            $table->boolean('erzsebetcard')->default(0);
            $table->integer('menusalepercent')->default(5);
            $table->boolean('showspecifications')->default(0);
            $table->boolean('showcalories')->default(0);
            $table->boolean('showdescription')->default(0);
            $table->boolean('isopen')->default(0);
            $table->boolean('isactive')->default(1);
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
        Schema::dropIfExists('restaurant');
    }
}
