<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side', function (Blueprint $table) {
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
            $table->longText('description')->default(' ');
            $table->boolean('vegan')->default(false);
            $table->boolean('vegetarian')->default(false);
            $table->boolean('glutenfree')->default(false);
            $table->boolean('lactosefree')->default(false);
            $table->boolean('fatfree')->default(false);
            $table->boolean('sugarfree')->default(false);
            $table->boolean('allergenicfree')->default(false);
            $table->string('calorie')->nullable();
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
        Schema::dropIfExists('side');
    }
}
