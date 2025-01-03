<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id(); // id column
            $table->string('username')->unique(); // username column
            $table->string('password'); // password column
            $table->string('role')->default('customer'); // role column
            $table->string('reset_token')->nullable(); // reset_token column
            $table->string('phone')->nullable(); // phone column
            $table->string('email')->nullable(); // email column
            $table->timestamps(); // created_at and updated_at columns
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