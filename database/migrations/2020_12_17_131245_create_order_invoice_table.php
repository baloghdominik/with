<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_invoice', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('order_id');
            $table->bigInteger('restaurant_id');
            $table->boolean('invoice_is_company');
            $table->string('invoice_name');
            $table->string('invoice_zipcode');
            $table->string('invoice_city');
            $table->string('invoice_address');
            $table->string('invoice_tax_number')->nullable();
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
        Schema::dropIfExists('order_invoice');
    }
}
