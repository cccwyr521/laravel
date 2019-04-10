<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller

{

	 public function Sign()
    {
        return view('study.index');
    }
    public function dlSign(Request $request)
    {
    	$params = $request->all();
    	$return = [
    		'code'=>2000,
    		'msg'=>'成功'
    	];
    	if(!isset($params['user_id']) || empty($params['user_id'])){
    		$return = [
    			'code'=>4001,
    			'msg'=>'用户id不能为空'
    		];

    		return json_encode($return);

    	}

    	//获取当前日期
    	$totay=data('Y-m-d');
    	$sign1=DB::select("select * from bp_sign_info where user_id = ? ",[$params['user_id']]);

    	if(!empty($sign1)&&$sign1[0]->last_date==$totay){
    		$return = [
    			'code'=>4002,
    			'msg'=>'你已经签到过了'
    			];

    		return json_encode($return);
    	}else{
    		if(empty($sign1)){
    			DB::insert("insert into bp_sign_info(user_id,c_dasy,total_scores,total_days,last_date)values(?,?,?,?,?)",[$params['user_id'],1,1,1,$totay]);
    			$return['date']['score']=1;
    			return json_encode($return);
    		}else{
    			$last_day=date('Y-m-d',time()-3600*24);
    			if($last_day == $sign1[0]->last_date){//连续签到
                    //连续签到天数
                    $c_days = $sign1[0]->c_days+1;
                }else{
                    $c_days= 1;
                }
                $total_scores=$sign1[0]->total_scores+$c_days;
                $total_days=$sign1[0]->total_days+1;
                DB::update("update bp_sign_info set c_days =?, total_scores = ?,total_days = ?,last_date = ? where user_id = ?",[$c_days,$total_scores,$total_days,$today,$params['user_id']]);
                $return['date']['score']=$c_days;
                return json_encode($return);
    		}
    	}


    	

    }

    public function getList()
    	{
        	$sign = DB::select('select * from bp_sign_info');

         	$return = [
                'code' => 2000,
                'msg'  => '签到成功',
                'data' => $sign
            ];

        	return json_encode($return);
   		 }
}
