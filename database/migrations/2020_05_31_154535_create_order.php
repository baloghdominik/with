<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('customer_id');
            $table->bigInteger('restaurant_id');
            $table->boolean('is_delivery');
            $table->bigInteger('delivery_price')->default(0);
            $table->string('coupon')->nullable();
            $table->string('coupon_sale')->default(0);
            $table->boolean('is_online_payment');
            $table->bigInteger('total_price');
            $table->boolean('is_paid');
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
        Schema::dropIfExists('order');
    }
}
