<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('file_id');
            $table->text('attendance_place');
            $table->timestamp('call_date');
            $table->timestamp('inspection_date');
            $table->timestamp('finish_date');
            $table->text('description');
            $table->text('solution');
            $table->string('responsible');
            $table->string('manpower_cost');
            $table->string('material_cost');
            $table->string('total_cost');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone_number');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('attendances');
    }
}
