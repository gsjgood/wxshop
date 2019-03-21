<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //购买记录
    public function buyrecord(){
        return view("user/buyrecord");
    }
    //我的钱包
    public function mywallet(){
        return view('user/mywallet');
    }
    //收货地址
    public function address(){
        return view('user/address');
    }
    //我的晒单
    public function willshare(){
        return view("user/willshare");
    }
    //二维码分享
    public function invite(){
        return view("user/invite");
    }
}
