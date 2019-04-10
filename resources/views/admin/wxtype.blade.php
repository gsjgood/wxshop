<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.1</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{url('admin/xadmin/css/font.css')}}">
	<link rel="stylesheet" href="{{url('admin/xadmin/css/xadmin.css')}}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript"src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.min.js"></script>
    <script src="{{url('admin/xadmin/lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{url('layui/css/layui.css')}}"></script>

    <script type="text/javascript" src="{{url('admin/xadmin/js/xadmin.js')}}"></script>
    <script type="text/javascript" src="{{url('admin/xadmin/js/cookie.js')}}"></script>
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>
<body>
    <form method="post" class="layui-form">
        @csrf
<div class="layui-form-item" >
    <div class="layui-input-block"> 
      <input type="radio" name="sex"  class="news" value="news" title="图文消息" />
    </div>
</div>
<div class="layui-form-item" >
    <div class="layui-input-block">
      <input type="radio" name="sex" class="voice" value="voice" title="语音消息" />
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
      <input type="radio" name="sex" class="video" value="video" title="视频消息" />
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
      <input type="radio" name="sex" class="image" value="image"  title="图片消息"/>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
      <input type="radio" name="sex" class="music" value="music" title="音乐消息" />
    </div>
</div>
<div class="layui-form-item" >
    <div class="layui-input-block">
      <input type="radio" name="sex" class="text" value="text"  title="文本消息" />
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit id="btn" lay-filter="*">提交</button>
    </div>
</div>
</form>
</body>
<script src="{{url('layui/layui.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
$(function(){
    layui.use('form', function(){
    var form = layui.form;
    // var input=$("input");
    // input.each(function(res){
    //     var type = $(this).val();
    //     console.log(type);
    //     if(type=="{{$type}}"){
    //         $("input").prop('checked','checked');
    //     }
    // })
    $("input[class='{{$type}}']").prop('checked',true); 
    console.log($("input[class='{{$type}}']"));
        $("#btn").click(function(){
            //获取单选框的类型
            var type = $("input[type='radio']:checked").val();
            var result = confirm("您选择的"+type+"是否正确");
            if(result){
               $.post(
                   "/admin/wxtypedo",
                   {type:type,_token:"{{csrf_token()}}"},
                   function(res){
                       console.log(res);
                   }
               )
            }else{
                history.go(0);
            }
        })
    });
})
</script>
