<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentGuaranteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_guarantees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('condominium_id');
            $table->integer('file_id');
            $table->string('item');
            $table->timestamp('start_date');
            $table->integer('duration');
            $table->decimal('total_cost');
            $table->string('reference')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();

            $table->foreign('condominium_id')->references('id')->on('condominiums');
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
        Schema::dropIfExists('equipment_guarantees');
    }
}
