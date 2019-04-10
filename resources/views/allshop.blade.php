@extends("header")
<body class="g-acc-bg" fnav="0" style="position: static">
<div class="page-group">
    <div id="page-infinite-scroll-bottom" class="page">
    
        <!--触屏版内页头部-->
        <div class="m-block-header" id="div-header" style="display: none">
            <strong id="m-title"></strong>
            <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
            <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
        </div>
      
        <div class="pro-s-box thin-bor-bottom" id="divSearch">
            <div class="box">
                <div class="border">
                    <div class="border-inner"></div>
                </div>
                <div class="input-box" id="txtSearch">
                    <i class="s-icon"></i>
                    <input type="text" placeholder="输入“汽车”试试"  />
                    <i class="c-icon" id="btnClearInput" style="display: none"></i>
                </div>
            </div>
            <a href="javascript:;" class="s-btn" id="btnSearch">搜索</a>
        </div>

        <!--搜索时显示的模块-->
        <div class="search-info" style="display: none;">
            <div class="hot">
                <p class="title">热门搜索</p>
                <ul id="ulSearchHot" class="hot-list clearfix"><li wd='iPhone'><a class="items">iPhone</a></li><li wd='三星'><a class="items">三星</a></li><li wd='小米'><a class="items">小米</a></li><li wd='黄金'><a class="items">黄金</a></li><li wd='汽车'><a class="items">汽车</a></li><li wd='电脑'><a class="items">电脑</a></li></ul>
            </div>
            <div class="history" style="display: none">
                <p class="title">历史记录</p>
                <div class="his-inner" id="divSearchHotHistory">
                    <ul class="his-list thin-bor-top">
                        <li wd="小米移动电源" class="thin-bor-bottom"><a class="items">小米移动电源</a></li>
                        <li wd="苹果6" class="thin-bor-bottom"><a class="items">苹果6</a></li>
                        <li wd="苹果电脑" class="thin-bor-bottom"><a class="items">苹果电脑</a></li>
                    </ul>
                    <div class="cle-cord thin-bor-bottom" id="btnClear">清空历史记录</div>
                </div>
            </div>
        </div>

        <div class="all-list-wrapper">
        <!-- 左侧栏 -->
            <div class="menu-list-wrapper" id="divSortList">
            <ul id="sortListUl" class="list" >
                    @if($cate_id== 0)
                        <a href="/allshop/{{0}}">
                        <li sortid='0' class='pid current' >
                            <span class='items '>全部商品</span>
                        </li>
                        </a>
                        @else
                        <a href="/allshop/{{0}}">
                        <li sortid='0' class='pid ' >
                            <span class='items '>全部商品</span>
                        </li>
                        </a>
                    @endif    
                @foreach($pid as $k=>$v)
                    @if($cate_id== $v['cate_id'])
                        <a href="/allshop/{{$v['cate_id']}}" id="btnNew">
                        <li sortid='0' class='current pid' cate_id="{{$v['cate_id']}}" >
                            <span class='items '>{{$v['cate_name']}}</span>
                        </li>
                        </a>
                    @else
                        <a href="/allshop/{{$v['cate_id']}}" id="btnNew">
                        <li sortid='0' class='pid' cate_id="{{$v['cate_id']}}" >
                            <span class='items '>{{$v['cate_name']}}</span>
                        </li>
                        </a>
                    @endif
                @endforeach
                </ul>
            </div>

            <div class="good-list-wrapper">
                <div class="good-menu thin-bor-bottom" cate_id="{{$cate_id}}">
                    <ul class="good-menu-list" id="ulOrderBy">
                        <li orderflag="20"><a href="/allshop/{{0}}">默认</a></li>
                        <li orderflag="50"><a href="javascript:;" id="new">最新</a></li>
                        <li orderflag="30"><a href="javascript:;" class="up">价值</a><span class="i-wrap"><i class="up"></i><i class="down"></i></span></li>
                        <!--价值(由高到低30,由低到高31)-->
                    </ul>
                </div>
                
                <!-- 商品信息 -->
                <div  class="good-list-inner">
                    <div id="pullrefresh" class="good-list-box  mui-content mui-scroll-wrapper">
                        <div class="goodList mui-scroll">
                            <ul id="ulGoodsList" class="mui-table-view mui-table-view-chevron">
                            @foreach($goodsInfo as $k=>$v)
                                <li id="23468" goods_id="{{$v['goods_id']}}">    
                                    <span class="gList_l fl"> 
                                    <a href="/shopcontent/{{$v['goods_id']}}">
                                        <img class="lazy" data-original="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" src="/uploads/goodsimg/{{$v['goods_img']}}">
                                    </a>       
                                    </span>
                                    <div class="gList_r">        
                                    <h3 class="gray6" id="shopct">{{$v['goods_name']}}</h3>
                                        <em class="gray9">价值：￥<span>{{$v['self_price']}}</span>.00</em>
                                        <div class="gRate">            
                                            <div class="Progress-bar">    
                                                <p class="u-progress">
                                                    <span style="width:{{$v['goods_num']/10}}%;" class="pgbar">
                                                        <span class="pging"></span>
                                                    </span>
                                                </p>                
                                                <ul class="Pro-bar-li">
                                                    <li class="P-bar01"><em>7342</em>已参与</li>
                                                    <li class="P-bar02"><em>7988</em>总需人次</li>
                                                    <li class="P-bar03"><em>646</em>剩余</li>
                                                </ul>            
                                            </div>           
                                            <a codeid="12785750" class="joincart"  canbuy="646"><s></s></a>        
                                        </div>    
                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                   
            </div>
        </div>
       
        <div class="footer clearfix">
            <ul>
                <li class="f_home"><a href="/v41/index.do" ><i></i>潮购</a></li>
                <li class="f_announced"><a href="/v41/lottery/" class="hover"><i></i>全部商品</a></li>
                <li class="f_single"><a href="#" ></a></li>
                <li class="f_car"><a id="btnCart" href="/v41/mycart/index.do" ><i></i>购物车</a></li>
                <li class="f_personal"><a href="/v41/member/index.do" ><i></i>我的潮购</a></li>
            </ul>
        </div>
    </div>
