<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Tools\ToolsAdmin;

class Permissions extends Model
{
    //指定表名
     protected $table = "Permissions";
     const 
     		IS_MENU =1, //是菜单
     		IS_NO_MENU =2,//不是菜单

     		END =true;
     //获取左侧菜单的权限数据
     public static function getMeuns($user = [])
     {
     	$Permissions = self::select('id','fid','name','url')
     				->where('is_menu',self::IS_MENU)
	     			->orderBy('sort')
	     			->get()
	     			->toArray();
            //如果不是超管
        if($user['is_super'] !=2){
            $pids = ToolsAdmin::getUserPermissionIds($user['user_id']);//当前登录用户的所有权限节点
            $Permissions = self::select('id','fid','name','url') 
                        ->whereIn('id',$pids)
                        ->where('is_menu',self::IS_MENU)
                        ->orderBy('sort')
                        ->get()
                        ->toArray();
        }
	   $leftMenu = ToolsAdmin::buildTree($Permissions);
	     return $leftMenu;
     }
          //获取权限列表
     public static function getListByFid($fid=0)
     {
          $list = self::select('id','fid','name','is_menu','url','sort')
                        ->where('fid',$fid)
                        ->orderBy('sort')
                        ->get()
                        ->toArray();
               return $list; 
     }

     /**
      * 添加权限
      * @param [type] $data [description]
      */
     public static function addRecord($data)
     {
        return self::insert($data);
     }
 /**
  * 删除权限的函数
  * @param  [type] $id [description]
  * @return [type]     [description]
  */
     public static function delRecord($id)
     {
        return self::where('id',$id)->delete();
     }
     
     public static function getAllPermissions()
     {
      $Permissions = self::select('id','fid','name','url')
                        ->orderBy('sort')
                        ->get()
                        ->toArray();
                  $Permissions =ToolsAdmin::buildTree($Permissions);
                  return $Permissions;
     }
     //通过权限的主键id获取权限的url地址集合
     public static function getUrlsByIds($pids)
     {
        $permissions = self::select('url')
                            ->whereIn('id',$pids)
                            ->get()
                            ->toArray();
        $urls = [];
        foreach($permissions as $key=>$value){
          $urls[] =$value['url'];
        }
        return $urls;
     }

}
