<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
        //与模型关联的数据表
        protected  $table=('shop_address');

        //定义表的主键
        protected $primaryKey="address_id";
    
        //执行模型是否自动维护时间戳
        public $timestamps=false;
}