</div>
<input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
@extends('footer')
<script src="{{url('js/lazyload.min.js')}}"></script>
<script src="{{url('js/mui.min.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
$(function(){
    $(document).on('click','#shopct',function(res){
        var _this=$(this);
        var goods_id=_this.parents('li').attr('goods_id');
        var _token=$("#_token").val();
        // console.log(_token);
        $.ajax({
            type:"post",
            data:{goods_id:goods_id,_token:_token},
            url:"/shopcontent/"+goods_id,
            success:function(res){
                location.href="/shopcontent/"+goods_id;
            }
        });
   })
})
</script>
<script>
$(function(){
    $("#txtSearch").click(function(){
        var _this=$(this);
        var seach=_this.children('input').val();
        $.ajax({
            type:"post",
            url: "/seach",
            data: {seach:seach,_token:_token}
        }).done(function(res) {
            // console.log(res);
            $('#ulGoodsList').html(res);
            
        });
        
        
    })
   
})
</script>
<script>  
        jQuery(document).ready(function() {
            $("img.lazy").lazyload({
                placeholder : "images/loading2.gif",
                effect: "fadeIn",
            });
        }); 
         var _token=$("#_token").val();
        // //左侧分类查询
        // $(document).on('click','.pid',function(){
        //     var _this=$(this);
        //     var cate_id=_this.attr('cate_id');
        //     // console.log(cate_id);
        //     $.ajax({
        //         type:"post",
        //         url: "/allshop/"+cate_id,
        //         data: {cate_id:cate_id,_token:_token}
        //     }).done(function(res) {
        //         $('#ulGoodsList').html(res);

        //     });
        // })
        //根据最新排序
        $(document).on('click','#new',function(){
            var _this=$(this);
            var cate_id=_this.parents('div').attr('cate_id');
            // console.log(cate_id);
            $.ajax({
                method: "GET",
                url: "/shopnew",
                data: {cate_id:cate_id}
            }).done(function(res) {
                // console.log(res);
                $('#ulGoodsList').html(res);

            });
            // $.ajax({
            //     method: "GET",
            //     url: "/shopnew",
            //     data: {cate_id:cate_id}
            // }).done(function(res) {
            //     // console.log(res);
            //     $('#ulGoodsList').html(res);

            // });
        })
         //根据价值排序
         $(document).on('click','.up',function(){
            var _this=$(this);
            var cate_id=_this.parents('div').attr('cate_id');
            // console.log(cate_id);
            $.ajax({
                method: "GET",
                url: "/shopup",
                data: {cate_id:cate_id}
            }).done(function(res) {
                // console.log(res);
                $('#ulGoodsList').html(res);
            });
        })
        //根据价值降序
        $(document).on('click','.down',function(){
            var _this=$(this);
            var cate_id=_this.parents('div').attr('cate_id');
            // console.log(cate_id);
            $.ajax({
                method: "GET",
                url: "/shopdown",
                data: {cate_id:cate_id}
            }).done(function(res) {
                // console.log(res);
                $('#ulGoodsList').html(res);

            });
        })
        //加入购物车
        $(".joincart").click(function(){
            var _this=$(this);
            var goods_id=_this.parents('li').attr('goods_id');
            var _token=$("#_token").val();
            // console.log(_token);
            $.ajax({
                type:"post",
                url: "/shopcart",
                data: {goods_id:goods_id,_token:_token}
            }).done(function(res) {
                    location.href="/shopcart";
            });
        })
</script>
<script>
    // 点击切换类别
    $('#sortListUl li').click(function(){
        $(this).addClass('current').siblings('li').removeClass('current');
    })
