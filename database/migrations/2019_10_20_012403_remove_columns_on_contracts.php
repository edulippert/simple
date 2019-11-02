<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnsOnContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign('contracts_file_id_foreign');
            $table->dropColumn('file_id');

            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('total_cost');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('file_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('total_cost')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone_number')->nullable();
        });
    }
}
