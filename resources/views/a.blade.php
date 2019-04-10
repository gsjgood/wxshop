<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
	li{
		float:left;
		list-style:none;
		margin-left:20px;
	}
	</style>
</head>
<body>
	<div id="div1">
		<input type="text" id="sss">
		<input type="button" id="seach" value="搜索">
		@foreach($goodsInfo as $k=>$v)
			<p>{{$v->goods_name}}</p>
		@endforeach
		<div>
			 <li>{!! $goodsInfo->appends(['seach'=>$seach])->render()!!}​</li>
		</div>
	</div>
</body>
</html>
<script src="js/jquery-1.11.2.min.js"></script>
<script>
$(function(){
	$("#seach").click(function(){
		var _this=$(this);
		var sss=$('#sss').val();
		// console.log(sss);
		$.ajax({
			type:"post",
			url:"/a",
			data:{_token:"{{csrf_token()}}",seach:sss},
			success:function(res){
				// console.log(res);
				$("#div1").html(res);
			}
		})

	})
})
</script>
