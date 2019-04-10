<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUsers extends Model
{
    //
     //制定数据库表名
     protected $table="admin_users";

    public $timestamps = true;

    //通过用户名获取用户
    public static function getUserByName($username) 
    {
    	$userInfo = self::where('username',$username)
    					->where('status',1)
    					->first();
    					//dd($userInfo);
		return $userInfo;

    					
    } 	
        public static function getUserById($id) 
    {
        $userInfo = self::where('id',$id)
                        ->first();
                        //dd($userInfo);
        return $userInfo;

                        
    }   

    //用户保存	
    public function addRecord($data)
    {
        return self ::insert($data);
    }	

    public function getMaxId()
    {
        return self::select('id')->orderBy('id','desc')->first(); 
    }
    //修改用户信息

    public function updateUser($data,$id)
    {
        return self::where('id',$id)->update($data);
    }

     //获取用户列表的信息
     public static function getList()
     {
      return self::paginate(1);
     } 

     //用户删除
     //@param id
     public static function del($id)
     {
        return self::where('id',$id)->delete();
     } 		
}
