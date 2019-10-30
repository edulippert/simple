<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnMaintenancePrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenance_programs', function (Blueprint $table) {
            $table->decimal('estimated_cost')->nullable()->default(0);
            $table->decimal('executed_cost')->nullable()->default(0);
            $table->text('condominium_comments')->nullable();
            $table->text('company_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintenance_programs', function (Blueprint $table) {
            $table->dropColumn('estimated_cost');
            $table->dropColumn('executed_cost');
            $table->dropColumn('condominium_comments');
            $table->dropColumn('company_comments');
        });
    }
}
