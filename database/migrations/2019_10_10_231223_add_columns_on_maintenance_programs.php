<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnMaintenancePrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenance_programs', function (Blueprint $table) {
            $table->integer('customer_guarantee_maintenance_id');
            $table->foreign('customer_guarantee_maintenance_id')->references('id')->on('customer_guarantee_maintenances')->onDelete('cascade');
            $table->integer('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->date('maintenance_day');
            $table->date('executed_day')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_done')->nullable()->default(false);
            $table->boolean('is_blocked')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintenance_programs', function (Blueprint $table) {
            //
        });
    }
}
