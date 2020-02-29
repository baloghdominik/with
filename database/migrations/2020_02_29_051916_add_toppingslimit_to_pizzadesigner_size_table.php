<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToppingslimitToPizzadesignerSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pizzadesigner_size', function (Blueprint $table) {
            $table->integer('toppingslimit')->default(5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pizzadesigner_size', function (Blueprint $table) {
            $table->dropColumn('toppingslimit');
        });
    }
}
