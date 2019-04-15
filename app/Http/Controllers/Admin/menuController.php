<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use App\Model\Menu;
class menuController extends Controller
{
   /**
     * @content自定义菜单创建接口
     */
    public function menulist(){
        // $token = Wechat::getAccessToken();
        // $url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$token";
        // $data = file_get_contents($url);
        $str = '{"menu":{"button":[{"type":"click","name":"今日歌曲","key":"V1001_TODAY_MUSIC","sub_button":[]},{"name":"菜单","sub_button":[{"type":"view","name":"搜索","url":"http:\/\/www.soso.com\/","sub_button":[]},{"type":"miniprogram","name":"wxa","url":"http:\/\/mp.weixin.qq.com","sub_button":[],"appid":"wx286b93c14bbf93aa","pagepath":"pages\/lunar\/index"},{"type":"click","name":"赞一下我们","key":"V1001_GOOD","sub_button":[]}]}]}}';
        $str = json_decode($str,true)['menu']['button'];
       print_r($str);
        $arr = [];
        $arr1 = [];
        foreach($str as $k=>$v){
            // print_r($k);
            $arr[$k]['pid']=0;
            $arr[$k]['type']=isset($v['type'])?$v['type']:null;
            $arr[$k]['name']=$v['name'];
            $arr[$k]['key']=isset($v['key'])?$v['key']:null;
            $arr[$k]['url']=isset($v['url'])?$v['url']:null;
            if(!empty($v['sub_button'])){
                // print_r($k);
                foreach($v['sub_button'] as $key=>$value){
                    
                    $arr1[$key]['pid']=$k+1;
                    $arr1[$key]['type']=isset($value['type'])?$value['type']:null;
                    $arr1[$key]['name']=$value['name'];
                    $arr1[$key]['url']=isset($value['url'])?$value['url']:null;
                    $arr1[$key]['key']=isset($value['key'])?$value['key']:null;
                }
                
            }
        }
        print_r($arr);
        // print_r($arr1);
        // die;
        foreach($arr as $v){
            Menu::insert($v);
        }
        foreach($arr1 as $v){
            Menu::insert($v);
        }
        return view("/admin/menuindex");
    }

    public function menuindex(){
        $menuinfo=Menu::where('is_back',1)->get()->toArray();
        // dd($menuinfo);
        $son =$this->getmenuinfo($menuinfo);
        // print_r($son);
        return view('/admin/menuindex',['menuinfo'=>$son]);
    }
    public function getmenuinfo($menuinfo,$pid=0){
        // dd($menuinfo);
        static $arr=[];
        foreach($menuinfo as $k=>$v){
            if($v['pid']==$pid){
                $arr[]=$v;
                $this->getmenuinfo($menuinfo,$v['m_id']);
            }
        }

        return $arr;
    }
    public function addmenu(){
        //获取二级菜单
        $menu = Menu::menuson(0);
        return view('admin/addmenu',['menu'=>$menu]);
    }

    public function domenuadd(Request $request){
        unset($request['_token']);
        $pid = $request['pid'];
        $data=$request->all();
        if($pid==0){
            unset($request['type']);
            unset($request['key']);
            unset($request['url']);
            $res = Menu::insert($data);
            // dd($res);
            if($res){
                return "添加成功";
            }else{
                return "添加失败";
            }
        }else{
            $res = Menu::insert($data);
            // dd($res);
            if($res){
                return "添加成功";
            }else{
                return "添加失败";
            }
        }
        
    }
    /**
     * @content 获取所有启用菜单
     */
    public function wxMenu(){
        $menu = Menu::where('status',1)->get()->toArray();
        // print_r($menu);
        //处理json
        $data=[];
        foreach($menu as $key=>$value){
            if($value['pid']==0){
                if($value['type']==""){
                   //二级菜单
                   $pid = $value['m_id'];
                   $sonmenu =Menu::menuson($pid);
                    $sonarr=[];
                    foreach($sonmenu as $k=>$v){
                        if($v['type']=="click"){
                            $sonarr[]=[
                                'name'=>$v['name'],
                                'key'=>$v['key'],
                                'type'=>$v['type'],
                            ];
                        }else if($v['type']=="view"){
                            $sonarr[]=[
                                'name'=>$v['name'],
                                'url'=>$v['url'],
                                'type'=>$v['type'],
                            ];
                        }
                    }
                    // print_r($sonarr);
                    //将二级菜单放入一级菜单中
                    $data[]=[
                        'name'=>$value['name'],
                        'sub_button'=>$sonarr
                    ];
                }else if($value['type']=="click"){
                    $data[]=[
                        'name'=>$value['name'],
                        'key'=>$value['key'],
                        'type'=>$value['type'],
                    ];
                }else if($value['type']=="view"){
                    $data[]=[
                        'name'=>$value['name'],
                        'url'=>$value['url'],
                        'type'=>$value['type'],
                    ];
                }
            }
        }
        $data=[
            'button'=>$data,
        ];
        $menujson = json_encode($data,JSON_UNESCAPED_UNICODE);
        $token=Wechat::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$token";
        $res = Wechat::HttpPost($url,$menujson);
        // var_dump($res);
    }
    public function customize(){
        $data =Menu::get();
        $menujson = json_encode($data,JSON_UNESCAPED_UNICODE);
        return view('/admin/customize',['data'=>$menujson]);
    }
    //是否开启菜单
    public function statusUpdate(Request $request){
        unset($request['_token']);
        $status = $request->status;
        $m_id = $request->m_id;
        
        $res_mid = Menu::where('pid',$m_id)->select('m_id')->get()->toArray();
        $where=[
            'm_id'=>$m_id
        ];
        $updateWhere=[
            'status'=>$status
        ];
        $re=Menu::whereIn('m_id',$res_mid)->update($updateWhere);
        // dd($re);
        $res = Menu::where($where)->update($updateWhere);
        $this->wxMenu();
        if($res){
            return "修改成功";
        }else{
            return "修改失败";
        }
        
    }
    //删除
    public function menudel(Request $request){
        $m_id =$request->m_id;
        $res_mid = Menu::where('pid',$m_id)->select('m_id')->get()->toArray();
        // dd($res_mid);
        $where=[
            'm_id'=>$m_id
        ];
        $updateWhere=[
            'is_back'=>2,
            'status'=>2            
        ];
        if($res_mid==[]){
            $res = Menu::where($where)->update($updateWhere); 
            if($res){
                return "删除成功";
            }else{
                return "删除失败";
            }           
        }else{
            $re=Menu::whereIn('m_id',$res_mid)->update($updateWhere);
            $res = Menu::where($where)->update($updateWhere);
            if($res){
                return "删除成功";
            }else{
                return "删除失败";
            }
        }
    }
}
