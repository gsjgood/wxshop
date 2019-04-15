<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Subscribe;
use CURLFile;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

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
            dd($request['img']);
            //文件上传
            $file = $request->img;
            $data = Wechat::uploadfile($file);
            // 获取data信息
            $newfilename = $data['newfilename'];
            $imgpath = $data['imgpath'];
            //type格式
            $str = $data['str'];
            $type=Wechat::getType($str);
            //获取token
            $token = Wechat::getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";
            $data= ['media'=>new CURLFile(realpath($imgpath),$str,$newfilename),];
            //视频文件的数据处理
            $description=json_encode([
                'title'=>$request->input("title"),
                'introduction'=>$request->input("des"),
            ]);
            if($type=='video'){
                $data= [
                    'media'=>new CURLFile(realpath($imgpath),$str,$newfilename),
                    'description'=>$description
                ];
            }
            //获取文件post结果
            $re =Wechat::HttpPost($url,$data);
            //处理成json集合
            $da = json_decode($re,true);
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
            
        }else{
            return "文件未提交";
        }
    }
    /**
     * @content 首次关注类型设置
     */
    public function wxtype(){
        //默认设置
        $type = config("wxconfig.subscribe");
        return view('admin.wxtype',['type'=>$type]);
    }
    /**
     * @content 处理首次关注的类型
     */
    public function wxtypedo(Request $request){
        $type = $request->type;
        //获取config中wxconfig.php文件的路径
        $path = config_path("wxconfig.php");
        //将类型添加到自定义Key中
        $config = [];
        $config['subscribe']=$type;
        //原样输出到文件中
        $str='<?php return '.var_export($config,true).";?>";
        $re = file_put_contents($path,$str);
        if($re){
            return "修改成功";
        }else{
            return "修改失败";
        }
    }
}
