<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>填写收货地址</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/writeaddr.css')}}">
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{url('dist/css/LArea.css')}}">
</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">填写收货地址</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <!-- <a href="formDemo" class="m-index-icon">保存</a> -->
</div>
<div class=""></div>
<!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">  
  
</form> -->
<form class="layui-form" method="post">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <div class="addrcon">
    <ul>
      <li><em>收货人</em><input type="text" placeholder="请填写真实姓名" name="address_name"></li>
      <li><em>手机号码</em><input type="number" placeholder="请输入手机号" name="address_tel"></li>
      <li><em>所在区域</em>
        <!-- <input id="demo1" type="text"  name="" placeholder="请选择所在区域">  -->
        <input id="demo1" type="text" readonly="" name="select_area" placeholder="请选择所在区域">
      </li>
      <li class="addr-detail"><em>详细地址</em><input type="text" name="address_detail" placeholder="20个字以内" class="addr"></li>
    </ul>
    <div class="setnormal"><span>设为默认地址</span><input type="checkbox"  name="is_default" lay-skin="switch">  </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
    </div>
  </div>
</form>

<!-- SUI mobile -->
<script src="{{url('dist/js/LArea.js')}}"></script>
<script src="{{url('dist/js/LAreaData1.js')}}"></script>
<script src="{{url('dist/js/LAreaData2.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script src="{{url('layui/layui.js')}}"></script>

<script>
  //Demo
layui.use(['form','layer'], function(){
  var form = layui.form;
  var layer = layui.layer;
  // alert(1);
  // 监听提交
  form.on('submit(formDemo)', function(data){
    // layer.msg(JSON.stringify(data.field));
      $.ajax({
        type:"post",
        url:"writeaddr",
        data:{data:field},
      }).done(function(res){
        console.log(res);
        // if(res=="ok"){
        //     layer.msg('添加成功',{icon:1,time:3000},function(){
        //       location.href="user/address";
        //     });
        // }else{
        //   layer.msg('添加失败',{icon:2});
        // }
      });
    return false;
  });
});

var area = new LArea();
area.init({
    'trigger': '#demo1', //触发选择控件的文本框，同时选择完毕后name属性输出到该位置
    'valueTo': '#value1', //选择完毕后id属性输出到该位置
    'keys': {
        id: 'id',
        name: 'name'
    }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
    'type': 1, //数据源类型
    'data': LAreaData //数据源
});
area.success = function(){
  area.address = area.trigger.value;
  console.log(area.address);
}

</script>


</body>
</html>
