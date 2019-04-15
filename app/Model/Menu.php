<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
        //与模型关联的数据表
        protected  $table=('menu');

        //定义表的主键
        protected $primaryKey="m_id";
    
        //执行模型是否自动维护时间戳
        public $timestamps=false;
        //获取二级菜单的值
        public static function menuson($pid){
                $menuson = Menu::where('pid',$pid)->where('status',1)->get()->toArray();
                return $menuson;
        }
}
