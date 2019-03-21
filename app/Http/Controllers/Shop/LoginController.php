<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use Validator;
use function GuzzleHttp\json_encode;
class LoginController extends Controller
{
    //登录
    public function login(){
       return view("login/login");
    }
    //登录跳转
    public function logindo(Request $request){
        $code=$request['code'];
        $code_session=session('verifycode');
        $user_tel=$request['user_tel'];
        $user_pwd=$request['user_pwd'];
        $user_model=new User;
        $res=$user_model->where(["user_tel"=>$user_tel])->first();

        if($res){
            $pwd=decrypt($res['user_pwd']);
            if($pwd==$user_pwd){
                if($code==$code_session){
                    $error_num=$res['error_num'];
                    $last_error_time=$res['last_error_time'];
                    $where=[
                        'user_tel'=>$user_tel
                    ];
                    $uWhere=[
                        "error_num"=>0,
                        "last_error_time"=>time()
                    ];
                    $userInfo=[
                        "user_id"=>$res['user_id'],
                        "user_name"=>$res['user_tel']
                    ];
                    session(["userInfo"=>$userInfo]);
                    $re=$user_model->where($where)->update($uWhere);
                    echo "登录成功";
                }else{
                    echo "验证码不对";
                }
            }else{
                $error_num=$res['error_num'];
                $last_error_time=$res['last_error_time'];
                $updateWhere=[
                    "error_num"=>$error_num+1,
                    "last_error_time"=>time()
                ];
                $where=[
                    'user_tel'=>$user_tel
                ];
                $time=time()-$last_error_time;
                // dd($time);die;
                if($time>=3600){
                    $uWhere=[
                        "error_num"=>1,
                        "last_error_time"=>time()
                    ];
                    $re=$user_model->where($where)->update($uWhere);
                    echo "密码错误1";
                }else{
                    if($error_num>=5){
                        echo "账号锁定一小时";
                    }else{
                        //错误次数加一
                        $re=$user_model->where($where)->update($updateWhere);
                        echo "密码错误";
                    }
                }
            }
        }else{
            echo "账号错误";
        }
    }
    //注册
    public function register(){
        // dd(session('sendEmail'));
        return view("login/register");
    }
    //注册添加
    public function registeradd(Request $request){
        unset($request['repwd']);
        $code=$request['code'];
        $code_session=session("sendEmail.code");
        if($code==$code_session){
            unset($request['code']);
            $data=$request->all();
            $user_pwd=$request['user_pwd'];
            $data['user_pwd']=encrypt($user_pwd);
            $user_model=new User;
            $res=$user_model->insert($data);
            if($res){
                echo "ok";
            }else{
                echo "no";
            }
        }else{
            return "验证码不对";
        }
    }
    //用户唯一性验证
    public function unique(Request $request){
        $user_tel=$request['user_tel'];
        $user_model=new User();
        $res=$user_model->where(['user_tel'=>$user_tel])->count();
        if($res!=0){
            return "no";
        }else{
            return "ok";
        }

    }
}
