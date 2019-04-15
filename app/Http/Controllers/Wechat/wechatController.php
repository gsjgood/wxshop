<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Subscribe;
use App\Model\Goods;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Cache;
use App\Model\Wxuserinfo;

class wechatController extends Controller
{
    
    /**
     * @content 微信绑定服务器效验
     * @params
     *  */
    public function check(){ 
        // $echostr= $_GET['echostr'];
        // if($this->checkSignature($signature,$timestamp,$nonce)){
        //     echo $echostr;exit;
        // }
        $this->responseMsg();

    }

    /**
     * @content 推送消息
     */
    public function responseMsg(){
        $postStr = file_get_contents("php://input");
        $postObj=simplexml_load_string($postStr);
        $form=$postObj->FromUserName;
        $to=$postObj->ToUserName;
        $time=time();
        $keywords=trim($postObj->Content);
        $msgtype="text";
        $te ="<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
        </xml>";
        //关注自动回复
        if($postObj->MsgType == "event"){
            //判断是一个关注事件
            if($postObj->Event == "subscribe"){
                $type = config('wxconfig.subscribe');
                $types = ucfirst($type);
                $resultStr = Wechat::$types($type,$form,$to);
                echo $resultStr;
                session(['openid'=>$form]);
            }
        }
        //关键词回复
        if($keywords=="你好"){
            $contentStr=$form;
            $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
            echo $resultStr;
        }else if(strpos($keywords,"天气")){
            //获取天气城市名
            $city=substr($keywords,0,strpos($keywords,"天气"));
            //天气调用
            $str=Wechat::getcityweather($city);
            $contentStr=$str; 
            $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
            echo $resultStr;
        }else if(strpos($keywords,"信息")){
            //获取商品信息
            $goods=substr($keywords,0,strpos($keywords,"信息"));
            $resultStr =Wechat::shopcontent($goods,$form,$to);
            echo $resultStr;
        }else{
            //图灵机器人回复
            $msg=Wechat::tuling($keywords);
            $contentStr= $msg;
            $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
            echo $resultStr;
        }

    }
   
    /**
     * @content效验微信签名
     *  */
    private function checkSignature(){
        $signature= $_GET['signature'];
        $timestamp= $_GET['timestamp'];
        $nonce= $_GET['nonce'];
        $token = env("WEIXINTOKEN");
         // 将三个参数写入数组
         $arr= array($token,$timestamp,$nonce);
         //字典排序
         sort($arr, SORT_STRING);
         //将数组化为字符串
         $str=implode($arr);
         //加密
         $shal=sha1($str);
         if($shal==$signature){
             return true;
         }else{
             return false;
         }
    }
    /**
     *@content 测试
     */
    public function material(){
        
        dd(session('openid'));
    }
    //将用户信息存入mysql
    public function getUserInfo(){
        $token=Wechat::getAccessToken();
        $openid=Cache::get('openid');
        // dd($openid);
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=ormvM5rZx-Mkj8E_iHF8j2RI40mM&lang=zh_CN";
        $data=json_decode(file_get_contents($url),true);
        // dd($data);
        unset($data['tagid_list']);
        unset($data['language']);
        unset($data['remark']);
        unset($data['groupid']);
        unset($data['subscribe_scene']);
        unset($data['qr_scene']);
        unset($data['qr_scene_str']);
        $re=Wxuserinfo::insert($data);
        dd($re);
    }
}
