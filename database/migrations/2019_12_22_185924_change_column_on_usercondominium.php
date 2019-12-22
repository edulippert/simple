<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnOnUsercondominium extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_condominiums', function (Blueprint $table) {
            $table->dropForeign('user_condominiums_user_company_id_foreign');
            $table->foreign('user_company_id')->references('id')->on('user_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_condominiums', function (Blueprint $table) {
            //
        });
    }
}
