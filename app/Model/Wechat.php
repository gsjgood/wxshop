<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use function GuzzleHttp\json_decode;

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
        $data=json_decode($data,true);
        $token=$data['access_token'];
        
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

}
