<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('condominium_id');
            $table->integer('option_id');
            $table->integer('file_id');
            $table->string('description');
            $table->timestamps();

            $table->foreign('condominium_id')->references('id')->on('condominiums');
            $table->foreign('option_id')->references('id')->on('license_options');
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
        Schema::dropIfExists('licenses');
    }
}
