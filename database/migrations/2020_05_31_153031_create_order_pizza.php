<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPizza extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pizza', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('order_id');
            $table->bigInteger('pizzadesigner_base_id');
            $table->bigInteger('pizzadesigner_dough_id');
            $table->bigInteger('pizzadesigner_size_id');
            $table->integer('quantity');
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
        Schema::dropIfExists('order_pizza');
    }
}
