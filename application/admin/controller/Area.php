<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2020/4/18
 * Time: 14:07
 */

namespace app\admin\controller;


use think\Db;

class Area extends AdminBase
{
    public function areaList(){
        $district=trim(input('district'));
        $map=array();
        $map['level']=1;
        if(!empty($district)){
            $map['district']=['like','%'.$district.'%'];
        }
        $data=Db::name('area')
            ->where($map)
            ->paginate(10);
        // dump($data->render());
        // dump($data);die;
        return view('',['data'=>$data,'district'=>$district]);
    }
}