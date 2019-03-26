<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
     //与模型关联的数据表
     protected  $table=('shop_area');

     //定义表的主键
     protected $primaryKey="id";
 
     //执行模型是否自动维护时间戳
     public $timestamps=false;
}
