<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnFinishgroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finish_groups', function (Blueprint $table) {
            $table->integer('condominium_id')->nullable();
            $table->foreign('condominium_id')->references('id')->on('condominiums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finish_groups', function (Blueprint $table) {
            //$table->dropForeign('condominium_id');
            $table->dropColumn('condominium_id');
        });
    }
}
