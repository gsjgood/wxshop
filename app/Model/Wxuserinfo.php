<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wxuserinfo extends Model
{
    //与模型关联的数据表
    protected  $table=('wxuserinfo');

    //定义表的主键
    protected $primaryKey="wxu_id";

    //执行模型是否自动维护时间戳
    public $timestamps=false;
    //过滤
    protected $guarded = ['nickname'];
}
