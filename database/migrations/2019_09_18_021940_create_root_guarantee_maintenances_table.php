<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRootGuaranteeMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('root_guarantee_maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('root_guarantee_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('subitem_id')->nullable();
            $table->string('activity');
            $table->string('description');
            $table->integer('amount');
            $table->string('period');
            $table->string('responsable')->nullable();
            $table->string('font')->nullable();
            $table->timestamps();

            $table->foreign('root_guarantee_id')->references('id')->on('root_guarantees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('root_guarantee_maintenances');
    }
}
