<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
	<div id="sign">

	<button v-on:click="dlSign">签到</button> <span v-if="show">今日已签到，获得积分分</span>
	<br/><br/><br/>
	<table border="1">
		{{csrf_field()}}
		<thead><th>总计签到</th><th>总积分</th><th>总签到天数</th></thead>
		
		<tbody>
			
			<tr v-for="sign in sign_list">
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>

</div>
<script src="/js/jquery-2.1.1.min.js"></script>
<script src="/js/vue.js"></script>
<script>
	var sign = new Vue({
		el: "#sign",
		data: {
			show: false,
			score: 0,
			sign_list: [],
		},

		created: function(){
			this.list();
		},

		methods: {

			//获取签名列表

			list:function(){
				var that =this;
				var token = $("input[name=_token]").val();
				$.ajax({
					url:"/Study/Index/getList",
					type:"post",
					dataType: "json",
					data:{_token:token},
					success:function(res){
						if(res.code == 2000){
							that.sign_list = res.data;
						}
					},
					error: function(){

					}
				})
			},

			//执行签名
			dlSign: function(){

				var that =this;
				var token = $("input[name=_token]").val();
				$.ajax({
					url:"/Study/Index/dlSign",
					type:"post",
					dataType: "json",
					data:{user_id:1,_token:token},
					success:function(res){
						if(res.code == 2000){
							that.score = res.data.score;

							that.show=true;

							that.list();
						}else{
							alert(res.msg);
							return false;
						}
					},
					error: function(){

					}
				})

			}
		}
	})
</script>
</body>
</html>