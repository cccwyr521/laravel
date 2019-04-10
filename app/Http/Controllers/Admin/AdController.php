<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdPosition;
use App\Model\Ad;
use App\Tools\ToolsAdmin;
use think\response\Redirect;

class AdController extends Controller
{
    //
    protected $position = null;
    protected $ad=null;
    public function __construct()
    {
        $this->position = new AdPosition();
        $this->ad=new Ad();
    }
//广告列表页面
    public function lists()
    {
        $assign['list'] = $this->ad->getAdList();
        return view('admin.ad.list',$assign);
    }
    //广告添加页面
    public function add()
    {
        $assign['position'] = $this->position->getList();//获取广告位列表
        return view('admin.ad.add',$assign);
    }
    public function store(Request $request)
    {
        $params = $request->all();

        if(!isset($params['image_url']) || empty($params['image_url'])){
            return redirect()->back()->with('msg','请先上传图片');
        }

        $params['image_url'] = ToolsAdmin::uploadFile($params['image_url']);

        $params = $this->delToken($params);


        $ad = new Ad();

        $res = $this->storeData($ad, $params);

        if(!$res){
            return redirect()->back()->with('msg','添加广告失败');
        }

        return redirect('/admin/ad/list');
    }
    public function edit($id)
    {
        $ad = new Ad();
        $assign['info']=$this->getDataInfo($ad,$id);
        $assign['position']=$this->position->getList();
        return view('admin.ad.edit',$assign);
    }
    public function doEdit(Request $request)
    {
        $params = $request->all();
        if(isset($params['image_url'])&&!empty($params['image_url'])){
            $params['image_url']=ToolsAdmin::uploadFile($params['image_url']);
        }
        $params = $this->delToken($params);
        $ad = Ad::find($params['id']);
        $res =$this->storeData($ad,$params);
        if(!$res){
            return redirect()->back()->with('msg','添加修改失败');
        }
        return redirect('/admin/ad/list');
    }
    public function del($id)
    {
        $ad = new Ad();
        $res =$this->delData($ad,$id);
        return redirect('/admin/ad/list');
    }

}
