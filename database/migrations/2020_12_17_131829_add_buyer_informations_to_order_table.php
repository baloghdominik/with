<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyerInformationsToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->string('customer_firstname');
            $table->string('customer_lastname');
            $table->string('customer_phone_number');
            $table->string('customer_email');
            $table->string('customer_country')->default("Magyarország");
            $table->string('customer_zipcode');
            $table->string('customer_address');
            $table->string('customer_ip_address')->nullable();
            $table->string('paying_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('customer_firstname');
            $table->dropColumn('customer_lastname');
            $table->dropColumn('customer_phone_number');
            $table->dropColumn('customer_email');
            $table->dropColumn('customer_country');
            $table->dropColumn('customer_zipcode');
            $table->dropColumn('customer_address');
            $table->dropColumn('customer_ip_address');
            $table->dropColumn('paying_method');
        });
    }
}
