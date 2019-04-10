<?php
namespace App\Tools;
/**
 * 公共方法类
 */
class ToolsAdmin 
{	
	/**
	*无限极分类的组装
	*@param  $array $data
	*@param  $fid 父类id 
	*/
	public static function buildTree($data,$fid=0)
	{
		if(empty($data)){
			return [];
		}
		static $menus = [];//定义一个静态变量用来存储无限极分类的数据
		foreach($data as $key => $value){
			if($value['fid']==$fid){ //当前循环的内容中fid是否等于函数fid参数

				if(!isset($menus[$value['fid']])){ //如果数据没有fid的key

					$menus[$value['id']]=$value;
				}else{
					$menus[$fid]['son'][$value['id']]=$value;
				}

				//删除已经添加过的数据
				unset($data[$key]);
				self::buildTree($data,$value['id']); //执行递归调用
			}
		}
		return $menus;

	}
	/**
	 * 文件上传的函数
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	public static function uploadFile($files)
	{
		if(empty($files)){
			return "";
		}

		//文件上传的目录
		$basePath = 'uploads/'.date('Y-m-d',time());
		//目录不存在
		if(!file_exists($basePath)){
			@mkdir($basePath,755,true);
		}
		//文件名字
		$filename = "/".date('YmdHis',time()).rand(0,10000).".".$files->extension(); 
		@move_uploaded_file($files->path(),$basePath.$filename);//执行文件的上传
		return '/'.$basePath.$filename;
	}
	/**
	 * 获取用户所有权限的主键id
	 * 
	 */
	public static function getUserPermissionIds($userId)
	{
		//dd($userId);

		if(!isset($userId) || empty($userId)){
			return [];
		}
		$userRole = new \App\Model\UserRole();

		$roles = $userRole->getByUserId($userId);//根据用户id去查询角色id
		//角色id没有或者不存
		if(empty($roles)){
			return [];
		}
		$roleP = new \App\Model\RolePermission();

		$pids=$roleP->getPermissionByRoleId($roles->role_id);//根据用户的角色id去调用权限id集合
		return $pids;
	}
	//获取当前登录用户的所有的权限url地址
	public static function getUrlsByUserId($userId)
	{
		$pids = self::getUserPermissionIds($userId);//获取所有权限节点id

		$urls = \App\Model\Permissions::getUrlsByIds($pids);//根据权限节点id获取所有的权限的url地址
		return $urls;
	}
    //创建无限级分类树形结构
	public static function buildTreeString($data,$fid,$level,$fkey="fid")
    {
        if(empty($data)){
            return [];
        }
        static $tree = [];
        foreach($data as $key => $vaule){
            //判断当前的父类id是否等于递归调用传过来的id
            if($vaule[$fkey]==$fid){
                $vaule['level']=$level;
                $tree[]=$vaule;
                unset($data[$key]);
                self::buildTreeString($data,$vaule['id'],$level+1,$fkey);
            }

        }
        return $tree;
    }

    //生成货号
    public static function buildGoodsSn($string = 16)
    {
        return "JY".date("YmdHis",time());
    }
}
?>