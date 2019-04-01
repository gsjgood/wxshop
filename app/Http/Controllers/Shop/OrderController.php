<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Address;
use App\Model\Goods;

class OrderController extends Controller
{
    //立即购买
    public function ordersupplyment(Request $request){
        $goods_id=$request['goods_id'];
        $address=new Address();
        $goods=new Goods();
        $user_id=session('userInfo.user_id');
        $addressWhere=[
            'user_id'=>$user_id,
            "is_default"=>1
        ];
        $addressinfo=$address->where($addressWhere)->first();
        $where=[
            "goods_id"=>$goods_id
        ];
        $goodsInfo=$goods->where($where)->first();
        // dd($goodsInfo);
        return view('order.ordersupplyment',['addressinfo'=>$addressinfo,'goodsInfo'=>$goodsInfo]);
    }
    //购物车购买
    public function ordersupplymentCart(Request $request){
        $goods_id=$request['goods_id'];
        // dd($goods_id);
        $goods_ids=explode(',',$goods_id);
        $address=new Address();
        $goods=new Goods();
        $user_id=session('userInfo.user_id');
        $addressWhere=[
            'user_id'=>$user_id,
            "is_default"=>1
        ];
        $addressinfo=$address->where($addressWhere)->first();
        $goodsInfo=$goods->whereIn('goods_id',$goods_ids)->get()->toArray();
        // dd($goodsInfo);
        return view('order.ordersupplymentCart',['addressinfo'=>$addressinfo,'goodsInfo'=>$goodsInfo,'goods_id'=>$goods_id]);
    }
    //购物车结算
    public function orderwillsendCart(Request $request){
        $goods_id=$request['goods_id'];
        $goods_ids=explode(',',$goods_id);
        $address=new Address();
        $goods=new Goods();
        $user_id=session('userInfo.user_id');
        $addressWhere=[
            'user_id'=>$user_id,
            "is_default"=>1
        ];
        $addressinfo=$address->where($addressWhere)->first();
        $goodsInfo=$goods->whereIn('goods_id',$goods_ids)->get()->toArray();
        // dd($goodsInfo);
        $randnum="ABCDEFGHIGKLMNOPQRSTUVWXYZ1234567890";
        $user_id=session('userInfo.user_id');
        $ordernumber=date('ymdhis').substr(str_shuffle($randnum),0,5).$user_id;
        return view('order.ordersupplymentCart',['addressinfo'=>$addressinfo,'goodsInfo'=>$goodsInfo,'ordernumber'=>$ordernumber]);
    }
    //确定地址
    public function orderwillsend(Request $request){
        $goods_id=$request['goods_id'];
        $address=new Address();
        $goods=new Goods();
        $user_id=session('userInfo.user_id');
        $addressWhere=[
            'user_id'=>$user_id,            
            "is_default"=>1
        ];
        $addressinfo=$address->where($addressWhere)->first();
        $where=[
            "goods_id"=>$goods_id
        ];
        $goodsInfo=$goods->where($where)->first();
        //生成订单号
        $randnum="ABCDEFGHIGKLMNOPQRSTUVWXYZ1234567890";
        $user_id=session('userInfo.user_id');
        $ordernumber=date('ymdhis').substr(str_shuffle($randnum),0,5).$user_id;
        // dd($ordernumber);
        return view('order.orderwillsend',['addressinfo'=>$addressinfo,'goodsInfo'=>$goodsInfo,'ordernumber'=>$ordernumber]);
    }
    //修改地址
    public function orderaddress(){
        $user_id=session('userInfo.user_id');
        $where=[
            'user_id'=>$user_id
        ];
        $address=Address::where($where)->get();
        // dd($address);
        return view('order.orderaddress',['res'=>$address]);
    }
}
