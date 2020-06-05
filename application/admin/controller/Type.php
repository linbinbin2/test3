<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2020/4/18
 * Time: 15:44
 */

namespace app\admin\controller;


use think\Db;

class Type extends AdminBase
{
    public function typeList(){
        $map=array();
        //$map['level']=0;
        $data=Db::name('type')->where($map)->where('del',"=",1)->paginate(10);
        return view('',['data'=>$data]);
    }

    public function Search(){
      $flag = input('post.');
      // dump($flag);die;
      $ttype = $flag['ttype'];
      //print_r($flag);
      $data = Db::name("type")->where('del',"=",1)->where('ttype',"like",'%'.$ttype.'%')->paginate(10);
      $this->assign('data',$data);
      return $this->fetch('typeList');
    
    }

    public function  addtype(){
        $typeL = input('post.');

        if($typeL){

          $arr = $typeL;
          if($typeL['tid']==0){
            $arr['level'] =0;
          }else{
            $arr['level'] =2;
          }
          $arr['del'] = 1;
          $arr['create_time'] = Date('m-d H:i:s');
          $type = Db::name("type")->insert($arr);
          if($type){
             return $this->success('添加成功','typeList');
           }else{
              return $this->error('添加失败');
           }
        }else{
          $type_type = Db::name("type")->where('level',"=",0)->select();
          $this->assign('type_type',$type_type);
          return $this->fetch();
        }
        
    }
    //修改type
    public function EditType(){
        $type = input('get.');
        $type_id = $type['id'];
        $type_user = Db::name("type")->where('id','=',$type_id)->find();
        $type_name = $type_user['ttype'];
        $this->assign('type_name',$type_name);   
            
        $type_type = Db::name("type")->where('level',"=",0)->select();
        $this->assign('type_type',$type_type);
        $this->assign('typeid',$type_id);
        return $this->fetch();
    }
    public function edit2type(){
      $flag = input('post.');

      $arr = array();
      $arr = $flag;
       if($flag['tid'] != 0){
        $arr['level'] = 2;
      }
      $arr['del'] = 1;
      $arr['create_time'] = Date('m-d H:i:s');
      
      $res = Db::name('type')->where('id','=',$flag['id'])->update($arr);
      print_r($res);
      if($res){
          return $this->success('修改成功','typeList');
      }else{
        return $this->error('修改失败');
      }
    }
    public function DelType(){
      $type = input('get.');
      $type_id = $type['id'];
      
      $res = Db::name('type')->where('id','=',$type_id)->update(['del'=>2]);
    print_r($res);

      if($res){
          return $this->success('删除成功','typeList');
      }else{
          return $this->error('删除失败');
      }
    } 

    
    /*public function savetype(){
       $type=input('post.');
       $id = $type['id'];
       if($type=='add'){
           $data=array();
           $data['ttype']=trim(input('article_title'));
           $data['tid']=trim(input('tid'));
           if(empty($data['tid'])){
               $data['level']=0;
           }else{
               $data['level']=2;
           }
           $res=Db::name('type')->insert($data);
       }else{
           $data=array();
           $data['ttype']=trim(input('article_title'));
           $data['tid']=trim(input('tid'));
           if(empty($data['tid'])){
               $data['level']=1;
           }else{
               $data['level']=2;
           }
           $id=trim(input('id'));
           $res=Db::name('type')->where('id',$id)->update($data);
       }
       if($res){
           return ['code'=>1,'msg'=>'操作成功'];
       }else{
           return ['code'=>2,'msg'=>'操作失败'];
       }
    }*/
}