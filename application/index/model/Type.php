<?php
/**
 * @Author: ningmeng
 * @Date:   2020-04-19 16:11:49
 * @Last Modified by:   ningmeng
 * @Last Modified time: 2020-04-19 16:35:36
 */
namespace app\index\model;
use think\Model;
class Type extends Model{
    public function getInfo($map){
        $data = $this->where('ttype',"=",$map)->find();
        if(!empty($data)){
            $data = $data->toArray();
        }
        return $data;
    }
}