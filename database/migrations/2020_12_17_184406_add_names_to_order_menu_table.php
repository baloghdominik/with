<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNamesToOrderMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_menu', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('menu_name');
            $table->string('side_name');
            $table->string('drink_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_menu', function (Blueprint $table) {
            $table->dropColumn('menu_name');
            $table->dropColumn('side_name');
            $table->dropColumn('drink_name');
        });
    }
}
