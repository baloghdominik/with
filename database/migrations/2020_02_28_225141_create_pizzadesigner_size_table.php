<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePizzadesignerSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pizzadesigner_size', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('restaurantid');
            $table->integer('size');
            $table->bigInteger('price');
            $table->bigInteger('makeprice');
            $table->bigInteger('maketime');
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
        Schema::dropIfExists('pizzadesigner_size');
    }
}
