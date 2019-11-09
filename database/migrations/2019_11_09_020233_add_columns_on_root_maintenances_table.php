<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnRootMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('root_maintenances', function (Blueprint $table) {
            $table->boolean('is_informed')->default(true);
            $table->string('optional_period')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('root_maintenances', function (Blueprint $table) {
            $table->dropColumn('is_informed');
            $table->dropColumn('optional_period');
        });
    }
}
