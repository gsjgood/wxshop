<?php
namespace App\Http\Controllers;

use App\Tools\Ucpaas;
use Symfony\Component\HttpFoundation\Request;
class SendEmailController extends Controller
{
    /** 发送验证码 */
    public static function SendSms($address,$code)
    {
        //填写在开发者控制台首页上的Account Sid 
        $options['accountsid']='a7d6a71ad621a9179cc97c9f8ecd44d1';
        //填写在开发者控制台首页上的Auth Token
        $options['token']='b8b9bcc0c34400765300a3e7cbbd2d71';

        //初始化 $options必填
        $appid = "f3f083e2d55044459454737505c6c63e";	//应用的ID，可在开发者控制台内的短信产品下查看
        $templateid = "444804";    //可在后台短信产品→选择接入的应用→短信模板-模板ID，查看该模板ID

        //以下是发送验证码的信息
        $param = $code; //验证码 多个参数使用英文逗号隔开（如：param=“a,b,c”），如为参数则留空
        $mobile = $address; // 手机号
        $uid =  config('sms.sms_uid');
        $ucpass = new Ucpaas($options);
        $result = $ucpass->SendSms($appid, $templateid, $param, $mobile, $uid);

        if($result) {
            return true;
        }else{
            return false;
        }
    }
    //发送短信
    public function getcode(Request $request){
        $user_tel=$request['user_tel'];
        // $code=$request['code'];
        $code=rand(0001,9999);
        dump($code);
        //发送短信
        $res=SendEmailController::SendSms($user_tel,$code);
        if($res){
            $sendEmail=[
                'code'=>$code,
                'user_tel'=>$user_tel,
                'sendtime'=>time()
            ];
            session(['sendEmail'=>$sendEmail]);
            // dump(session('sendEmail'));
            return "发送成功";
        }else{
            return "发送失败";
        }
    }
    
}
