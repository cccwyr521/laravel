<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //
     protected $table='user_role';

     public $timestamps=false;

     public function addUserRole($data)
     {
     	return self::insert($data);
     }
     //通过userid删除记录
     public function delByUserId($userId)
     {
     	return self::where('user_id',$userId)->delete();
     }
     //通过用户id删除记录
     public function getByUserId($userId)
     {
     	return self::where('user_id',$userId)->first();
     }
     //通过角色id删除记录
     public function delRoleId($roleId)
     {
          return self::where('role_id',$roleId)->delete();
     }

}
