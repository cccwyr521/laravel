<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use Illuminate\Support\Facades\DB;
use App\Model\UserRole;
use App\Model\RolePermission;
use App\Model\permissions;
use Log;

class RoleController extends Controller
{
	//角色列表
     public function list()
     {
     	$roles =new Role();
     	$assign['role_list'] = $roles->getRoles();

     	return view('admin.role.list',$assign);
     }
     //角色删除也
     public function delRole($id)
     {
     	try {
     		DB::beginTransaction();//开启事务 
     		$role = new Role();
     		$UserRole = new UserRole();
     		$rolePer = new RolePermission();
     		//删除角色记录
     		$role ->delRole($id);
     		//删除当前角色用户角色记录
     		$UserRole->delRoleId($id);
     		//删除当前角色的权限记录
     		$rolePer ->delByRoleId($id);
     		DB::commit();//提交事务
     		
     	} catch (\Exception $e) {
     		DB::rollBack();//事务回滚
     		Log::error('角色删除失败'.$e->getMessage());
     	}
     	return redirect('/admin/role/list');
     }

     public function edit($id)
     {
     	$role =new Role();
     	$assign['role']=$role->getRoleById($id);
     	return view('admin.role.edit',$assign);
     }
     //执行角色编辑
     public function doEdit(Request $request)
     {
     	$params =$request->all();

     	$data = [
     		'role_name' => $params['role_name'] ?? "",
     		'role_desc' => $params['role_desc'] ?? "",
     	];

     	$role = new Role();

     	$role ->updateRole($data,$params['id']);
     	if(!$role){
     		return redirect()->back();
     	}
     	return redirect('/admin/role/list');
     }
     //创建角色	
     public function create()
     {
     	return view('admin.role.create');
     }
     //执行添加
     public function store(Request $request)
     {

     	$params =$request->all();

     	$role=new Role();
     	$data = [
     		'role_name' => $params['role_name'] ?? "",
     		'role_desc' => $params['role_desc'] ?? "",
     	];
     	$res = $role ->addRole($data);
     	if(!$res){
     		return redirect()->back();

     	}
     	return redirect('/admin/role/list');
     }

     public function rolePermission($roleId)
     {
     	$role=new Role();
     	$roleP=new RolePermission();
     	$assign['role']=$role->getRoleById($roleId);//获取角色信息
     	$assign['permissions']=permissions::getAllPermissions();//获取所有的权限节点
     	$assign['p_ids']=RolePermission::getPermissionByRoleId($assign['role']->id);
     	 //通过角色的id获取所分配的所有权限节点id
     	return view('admin.role.permission',$assign);
     }
     //保存角色和权限的节点信息
     
     public function saveRolePermission(Request $request)
     {
     	$params = $request->all();
     	try {
     		$roleP = new RolePermission();
     		//先删除原来的权限节点数据
     		$roleP->delByRoleId($params['role_id']);
     		//添加新的节点数据
     		$data = [];
     		foreach($params['permissions'] as $key=>$value){
     			$data[$key] = [
     				'role_id'=>$params['role_id'],
     				'p_id'=>$value
     			];
     		}
     		$roleP->addRolePermission($data);
     	} catch (\Exception $e) {
     		Log::error('保存失败'.$e->getMessage());
     		return redirect()->back();
     	}
     	return redirect('/admin/role/list');
     }
}
