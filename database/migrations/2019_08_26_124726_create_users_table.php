<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id');
            $table->string('username', 80)->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('id_number')->unique();
            $table->string('cep', 8);
            $table->string('address');
            $table->decimal('complement');
            $table->string('phone_number');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
