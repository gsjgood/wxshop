<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>关注内容设置</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{url('admin/xadmin/css/font.css')}}">
	<link rel="stylesheet" href="{{url('admin/xadmin/css/xadmin.css')}}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript"src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.min.js"></script>
    <script src="{{url('admin/xadmin/lib/layui/layui.js')}}" charset="utf-8"></script>

    <script type="text/javascript" src="{{url('admin/xadmin/js/xadmin.js')}}"></script>
    <script type="text/javascript" src="{{url('admin/xadmin/js/cookie.js')}}"></script>
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>
<body>
    <form action="upsubscribe" method="post" enctype="multipart/form-data">
    @csrf
        <p></p>
        <label class="layui-form-label">请选择回复的类型：</label>
        <select name="type" id="type">
            <option value="text">文本</option>
            <option value="img">图片</option>
            <option value="audio">语音</option>
            <option value="music">音乐</option>
            <option value="video">视频</option>
            <option value="news">图文</option>
        </select>
        <div class="content" width="200px;" height="200px;" class="layui-form-item">
        </div>
        <div id="show" style="display:none;">
        设置标题：<input type="text" name='title' class="layui-input">
        设置简介：<input type="text"name='des' class="layui-input">
        跳转地址：<input type="text"name='url' class="layui-input">
        选择图片：<input type="file" name='img'>
        </div>
        <input type="submit" class="layui-btn layui-btn-normal" value="提交">
    </form>
</body>
<script src="{{url('layui/layui.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
$(function(){
    layui.use(['form','element'], function(){
    var element = layui.element;
    var form = layui.form;
        $("#type").click(function(){
            var type = $(this).val();
            console.log(type);
            $("#show").css('display','none');        
            if(type=="text"){
                $(".content").empty();
                $(".content").append("<textarea name='content'  cols='30' rows='10'></textarea>");            
            }else if(type=="img"){
                $(".content").empty();
                $(".content").append("<input type='file' name='img' >");
            }else if(type=="audio"){
                $(".content").empty();
                $(".content").append("<input type='file' name='img'>");
            }else if(type=="music"){
                $(".content").empty();
                $(".content").append("<input type='file' name='img'>");
            }else if(type=="video"){
                $(".content").empty(); 
                $(".content").append("<input type='file' name='img'>");
            }else if(type=='news'){
                // alert(1);
                $(".content").empty();
                $("#show").show();
            }
        })
    });
})
</script>