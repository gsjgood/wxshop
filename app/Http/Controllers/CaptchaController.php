<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Captcha;
class CaptchaController extends Controller
{
    //图片验证码
    public function captcha(){
        $verify = new Captcha();
        $code = $verify->getCode();
        session(['verifycode'=>$code]);
        return $verify->doimg();
    }
}
