<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购物车</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('css/cartlist.css')}}" rel="stylesheet" type="text/css" />
</head>
<body id="loadingPicBlock" class="g-acc-bg">
    <input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
    <div>
        <!--首页头部-->
        <div class="m-block-header">
            <a href="/" class="m-public-icon m-1yyg-icon"></a>
            <a href="/" class="m-index-icon">编辑</a>
        </div>
        <!--首页头部 end-->
        <div class="g-Cart-list">
            @foreach($goodsInfo as $k=>$v)
                <li goods_id="{{$v['goods_id']}}" class="gid">
                    <s class="xuan current"></s>
                    <a class="fl u-Cart-img" href="/v44/product/12501977.do">
                        <img src="/uploads/goodsimg/{{$v['goods_img']}}" border="0" alt="">
                    </a>
                    <div class="u-Cart-r">
                        <a href="/v44/product/12501977.do" class="gray6">{{$v['goods_name']}}</a>
                        <span class="gray9">
                            <em>库存：{{$v['goods_num']}}</em>
                        </span>
                        <span>
                            <input class="price" name="num" maxlength="6" type="hidden" value="{{$v['self_price']}}" codeid="12501977">
                        </span>
                        <div class="num-opt">
                            <em class="num-mius dis min"><i></i></em>
                            <input class="text_box" name="num" maxlength="6" type="text" value="{{$v['buy_number']}}" codeid="12501977">
                            <em class="num-add add"><i></i></em>
                        </div>
                        <a href="javascript:;" name="delLink" cid="12501977" isover="0" class="z-del"><s></s></a>
                    </div>    
                </li>
            @endforeach
            </ul>
            <div id="divNone" class="empty "  style="display: none"><s></s><p>您的购物车还是空的哦~</p><a href="https://m.1yyg.com" class="orangeBtn">立即潮购</a></div>
        </div>
        <div id="mycartpay" class="g-Total-bt g-car-new" style="">
            <dl>
                <dt class="gray6">
                    <s class="quanxuan current"></s>全选
                    <p class="money-total">合计<em class="orange total"><span>￥</span>17.00</em></p>
                    
                </dt>
                <dd>
                    <a href="javascript:;" id="a_payment" class="orangeBtn w_account remove">删除</a>
                    <a href="javascript:;" id="a_payment" class="orangeBtn w_account">去结算</a>
                </dd>
            </dl>
        </div>
        <div class="hot-recom">
            <div class="title thin-bor-top gray6">
                <span><b class="z-set"></b>最新热卖</span>
                <em></em>
            </div>
            <div class="goods-wrap thin-bor-top">
                <ul class="goods-list clearfix">
                @foreach($newgoods as $k=>$v)
                    <li>
                        <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                            <img src="/uploads/goodsimg/{{$v['goods_img']}}" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="https://m.1yyg.com/v44/products/23458.do">{{$v['goods_name']}}</a>
                        </p>
                        <ins class="gray9">价值:￥{{$v['self_price']}}</ins>
                        <div class="btn-wrap">
                            <div class="Progress-bar">
                                <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                                </p>
                            </div>
                            <div class="gRate" data-productid="23458">
                                <a href="javascript:;"><s></s></a>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
@extends('footer')
<input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<!---商品加减算总数---->
<script>
$(function(){
    //单个删除
    $('.z-del').click(function(){
        var _this=$(this);
        var goods_id=_this.parents('li').attr('goods_id');
        var _token=$("#_token").val();
        // console.log(_token);
        $.ajax({
                type:"post",
                url: "/cartdel",
                data: {goods_id:goods_id,_token:_token}
            }).done(function(res) {
               history.go(0);
        });
    })
    
})
</script>
    <script type="text/javascript">
    $(function () {
        $(".add").click(function () {
            var t = $(this).prev();
            t.val(parseInt(t.val()) + 1);
            GetCount();
            var _this=$(this);
            var goods_id=_this.parents('li').attr('goods_id');
            var _token=$("#_token").val();
            console.log(goods_id);
            $.ajax({
                    type:"post",
                    url: "/cartadd",
                    data: {goods_id:goods_id,_token:_token}
                }).done(function(res) {
                console.log(res);
            });
        })
        $(".min").click(function () {
            var t = $(this).next();
            if(t.val()>1){
                t.val(parseInt(t.val()) - 1);
                GetCount();
                var _this=$(this);
                var goods_id=_this.parents('li').attr('goods_id');
                var _token=$("#_token").val();
                // console.log(goods_id);
                $.ajax({
                        type:"post",
                        url: "/cartmin",
                        data: {goods_id:goods_id,_token:_token}
                    }).done(function(res) {
                    console.log(res);
                });
            }
        })
        //购买数量
        $(".text_box").blur(function(){
            var _this=$(this);
            var goods_id=_this.parents('li').attr('goods_id');
            var _token=$("#_token").val();
            var buy_number=$(this).val();
            // console.log(buy_number);
            $.ajax({
                    type:"post",
                    url: "/cartbuynum",
                    data: {goods_id:goods_id,_token:_token,buy_number:buy_number}
                }).done(function(res) {
                console.log(res);
            });
        })
    })
    </script>

    <script>

    //批量删除
    $('.remove').click(function(){
        var _this=$(this);
        var q=_this.parents('div').find('s').hasClass('current');
        
        if(q){
            // var goods_id = _this.parents('div').prev().find('li');
            var goods_id=$('.gid');
            goods_id.each(function(){
                var goods_id=$(this).attr('goods_id');
                var _token=$("#_token").val();
                // console.log(_token);
                $.ajax({
                        type:"post",
                        url: "/cartdel",
                        data: {goods_id:goods_id,_token:_token}
                    }).done(function(res) {
                    history.go(0);
                });
                
            })
        }else{
            alert('请选择商品，再进行删除');
        }
    })
    // 全选        
    $(".quanxuan").click(function () {
        if($(this).hasClass('current')){
            $(this).removeClass('current');
            console.log($('.xuan'));
             $(".g-Cart-list .xuan").each(function () {
                if ($(this).hasClass("current")) {
                    $(this).removeClass("current"); 
                } else {
                    $(this).addClass("current");
                    
                } 
            });
            GetCount();
        }else{
            $(this).addClass('current');

             $(".g-Cart-list .xuan").each(function () {
                $(this).addClass("current");
                // $(this).next().css({ "background-color": "#3366cc", "color": "#ffffff" });
            });
            
            GetCount();
        }
        
        
    });
    // 单选
    $(".g-Cart-list .xuan").click(function () {
        if($(this).hasClass('current')){
        
            $(this).removeClass('current');

        }else{
            $(this).addClass('current');
        }
        if($('.g-Cart-list .xuan.current').length==$('#cartBody li').length){
                $('.quanxuan').addClass('current');

            }else{
                $('.quanxuan').removeClass('current');
            }
        // $("#total2").html() = GetCount($(this));
        GetCount();
        //alert(conts);
    });
  // 已选中的总额
    function GetCount() {
        var conts = 0;
        var aa = 0;
        
        $(".g-Cart-list .xuan").each(function () {
            if ($(this).hasClass("current")) {
                for (var i = 0; i < $(this).length; i++) {
                 conts +=parseInt($(this).parents('li').find('input.text_box').val())*parseInt($(this).parents('li').find('input.price').val());
                     
                    // aa += 1;
                }
            }
        });
        
         $(".total").html('<span>￥</span>'+(conts).toFixed(2));
    }
    GetCount();
</script>
</body>
</html>
