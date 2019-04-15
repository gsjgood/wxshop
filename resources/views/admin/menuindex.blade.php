<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微信菜单</title>
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}" media="all">
    <style>
    span{
        cursor:pointer;
    }
    </style>
</head>
<body>
  <form action="" class="layui-form">
<table class="layui-table">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>菜单层级</th>
      <th>pid</th>
      <th>菜单类型</th>
      <th>菜单名称</th>
      <th>跳转地址</th>
      <th>是否启用</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
      @foreach($menuinfo as $k=>$v)
      @if($v['pid']==0)
    <tr style="display:none;" class="top" pid="{{$v['pid']}}" m_id="{{$v['m_id']}}">
    <td> 
        <font color="red">一级菜单</font>
        <span id="dj">+</span>
    </td>
    <td>{{$v['pid']}}</td>
      <td>{{$v['type']}}</td>
      <td>{{$v['name']}}</td>   
      <td>{{$v['url']}}</td>  
      <td>
        
        <!-- <input type="checkbox" name="xxx" class="status" lay-skin="switch" checked> -->
    <div class="layui-input-block status">
      @if($v['status']==1)
      <input type="checkbox" lay-skin="switch"  lay-filter="a" status="{{$v['status']}}" checked>
      @else
      <input type="checkbox" lay-skin="switch"  lay-filter="a" status="{{$v['status']}}" >
      @endif
    </div>
      </td>
      <td>
        <input type="button"  class="layui-btn layui-btn-radius layui-btn-danger del" value="删除" >        
      </td>  
    </tr>
    @else
    <tr style="display:none;" class="top" pid="{{$v['pid']}}" m_id="{{$v['m_id']}}">
    <td>
        二级菜单
        <span id="dj">+</span>
    </td>
    <td>{{$v['pid']}}</td>
      <td>{{$v['type']}}</td>
      <td>{{$v['name']}}</td>   
      <td>{{$v['url']}}</td>   
      <td>
        <div class="layui-input-block status">
          @if($v['status']==1)
          <input type="checkbox" lay-skin="switch"  lay-filter="a" status="{{$v['status']}}" checked>
          @else
          <input type="checkbox" lay-skin="switch" lay-filter="a"  status="{{$v['status']}}" >
          @endif
        </div>
      </td> 
      <td>
        <input type="button"  class="layui-btn layui-btn-radius layui-btn-danger del" value="删除" >        
      </td>  
    </tr>
    @endif
    @endforeach
  </tbody>
</table>
<input type="button" value="添加新的菜单" id="addmenu"	class="layui-btn layui-btn-normal">
</form>
</body>
</html>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
$(function(){
    var a =$('.top');
    a.each(function(res){
        var b=$(this).attr('pid');
        if(b==0){
            $(this).show();
        }
        // console.log(b);
    })

    $(document).on('click','#dj',function(){
        var _this=$(this);
        var dj = _this.text();
        var m_id=_this.parents("tr").attr('m_id');
        console.log(m_id);
        if(dj == "+"){
            _this.text('-');
            // attr('pid',m_id)m_id
            a.each(function(res){
                var b=$(this).attr('pid');
                if(b==m_id){
                    $(this).show();
                }
            })
        }
        if(dj=="-"){
            _this.text('+');
            a.each(function(res){
                var b=$(this).attr('pid');
                if(b==m_id){
                    $(this).hide();
                    $(this).find('span').text('+');
                }
            })            
        }

    })
    $("#addmenu").click(function(){
        location.href="/addmenu";
    })

})
</script>
<script src="{{url('/layui/layui.js')}}"></script>
<script>
layui.use(['form','layer'], function(){
  var form = layui.form;
  var layer = layui.layer;
  form.on('switch(a)', function(data){
  // console.log(data.elem.checked); //开关是否开启，true或者false
  $('.status').click(function(){
      var _this=$(this);
      var sta=data.elem.checked;
      var status=_this.children().attr('status');
      var m_id =_this.parents('tr').attr('m_id');
      if(sta ==true){
        // console.log(status);
        $.post(
          "/statusUpdate",
          {status:1,m_id:m_id,_token:"{{csrf_token()}}"},
          function(res){
            // console.log(res);
            layer.msg(res,{time:3000},function(){
            history.go(0);
            });
          }
        )
      }else{
        var staa=_this.children().attr('status','2');
        $.post(
          "/statusUpdate",
          {status:2,m_id:m_id,_token:"{{csrf_token()}}"},
          function(res){
            // console.log(res);
            layer.msg(res,{time:3000},function(){
            history.go(0);
            });
          }
        )
      }
    })
  });
  //删除菜单
  $(".del").click(function(){
    var _this=$(this);
    var pid = _this.parents('tr').attr('pid');
    // console.log(pid);
    if(pid==0){
      layer.confirm('此菜单下还有二级菜单，是否删除', {icon: 3, title:'提示'}, function(index){
        var m_id=_this.parents('tr').attr('m_id');
        console.log(m_id);
        $.post(
          "/menudel",
          {m_id:m_id,_token:"{{csrf_token()}}"},
          function(res){
            console.log(res);
            layer.msg(res,{time:3000},function(){
            history.go(0);
            });
          }
        )
      layer.close(index);
      });   
    }else{
      layer.confirm('是否删除', {icon: 3, title:'提示'}, function(index){
        var m_id=_this.parents('tr').attr('m_id');
        console.log(m_id);
        $.post(
          "/menudel",
          {m_id:m_id,_token:"{{csrf_token()}}"},
          function(res){
            console.log(res);
            layer.msg(res,{time:3000},function(){
            history.go(0);
            });
          }
        )
      layer.close(index);
      }); 
    }
  })
});
</script>
</body>
</html>
      
