<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //与模型关联的数据表
    protected  $table=('shop_goods');

    //定义表的主键
    protected $primaryKey="goods_id";

    //执行模型是否自动维护时间戳
    public $timestamps=false;
}
