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
});
Route::any('userpage',"IndexController@userpage")->middleware('login');
Route::any('shopcart',"IndexController@shopcart")->middleware('login');
//删除购物车
Route::any('cartdel',"Shop\CartController@cartdel")->middleware('login');
//加号
Route::any('cartadd',"Shop\CartController@cartadd")->middleware('login');
//减号
Route::any('cartmin',"Shop\CartController@cartmin")->middleware('login');
//购买的数量
Route::any('cartbuynum',"Shop\CartController@cartbuynum")->middleware('login');


//我的
Route::group(['middleware'=>'login','prefix'=>'user'],function () {
    //购买记录
    Route::any('buyrecord',"Shop\UserController@buyrecord");
    //我的钱包
    Route::any('mywallet',"Shop\UserController@mywallet");
    //收货地址
    Route::any('address',"Shop\UserController@address");
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

//个人信息编辑
Route::group(['middleware'=>'login','prefix'=>'userInfo'],function () {
    Route::any('set',"Shop\userInfoController@set");
    //安全设置
    Route::any('safeset',"Shop\userInfoController@safeset");
    //重置密码
    Route::any('resetpassword',"Shop\userInfoController@resetpassword");
    
});

//验证码
Route::any('captcha',"CaptchaController@captcha");
//手机验证码
Route::any('getcode',"SendEmailController@getcode");

