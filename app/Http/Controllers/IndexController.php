<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cart;
use App\Model\Category;
class IndexController extends Controller
{
    public function index(){
        $goods_model=new Goods;
        $res=$goods_model->limit(4)->get();
        // dd($res);
        //获取展示栏的顶级分类
        $cate_model=new Category;
        $where=[
            'pid'=>0
        ];
        $pid=$cate_model->where($where)->get()->toArray();

        return view('index',['res'=>$res,'pid'=>$pid]);
    }
    //全部商品
    public function allshop(Request $request){
        // $url_id = substr($request->getRequestUri(),'10');
        // dd($url_id);die;
        $cate_model=new Category;
        $where=[
            'pid'=>0
        ];
        $cateInfo=$cate_model->get()->toArray();
        $res=$this->getCateInfo($cateInfo);
        $pid=$cate_model->where($where)->get()->toArray();
        // dd($pid);
        $id=$request['id'];
        if($id!=0){
            $cate_id=$this->getSonCateId($cateInfo,$id);
            $goodsInfo =Goods::whereIn('cate_id',$cate_id)->get();
        }else{
            $goodsInfo=Goods::all();
        }
        return view("/allshop",['res'=>$res,'pid'=>$pid,'goodsInfo'=>$goodsInfo,'cate_id'=>$id]);
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
    //购物车
    public function shopcart(Request $request){
        $goods_id=$request['goods_id'];
        //根据商品id做添加到购物车
        $cart_model=new Cart();
        $goods_model=new Goods();
        $user_id=session('userInfo.user_id');
        //判断该用户下是否有商品
        $cartWhere=[
            "goods_id"=>$goods_id,
            'user_id'=>$user_id,
        ];
        $re=$cart_model->where($cartWhere)->first();
        // dd($re);
        if($re){
            //有的话做购买数量的添加
            $data=[
                'buy_number'=>$re['buy_number']+1
            ];
            $where=[
                'user_id'=>$user_id,
                'goods_id'=>$goods_id
                
            ];
            $res=$cart_model->where($where)->update($data);
        }else{
            //没有的话添加
            if($goods_id==""){
                        //查询商品数据
                $where=[
                    "user_id"=>$user_id,
                    "status"=>1
                ];
                $goodsInfo=$goods_model
                ->join('shop_cart','shop_goods.goods_id','=','shop_cart.goods_id')
                ->where($where)
                ->take(3)
                ->orderBy('shop_cart.create_time','desc')
                ->get()
                ->toArray();
                // dd($goodsInfo);
                //最新热卖
                $newgoods=$goods_model->orderBy('create_time','desc')->take(2)->get();
                // dump($newgoods);
                return view("shopcart",['goodsInfo'=>$goodsInfo,'newgoods'=>$newgoods]);
            }else{
                $data=[
                    "goods_id"=>$goods_id,
                    'user_id'=>$user_id,
                    'buy_number'=>1,
                    'create_time'=>time()
                ];
                $res=$cart_model->insert($data);
            }
        }

        
    }
    //我的
    public function userpage(){
        return view("userpage");
    }
     /**
     * 获取所有子类的id
     * $cateInfo 所有分类信息
     * $pid  父类id
     *  */
    public function getSonCateId($cateInfo,$pid){
        static $cate_id=[];
        foreach($cateInfo as $k=>$v){
            if($v['pid']==$pid){
                $cate_id[]=$v['cate_id'];
                self::getSonCateId($cateInfo,$v['cate_id']);
            }
        }
        // dd($cate_id);
        return $cate_id;
    }

    
    
}
