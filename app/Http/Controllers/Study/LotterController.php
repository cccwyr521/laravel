<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LotterController extends Controller
{
    //抽奖页面
    public function lottery()
    {
        return view('study.lottery.index');
    }
    //执行抽奖的操作
    public function doLottery(Request $request)
    {
        $phone = $request->input('phone');
        $start=date('Y-m-d 17:00:00',time());

        $end= date('Y-m-d 20:00:00',time());
        $return = [
            'code'=>2000,
            'msg'=>'成功'
        ];

            if(empty($phone)){
                $return = [
                    'code'=>4001,
                    'msg'=>'手机号不能为空'
                ];
                return json_encode($return);
            }

            //检测用户信息
            $user = DB::table('study_lottery_user')->where('phone',$phone)->first();
            if(empty($phone)){
                $return = [
                    'code'=>4002,
                    'msg'=>'用户不存在'
                ];
                return json_encode($return);
            }
            $records=DB::table('study_lottery_record')->where('user_id',$user->id)->where('create_at',date('Y-m-d'))->count();
            if($records>=3){
                $return = [
                    'code'=>4003,
                    'msg'=>'今日抽奖次数已用完请明天再来'
                ];
                return json_encode($return);
            }
            if(time()>strtotime($end) || time() < strtotime($start)){
                $return = [
                    'code'=>4004,
                    'msg'=>'请在活动时间内来抽奖'
                ];
                return json_encode($return);
            }
            $lottery=DB::table('study_lottery')->get()->toArray();
            $lotterys = $precents=[];
            foreach($lottery as $key=>$value){
                $lotterys[$value->id]=[
                    'lottery_name' => $value->lottery_name
                ];
                $precents[$value->id]=$value->precent;

            }
            $preSum=array_sum($precents);
            $result='';
            foreach($precents as $k=>$v){
                $preCurrent = mt_rand(1,$preSum);
                if($v > $preCurrent){
                   $result = $k;
                   break;
                }else{
                    $preSum = $preSum - $v;
                }
            }
            $data = [
              'user_id'=>$user->id,
                'lottery_id'=>$result,
                'create_at'=>data('Y-m-d')
            ];
            DB::table('study_lottery_record')->insert($data);
            $return['data']=$lotterys[$result]['lottery_name'];
    }
}
