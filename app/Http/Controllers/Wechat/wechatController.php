<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Subscribe;
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
                    $type = config('wxconfig.subscribe');
                    $types = ucfirst($type);
                    $resultStr = Wechat::$types($type,$form,$to);
                    echo $resultStr;
                }
            }
            //关键词回复
            if($keywords=="你好"){
                $contentStr="一点都不好，一下午没搞出来";
                $resultStr = sprintf($te,$form,$to,$time,$msgtype,$contentStr);
                echo $resultStr;
            }else if($keywords=="图片"){
                $te ="<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime><![CDATA[%s]]></CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                        </Image>
                    </xml>";
                $msgtype="image";
                $media_id = Subscribe::first()->media_id;                   
                $resultStr = sprintf($te,$form,$to,$time,$msgtype,$media_id);
                echo $resultStr;
            }else if($keywords=="博客"){
                $te ="<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime><![CDATA[%s]]></CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>1</ArticleCount>
                        <Articles>
                        <item>
                            <Title><![CDATA[%s]]></Title>
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                        </item>
                        </Articles>
                    </xml>";
                $data = Subscribe::first();
                $msgtype="news";
                $title=$data->title;//标题
                $des=$data->des;//内容
                $picurl = $data->picurl;//图片路径
                $url = $data->url;//点击路径
                // $media_id = Subscribe::first()->media_id;                   
                $resultStr = sprintf($te,$form,$to,$time,$msgtype,$title,$des,$picurl,$url);
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
                $te ="<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                    </xml>";
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
        $type = config('wxconfig.subscribe');
        $aaa=ucfirst($type);
        $resultStr = Wechat::News($type,1,2);
        $data = Subscribe::where('type',$type)->orderBy('s_id','desc')->first();
        $title = $data->title;
        dd($title);
    }
}
