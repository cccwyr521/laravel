<?php

namespace App\Study;


use Illuminate\Database\Eloquent\Model;

class BsBonus extends Model
{
    //红包表
    protected $table = "bs_bonus";
    public static  function getBounsInfo($id)
    {
        $bouns=self::where('id',$id)->first();
        return $bouns;
    }

    /**
     * @param $data 更新红包信息
     * @param $id
     * @return bool
     */
    public  static function updateBonusInfo($data,$id)
    {
        return self::where('id',$id)->update($data);
    }
}
