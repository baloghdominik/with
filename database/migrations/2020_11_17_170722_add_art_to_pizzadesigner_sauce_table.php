<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArtToPizzadesignerSauceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pizzadesigner_sauce', function (Blueprint $table) {
            $table->string('art')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pizzadesigner_sauce', function (Blueprint $table) {
            $table->dropColumn('art');
        });
    }
}
