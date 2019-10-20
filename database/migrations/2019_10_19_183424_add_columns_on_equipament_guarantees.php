<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnEquipamentGuarantees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_guarantees', function (Blueprint $table) {
            $table->integer('file_id')->nullable();
            $table->string('item')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->integer('duration')->nullable();
            $table->string('period')->nullable();
            $table->decimal('total_cost')->nullable();
            $table->string('company')->nullable();
            $table->string('company_number_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_guarantees', function (Blueprint $table) {
            $table->dropColumn('file_id');
            $table->dropColumn('item');
            $table->dropColumn('start_date');
            $table->dropColumn('duration');
            $table->dropColumn('period');
            $table->dropColumn('total_cost');
            $table->dropColumn('company');
            $table->dropColumn('company_number_id');
            $table->dropColumn('phone');
            $table->dropColumn('email');

        });
    }
}
