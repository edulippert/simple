<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignGuaranteeIdFromCustomerGuarantees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_guarantees', function (Blueprint $table) {
            $table->dropForeign(['guarantee_id']);
            $table->dropColumn('guarantee_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_guarantees', function (Blueprint $table) {
            $table->integer('guarantee_id');
            $table->foreign('guarantee_id')->references('id')->on('guarantees');
        });
    }
}
