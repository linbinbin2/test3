<?php
namespace app\index\model;
use think\Model;
class User extends Model{
    public function getInfo($map){
        $data = $this->where('address','like','%'.$map.'%')
                    ->where('type','like','%'.$type.'%')->find();
        if(!empty($data)){
            $data = $data->toArray();
        }
        return $data;
    }
}
?>