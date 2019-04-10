<?php 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/',"IndexController@index");
Route::any('a',"IndexController@a");

//结算
Route::group(['middleware'=>'login','prefix'=>''],function () {
    // 立即购买
    Route::any('ordersupplyment/{goods_id}',"Shop\OrderController@ordersupplyment");
    //购物车购买
    Route::any('ordersupplymentCart/{goods_id}',"Shop\OrderController@ordersupplymentCart");
    // 确认地址
    Route::any('orderwillsend/{goods_id}',"Shop\OrderController@orderwillsend");
    // 购物车确认地址
    Route::any('orderwillsendCart/{goods_id}',"Shop\OrderController@orderwillsendCart");
    //改变地址
    Route::any('orderaddress',"Shop\OrderController@orderaddress");
});
//商品
Route::group(['middleware'=>'login','prefix'=>''],function () {
    Route::any('allshop/{id}',"IndexController@allshop")->middleware('login');
    //点击展示商品分类
    Route::any('shopcate/{cate_id}',"Shop\ShopController@shopcate");
    //商品详情
    Route::any('shopcontent/{goods_id}',"Shop\ShopController@shopcontent");
    //展示顶级分类
    Route::any('showtopcate',"IndexController@showtopcate");
    //根据最新查询
    Route::any('shopnew',"Shop\ShopController@shopnew");
    //根据价值来查询
    Route::any('shopup',"Shop\ShopController@shopup");
    //根据价值来降序
    Route::any('shopdown',"Shop\ShopController@shopdown");
    //查询
    Route::any('seach',"Shop\ShopController@seach");
});
//我的页面
//购物车
Route::group(['middleware'=>'login','prefix'=>''],function () {
    Route::any('shopcart',"IndexController@shopcart");
    //删除购物车
    Route::any('cartdel',"Shop\CartController@cartdel");
    //结算
    Route::any('clear',"Shop\CartController@clear");
    //加号
    Route::any('cartadd',"Shop\CartController@cartadd");
    //减号
    Route::any('cartmin',"Shop\CartController@cartmin");
    //购买的数量
    Route::any('cartbuynum',"Shop\CartController@cartbuynum");
});


Route::any('userpage',"IndexController@userpage")->middleware('login');
//我的
Route::group(['middleware'=>'login','prefix'=>'user'],function () {
    //购买记录
    Route::any('buyrecord',"Shop\UserController@buyrecord");
    //我的钱包
    Route::any('mywallet',"Shop\UserController@mywallet");
    //收货地址
    Route::any('address',"Shop\UserController@address");
        //收货地址添加
        Route::any('writeaddr',"Shop\UserController@writeaddr");
        //删除地址
        Route::any('addressdel',"Shop\UserController@addressdel");
        //设为默认
        Route::any('addressdefault',"Shop\UserController@addressdefault");

    //我的晒单
    Route::any('willshare',"Shop\UserController@willshare");
    //二维码分享
    Route::any('invite',"Shop\UserController@invite"); 

});

//注册
Route::any('register',"Shop\LoginController@register");
//注册添加
Route::any('registeradd',"Shop\LoginController@registeradd");
//验证唯一
Route::any('unique',"Shop\LoginController@unique");

//登录
Route::any('login',"Shop\LoginController@login");
Route::any('logindo',"Shop\LoginController@logindo");
//退出登录
Route::any('quit',"Shop\LoginController@quit"); 
//忘记密码
Route::any('regauth',"Shop\LoginController@regauth");
//忘记密码-修改密码
Route::any('resetpassword',"Shop\LoginController@resetpassword");

//个人信息编辑
Route::group(['middleware'=>'login','prefix'=>'userInfo'],function () {
    //设置
    Route::any('set',"Shop\userInfoController@set");
    //编辑个人信息
    Route::any('edituser',"Shop\userInfoController@edituser");
    //安全设置
    Route::any('safeset',"Shop\userInfoController@safeset");
    //重置密码
    Route::any('modyloginpwd',"Shop\userInfoController@modyloginpwd");
        //修改
        Route::any('updatepwd',"Shop\userInfoController@updatepwd");

    
});

//验证码
Route::any('captcha',"CaptchaController@captcha");
//手机验证码
Route::any('getcode',"SendEmailController@getcode");

//支付
Route::prefix('alipay')->group(function () {
    Route::any('mobilepay',"alipayController@mobilepay");
    Route::any('return',"alipayController@re");
    Route::any('notify',"alipayController@notify");
});

//测试
Route::prefix('alipay')->group(function () {
    Route::any('mobilepay',"alipayController@mobilepay");
    Route::any('return',"alipayController@re");
    Route::any('notify',"alipayController@notify");
});
Route::any('phpinfo',"IndexController@phpinfo");

Route::any('wechat/check',"Wechat\wechatController@check");
//微信
Route::any('material/index',"Wechat\materialController@index");
Route::any('material/doup',"Wechat\materialController@getMaterial");
Route::any('material',"Wechat\wechatController@material");
//微信后台
Route::prefix('admin')->group(function () {
    Route::any('index',"Admin\WechatAdminController@index");
    Route::any('upsubscribe',"Admin\WechatAdminController@upsubscribe");
    //关注内容的提交
    Route::any('wxindex',"Admin\WechatAdminController@wxindex");
    //关注类型的选择
    Route::any('wxtype',"Admin\WechatAdminController@wxtype");
    Route::any('wxtypedo',"Admin\WechatAdminController@wxtypedo");

});



