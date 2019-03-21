<!--底部-->
<div class="footer clearfix">
    <ul>
        <li class="f_home "><a href="/"  class=" a"><i></i>首页</a></li>
        <li class="f_announced "><a href="/allshop/{{0}}" class="a " ><i></i>所有商品</a></li>
        <li class="f_single "><a href="javascript:;" class="a" ></a></li>
        <li class="f_car "><a id="btnCart" href="/shopcart"  class="a" ><i></i>购物车</a></li>
        <li class="f_personal "><a href="/userpage"  class="a" ><i></i>我的潮购</a></li>
    </ul>
</div>
<div id="div_fastnav" class="fast-nav-wrapper">
    <ul class="fast-nav">
        <li id="li_menu" isshow="0">
            <a href="javascript:;"><i class="nav-menu"></i></a>
        </li>
        <li id="li_top" style="display: none;">
            <a href="javascript:;"><i class="nav-top"></i></a>
        </li>
    </ul>
    <div class="sub-nav four" style="display: none;">
        <a href="#"><i class="announced"></i>最新揭晓</a>
        <a href="#"><i class="single"></i>晒单</a>
        <a href="#"><i class="personal"></i>我的潮购</a>
        <a href="#"><i class="shopcar"></i>购物车</a>
    </div>
</div>
    @yield('content');
</body>
<script src="{{url('layui/layui.js')}}"></script> 
<script src="{{url('layui/layui.all.js')}}"></script> 
<script src="{{url('js/all.js')}}"></script>
<script src="{{url('js/index.js')}}"></script>
<script src="{{url('js/lazyload.min.js')}}"></script>
<!-- 商品 -->
<script src="{{url('js/mui.min.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
$(function(){
	$(document).on('click','.a',function(){
		var _this=$(this);
		_this.addClass('hover');
		$("a").remove("hover");
	})
})
</script>
<script>
    @yield('my-js')
    jQuery(document).ready(function() {
		$("img.lazy").lazyload({
			placeholder : "images/loading2.gif",
			effect: "fadeIn",
		});
		// 返回顶部点击事件
		$('#div_fastnav #li_menu').click(
			function(){
				if($('.sub-nav').css('display')=='none'){
					$('.sub-nav').css('display','block');
				}else{
					$('.sub-nav').css('display','none');
				}
				
			}
		)
		$("#li_top").click(function(){ 
			$('html,body').animate({scrollTop:0},300);
			return false; 
		}); 
		$(window).scroll(function(){
			if($(window).scrollTop()>200){
				$('#li_top').css('display','block');
			}else{
				$('#li_top').css('display','none');
			}               
		}) 
	});
</script>