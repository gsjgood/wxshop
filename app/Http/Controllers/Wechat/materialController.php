<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Subscribe;
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
        $data = Wechat::uploadfile($file);
        $str = $data['str'];
        $imgpath = $data['imgpath'];
        $newfilename = $data['newfilename'];
            $token =Wechat::getAccessToken();
            $ty = self::getType($str);
            $url  = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$ty";
            $data = ['media'=>new CURLFile(realpath($imgpath),$str,$newfilename)];
            //     CURLFile        要上载的文件的名称。
            // 上载数据中文件的名称(默认为name属性)。
            // 文件的MIME类型(默认为application/octe -stream)
            $re = Wechat::HttpPost($url,$data);
            $result = json_decode($re,true);
            echo $result['media_id'];
            if($result['media_id']){
                $media_id = $result['media_id'];
                $data=[
                    'media_id'=>$media_id
                ];
                $res = Subscribe::insert($data);
                // dd($res);
            }else{
                die("素材上传出错");
            }
        
        // $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=TYPE";
    }


}
