<?php
namespace app\admin\controller;
use app\common\util\PasswordHash;
use think\Db;
class Userregister  extends AdminBase
{
    public function userList()   
    {
        $users = Db::name('users')->where('user_status','0')->paginate(10);
        
        $this->assign("users",$users);

        return $this->fetch();
    }
    public function add(){
        $adminflag = input('post.');
        if($adminflag){
            //print_r($adminflag);
            $arr = array();
            $arr['user_name'] = $adminflag['user_name'];
            $arr['user_pwd'] = md5($adminflag['user_pwd']);
            $arr['phone'] = $adminflag['phone'];
            // $arr['user_registered'] = date('Y-m-d H:i:s');
            // $arr['user_role'] =1;
            // $arr['user_status'] = 0;
            $admin = Db::name('users')->insert($arr);
            if($admin){
                return $this->success('添加管理员成功','userList');
            }else{
                return $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }
    public function EditUser(){
        $user_id = input('get.');
        $admin_id = $user_id['id'];
        $admin = Db::name("users")->where('id',"=",$admin_id)->select();
        $this->assign('flag',$admin);
        return $this->fetch();
    }
    public function add2(){
        $user = input('post.');
        $admin_id = $user['id'];
        $arr = array();
        $pwd = Db::name('users')->where('id',$admin_id)->field('user_pwd')->find();
        if($user['user_pwd'] == '')
        {
            $arr['user_pwd'] = $pwd['user_pwd'];
        }else{
            $arr['user_pwd'] = md5($user['user_pwd']);
        }
        // echo $admin_id;
        $arr['user_name'] = $user['user_name'];
        $arr['phone'] = $user['phone'];
        // dump($arr);die;
        $useradmin = Db::name("users")->where('id',"=",$admin_id)->update($arr);
        if($useradmin){
            return $this->success('修改管理员成功','userList');
        }else{
            return $this->error('修改失败');
        }
    }
    public function delUser(){
        $user_id = input('get.');
        $admin_id = $user_id['id'];
        // echo $admin_id;

        $admin = Db::name("users")->where('id',"=",$admin_id)->update(['user_status'=>1]);
        if($admin){
            return $this->success('删除成功','userList');
        }else{
             return $this->error('删除失败');
        }
    }
    
   /* public function getUser() {
        $userId = input('param.user_id');

        $user   = model("User")->getUser($userId);
        
        return $user;
    }
    
    public function getRoles(){

        $roles  = model('Role')->getSelectRoles();

        return $roles ? json(['code'=>1,'roles'=>$roles,'msg'=>'获取数据成功']) : json(['code'=>0,'roles'=>'','msg'=>'获取数据成功']);
    }
    public function addUser(){
        
        $input = input();

        $info  =  model('User')->addUser($input);
       
        return $info;
    }
    
    public function delUser(){
        
        $userId = input('param.id');
        return $userId;
        die;

        $info  =  model('User')->delUser($userId);
    
        return $info;
        
    }
    
    public function updateUser(){
           
        $input  = input();
         
        $info   = model('User')->updateUser($input);
        
        return $info;
      
    }*/

    
}
