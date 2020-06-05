<?php
namespace app\admin\controller;
use app\common\util\PasswordHash;
use think\Db;
class Money  extends AdminBase
{
   public function moneylist(){
    $money = Db::name("money")->select();
    $this->assign('money',$money);
    return $this->fetch();
   }
   public function editmoney(){
    $id = input("get.id");
    $flag = Db::name("money")->where('id',"=",$id)->select();
    $this->assign('flag',$flag);
    return $this->fetch('editmoney');
   }
   public function edit2(){
    $flag = input('post.');
    $arr = $flag;
    $date = Date('Y-m-d H:i:s');
    $arr['update_time'] = date("Y-m-d H:i:s",$date);
    $money = Db::name("money")->where('id',"=",$arr['id'])->update($arr);
    if($money){
      return $this->success('修改金额成功','moneylist');
    }else{
      return $this->error('修改金额失败');
    }
   }
}
