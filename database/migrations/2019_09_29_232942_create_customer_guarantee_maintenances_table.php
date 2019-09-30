<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerGuaranteeMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_guarantee_maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_guarantee_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('subitem_id')->nullable();
            $table->string('activity')->nullable();
            $table->string('description');
            $table->integer('amount');
            $table->string('period');
            $table->string('responsable')->nullable();
            $table->string('font')->nullable();
            $table->timestamps();

            $table->foreign('customer_guarantee_id')->references('id')->on('cutomer_guarantess')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_guarantee_maintenances');
    }
}
