<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJyBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jy_brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand_name',30)->default('')->comment('商品名字');
            $table->enum('status',[1,2])->default('1')->comment('商品状态 1 可用 2 禁用');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jy_brand');
    }
}
