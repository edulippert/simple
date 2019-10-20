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
            $table->integer('file_id');
            $table->string('name');
            $table->string('description');
            $table->string('total_cost');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone_number');
        });
    }
}
