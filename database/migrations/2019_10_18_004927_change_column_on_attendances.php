<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnOnAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign('attendances_file_id_foreign');
            $table->dropColumn('file_id');
            $table->dropColumn('inspection_date');
            $table->dropColumn('finish_date');
            $table->dropColumn('description');
            $table->dropColumn('solution');
            $table->dropColumn('responsible');
            $table->dropColumn('manpower_cost');
            $table->dropColumn('material_cost');
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
        Schema::table('attendances', function (Blueprint $table) {
            $table->integer('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->timestamp('inspection_date')->nullable();
            $table->timestamp('finish_date')->nullable();
            $table->text('description')->nullable();
            $table->text('solution')->nullable();
            $table->string('responsible')->nullable();
            $table->string('manpower_cost')->nullable();
            $table->string('material_cost')->nullable();
            $table->string('total_cost')->nullable();
        });
    }
}
