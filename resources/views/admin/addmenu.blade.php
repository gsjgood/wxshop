<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加菜单</title>
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}" media="all">
</head>
<body>
<form class="layui-form" method="post" action="/domenuadd">
    <!-- @csrf -->
    <input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="layui-form-item">
<label class="layui-form-label">菜单名称</label>
<div class="layui-input-block">
    <input type="text" name="name" placeholder="请输入菜单名称" class="layui-input">
</div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">菜单等级</label>
    <div class="layui-input-block">
      <select name="pid" lay-filter="menu">
        <option value="0">一级菜单</option>
        @foreach($menu as $k=>$v)
        <option value="{{$v['m_id']}}">二级菜单：{{$v['name']}}</option>
        @endforeach
    </select>
    </div>
</div>    
<div class="layui-form-item "  id="types" style="display:none;" >
    <label class="layui-form-label">选择类型</label>
    <div class="layui-input-block">
      <select name="type" lay-filter="aihao" id="type">
        <option value="0">请选择</option>
        <option value="click">click</option>
        <option value="view">view</option>
      </select>
    </div>
</div>
<div class="layui-form-item" id="key" style="display:none;" >
    <input type="text" name="key" placeholder="请输入KEY的值" class="layui-input">
</div>
<div class="layui-form-item"  id="url" style="display:none;" >
    <input type="text" name="url" placeholder="请输入url地址" class="layui-input">
</div>

<div class="layui-form-item">
<div class="layui-input-block">
    <button class="layui-btn" lay-submit lay-filter="*">添加</button>
</div>
</div>
</form>
</body>
</html>
<script src="{{url('layui/layui.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
$(function(){
    layui.use(['form','element'], function(){
    var element = layui.element;
    var form = layui.form;
    // $("#types").css("display",'block');

    form.on('select(menu)', function(data){
        console.log(data.value); //得到被选中的值
        if(data.value=="1"){
            $("#types").css("display",'block');
        }else if(data.value=="2"){
            $("#types").css("display",'block');
        }else if(data.value==0){
            $("#url").hide(); 
            $("#key").hide();
            $("#types").css("display",'none'); 
        }
    }); 
    form.on('select(aihao)', function(data){
        console.log(data.value); //得到被选中的值
        if(data.value=="click"){
            $("#url").hide(); 
            $("#key").show();
        }else if(data.value=="view"){
            $("#key").hide();
            $("#url").show();
        }else if(data.value==0){
            $("#key").hide();
            $("#url").hide();

        }
    }); 
    // form.on('submit(*)', function(data){
    //     console.log(data.field)
    //     $.post(
    //         "/domenuadd",
    //         {data.filed,_token:"{{csrf_token()}}"},
    //         function(res){
    //             console.log(res);
    //         }
    //     );
    //     return false;
    // });
    });
})
</script>