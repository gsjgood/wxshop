<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Storage;
use App\Model\Subscribe;
use Illuminate\Support\Facades\Cache;

class Wechat extends Model
{
    /**
     * 读取文件，看看有没有，有的话读取，没有的话生成
     * 看看token是否过期 没有获取，有的话 生成
     */
    public static function getAccessToken(){
        $path = public_path()."/wx";
        $filename =$path."/token.txt";
        if(is_file($filename)){
            $str=file_get_contents($filename);
            if(!empty($str)){
                $now = time();
                $data=json_decode($str,true);
                if($now>$data[1]){
                    $token=self::CreateAccessToken();
                    $expires_in=time()+7100;
                    $arr = [$token,$expires_in];
                    $str=json_encode($arr);
    
                    file_put_contents($filename,$str);
                }else{
                    $token=$data[0];
                }
            }else{
                $token=self::CreateAccessToken();
                $expires_in=time()+7100;
                $arr = [$token,$expires_in];
                $str=json_encode($arr);

                file_put_contents($filename,$str);
            }
        }else{
            //没有文件生成文件
            touch($filename);
        }
        Cache::set("token",$token,7100);
        return $token;
    }
    /**
     * @content 获取access_token值
     */
    public static function CreateAccessToken(){
        $appid=env('WXAPPID');
        $secret=env('WXAPPSECRET');
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $data=file_get_contents($url);
        $token=json_decode($data,true)['access_token'];
        
        return $token;
    }
    /**
     * @content 封装一个post请求
     */
    public static function HttpPost($url,$post_data){
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
       return $data;
    }
    /**
     * @content 天气
     */
    public static function getcityweather($city){
        $sign="2c3f30b09fed1c6d20864dfd07c94438";
        $appkey="41374";
        $url="http://api.k780.com/?app=weather.today&weaid=$city&appkey=$appkey&sign=$sign&format=json";
        $data =file_get_contents($url);
        $data =json_decode($data,true);
        if($data['success']==1){
            $result=$data['result'];
            $str ="今天是".$result['days']."\r\n";
            $str .=$result['week']."\r\n";
            $str .="城市：".$result['citynm']."\r\n";
            $str .="天气：".$result['weather']."\r\n";
            $str .="风度：".$result['wind'].$result['winp']; 
        }else{
            $str="有没有这个地名，心里没点b数吗？";
        }
        
        return $str;

    }
    /**
     * @content 图灵机器人
     */
    public static function tuling($str){
        $te ="<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
        </xml>";
        $data=[
            'perception'=>[
                'inputText'=>[
                    'text'=>$str
                ]
            ],
            'userInfo'=>[
                'apiKey'=>env("TULING_APIKEY"),
                'userId'=>env("TULING_USERID"),
            ]
        ];
        $post_data=json_encode($data);
        $tuling_url="http://openapi.tuling123.com/openapi/api/v2";
        $re=Wechat::HttpPost($tuling_url,$post_data);
        $msg=json_decode($re,true)['results'][0]['values']['text'];

        return $msg;
    }
    /**
     * @content 图片上传
     */
    public static function uploadfile($file){
        //获取文件类型
        $str = $file->getClientMimeType();
        //获取文件后缀名
        $ext = $file->getClientOriginalExtension();
        //获取文件当前位置
        $path = $file->getRealPath();
        //获取文件名称
        $newfilename = date('Ymd').'/'.mt_rand(1000,9999).'.'.$ext;
        //移动文件
        $re = Storage::disk('uploads')->put($newfilename,file_get_contents($path));
        $imgpath = public_path().'/uploads/'.$newfilename;
        $data=[
            'str'=>$str,
            'imgpath'=>$imgpath,
            'newfilename'=>$newfilename
        ];

        return $data;
    }
    /**
     * @content 获取类型
     */
    //获取文件类型
    public static function getType($str){
        $str = explode('/',$str);
        $ty = $str[0];
        $arr =[
            'image'=>'image',
            'audio'=>'voice',
            'video'=>'video'
        ];

        return $arr[$ty];
    }
    /**
     * @content 图文类型首次关注
     */
    public static function News($type,$form,$to){
        $time=time();
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
        $data = Subscribe::where('type',$type)->orderBy('s_id','desc')->first();
        $msgtype='news';
        $title=$data->title;//标题
        $des=$data->des;//内容
        $picurl = $data->picurl;//图片路径
        $url = $data->url;//点击路径
        // $media_id = Subscribe::first()->media_id;                   
        $resultStr = sprintf($te,$form,$to,$time,$msgtype,$title,$des,$picurl,$url);
        
        return $resultStr;
    }
    /**
     * @content 首次关注回复音频
     */
    public static function Voice($type,$form,$to){
        $time=time();
        $te ="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime><![CDATA[%s]]></CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Voice>
                    <MediaId><![CDATA[%s]]></MediaId>
                </Voice>
            </xml>";
        $msgtype='voice';        
        $media_id = Subscribe::where('type',$type)->orderBy('s_id','desc')->first()->media_id;                  
        $resultStr = sprintf($te,$form,$to,$time,$msgtype,$media_id);
        
        return $resultStr;
    }
    /**
     * @content 首次关注回复视频
     * $type 数据类型为视频
     */
    public static function Video($type,$form,$to){
        $time=time();
        $te ="<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime><![CDATA[%s]]></CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Video>
                    <MediaId><![CDATA[%s]]></MediaId>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                </Video>
            </xml>";
        $msgtype='video';        
        $data = Subscribe::where('type',$type)->orderBy('s_id','desc')->first();
        $media_id=$data->media_id;
        $title = $data->title;
        $des = $data->des;                  
        $resultStr = sprintf($te,$form,$to,$time,$msgtype,$media_id,$title,$des);
        
        return $resultStr;
    }
    /**
     * @content 商品详情
     */
    public static function shopcontent($goods,$form,$to){
        $time=time();
        $data =Goods::where('goods_name','like',"%$goods%")->orderBy('create_time','desc')->first();
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
                <Price><![CDATA[%s]]></Price>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
            </item>
            </Articles>
        </xml>";
        $msgtype='news';
        $title=$data->goods_name;//标题 
        $des="库存".$data->goods_num;//内容
        $price="价格".$data->self_price;//内容
        $picurl ="/uploads/goodsimg/".$data->goods_img;//图片路径
        $goods_id=$data->goods_id;
        $url ="39.96.204.43/shopcontent/".$goods_id;//点击路径
        $resultStr = sprintf($te,$form,$to,$time,$msgtype,$title,$des,$price,$picurl,$url);

        return $resultStr;
    }
}
