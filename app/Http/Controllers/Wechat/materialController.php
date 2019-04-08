<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use Illuminate\Support\Facades\Storage;
use CURLFile;
use function GuzzleHttp\json_decode;

class materialController extends Controller
{
    public function index(){
        return view('wechat.index');
    }
    /**
     * @content 新增临时素材
     */
    public function getMaterial(Request $request){
        //获取文件
        $file = $request->material;
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
        if($re){
            $token =Wechat::getAccessToken();
            $ty = self::getType($str);
            $imgpath = public_path().'/uploads/'.$newfilename;
            $url  = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$ty";
            $data = ['media'=>new CURLFile(realpath($imgpath),$str,$newfilename)];
            //     CURLFile        要上载的文件的名称。
            // 上载数据中文件的名称(默认为name属性)。
            // 文件的MIME类型(默认为application/octe -stream)
            $re = Wechat::HttpPost($url,$data);
            $result = json_decode($re,true);
            if($result['media_id']){
                $media_id = $result['media_id'];
                $request->session()->put('media_id',$media_id);
                // echo session('media_id');
            }else{
                die("素材上传出错");
            }
        }else{
            die ("失败");
        }
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=TYPE";
    }
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

}
