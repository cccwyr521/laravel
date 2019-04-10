<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	//作者表
    protected $table = "author";
    const PAGE_SIZE =5;
    //作者分页显示
    public function getLists()
    {
    	return self::paginate(self::PAGE_SIZE);
    }
    	//执行作者添加
    public function addRecord($data)
    {
    	return self::insert($data);
    }

    public function delRecord($id)
    {
    	return self::where('id',$id)->delete();
    }

    //获取作者列表
    public function getAuthor()
    {
        return self::get()->toArray();
    }
}
