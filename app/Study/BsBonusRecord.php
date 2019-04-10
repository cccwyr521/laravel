<?php

namespace App\Study;

use Illuminate\Database\Eloquent\Model;

class BsBonusRecord extends Model
{
    //用户抢到红包的记录表
    protected $table = "bs_bonus_record";

    /**
     * @param $data 创建一条记录
     * @return bool array
     */
    public static function createRecord($data)
    {
        $res  = self::insert($data);
        return $res;
    }

    /**
     * @param $bounsId获取最大金额的红包id
     */
    public static function getMaxBouns($bounsId)
    {
        $res=self::select('id')
            ->where('bonus_id',$bounsId)
            ->orderBy('money','desc')
            ->first();
        return $res;
    }

    /**
     * @param $data更新抢红包的记录
     * @param $id
     * @return bool
     */
    public static function updateBonusRecord($data,$id)
    {
        return self::where('id',$id)->update($data);
    }

    /**
     * @param $userId 通过用户id和红包id获取红包记录
     * @param $bonusId
     * @return BsBonusRecord|Model|null
     */
    public  static  function  getRecordById($userId,$bonusId)
    {
        return self::where('user_id',$userId)->where('bonus_id',$bonusId)->first();
    }

}
