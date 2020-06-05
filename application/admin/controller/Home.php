<?php
namespace app\admin\controller;
use app\common\util\PasswordHash;
use think\Db;

use think\Controller;
use app\index\model\Area;
use app\index\validate\User;
use app\index\controller\MessageSend;
use think\Session;
class Home  extends Controller
{
    public function homePage()   
    {
        $users = Db::name('home')->where('del','0')->paginate(10);
        
        $this->assign("users",$users);

        return $this->fetch();
    }
    public function add(){
        return $this->fetch();
    }
    public function addimg(){
        //图片上传
        $file = request()->file('file');
        // dump($file);die;
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $info->getExtension();
                $images = $info->getSaveName();
                $info->getFilename(); 
            }else{
                return $file->getError();
            }
        }
        // echo $images;
        $user_id=session::get('user_id');
        $admin_data = Db::name('adminuser')->where('user_id',$user_id)->select();
        $name = $admin_data[0]['user_login'];
        // echo $name;
        $arr['img_path'] = '/uploads/'.$images;
        $arr['name'] = $name;
        $res=Db::name('home')->insert($arr);
        if($res){
            return $this->redirect('home/homepage');
        }else{
             return $this->error('上传失败');
        }
    }
    public function EditUser(){
        $user_id = input('get.');
        $admin_id = $user_id['id'];
        $admin = Db::name("home")->where('id',"=",$admin_id)->select();
        $this->assign('flag',$admin);
        return $this->fetch();
    }
    public function add2(){
        $user = input('post.');
        $admin_id = $user['id'];
        // echo $admin_id;
        //图片上传
        $file = request()->file('file');
        // dump($file);die;
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $info->getExtension();
                $images = $info->getSaveName();
                $info->getFilename(); 
            }else{
                return $file->getError();
            }
        }
        // echo $images;
        $user_id=session::get('user_id');
        $admin_data = Db::name('adminuser')->where('user_id',$user_id)->select();
        $name = $admin_data[0]['user_login'];
        // echo $name;
        $arr['img_path'] = '/uploads/'.$images;
        $arr['name'] = $name;
        $useradmin = Db::name("home")->where('id',"=",$admin_id)->update($arr);
        if($useradmin){
            return $this->success('图片修改成功','homePage');
        }else{
            return $this->error('修改失败');
        }
    }
    public function delUser(){
        $user_id = input('get.');
        $admin_id = $user_id['id'];
        // echo $admin_id;

        $admin = Db::name("home")->where('id',"=",$admin_id)->update(['del'=>1]);
        if($admin){
            return $this->success('图片删除成功','homePage');
        }else{
             return $this->error('删除失败');
        }
    }
    //首页文章
    public function homeContent()   
    {
        $users = Db::name('content')->where('del','0')->paginate(10);
        
        $this->assign("users",$users);

        return $this->fetch();
    }
    public function addcontent(){
        return $this->fetch();
    }
    public function addcontent2(){
        $content = $_POST['content'];
        $user_id=session::get('user_id');
        $admin_data = Db::name('adminuser')->where('user_id',$user_id)->select();
        $name = $admin_data[0]['user_login'];
        $arr['content']=$content;
        $arr['name']=$name;
        $res = Db::name('content')->insert($arr);
        if($res)
        {
            return $this->success('文章上传成功','homeContent');
        }else{
            return $this->error('文章上传失败');
        }
    }
    public function EditContent(){
        $user_id = input('get.');
        $admin_id = $user_id['id'];
        $admin = Db::name("content")->where('id',"=",$admin_id)->select();
        $this->assign('flag',$admin);
        return $this->fetch();
    }
    public function content2(){
        $data = input('post.');
        // dump($data);
        $content = $data['data'];
        $id = $data['id'];
        $user_id=session::get('user_id');
        $admin_data = Db::name('adminuser')->where('user_id',$user_id)->select();
        $name = $admin_data[0]['user_login'];
        $arr['content'] = $content;
        $arr['name'] = $name;
        $useradmin = Db::name("content")->where('id',"=",$id)->update($arr);
        // return $useradmin;
        if($useradmin){
            return $this->success('文章修改成功','homeContent');
        }else{
            return $this->error('修改失败');
        }

        // $user = input('post.');
        // $admin_id = $user['id'];
        // $user_id=session::get('user_id');
        // $admin_data = Db::name('adminuser')->where('user_id',$user_id)->select();
        // $name = $admin_data[0]['user_login'];
        // // echo $name;
        // $arr['content'] = $user['content'];
        // $arr['name'] = $name;
        // $useradmin = Db::name("content")->where('id',"=",$admin_id)->update($arr);
        // if($useradmin){
        //     return $this->success('文章修改成功','homeContent');
        // }else{
        //     return $this->error('修改失败');
        // }
    }
}
