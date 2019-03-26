<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
class userInfoController extends Controller
{
    //设置
    public function set(){
        return view("userInfo/set");
    }
    //编辑个人资料
    public function edituser(){
        $user=new User();
        $user_id=session('userInfo.user_id');
        $where=[
            'user_id'=>$user_id
        ];
        $userInfo=$user->where($where)->first();
        // dd($userInfo);
        return view("edituser",['userInfo'=>$userInfo]);
    }
    //安全设置
    public function safeset(){
        return view("userInfo/safeset");
    }
     //重置密码
     public function modyloginpwd(){
        return view("modyloginpwd");
    }
    //修改
    public function updatepwd(Request $request){
        $pwd=$request['pwd'];
        $pwd=encrypt($pwd);
        $user_pwd=$request['user_pwd'];
        $user=new User();
        $user_id=session('userInfo.user_id');
        $res=$user->where(['user_id'=>$user_id])->first()->toArray();
        $res_pwd=decrypt($res['user_pwd']);
        if($user_pwd==$res_pwd){
            $where=[
                "user_id"=>$user_id
            ];
            $updateWhere=[
                "user_pwd"=>$pwd
            ];
            $re=$user->where($where)->update($updateWhere);
            if($re){
                echo "修改成功";
            }else{
                echo "修改失败";
            }
        }else{
            echo "当前密码错误";
        }
    }
}
