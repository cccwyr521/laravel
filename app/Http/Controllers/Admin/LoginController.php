<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminUsers;
class LoginController extends Controller
{
    /**
     * 登录页面
     */
    public function index(Request $request)
    {           
            $session=$request->session();
            if($session->has('user')){
                    return redirect('/admin/home');
            }
            return view('admin.login');
    }
    /**
     * 执行登录页面
     */
    public function doLogin(Request $request)
    {
        $params=$request->all();
        $return=[
            'code'=>2000,
            'msg'=>'登录成功'
        ];
        //用户名不能为空
        if(!isset($params['username'])||empty($params['username'])){

                $return=[
                'code'=>4000,
                'msg'=>'用户名不能为空'
                ];
                return json_encode($return);
        }
        if(!isset($params['password'])||empty($params['password'])){

                $return=[
                'code'=>4001,
                'msg'=>'密码不能为空'
                ];
                return json_encode($return);
        }
        //通过用户名获取用户的信息
        $userInfo = AdminUsers::getUserByName($params['username']);

        if(empty($userInfo)){
            $return=[
                'code'=>4002,
                'msg'=>'用户不存在'
                ];
                return json_encode($return);

        }else{
        //传递过来的密码
        $postPwd=md5($params['password']);
        if($postPwd !==$userInfo->password){
                $return=[
                'code'=>4003,
                'msg'=>'密码不正确'
                ];
                return json_encode($return);
        }else{
                //密码正确执行登录
            $session=$request->session();

            //储存用户id
            $session->put('user.user_id',$userInfo->id);
            $session->put('user.username',$userInfo->username);
            $session->put('user.image_url',$userInfo->image_url);
            $session->put('user.is_super',$userInfo->is_super);
            
            return json_encode($return);
        }
    }


    }

    public function logout(Request $request)
    {
        //session 删除
        $request->session()->forget('user');
        return redirect('/admin/login');
    }

}
