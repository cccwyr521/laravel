@extends('common.admin_base')

@section('title','管理后天权限列表')

@section('pageHeader')
<div class="pageheader">
      <h2><i class="fa fa-home"></i> 权限列表 <span>Subtitle goes here...</span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label">You are here:</span>
        <ol class="breadcrumb">
          <li><a href="">Bracket</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div>
@endsection

@section('content')
	{{csrf_field()}}
  <div class="row" id="list">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-primary mb30">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>权限名字</th>
                        <th>URL地址</th>
                        <th>是否显示</th>
                        <th>排序</th>
                        <th>操作</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="permission in parmission_list">
                        <td>{permission.id}</td>
                        <td>{permission.name}</td>
                        <td>{permission.url}</td>
                        <td>{permission.is_menu==2 ? '是' : '否'}</td>
                        <td>{permission.sort}</td>
                        <td><button class="btn btn-sm btn-success" v-on:click="getPermissonList(permission.id)">查看子级</button>
                        	<button class="btn btn-sm btn-success" v-if="permission.fid>0" v-on:click="getPermissonList()">返回</button>
                          <button class="btn btn-sm btn-success"  v-on:click="delRecord(permission.id)">删除</button>
                        </td>
                      </tr>
                      
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        </div>

      </div>
     <!--  <script src="/js/jquery-2.1.1.min.js"></script> -->
      <script src="/js/vue.js"></script>
      <script>
      		var list = new Vue({
      			el:"#list",
      			delimiters:['{','}'],
      			data:{parmission_list:[]},
      			created:function(){
      				this.getPermissonList();
      			},
      			methods:{
      				getPermissonList:function(fid=0){
      					var that=this;
      					var token = $("input[name=_token]").val();
      					$.ajax({
      						url:'/admin/get/permission/list/'+fid,
      						type:'post',
      						dataType:'json',
      						data:{_token:token},
      						success:function(res){
      								if(res.code==2000){
      									that.parmission_list=res.data;
      								}
      						},
      						error:function(res){

      						}
      					})
      				},

              delRecord:function(id){
                var that=this;
                
                $.ajax({
                  url:'/admin/permission/del/'+id,
                  type:'get',
                  dataType:'json',
                  data:{},
                  success:function(res){
                      if(res.code==2000){
                        that.getPermissonList();
                      }
                  },
                  error:function(res){

                  }
                })
              }
      			}
      		})
      </script>
	

@endsection

