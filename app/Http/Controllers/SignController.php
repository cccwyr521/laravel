<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignController extends Controller
{
    //
   
    public function  delSign(Request $request)
    {
//        $request::all();
        $params=$request->all();
//        dd($params);
        $return = [
            'code'=>2000,
            'msg'=>'成功',
            'data'=>[]
        ];
        //判断是否传id
        if(!isset($params['user_id']) || empty($params['user_id'])) {
            $return = [
                'code' => 4001,
                'msg' => '用户id不能为空'
            ];
            return json_encode($return);
        }
        //获取当前日期
        $today=date('Y-m-d');
        //根据用户id查询签到信息
        $sign1=DB::select("select * from bp_sign_info where user_id = ? ",[$params['user_id']]);
//        dd($sign1);
        if(!empty($sign1)&& $sign1[0]->last_date==$today){
            $return = [
                'code'=>4002,
                'msg'=>"你已经签到过了"
            ];
            return json_encode($return);
        }else{

            if(empty($sign1)){
                //第一次签到的时候
                DB::insert('insert into bp_sign_info(user_id,c_days,total_scores,total_days,last_date) values(?,?,?,?,?)',[$params['user_id'],1,1,1,$today]);
                    $return['date']['score']= 1;
                    return json_encode($return);
            }else{
                //昨天的日期
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
}
