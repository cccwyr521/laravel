<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Study\BsBonus;
use App\Study\BsBonusRecord;
use Log;

class BonusController extends Controller
{
    //首页
    public  function index()
    {
            return view('study/.index');
    }
    //添加红包
    public function addBonus(Request $request)
    {
        $params=$request->all();//获取所有参数
        $return=[
            'code'=>2000,
            'msg'=>'成功'
        ];
        try{

        }catch(\Exception $e){
            $return = [
                'code'=>getCode(),
                'msg'=>getMessage()
            ];
            return json_encode($return);
        }
          return json_encode($return);
    }

    //获取红包列表
        public function getList()
        {
            $list = BsBonus::getBonusList();
            $return = [
                'code'=>2000,
                'msg'=>'成功',
                'data'=>$list
            ];
            return json_encode($return);
        }

        //红包记录列表
        public function getBonusRecord(Request $request)
        {
            $bonusId =$request->input('bonus_id',1);
            $list=BsBonusRecord::getBonusRecord($bonusId);
            $return = [
                'code'=>2000,
                'msg'=>'成功',
                'data'=>$list
            ];
            return json_encode($return);
        }
    public function getBonus(Request $request)
    {
        $params=$request->all();
        $params['user_id']=rand(1,100);
        $return=[
            'code'=>2000,
            'msg'=>'成功',
             
        ];
        if(!isset($params['user_id'])||empty($params['user_id'])){
            $return=[
                'code'=>4001,
                'msg'=>'用户未登录'
                
            ];
            return json_encode($return);
        }
        if(!isset($params['bonus_id'])||empty($params['bonus_id'])){
            $return=[
                'code'=>4002,
                'msg'=>'请选择指定红包'
                
            ];
            return json_encode($return);
        }

        //检测红包是否存在
        $bouns=BsBonus::getBounsInfo($params['bonus_id']);
        if(empty($bouns)){
            $return=[
                'code'=>4003,
                'msg'=>'红包不存在'
            ];
            return json_encode($return);
        }

        $record=BsBonusRecord::getRecordById($params['user_id'],$params['bonus_id']);
        if($record){
            $return=[
                'code'=>4005,
                'msg'=>'你已经抢过红包了'
            ];
            return json_encode($return);
        }

        //判断红包是否被抢光
        if($bouns->left_amount <=0 || $bouns->left_nums<=0)
        {
            $return=[
                'code'=>4004,
                'msg'=>'红包已经被抢光了'
            ];
            return json_encode($return);
        }
        //是否是最后一个红包
        if($bouns->left_nums ==1)
        {
            Log::info('最后一个红包抢到人的id'.$params['user_id']);
            //用户抢到的金额
            $getMoney = $bouns->left_amount;
            //插入一条bouns_record记录
            $data = [
              'user_id'=>$params['user_id'],
                'bonus_id'=>$params['bonus_id'],
                'money'=>$getMoney,
                'flag'=>1
            ];
            BsBounsRecord::createRecord($data);
            //更新红包记录表的数据
                $data1=[
                    'left_amoun'=>0,
                    'left_nums'=>0
                ];
                BsBonus::updateBonusInfo($data1,$params['bonus_id']);
            //评选出运气王
            //降序排列红包抢的记录
                $res=BsBonusRecord::getMaxBonus($params['bonus_id']);
                //更新抢红包的记录
            BsBonusRecord::updateBonusRecord(['flag'=>2],$res->id);


        }else{
            $min=0.01;//最小金额
            $max=$bouns->left_amount-($bouns->left_nums-1)*0.01;
            $getMoney=rand($min*100,$max*100)/100;//获取金额随机值
            //插入用户抢到的一条bouns_record记录
            $data=[
              'user_id'=>$params['user_id'],
                'bonus_id'=>$params['bonus_id'],
                'money'=>$getMoney,
                'flag'=>1
            ];
            BsBonusRecord::createRecord($data);
            //更新红包的金额
            $data1=[
                'left_amount'=>$bouns->left_amount->$getMoney,
                'left_nums'=>$bouns->left_nums -1
            ];
            BsBonus::updateBonusInfo($data1,$params['bonus_id']);
    }
        return json_encode($return);
    }
}