</script>
<!-- <script>
    mui.init({
        pullRefresh: {
            container: '#pullrefresh',
            down: {
                contentdown : "下拉可以刷新",//可选，在下拉可刷新状态时，下拉刷新控件上显示的标题内容
                contentover : "释放立即刷新",//可选，在释放可刷新状态时，下拉刷新控件上显示的标题内容
                contentrefresh : "正在刷新...",
                callback: pulldownRefresh
            },
            up: {
                contentrefresh: '正在加载...',
                callback: pullupRefresh
            }
        }
    });
    /**
     * 下拉刷新具体业务实现
     */
    // function pulldownRefresh() {
    //     setTimeout(function() {
    //         var table = document.body.querySelector('.mui-table-view');
    //         var cells = document.body.querySelectorAll('.mui-table-view-cell');
    //         for (var i = cells.length, len = i + 3; i < len; i++) {
    //             var li = document.createElement('li');
    //             var str='';
    //             // li.className = 'mui-table-view-cell';
    //             str += '<span class="gList_l fl">';        
    //             str += '<img class="lazy" data-original="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" src="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" style="display: block;"/>';
    //             str += '</span>';
    //             str += '<div class="gList_r">';
    //             str += '<h3 class="gray6">(第'+i+'云)苹果（Apple）iPhone 7 Plus 256G版 4G手机</h3>';        
    //             str += '<em class="gray9">价值：￥7988.00</em>';
    //             str += '<div class="gRate">';           
    //             str += '<div class="Progress-bar">'    
    //             str += '<p class="u-progress">';
    //             str += '<span style="width: 91.91286930395593%;" class="pgbar">';
    //             str += '<span class="pging"></span>';
    //             str += '</span>';
    //             str += '</p>';                
    //             str += '<ul class="Pro-bar-li">';
    //             str += '<li class="P-bar01"><em>7342</em>已参与</li>';
    //             str += '<li class="P-bar02"><em>7988</em>总需人次</li>';
    //             str += '<li class="P-bar03"><em>646</em>剩余</li>';
    //             str += '</ul>';            
    //             str += '</div>';           
    //             str += '<a codeid="12785750" class="" canbuy="646"><s></s></a>';        
    //             str += '</div>';    
    //             str += '</div>';
    //             //下拉刷新，新纪录插到最前面；
    //             li.innerHTML = str;
    //             table.insertBefore(li, table.firstChild);
    //         }
    //         mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
    //     }, 1500);
    // }
    var count = 0;
    /**
     * 上拉加载具体业务实现
     */
    // function pullupRefresh() {
    //     setTimeout(function() {
    //         mui('#pullrefresh').pullRefresh().endPullupToRefresh((++count > 2)); //参数为true代表没有更多数据了。
    //         var table = document.body.querySelector('.mui-table-view');
    //         var cells = document.body.querySelectorAll('.mui-table-view-cell');
    //         for (var i = cells.length, len = i + 20; i < len; i++) {
    //             var li = document.createElement('li');
    //             // li.className = 'mui-table-view-cell';
    //             var str='';
    //             str += '<span class="gList_l fl">';        
    //             str += '<img class="lazy" data-original="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" src="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" style="display: block;"/>';
    //             str += '</span>';
    //             str += '<div class="gList_r">';
    //             str += '<h3 class="gray6">(第'+i+'云)苹果（Apple）iPhone 7 Plus 256G版 4G手机</h3>';        
    //             str += '<em class="gray9">价值：￥7988.00</em>';
    //             str += '<div class="gRate">';           
    //             str += '<div class="Progress-bar">'    
    //             str += '<p class="u-progress">';
    //             str += '<span style="width: 91.91286930395593%;" class="pgbar">';
    //             str += '<span class="pging"></span>';
    //             str += '</span>';
    //             str += '</p>';                
    //             str += '<ul class="Pro-bar-li">';
    //             str += '<li class="P-bar01"><em>7342</em>已参与</li>';
    //             str += '<li class="P-bar02"><em>7988</em>总需人次</li>';
    //             str += '<li class="P-bar03"><em>646</em>剩余</li>';
    //             str += '</ul>';            
    //             str += '</div>';           
    //             str += '<a codeid="12785750" class="" canbuy="646"><s></s></a>';        
    //             str += '</div>';    
    //             str += '</div>';
    //             li.innerHTML = str;
    //             table.appendChild(li);
    //         }
    //     }, 1500);
    // }
    // if (mui.os.plus) {
    //     mui.plusReady(function() {
    //         setTimeout(function() {
    //             mui('#pullrefresh').pullRefresh().pullupLoading();
    //         }, 1000);

    //     });
    // } 
    // else {
    //     mui.ready(function() {
    //         mui('#pullrefresh').pullRefresh().pullupLoading();
    //     });
    // }
</script> -->

</body>
</html>

