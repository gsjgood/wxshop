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
</head>
<body>
    <form action="/admin/upsubscribe" method="post" enctype="multipart/form-data">
    @csrf
        <div class="select">
            <p>请选择回复的类型：</p>
            <label class="layui-form-label"></label>
            <select name="type" id="type">
                <option value="text">文本</option>
                <option value="img">图片</option>
                <option value="voice">语音</option>
                <option value="music">音乐</option>
                <option value="video">视频</option>
                <option value="news">图文</option>
            </select>
        </div>
        <div class="text" >
            <textarea name="content" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="news" style="display:none;">
            设置标题：<input type="text" name='title' class="layui-input">
            设置简介：<input type="text"name='des' class="layui-input">
            跳转地址：<input type="text"name='url' class="layui-input">
        </div>
        <div class="video" style="display:none;">
            设置标题：<input type="text" name='title' class="layui-input">
            设置简介：<input type="text"name='des' class="layui-input">
        </div>
        <div class="img voice music" style="display:none;">
            <input type='file' name='img'>        
        </div>
        <div class="btn">
            <input type="submit" style="margin-top:50px;" class="layui-btn layui-btn-normal" value="提交">
        </div>
    </form>
</body>
<script src="{{url('layui/layui.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
$(function(){
    layui.use(['form','element'], function(){
    var element = layui.element;
    var form = layui.form;
    //改变文件类型所需要添加的数据
        $("#type").change(function(){
            var type = $(this).val();
            console.log(type);
            if(type =="news"){
                $('.news').show();
                $(".news").siblings().hide();
                $('.select').show();
                $('.btn').show();
                $('.img').show();
            }else if(type == "text"){
                $('.text').show();
                $(".text").siblings().hide();
                $('.select').show();
            }else if(type == "video"){
                $('.video').show();
                $(".video").siblings().hide();
                $('.select').show();
                $('.btn').show();
                $('.img').show();
            }else{
                $('.text').hide();
                $(".news").hide();
                $('.img').show();
                $('.btn').show();
            }
        })
    });
})
</script>