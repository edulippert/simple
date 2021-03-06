<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerGuaranteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_guarantees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('condominium_id');
            $table->integer('guarantee_id');
            $table->integer('group_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('subitem_id')->nullable();
            $table->timestamp('start_date');
            $table->integer('amount')->nullable(); //2
            $table->string('period')->nullable(); // dias semanas meses anos
            $table->timestamp('due_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_expired')->default(false);
            $table->string('reference')->nullable();
            $table->timestamps();

            $table->foreign('condominium_id')->references('id')->on('condominiums');
            $table->foreign('guarantee_id')->references('id')->on('guarantees');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('subitem_id')->references('id')->on('subitems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_guarantees');
    }
}
