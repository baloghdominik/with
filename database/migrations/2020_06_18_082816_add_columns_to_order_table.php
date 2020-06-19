<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->boolean('is_final_order')->default(0);
            $table->boolean('is_done')->default(0);
            $table->dateTime('done_at')->nullable();
            $table->boolean('is_delivered')->default(0);
            $table->dateTime('delivered_at')->nullable();
            $table->boolean('is_finished')->default(0);
            $table->dateTime('finished_at')->nullable();
            $table->boolean('is_cancelled')->default(0);
            $table->boolean('is_refund')->default(0);
            $table->boolean('is_refund_finished')->default(0);
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
            $table->dropColumn('is_final_order');
            $table->dropColumn('is_done');
            $table->dropColumn('done_at');
            $table->dropColumn('is_delivered');
            $table->dropColumn('delivered_at');
            $table->dropColumn('is_finished');
            $table->dropColumn('finished_at');
            $table->dropColumn('is_cancelled');
            $table->dropColumn('is_refund');
            $table->dropColumn('is_refund_finished');
        });
    }
}
