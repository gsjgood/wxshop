<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class userInfoController extends Controller
{
    public function set(){
        return view("userInfo/set");
    }
    //安全设置
    public function safeset(){
        return view("userInfo/safeset");
    }
     //重置密码
     public function resetpassword(){
        return view("userInfo/resetpassword");
    }
}
