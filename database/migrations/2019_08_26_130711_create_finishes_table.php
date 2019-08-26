<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finishes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('condominium_id');
            $table->integer('group_id');
            $table->integer('item_id');
            $table->timestamps();

            $table->foreign('condominium_id')->references('id')->on('condominiums');
            $table->foreign('group_id')->references('id')->on('finish_groups');
            $table->foreign('item_id')->references('id')->on('finish_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finishes');
    }
}
