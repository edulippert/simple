<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnsOnEquipamentGuarantees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_guarantees', function (Blueprint $table) {
            $table->dropForeign('equipment_guarantees_file_id_foreign');
            $table->dropColumn('file_id');
            $table->dropColumn('item');
            $table->dropColumn('start_date');
            $table->dropColumn('duration');
            $table->dropColumn('total_cost');
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
            $table->integer('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->string('item')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->integer('duration')->nullable();
            $table->decimal('total_cost')->nullable();
        });
    }
}
