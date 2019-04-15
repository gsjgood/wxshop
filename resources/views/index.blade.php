<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>三介雉</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
	<link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
	<link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{url('css/index.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
        <!-- 焦点图 -->
        <div class="hotimg-wrapper">
            <div class="hotimg-top"></div>
            <section id="sliderBox" class="hotimg">
        		<ul class="slides" style="width: 600%; transition-duration: 0.4s; transform: translate3d(-828px, 0px, 0px);">
					<li style="width: 414px; float: left; display: block;" class="clone">
        				<a href="http://weixin.1yyg.com/v27/products/23559.do?pf=weixin">
        					<img src="https://img.alicdn.com/simba/img/TB14GBlNXzqK1RjSZFCSuvbxVXa.jpg" alt="">
        				</a>
        			</li>
        			<li style="width: 414px; float: left; display: block;" class="flex-active-slide">
        				<a href="http://weixin.1yyg.com/v40/GoodsSearch.do?q=%E6%B8%85%E5%87%89%E4%B8%80%E5%A4%8F&amp;pf=weixin"><img src="https://img.alicdn.com/simba/img/TB14GBlNXzqK1RjSZFCSuvbxVXa.jpg" alt="">
        				</a>
        			</li>
        			<li style="width: 414px; float: left; display: block;" class="">
        				<a href="http://weixin.1yyg.com/v27/products/23559.do?pf=weixin">
        					<img src="https://img.alicdn.com/simba/img/TB1fj4xMbvpK1RjSZFqSuwXUVXa.jpg" alt="">
        				</a>
					</li>
					<li style="width: 414px; float: left; display: block;" class="">
        				<a href="http://weixin.1yyg.com/v27/products/23559.do?pf=weixin">
        					<img src="https://img.alicdn.com/tps/i4/TB16pn1MQPoK1RjSZKbSut1IXXa.jpg_q90_.webp" alt="">
        				</a>
					</li>
					<li style="width: 414px; float: left; display: block;" class="">
        				<a href="http://weixin.1yyg.com/v27/products/23559.do?pf=weixin">
        					<img src="https://aecpm.alicdn.com/tfscom/TB1kYfdN8LoK1RjSZFuXXXn0XXa.png" alt="">
        				</a>
        			</li>
        		</ul>
            </section>
        </div>
        
        <!--分类-->
        <div class="index-menu thin-bor-top thin-bor-bottom">
            <ul class="menu-list">
				@foreach($pid as $k=>$v)
                <li>
                    <a href="allshop/{{$v['cate_id']}}" id="btnNew">
                        <i class="xinpin ctgr" ></i>
                        <span class="title" cate_id="{{$v['cate_id']}}">{{$v['cate_name']}}</span>
                    </a>
				</li>
				@endforeach
            </ul>
        </div>
        <!--导航-->
        <div class="success-tip">
        	<div class="left-icon"></div>
        	<ul class="right-con">
				<li>
					<span style="color: #4E555E;">
						<a href="./index.php?i=107&amp;c=entry&amp;id=10&amp;do=notice&amp;m=weliam_indiana" style="color: #4E555E;">恭喜<span class="username">啊啊啊</span>获得了<span>iphone7 红色 128G 闪耀你的眼</span></a>
					</span>
				</li>
				<li>
					<span style="color: #4E555E;">
						<a href="./index.php?i=107&amp;c=entry&amp;id=10&amp;do=notice&amp;m=weliam_indiana" style="color: #4E555E;">恭喜<span class="username">啊啊啊</span>获得了<span>iphone7 红色 128G 闪耀你的眼</span></a>
					</span>
				</li>
				<li>
					<span style="color: #4E555E;">
						<a href="./index.php?i=107&amp;c=entry&amp;id=10&amp;do=notice&amp;m=weliam_indiana" style="color: #4E555E;">恭喜<span class="username">啊啊啊</span>获得了<span>iphone7 红色 128G 闪耀你的眼</span></a>
					</span>
				</li>
			</ul>
        </div>
  
        <!-- 热门推荐 -->
        <div class="line hot">
        	<div class="hot-content">
        		<i></i>
        		<span>商品列表</span>
        		<div class="l-left"></div>
        		<div class="l-right"></div>
        	</div>
        </div>
        <div class="goods-wrap marginB">
            <ul id="ulGoodsList" class="goods-list clearfix">
        @foreach($res as $k=>$v)
            	<li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436" goods_id="{{$v['goods_id']}}">
            		<a href="/shopcontent/{{$v['goods_id']}}" class="g-pic">
            			<img class="lazy" name="goodsImg" src="/uploads/goodsimg/{{$v->goods_img}}" width="136" height="136">
            		</a>
            		<p class="g-name">{{$v->goods_name}}</p>
            		<ins class="gray9">价值：￥<span>{{$v->self_price}}</span>.00</ins>
            		<div class="Progress-bar">
            			<p class="u-progress">
            				<span class="pgbar" style="width: 96.43076923076923%;">
            					<span class="pging"></span>
            				</span>
            			</p>
            		</div>
            		<div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
            			<a href="/ordersupplyment/{{$v['goods_id']}}" class="buy-btn" codeid="12751965">立即购买</a>
            			<div class="gRate" codeid="12751965" canbuy="58">
            				<a href="javascript:;" class="cart"></a>
            			</div>
            		</div>
            	</li>
            @endforeach
            </ul>
        </div> 
        <!-- 猜你喜欢 -->
        <!-- <div class="line guess">
        	<div class="hot-content">
        		<i></i>
        		<span>猜你喜欢</span>
        		<div class="l-left"></div>
        		<div class="l-right"></div>
        	</div>
        </div> -->
        <!--商品列表-->
        <!-- <div class="goods-wrap marginB">
            <ul id="ulGoodsList" class="goods-list clearfix">
            	<li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436">
            		<a href="javascript:;" class="g-pic">
            			<img class="lazy" name="goodsImg" data-original="https://img.1yyg.net/GoodsPic/pic-200-200/20161103170504456.jpg" width="136" height="136">
            		</a>
            		<p class="g-name">(第<em>28436</em>潮)中国黄金 财富投资金条 Au9999 5g</p>
            		<ins class="gray9">价值：￥1625.00</ins>
            		<div class="Progress-bar">
            			<p class="u-progress">
            				<span class="pgbar" style="width: 96.43076923076923%;">
            					<span class="pging"></span>
            				</span>
            			</p>

            		</div>
            		<div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
            			<a href="javascript:;" class="buy-btn" codeid="12751965">立即购买</a>
            			<div class="gRate" codeid="12751965" canbuy="58">
            				<a href="javascript:;"></a>
            			</div>
            		</div>
            	</li>
            </ul>
            <div class="loading clearfix"><b></b>正在加载</div>
        </div> -->
<input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
<!--底部-->
<div class="footer clearfix">
    <ul>
	@if('url'=="www.wxshop.com")
        <li class="f_home "><a href="/"  class="hover a"><i></i>首页</a></li>
	@else
        <li class="f_home "><a href="/"  class=" a"><i></i>首页</a></li>
	@endif
        <li class="f_announced "><a href="/allshop/{{0}}" class="a " ><i></i>所有商品</a></li>
        <li class="f_car "><a id="btnCart" href="/shopcart"  class="a" ><i></i>购物车</a></li>
        <li class="f_personal "><a href="/userpage"  class="a" ><i></i>我的潮购</a></li>
    </ul>
</div>
</body>
<script src="{{url('layui/layui.js')}}"></script> 
<script src="{{url('js/all.js')}}"></script>
<script src="{{url('js/index.js')}}"></script>
<script src="{{url('js/lazyload.min.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script src="{{url('js/jquery-1.8.3.min.js')}}"></script>   
<script src="{{url('jquery.flexslider.min.js')}}"></script>
<script>
	$(function () {  
		$('.hotimg').flexslider({   
			directionNav: false,   //是否显示左右控制按钮   
			controlNav: true,   //是否显示底部切换按钮   
			pauseOnAction: false,  //手动切换后是否继续自动轮播,继续(false),停止(true),默认true   
			animation: 'slide',   //淡入淡出(fade)或滑动(slide),默认fade
			slideshowSpeed: 3000,  //自动轮播间隔时间(毫秒),默认5000ms
			animationSpeed: 150,   //轮播效果切换时间,默认600ms   
			direction: 'horizontal',  //设置滑动方向:左右horizontal或者上下vertical,需设置animation: "slide",默认horizontal   
			randomize: false,   //是否随机幻切换   
			animationLoop: true   //是否循环滚动  
		});
		setTimeout($('.flexslider img').fadeIn()); 
	}) 
</script>
<script>
$(function(){
	layui.use(['layer'],function(){
		var layer=layui.layer;
		$(document).on('click','.ctgr',function(){
			var cate_id=$(this).next().attr('cate_id');
			// console.log(cate_id);
			$.ajax({
					method: "GET",
					url: "showtop",
					data: {cate_id:cate_id}
				}).done(function(res) {
					console.log(res);
			});
		})
		$(".cart").click(function(){
			var _this=$(this);
			var goods_id=_this.parents('li').attr('goods_id');
			var _token=$("#_token").val();
			// console.log(_token);
			$.ajax({
				type:"post",
				url: "/shopcart",
				data: {goods_id:goods_id,_token:_token}
			}).done(function(res) {
				// console.log(res);
				layer.msg('加入购物车成功',{icon:1});
			});
		})
	})
})
</script>


