<?php
namespace app\admin\controller;
use app\common\util\PasswordHash;
use think\Db;
class User  extends AdminBase
{
    public function userList()   
    {
        // $users =  model('User')->getUserList();
        $D = Db::name('adminuser');
        $users = $D->alias('u')->field('u.*,r.role_name')
        ->join('role r','r.role_id = u.user_role','LEFT')
        ->where('u.user_status=0')->paginate(10);
        // $data=$users->paginate(10);
        // dump($users->render());die;
        $this->assign("users",$users);

        return $this->fetch();
    }
    public function add(){
        $adminflag = input('post.');
        if($adminflag){
            //print_r($adminflag);
            $arr = array();
            $arr = $adminflag;
            $arr['user_registered'] = date('Y-m-d H:i:s');
            $arr['user_role'] =1;
            $arr['user_status'] = 0;
            $admin = Db::name('adminuser')->insert($arr);
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
        $admin = Db::name("adminuser")->where('user_id',"=",$admin_id)->select();
        $this->assign('flag',$admin);
        return $this->fetch();
    }
    public function add2(){
        $user = input('post.');
        $admin_id = $user['user_id'];
        echo $admin_id;
       
        $arr = array();
        $arr = $user;
        $arr['user_registered'] = date('Y-m-d H:i:s');
        $arr['user_role'] =1;
        $arr['user_status'] = 0;
        $useradmin = Db::name("adminuser")->where('user_id',"=",$admin_id)->update($arr);
        if($useradmin){
            return $this->success('修改管理员成功','userList');
        }else{
            return $this->error('修改失败');
        }
    }
    public function delUser(){
        $user_id = input('get.');
        $admin_id = $user_id['id'];
        echo $admin_id;

        $admin = Db::name("adminuser")->where('user_id',"=",$admin_id)->update(['user_status'=>1]);
        if($admin){
            return $this->success('删除管理员成功','userList');
        }else{
             return $this->error('删除失败');
        }
    }
//------------------------------------------------------------------------------------------------------------
    public function userregisterList()   
    {
        // $users =  model('User')->getUserList();
        $D = Db::name('users');
        $users = $D->paginate(10);
        // $data=$users->paginate(10);
        // dump($users->render());die;
        $this->assign("users",$users);

        return $this->fetch();
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
