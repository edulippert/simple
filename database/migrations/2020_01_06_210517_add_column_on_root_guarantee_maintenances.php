<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnRootGuaranteeMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('root_guarantee_maintenances', function (Blueprint $table) {
            $table->boolean('is_informed')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('root_guarantee_maintenances', function (Blueprint $table) {
            $table->dropColumn('is_informed');
        });
    }
}
