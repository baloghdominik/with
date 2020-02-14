<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drink', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->longText('picid');
            $table->bigInteger('restaurantid');
            $table->string('name');
            $table->bigInteger('price');
            $table->bigInteger('saleprice');
            $table->boolean('sale')->default(false);
            $table->bigInteger('makeprice');
            $table->bigInteger('maketime');
            $table->boolean('monday')->default(true);
            $table->boolean('tuesday')->default(true);
            $table->boolean('wednesday')->default(true);
            $table->boolean('thirsday')->default(true);
            $table->boolean('friday')->default(true);
            $table->boolean('saturday')->default(true);
            $table->boolean('sunday')->default(true);
            $table->integer('size');
            $table->boolean('vegan')->default(false);
            $table->boolean('alcoholfree')->default(false);
            $table->boolean('lactosefree')->default(false);
            $table->boolean('sugarfree')->default(false);
            $table->string('calorie')->nullable();
            $table->boolean('available_separately')->default(true);
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
        Schema::dropIfExists('drink');
    }
}
