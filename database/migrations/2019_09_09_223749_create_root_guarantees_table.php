<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRootGuaranteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('root_guarantees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('guarantee_id');
            $table->integer('group_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('subitem_id')->nullable();
            $table->integer('amount')->nullable(); //2
            $table->string('period')->nullable(); // dias semanas meses anos
            $table->boolean('is_active')->default(true);
            $table->string('reference')->nullable();
            $table->timestamps();

            $table->foreign('guarantee_id')->references('id')->on('guarantees')->onDelete('cascade');
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
        Schema::dropIfExists('root_guarantees');
    }
}
