<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    const
        USE_ABLE = 1,//可用
        USE_DISABLE = 2,//禁用
        END = TRUE;
    protected $table="jy_category";
    public $timestamps=false;
    //获取分类列表
    public static function getCategoryList()
    {
        $list=self::get()->toArray();
        return $list;
    }
    //添加分类的数据
    public static function doAdd($data)
    {
            return self::insert($data);
    }
    public static function doUpdate($data,$id)
    {
        return self::where('id',$id)->update($data);
    }
    //通过fid查询子级分类
    public static function getCategoryByFid($fid=0)
    {
        $list = self::where('f_id',$fid)->get()->toArray();
        return $list;
    }
    //执行删除
    public static function del($id)
    {
        return self::where('id',$id)->delete();
    }
    //获取分类的信息
    public static function getCateInfo($id)
    {
        return self::where('id',$id)->first();
    }

}
