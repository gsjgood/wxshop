<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use function GuzzleHttp\json_decode;

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
        if(!empty($postStr)){
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
                    $contentStr="终于成功了";
                    $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
                    echo $resultStr;
                    exit();
                }
            }
            //关键词回复
            if($keywords=="你好"){
                $contentStr="一点都不好，一下午没搞出来";
                $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
                echo $resultStr;
            }else if($keywords=="图片"){
                $msgtype="image";
                $te ="<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime><![CDATA[%s]]></CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        <MediaId><![CDATA[%s]]></MediaId>
                        <MsgId><![CDATA[%s]]></MsgId>
                    </xml>";
                $mediaid = session('media_id');
                $token = Wechat::getAccessToken();
                $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=$mediaid";
                $data=file_get_contents($url);
                $contentStr=1111;
                $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr,$mediaid);
                echo $resultStr;
            }else if(strpos($keywords,"天气")){
                //获取天气城市名
                $city=substr($keywords,0,strpos($keywords,"天气"));
                //天气start
                $str=Wechat::getcityweather($city);
                //天气end
                $contentStr=$str;
                $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
                echo $resultStr;
            }else{
                //图灵机器人回复
                $msg=Wechat::tuling($keywords);
                $contentStr= $msg;
                $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
                echo $resultStr;
            }
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

    public function material(){
        $mediaid = session('media_id');
        $token = Wechat::getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=$mediaid";
        $data=file_get_contents($url);
       echo $data;
    }
}
