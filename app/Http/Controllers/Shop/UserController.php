<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Address;
use App\Model\Area;

class UserController extends Controller
{
    //购买记录
    public function buyrecord(){
        return view("user/buyrecord");
    }
    //我的钱包
    public function mywallet(){
        return view('user/mywallet');
    }
    //收货地址
    public function address(){
        $address=new Address();
        $user_id=session('userInfo.user_id');
        $where=[
            'user_id'=>$user_id,
            'address_status'=>1
        ];
        $res=$address->where($where)->get();
        return view('user/address',['res'=>$res]);
    }
    //删除地址
    public function addressdel(Request $request){
        unset($request['_token']);
        $address_id=$request['address_id'];
        // dd($address_id);
        $address=new Address();
        $user_id=session('userInfo.user_id');
        $where=[
            'address_id'=>$address_id,
            'user_id'=>$user_id
        ];
        $udWhere=[
            'address_status'=>2
        ];
        $res=$address->where($where)->update($udWhere);
        dd($res);
       
    }
    //设为默认
    public function addressdefault(Request $request){
        $address_id=$request['address_id'];
        $address=new Address();
        $user_id=session('userInfo.user_id');
        $where=[
            'user_id'=>$user_id
        ];
        $updateWhere=[
            'is_default'=>2
        ];
        $res=$address->where($where)->update($updateWhere);
        $where2=[
            'address_id'=>$address_id,
            'user_id'=>$user_id
        ];
        $updateWhere2=[
            'is_default'=>1
        ];
        $res=$address->where($where2)->update($updateWhere2);
        dd($res);        

    }
    //收货地址添加
    public function writeaddr(Request $request){
        if($request->post()){
            unset($request['_token']);
            $is_default=$request['is_default'];
            $data=$request->all();
            $address=new Address();
            $user_id=session('userInfo.user_id');
            if($user_id){
                if($is_default){
    
                    $where=[
                        'is_default'=>2
                    ];
                    $re=$address->where('address_id','>',0)->update($where);
                    // dd($re);
                    $data['is_default']=1;
                    $data['user_id']=$user_id;
                    $data['create_time']=time();
                    $res=$address->insert($data);
                    // dd($res);
                    // echo "ok";
                    return redirect("user/address");
                }else{
                    $data['user_id']=$user_id;
                    $res=$address->insert($data);
                    // echo "ok";
                    return redirect("user/address");
    
                }
            }else{
                return redirect("login");
            }
        }else{
            // $area=new Area();
            // $res=$area->get();
            // $re=$this->getCateInfo($res);
            // dd($re);
            return view('user/writeaddr');
        }
    }
     //递归
     public function getCateInfo($cateInfo,$pid=0){
        static $arr=[];
        foreach($cateInfo as $k=>$v){
            if($v['pid']==$pid){
                $arr[]=$v;
                self::getCateInfo($cateInfo,$v['cate_id']);    
            }
        }
        // dd($arr);
        return $arr;
    }
    //我的晒单
    public function willshare(){
        return view("user/willshare");
    }
    //二维码分享
    public function invite(){
        return view("user/invite");
    }

}
