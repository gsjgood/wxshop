<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use App\Model\Cart;
use App\Model\Category;
class ShopController extends Controller
{
    public function shopcate(Request $request){
        $pid=$request['cate_id'];
        $goods_model=new Goods();
        // dd($goods_model);
        $cate_model=new Category();
        $cateInfo=$cate_model->all()->toArray();
        //获取所有的子类id
        $cate_id=$this->getSonCateId($cateInfo,$pid);
        //获取所有子类下的id
        $goodsInfo=$goods_model->whereIn('cate_id',$cate_id)->get();
        // dd($goodsInfo);
        return view('shop/getallshop',['goodsInfo'=>$goodsInfo]);

    }
    //根据最新查询
    public function shopnew(Request $request){
        $pid=$request['cate_id'];
        $goods_model=new Goods();
        // dd($goods_model);
        $cate_model=new Category();
        $cateInfo=$cate_model->all()->toArray();
         //获取所有的子类id
         $cate_id=$this->getSonCateId($cateInfo,$pid);
         if($pid==0){
            $goodsInfo=$goods_model->orderBy('create_time','desc')->get();
        }else{
            $goodsInfo=$goods_model->whereIn('cate_id',$cate_id)->orderBy('create_time','desc')->take(5)->get();
         }
        //   dd($goodsInfo);
          return view('shop/getallshop',['goodsInfo'=>$goodsInfo]);
        
    }

    //根据价值排序
    public function shopup(Request $request){
        $pid=$request['cate_id'];
        $goods_model=new Goods();
        // dd($goods_model);
        $cate_model=new Category();
        $cateInfo=$cate_model->all()->toArray();
         //获取所有的子类id
         $cate_id=$this->getSonCateId($cateInfo,$pid);
         if($pid==0){
            $goodsInfo=$goods_model->orderBy('self_price','desc')->get();
        }else{
            $goodsInfo=$goods_model->whereIn('cate_id',$cate_id)->orderBy('self_price','desc')->take(5)->get();
         }
        //   dd($goodsInfo);
          return view('shop/getallshop',['goodsInfo'=>$goodsInfo]);
    }
    //根据价值降序
    public function shopdown(Request $request){
        $pid=$request['cate_id'];
        $goods_model=new Goods();
        // dd($goods_model);
        $cate_model=new Category();
        $cateInfo=$cate_model->all()->toArray();
         //获取所有的子类id
         $cate_id=$this->getSonCateId($cateInfo,$pid);
         if($pid==0){
            $goodsInfo=$goods_model->orderBy('self_price','asc')->get();
        }else{
            $goodsInfo=$goods_model->whereIn('cate_id',$cate_id)->orderBy('self_price','asc')->take(5)->get();
         }
        //   dd($goodsInfo);
          return view('shop/getallshop',['goodsInfo'=>$goodsInfo]);
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
    //商品详情
    public function shopcontent(Request $request){
        $goods_id=$request['goods_id'];
        // dd($goods_id);
        $user_id=session("userInfo.user_id");
        $where=[
            'goods_id'=>$goods_id,
        ];
        $goods_model=new Goods();
        $cart_model=new Cart();
        $goodsInfo =$goods_model->where($where)->first()->toArray();
        // dd($goodsInfo['goods_imgs']);
        $img=explode('|',$goodsInfo['goods_imgs']);
        // $img=array_pop($img);
        $cart=$cart_model->where($where)->count();
        // dd($cart);
        return view("shop/shopcontent",['goodsInfo'=>$goodsInfo,'img'=>$img,'cart'=>$cart]);
    }
    //查询
    public function seach(Request $request){
        $seach=$request['seach'];
        // dd($seach);
        $goods_model=new Goods();
        $goodsInfo=$goods_model->where('goods_name',"like","%$seach%")->get()->toArray();
        // dd($goodsInfo);
        return view('shop/getallshop',['goodsInfo'=>$goodsInfo]);

    }
}
