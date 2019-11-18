<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnOnFinishItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finish_items', function (Blueprint $table) {
            $table->dropForeign('finish_items_group_id_foreign');
            
            $table->foreign('group_id')->references('id')->on('finish_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finish_items', function (Blueprint $table) {
            //
        });
    }
}
