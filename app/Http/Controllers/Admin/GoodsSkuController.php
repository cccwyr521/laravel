<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;

class GoodsSkuController extends Controller
{
    //商品属性或sku编辑页面
    public function edit($goodsId){

        $goods = new Goods();

        $assign['goods_info'] = $this->getDataInfo($goods,$goodsId);

        return view('admin.goodsSku.edit');
    }
}
