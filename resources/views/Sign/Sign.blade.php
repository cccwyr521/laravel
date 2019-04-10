<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div id="sign">
	<button v-on:click="doSign">签到</button> <span v-if="show">今日已签到，获得积分{{score}}分</span>
	<br/><br/><br/>
	<table border="1">
		<thead><th>总计签到</th><th>总积分</th><th>总签到天数</th></thead>
		<tbody>
			
			<tr v-for="sign in sign_list">
				<td></td>
				<td></td>
				<td>{</td>
			</tr>
		</tbody>
	</table>

</div>
<script src="/js/jquery-2.1.1.min.js"></script>
<script src="/js/vue.js"></script>
</body>
</html>