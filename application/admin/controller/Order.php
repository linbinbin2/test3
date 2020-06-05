<?php
namespace app\admin\controller;
use app\common\util\PasswordHash;
use think\Db;
class Order  extends AdminBase
{
   public function orderlist(){
    // $Users = input('post.');
    $Users = input('param.');
    $phone = $Users['username'];
    if($phone == '')
    {
        $order = Db::name("order")->where('is_del',"=",2)->order('id','desc')->paginate(10);
    }else
    {
        $order = Db::name("order")->where('users_phone',$phone)->where('is_del',"=",2)->order('id','desc')->paginate(10,false,['query' => request()->param()]);
    }
    
    $this->assign('order',$order);
    return $this->fetch();
   }
   public function delorder(){
        $order = input('get.');
        $order_id = $order['id'];
        $res = Db::name("order")->where('id',"=",$order_id)->update(['is_del'=>1]);
        if($res){
            return $this->success('删除订单成功','Orderlist');
        }else{
            return $this->error('删除订单失败');
        }
   }
   public function editorder(){
        $order = input('get.');
        $order_id = $order['id'];
        $orderO = Db::name('order')->where('id',"=",$order_id)->select();
        $this->assign('orderO',$orderO);
        return $this->fetch();
   }
   public function add2(){
        $order = input('post.');
        $order_id = $order['id'];
        print_r($order);
        $arr = array();
        $arr = $order;
        $time= date("Y-m-d H:i:s",time());
        $arr['add_time'] = strtotime($time);
        $arr['is_del'] = 2;
        
        $res = Db::name('order')->where('id',"=",$order_id)->update($arr);
        if($res){
            return $this->success('修改订单成功','Orderlist');
        }else{
            return $this->error('修改订单失败');
        }
   }
}
