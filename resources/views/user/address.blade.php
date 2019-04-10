<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>地址管理</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/address.css')}}">
    <link rel="stylesheet" href="{{url('css/sm.css')}}">
  
   
    
</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">地址管理</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="writeaddr" class="m-index-icon">添加</a>
</div>
<div class="addr-wrapp">
    @foreach($res as $k=>$v)
    @if($v['is_default']==1)
    <div class="addr-list" >
         <ul>
            <li class="clearfix">
                <span class="fl">{{$v['address_name']}}</span>
                <span class="fr">{{$v['address_tel']}}</span>
            </li>
            <li>
                <p>{{$v['select_area']}},{{$v['address_detail']}}</p>
            </li>
            <li class="a-set" address_id="{{$v['address_id']}}">
                <s class="z-set" style="margin-top: 6px;"></s>
                <span>设为默认</span>
                <div class="fr" address_id="{{$v['address_id']}}">
                    <!-- <span class="edit">编辑</span> -->
                    <span class="remove">删除</span>
                </div>
            </li>
        </ul>  
    </div>
    @else
    <div class="addr-list" >
         <ul>
            <li class="clearfix">
                <span class="fl">{{$v['address_name']}}</span>
                <span class="fr">{{$v['address_tel']}}</span>
            </li>
            <li>
                <p>{{$v['select_area']}},{{$v['address_detail']}}</p>
            </li>
            <li class="a-set" address_id="{{$v['address_id']}}">
                <s class="z-defalt" style="margin-top: 6px;"></s>
                <span>设为默认</span>
                <div class="fr" address_id="{{$v['address_id']}}">
                    <!-- <span class="edit">编辑</span> -->
                    <span class="remove">删除</span>
                </div>
            </li>
        </ul>  
    </div>
    @endif
    @endforeach
   
</div>

<input type="hidden" name="_token" value="{{csrf_token()}}">
<script src="{{url('js/zepto.js')}}" charset="utf-8"></script>
<script src="{{url('js/sm.js')}}"></script>
<script src="{{url('js/sm-extend.js')}}"></script>


<!-- 单选 -->
<script>
    

     // 删除地址
    $(document).on('click','span.remove', function () {
        var _this=$(this);
        var buttons1 = [
            {
              text: '删除',
              bold: true,
              color: 'danger',
              onClick: function() {
                $.alert("您确定删除吗？");
                var _token=$('input').val();
                var address_id=_this.parent().attr('address_id');
                $.ajax({
                    type:'post',
                    data:{address_id:address_id,_token:_token},
                    url:'addressdel',
                    success:function(res){
                        alert('删除成功');
                        console.log(res);
                    }
                });
              }
            }
          ];
          var buttons2 = [
            {
              text: '取消',
              bg: 'danger'
            }
          ];
          var groups = [buttons1, buttons2];
          $.actions(groups);
    });
</script>
<script src="{{url('js/jquery-1.8.3.min.js')}}"></script>
<script>
    var $$=jQuery.noConflict();
    $$(document).ready(function(){
            // jquery相关代码
            $$('.addr-list .a-set s').toggle(
                // console.log($$(this).hasClass('z-set'));
            function(){
                if($$(this).hasClass('z-set')){
                    
                }else{
                    var _this=$(this);
                    var address_id=$(this).parent().attr('address_id');
                    // console.log(address_id);
                    $.ajax({
                        type:'post',
                        url:'addressdefault',
                        data:{ _token:"{{csrf_token()}}",address_id:address_id},
                        success:function(res){
                            // console.log(res);
                        }
                    });
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }   
            },
            function(){
                if($$(this).hasClass('z-defalt')){
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }
                
            }
        )

    });
</script>



</body>
</html>
