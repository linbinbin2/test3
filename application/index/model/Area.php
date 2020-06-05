<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2020/4/19
 * Time: 12:25
 */
namespace app\index\model;
use think\Model;

class Area extends Model
{
    public function getInfo($map){
        //$thin->where   == Db::name("area")->where
        $data=$this->where('district_id',"=",$map)->find();
        if(!empty($data)){
            $data=$data->toArray();  //转换当前模型对象为数组
        }
        return $data;
    }
}