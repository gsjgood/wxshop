﻿@extends('header')
<body class="g-acc-bg">
    
    <div class="welcome" style="display: none">
        <p>Hi，等你好久了！</p>
        <a href="login" class="orange">登录</a>
        <a href="register" class="orange">注册</a>
    </div>

    <div class="welcome">
        <a href="userInfo/set"><i class="set"></i></a>
        <div class="login-img clearfix">
            <ul>
                <li></li>
                <li class="name">
                    <h3>欢迎<font color="black">{{ Session::get('userInfo.user_name') }}</font>登录</h3 >
                    <p>ID：10030053</p>
                </li>
                
                <li class="next fr"><s></s></li>
            </ul>
        </div>
        <div class="chao-money">
            <ul class="clearfix">
                <li class="br">
                    <p>积分</p>
                    <span>822</span>
                </li>
                <li class="br">
                    <p>余额（元）</p>
                    <span>0</span>
                </li>
                <li>
                    <a href="" class="recharge">去充值</a>
                </li>
            </ul>
        </div>

    </div>
    <!--获得的商品-->
    
    <!--导航菜单-->
    
    <div class="sub_nav marginB person-page-menu">
        <a href="user/buyrecord"><s class="m_s1"></s>潮购记录<i></i></a>
        <a href="/v44/member/orderlist.do"><s class="m_s2"></s>获得的商品<i></i></a>
        <a href="user/willshare"><s class="m_s3"></s>我的晒单<i></i></a>
        <a href="user/mywallet"><s class="m_s4"></s>我的钱包<i></i></a>
        <a href="user/address"><s class="m_s5"></s>收货地址<i></i></a>
        <a href="/v44/help/help.do" class="mt10"><s class="m_s6"></s>帮助与反馈<i></i></a>
        <a href="user/invite"><s class="m_s7"></s>二维码分享<i></i></a>
        <p class="colorbbb">客服热线：400-666-2110  (工作时间9:00-17:00)</p>
    </div>
@extends('footer')
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
    <script>
        function goClick(obj, href) {
            $(obj).empty();
            location.href = href;
        }
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
            $(".m-block-header").show();
        }
    </script>
</body>
</html>
