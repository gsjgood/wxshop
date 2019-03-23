<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cart;
class CartController extends Controller
{
    //清除购物车
    public function cartdel(Request $request){
        $goods_id=$request['goods_id'];
        $user_id=session('userInfo.user_id');
        $delWhere=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        $where=[
            'status'=>2,
            'buy_number'=>0
        ];
        $cart_model=new Cart();
        // dd($cart_model);
        $res=$cart_model->where($delWhere)->update($where);
        dd($res);
    }

    //加商品
    public function cartadd(Request $request){
        $goods_id=$request['goods_id'];
        $user_id=session('userInfo.user_id');
        $cart_model=new Cart();
        $Where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        $cartInfo=$cart_model->where($Where)->first()->toArray();
        $buy_number=$cartInfo['buy_number'];
        $where=[
            'buy_number'=>$buy_number+1
        ];
        $res=$cart_model->where($Where)->update($where);
    }
    //减商品
    public function cartmin(Request $request){
        $goods_id=$request['goods_id'];
        $user_id=session('userInfo.user_id');
        $cart_model=new Cart();
        $Where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        $cartInfo=$cart_model->where($Where)->first()->toArray();
        $buy_number=$cartInfo['buy_number'];
        $where=[
            'buy_number'=>$buy_number-1
        ];
        $res=$cart_model->where($Where)->update($where);
    }
    //购买的数量
    public function cartbuynum(Request $request){
        $goods_id=$request['goods_id'];
        $buy_number=$request["buy_number"];
        $user_id=session('userInfo.user_id');
        $cart_model=new Cart();
        $Where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        $where=[
            'buy_number'=>$buy_number
        ];
        $res=$cart_model->where($Where)->update($where);
    }
}
