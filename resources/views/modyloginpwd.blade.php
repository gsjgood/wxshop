<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>修改支付密码</title>
<meta content="app-id=984819816" name="apple-itunes-app" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('css/login.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('css/findpwd.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
<link rel="stylesheet" href="{{url('css/modipwd.css')}}">
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">修改登录密码</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
</div>



    <div class="wrapper">
        <form class="layui-form" action="">
            <div class="registerCon regwrapp">
                <div class="account">
                    <em>账户名：</em> <i>{{Session::get('userInfo.user_name')}}</i>
                </div>
                <div><em>当前密码</em><input type="password" id="user_pwd"name="user_pwd"></div>
                <div><em>新密码</em><input type="password" id="verifcode" name="pwd" placeholder="请输入6-16位数字、字母组成的新密码"></div>
                <div><em>确认新密码</em><input type="password" id="verifcode2" placeholder="确认新密码" name="pwd2"></div>
                <button class="save" lay-submit lay-filter="formDemo">提交</button>
            </div>
        </form>
    </div>


<script src="{{url('layui/layui.js')}}"></script>
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  //监听提交
  form.on('submit(formDemo)', function(data){
    var user_pwd=$("#user_pwd").val();
    var pwd=$('#verifcode').val();
    var pwd2=$('#verifcode2').val();
    $.ajax({
        type:"post",
        url:"updatepwd",
        data:{pwd:pwd,pwd2:pwd2,user_pwd:user_pwd, _token:"{{csrf_token()}}"},
        success:function(res){
            if(res=="修改成功"){
                layer.msg(res,{icon:1,time:3000},function(res){
                    location.href="safeset";
                });            
            }else{
                layer.msg(res,{icon:2});
            }
        }
    });
    return false;
  });
});
function resetpwd(){
        // 密码失去焦点
        $('#verifcode').blur(function(){
            reg=/^[0-9A-Za-z]{6,16}$/;
            var that = $(this);
            if( that.val()==""|| that.val()=="6-16位数字、字母组成"){   
                layer.msg('请重置密码！');
            }else if(!reg.test(that.val())){
                layer.msg('请输入6-16位数字、字母组成的密码！');
            }
        })

    }
    resetpwd();
function resetpwd1(){
    // 密码失去焦点
    $('#verifcode2').blur(function(){
        var that = $(this);
        var pwd=$('#verifcode').val();
        var pwd2=$('#verifcode2').val();
        if(pwd !=pwd2){   
            layer.msg('俩次输入密码不一致');
        }
    })

}
resetpwd1();
</script>    

</body>
</html>
    