<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCondominiumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_condominiums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_company_id');
            $table->integer('condominium_id');
            
            $table->foreign('user_company_id')->references('id')->on('user_companies');
            $table->foreign('condominium_id')->references('id')->on('condominiums');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_condominiums');
    }
}
