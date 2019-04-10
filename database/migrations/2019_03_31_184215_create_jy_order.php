<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJyOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jy_order', function (Blueprint $table) {
            $table->increments('id')->comment('订单表');
            $table->string('order_sn',20)->default('')->comment('订单号，唯一');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->tinyInteger('order_status')->default(0)->comment('1 未确认  2已确认 3 取消 4 退货');
            $table->tinyInteger('shipping_statu')->default(0)->comment('1 代发货 2 已发货 3 已收货 4 退货');
            $table->tinyInteger('pay_status')->default(0)->comment('1 未支付  2 支付中 3、支付成功');
            $table->string('consignee',60)->default('')->comment('收货人的姓名,用户页面填写,默认取值表user_address');
            $table->smallInteger('country')->default(0)->comment('收货人的国家');
            $table->smallInteger('province')->default(0)->comment('收货人的省份');
            $table->smallInteger('city')->default(0)->comment('收货人的城市');
            $table->smallInteger('district')->default(0)->comment('收货人的地区');
            $table->string('address',255)->default('')->comment('收货人的详细地址');
            $table->string('zipcode',60)->default('')->comment('收货人的邮编');
            $table->char('phone',11)->default('')->comment('收件人的手机号');
            $table->string('shipping_name',20)->default('')->comment('配送方式');
            $table->string('pay_name',20)->default('')->comment('支付方式');
            $table->decimal('goods_price',10,2)->default(0.00)->comment('商品总价格');
            $table->decimal('shipping_fee',10,2)->default(0.00)->comment('配送费用');
            $table->decimal('pay_price',10,2)->default(0.00)->comment('支付总金额');
            $table->decimal('paid_price',10,2)->default(0.00)->comment('已支付的金额');
            $table->decimal('bonus_price',10,2)->default(0.00)->comment('红包金额');
            $table->string('note',100)->default('')->comment('订单备注');
            $table->datetime('confirm_time')->comment('订单确认时间');
            $table->datetime('pay_time')->comment('订单支付时间');
            $table->timestamps();
            $table->unique('order_sn');
            $table->index('user_id');
            $table->index('order_status');
            $table->index('shipping_statu');
            $table->index('pay_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jy_order');
    }
}
