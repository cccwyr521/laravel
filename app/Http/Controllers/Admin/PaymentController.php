<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Payment;
class PaymentController extends Controller
{
    //支付方式列表
    public function list(){

        $payment = new Payment();

        $assign['payments'] = $this->getDataList($payment);

        return view('admin.payment.list',$assign);
    }

    //添加页面
    public function add(){
        return view('admin.payment.add');
    }

    //执行添加的操作
    public function store(Request $request){

        $params = $request->all();

        $params = $this->delToken($params);
        //处理支付方式的配置信息，进行序列化
        if(!empty($params['pay_config'])){
            $pay_config = [];
            $arr = explode('|',$params['pay_config']);
            foreach($arr as $key => $value){
                $arr1 = explode("=>",$value);
                $pay_config[$arr[0] = $arr1[1]];
            }
            dd($$pay_config);
            $params['pay_config'] = serialize($arr);
        }

        $payment = new Payment();

        $res = $this->storeData($payment,$params);

        if(!$res){
            return redirect()->back()->with('msg','添加支付方式失败');
        }
        return redirect('/admin/payment/list');
    }


}
