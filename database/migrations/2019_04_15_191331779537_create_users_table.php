<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address')->default('istanbul');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('photo_url')->default('https://via.placeholder.com/150');
            $table->string('user_ref_number')->nullable();
            $table->float('user_total_debt')->default(0);
            $table->datetime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('device_token')->default('123456');
            $table->enum('role', ['admin', 'store','user'])->default('user');
            $table->enum('status', ['1', '0'])->default('1');
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
