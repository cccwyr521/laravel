<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',50)->default('')->comment('用户名');
            $table->string('password',32)->default('')->comment('密码');
            $table->string('image_url',150)->default('')->comment('用户头像');
            $table->enum('is_super',['1','2'])->default('1')->comment('是否超管 1 非超管 2超管');
            $table->enum('status',['1','2'])->default('1')->comment('用户状态1正常2停用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
