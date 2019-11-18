<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnCustomerMaintenanceGuarantee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_guarantee_maintenances', function (Blueprint $table) {
            $table->string('optional_period')->nullable();
            $table->boolean('is_informed')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_guarantee_maintenances', function (Blueprint $table) {
            $table->dropColumn('optional_period');
            $table->dropColumn('is_informed');
        });
    }
}
