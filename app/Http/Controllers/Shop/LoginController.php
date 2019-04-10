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
        //验证
        $validate = Validator::make($request->all(),[  
            'user_tel'=>"required",
            'user_pwd'=>"required|min:6|max:12|regex:/^[a-zA-Z0-9]+$/",
            'code'=>'required'],[
          "user_tel.required"=>'用户名不能为空',
          "user_pwd.required"=>'密码不能是空',
          "code.required"=>'验证码不能为空',
          "user_pwd.min"=>"密码不能小于6位",
          "user_pwd.max"=>"密码不能大于12位",
          "user_pwd.regex"=>"密码格式不对，只能输入字母和数字",
        ]);
        
        static $str = '';
        if($validate->fails()){
            $errors  = $validate->errors()->getMessages();
            foreach ($errors as $v){
                $str .= implode('&&',$v)."<br>";
            }
            return $str;
        }
        
        $code=$request['code'];
        $code_session=session('verifycode');
        $user_tel=$request['user_tel'];
        $user_pwd=$request['user_pwd'];
        //非空验证
        if($code==""){echo "验证码不能为空";}
        if($user_pwd==""){echo "密码不能为空";}
        if($user_tel==""){echo "用户名不能为空";}
        //登录错误5次锁定一小时
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
                        "user_tel"=>$res['user_tel'],
                        "user_name"=>$res['user_name']
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
        //验证
        $validate = Validator::make($request->all(),[  
            'user_tel'=>"required|unique:shop_user,user_tel",
            'user_pwd'=>"required|min:6|max:12|regex:/^[a-zA-Z0-9]+$/",
            'code'=>'required'],[
          "user_tel.required"=>'用户名不能为空',
          "user_tel.unique"=>'用户名已经存在',
          "user_pwd.required"=>'密码不能是空',
          "code.required"=>'验证码不能为空',
          "user_pwd.min"=>"密码不能小于6位",
          "user_pwd.max"=>"密码不能大于12位",
          "user_pwd.regex"=>"密码格式不对，只能输入字母和数字",
        ]);

        static $str = '';
        if($validate->fails()){
            $errors  = $validate->errors()->getMessages();
            foreach ($errors as $v){
                $str .= implode('&&',$v)."<br>";
            }
            return $str;
        }
        unset($request['repwd']);
        unset($request['_token']);
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
    //忘记密码
    public function regauth(Request $request){
        return view('login/regauth');
    }
    //忘记密码-修改密码
    public function resetpassword(Request $request){
        return view('userinfo.resetpassword');
    }
    //退出登录
    public function quit(Request $request){
        $request->session()->forget('userInfo');
        return back()->withInput();
    }
}
