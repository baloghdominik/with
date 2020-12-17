<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNamesToOrderPizzaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_pizza', function (Blueprint $table) {
            $table->string('size_name');
            $table->string('dough_name');
            $table->string('base_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_pizza', function (Blueprint $table) {
            $table->dropColumn('size_name');
            $table->dropColumn('dough_name');
            $table->dropColumn('base_name');
        });
    }
}
