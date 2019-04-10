<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Subscribe;
use CURLFile;
use function GuzzleHttp\json_decode;

class WechatAdminController extends Controller
{
    public function index(){
        return view("admin.index");
    }
    public function wxindex(){

        return view("admin.wxindex");
    }
    //上传素材
    public function upsubscribe(Request $request){
        if($request->hasFile('img')){
            $file = $request->img;
            $data = Wechat::uploadfile($file);
            $str = $data['str'];
            $newfilename = $data['newfilename'];
            $imgpath = $data['imgpath'];
            $token = Wechat::getAccessToken();
            $type=Wechat::getType($str);
            $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";
            $data= ['media'=>new CURLFile(realpath($imgpath),$str,$newfilename)];
            $re =Wechat::HttpPost($url,$data);
            // var_dump($re);
            $da = json_decode($re,true);
            // dd($da);
            if($da['media_id']){
                $date =[
                    'type'=>$request->input('type'),
                    'media_id'=>isset($da['media_id'])?$da['media_id']:null,
                    'url'=>$request->input('url',null),
                    'title'=>$request->input('title',null),
                    'des'=>$request->input('des',null),
                    'picurl'=>isset($da['url'])?$da['url']:null
                ];
                $res = Subscribe::insert($date);
                if($res){
                    return "提交成功";
                }else{
                    return "提交失败";
                }
            }else{
                die($da['errmsg']);
            }
            
        }
    }
    /**
     * @content 关注类型选择
     */
    public function wxtype(){
        $type = config("wxconfig.subscribe");
        return view('admin.wxtype',['type'=>$type]);
    }
    /**
     * @content 处理选择的类型
     */
    public function wxtypedo(Request $request){
        $type = $request->type;
        $path = config_path("wxconfig.php");
        $config = [];
        $config['subscribe']=$type;
        // dd($config);
        $str='<?php return '.var_export($config,true).";?>";
        file_put_contents($path,$str);
    }
}
