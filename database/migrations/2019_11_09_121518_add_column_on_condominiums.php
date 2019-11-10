<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnCondominiums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('condominiums', function (Blueprint $table) {
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('condominiums', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('state');
        });
    }
}
