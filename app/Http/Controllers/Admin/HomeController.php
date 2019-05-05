<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{	
    //后台首页
    public function home()
    {	
    	//redis缓存数据
    	$admin_data_key = "admin_home_data";
    	$redis = new \Redis();
    	$redis->connect('127.0.0.1',6379);

    	$data  = $redis->get($admin_data_key);

    	//今日日期
	    	$today = date('Y-m-d');
	    	//明天日期
	    	$tommorrow = date('Y-m-d',strtotime('+1 days'));
	    	//一周前的日期
	    	$lastWeek = date('Y-m-d',strtotime('-5 days'));

    	if(empty($data)){//redis数据如果为空
    		
	    	/*****************************[会员统计]************************************************/
	    	//会员总数
	    	$assign['member_nums'] = \DB::table('jy_user')->count('id');
	    	// 今日注册
	    	 $assign['today_nums'] = \DB::table('jy_user')->where('created_at','>=',$today)
	    	 ->where('created_at','<',$tommorrow)->count('id');
	    	 //近一周的会员注册量
	    	 $assign['last_week'] = \DB::table('jy_user')->where('created_at','>=',$lastWeek)
	    	 ->where('created_at','<',$tommorrow)->count('id');

	    	  //近一周的会员注册走势图
			 $member_data = \DB::table('jy_user')->select(\DB::raw("DATE_FORMAT(created_at,'%y-%m-%d')
			  as date,count(id) as nums"))
			 ->where('created_at','>=',$lastWeek)->where('created_at','<',$tommorrow)
			 ->groupBy(\DB::raw("DATE_FORMAT(created_at,'%y-%m-%d')"))
			 ->get();

			 $dates = $registes = '';

			 foreach ($member_data as $k => $v) {
			 		$dates .= "'".$v->date."' ,";
			 		$registes .= $v->nums. " ,";
			 }

			 // dd($dates,$registes);

			 $assign['register_date'] = rtrim($dates);
			 $assign['register_nums'] = rtrim($registes);

			 // dd($assign);
	    	 /*****************************[会员统计]*************************************************/

	    	 /*****************************[订单相关]*************************************************/
	    	//订单总数
	    	 $assign['order_nums'] = \DB::table('jy_order')->count('id');
	    	//今日订单总数
	    	 $assign['today_order_nums'] = \DB::table('jy_order')->where('created_at','>=',$today)
	    	 ->where('created_at','<',$tommorrow)->count('id');
	    	 //近一周的订单总数 
	    	 $assign['last_order_week'] = \DB::table('jy_order')->where('created_at','>=',$lastWeek)
	    	 ->where('created_at','<',$tommorrow)->count('id');
	    	 // dd($assign['last_order_week']);
	    	 /*****************************[订单相关]*************************************************/

	    	 /*****************************[商品相关]*************************************************/
	    	 //商品订单总数
	    	 $assign['goods_nums'] = \DB::table('jy_goods')->count('id');
	    	 //今日商品订单总数
	    	 $assign['today_goods_nums'] = \DB::table('jy_goods')->where('created_at','>=',$today)
	    	 ->where('created_at','<',$tommorrow)->count('id');
	    	 //近一周的商品
	    	 $assign['last_goods_week'] = \DB::table('jy_goods')->where('created_at','>=',$lastWeek)
	    	 ->where('created_at','<',$tommorrow)->count(('id'));
	    	 /*****************************[商品相关]*************************************************/
	    	 //设置redis的缓存
	    	 $redis->setex($admin_data_key,1800,json_encode($assign));
	    	 // dd($redis);

    	}else{//不为空走缓存
    		
    		$assign = json_decode($data,true);
    		

    	}

    	
    	 

    	 
    	return view('admin.home.home',$assign);
    }
}
