<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePizzadesignerDoughTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pizzadesigner_dough', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('sizeid');
            $table->bigInteger('restaurantid');
            $table->string('name');
            $table->bigInteger('price');
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
        Schema::dropIfExists('pizzadesigner_dough');
    }
}
