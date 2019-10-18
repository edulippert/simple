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
            $table->timestamp('inspection_date');
            $table->timestamp('finish_date');
            $table->text('description');
            $table->text('solution');
            $table->string('responsible');
            $table->string('manpower_cost');
            $table->string('material_cost');
            $table->string('total_cost');
        });
    }
}
