<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finish_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group_id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('finish_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finish_items');
    }
}
