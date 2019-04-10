<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //与模型关联的数据表
    protected  $table=('shop_user');

    //定义表的主键
    protected $primaryKey="user_id";

    //执行模型是否自动维护时间戳
    public $timestamps=false;
    //过滤
    // protected $guarded = ['user_email'];
}
