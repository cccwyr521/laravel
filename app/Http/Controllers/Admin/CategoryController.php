<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Tools\ToolsAdmin;
class CategoryController extends Controller
{
    //商品分类的页面
    public function lists()
    {
        return view('admin.category.list');
    }
    //获取商品分类列表的接口数据
    public  function getListData($fid = 0)
    {
        $return =[
            'code'=>2000,
            'msg'=>'成功'
        ];
        $list = Category::getCategoryByFid($fid);

        $return['data']=$list;

        return json_encode($return);
    }
    //商品分类添加页面
    public function add()
    {
        $list= Category::getCategoryList();

        $assign['list']=ToolsAdmin::buildTreeString($list,0,0,'f_id');

        return view('admin.category.add',$assign);
    }

    public function doAdd(Request $request)
    {
        $params = $request ->all();
        if(!isset($params['cate_name']) || empty($params['cate_name'])){
            return redirect()->back()->with('msg','分类的名称不能为空');
        }
        unset($params['_token']);
       $res=Category::doAdd($params);
       if(!$res){
           return redirect()->back()->with('msg','分类添加失败');
       }
       return redirect('/admin/category/list');
    }
    //执行删除的操作
    public function del($id)
    {
        $return =[
            'code'=>2000,
            'msg'=>'成功'
        ];
        $res = Category::del($id);
        if(!$res){
            $return=[
                'code'=>4000,
                'msg'=>'删除失败'
            ];
        }
        return json_encode($return);
    }
    //分类编辑页面
    public function edit($id)
    {
        $assign['info']=Category::getCateInfo($id);
        $list= Category::getCategoryList();

        $assign['list']=ToolsAdmin::buildTreeString($list,0,0,'f_id');
        return view('admin.category.edit',$assign);
    }
    //分类编辑执行操作
    public function doEdit(Request $request)
    {
        $params = $request ->all();

        if(!isset($params['cate_name']) || empty($params['cate_name'])){
            return redirect()->back()->with('msg','分类的名称不能为空');
        }
        unset($params['_token']);
        $res = Category::doUpdate($params,$params['id']);

        if(!$res){
            return redirect()->back()->with('msg','分类修改失败');
        }
        return redirect('/admin/category/list');
    }
}
