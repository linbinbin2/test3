<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2020/4/18
 * Time: 14:43
 */

namespace app\admin\controller;
use think\Db;
class Users extends AdminBase
{
    public function userList(){
        $map=array();
        $username=trim(input('username'));
        $userphone=trim(input('userphone'));
        if(!empty($username)){
            $map['username']=['like','%'.$username.'%'];
        }if(!empty($userphone)){
            $map['userphone']=['like','%'.$userphone.'%'];
        }

        $data=Db::name('user')
            ->where($map)
            ->where('del',"=",0)
            ->order('id','desc')
            ->paginate(10);
            // ->select();

        $type = Db::name("type")->select();
        // dump($type);die;
        return view('',['data'=>$data]);
    }
    //删除
    public function delUser(){
        $userId = input('param.id');
        //echo $userId;
        $user = Db::name('user')->where('id',"=",$userId)->update(['del'=>1]);
        if($user){
            $this->success('删除成功','userList');
        }else{
            $this->error('删除失败');
        }
    }
    //修改
    public function EditUser(){
        $userId = input('param.id');
        $user = Db::name("user")->where('id',"=",$userId)->select();

        //分割地址
        $address = $user[0]['address'];
        $var=explode("-",$address);
        $msheng = Db::name("area")->where('district',"=",$var[0])->select();
        $mshi = Db::name("area")->where('district',"=",$var[1])->select();
        $mqu = Db::name("area")->where('district',"=",$var[2])->select();
        $msheng_id = $msheng[0]['district_id'];
        $mshi_id = $mshi[0]['district_id'];
        $mqu_id = $mqu[0]['district_id'];
        
        $this->assign('msheng_id',$msheng_id);
        $this->assign('mshi_id',$mshi_id);
        $this->assign('mqu_id',$mqu_id);
        $this->assign('var',$var);
        

        //分割类型
        $type = $user[0]['type'];
        $vartype=explode("-",$type);
        $mtype1 = Db::name('type')->where('id',"=",$vartype[0])->find();
        $mtype2 = Db::name('type')->where('id',"=",$vartype[1])->find();
        $this->assign('mtype1',$mtype1['ttype']);
        $this->assign('mtype2',$mtype2['ttype']);
        $this->assign('vartype',$vartype);

        $arrtype = Db::name('type')->where('id',"=",$vartype[0])->find();
        $usertype = $arrtype['ttype'];
        $this->assign('usertype',$usertype);

        $sheng = Db::query("select * from huanyi_area where pid = level");
        foreach ($sheng as $key => $value) {
            if($value['district_id']==$msheng_id)
            {
                unset($sheng[$key]);
            }
        }
        $this->assign('sheng',$sheng);
        // $typea = Db::query("select * from huanyi_type where tid = level");
        $typea = Db::name('type')->where('tid','=','level')->where('del','1')->select();
        foreach ($typea as $key => $value) {
            if($value['id']==$mtype1['id'])
            {
                unset($typea[$key]);
            }
        }
        $this->assign('typea',$typea);
        $typeb = Db::name('type')->where('tid','=',$mtype1['id'])->where('del','1')->select();
        foreach ($typeb as $key => $value) {
            if($value['id']==$mtype2['id'])
            {
                unset($typeb[$key]);
            }
        }
        $this->assign('typeb',$typeb);
        $this->assign('user',$user);
        $shi = Db::name('area')->where('pid','=',$msheng_id)->select();
        foreach ($shi as $key => $value) {
            if($value['district_id']==$mshi_id)
            {
                unset($shi[$key]);
            }
        }
        $this->assign('shi',$shi);
        $qu = Db::name('area')->where('pid','=',$mshi_id)->select();
        foreach ($qu as $key => $value) {
            if($value['district_id']==$mqu_id)
            {
                unset($qu[$key]);
            }
        }
        $this->assign('qu',$qu);
        
        // dump($sheng);die;
        return $this->fetch('EditUser');
    }
    public function Edit2User(){
        $flag = input('post.');
        $id = $flag['id'];
        $image = $flag['image'];
        // dump($flag);die;
        // echo $image;die;
        //调用随机验证码
        //验证码类

        /*$result = $this->validate($flag,'User');
        if($result != 'true'){
            // 验证失败 输出错误信息
            //dump($result);
            //$this->error($result,'','500');
            return $this->error($result,'EditUser');
        }*/


        //头像上传
        $topfile = request()->file('topimg');
        // 移动到框架应用根目录/public/uploads/top 目录下
        if($topfile){
            $tinfo = $topfile->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($tinfo){
                $tinfo->getExtension();
                $topimg = $tinfo->getSaveName();
                $tinfo->getFilename(); 
            }else{
                return $this->error('上传失败');
            }
        }

        //图片上传
        $file = request()->file('images');
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
        // echo $images;die;
        $arr = array();
        $arr['del'] = 0;

        $arr['username'] = $flag['username'];
        $arr['userphone'] = $flag['userphone'];
       /* $arr['type'] = $flag['typea'];*/
        $user = Db::name("type")->where('id',"=",$flag['typeb'])->find();
        $ttype = $user['ttype'];
        $usertype = $flag['typea'].'-'.$flag['typeb'];

        $arr['title'] = $ttype;
        $arr['contents'] = $flag['contents'];
        // $arr['number'] = $flag['number'];
        // dump($arr['number']);die;
        $arr['topimg'] = '/uploads/'.$topimg;
        if($images == null)
        {
            $arr['images'] = $image;
        }else{
            $arr['images'] = '/uploads/'.$images;
        }
        
        $arr['status'] = $flag['status'];

        $arr['type'] = $flag['typea']."-".$flag['typeb'];

        $sheng1 = Db::name("area")->where('district_id',"=",$flag['sheng'])->find();
        $sheng = $sheng1['district'];
        $shi1 = Db::name("area")->where('district_id',"=",$flag['shi'])->find();
        $shi = $shi1['district'];
        $qu1 = Db::name("area")->where('district_id',"=",$flag['qu'])->find();
        $qu = $qu1['district'];
        $arr['address'] = $sheng."-".$shi."-".$qu;
        $arr['create_time'] =  date('m-d H:i:s');
        $res = Db::name("user")->where('id',"=",$id)->update($arr);
        if($res){ 
                return $this->success('修改成功','userList');
            }else{
                return $this->error('修改失败');
            }
    }

    //添加
    public function AddUser(){
        $flag = input('post.');
        if($flag){
            //头像上传
                $topfile = request()->file('topimg');
                // 移动到框架应用根目录/public/uploads/top 目录下
                if($topfile){
                    $tinfo = $topfile->move(ROOT_PATH . 'public' . DS . 'uploads');
                    if($tinfo){
                        $tinfo->getExtension();
                        $topimg = $tinfo->getSaveName();
                        $tinfo->getFilename(); 
                    }else{
                        return $this->error('上传失败','add');
                    }
                }

                //图片上传
                $file = request()->file('images');
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

                $arr = array();
                $arr['username'] = $flag['username'];
                $arr['userphone'] = $flag['userphone'];
              
                $user = Db::name("type")->where('id',"=",$flag['typeb'])->find();
                $ttype = $user['ttype'];
                $usertype = $flag['typea'].'-'.$flag['typeb'];

                $arr['title'] = $ttype;
                $arr['contents'] = $flag['contents'];
                //$arr['number'] = $flag['number'];
                $arr['topimg'] = '/uploads/'.$topimg;
                $arr['images'] = '/uploads/'.$images;
                $arr['status'] = $flag['status'];

                $arr['type'] = $flag['typea']."-".$flag['typeb'];

                $sheng1 = Db::name("area")->where('district_id',"=",$flag['sheng'])->find();
                $sheng = $sheng1['district'];
                $shi1 = Db::name("area")->where('district_id',"=",$flag['shi'])->find();
                $shi = $shi1['district'];
                $qu1 = Db::name("area")->where('district_id',"=",$flag['qu'])->find();
                $qu = $qu1['district'];
                $arr['address'] = $sheng."-".$shi."-".$qu;
                $arr['create_time'] =  date('m-d H:i:s');
                $arr['del'] = 0;
                $res = Db::name("user")->insert($arr);
                if($res){ 
                        return $this->success('上传成功','userList');
                    }else{
                        return $this->error('上传失败');
                    }
        }else{
            $sheng = Db::query("select * from huanyi_area where pid = level");
            $this->assign('sheng',$sheng);
            $typea = Db::query("select * from huanyi_type where tid = level");
            $this->assign('typea',$typea);
            return $this->fetch('AddUser');
        }
        
    }

    //搜索
    public function Search(){
        // echo '123';
        $Users = input('post.');
        $User_name = $Users['username'];
        $user = Db::name("user")->where('username','=',$User_name)->where('del',"=",0)->order('id','desc')->paginate(10);;
        $this->assign('data',$user);
        // dump($user);die;
        return $this->fetch('user_list');
    }

    //地区三级分类
    public function checkregion(){
        $id = input('id');
        $res = Db::name('area')->where(array('pid'=>$id))->select();
        $str ='';
        foreach ($res as $key => $value) {
            if ($key ==0) {
                $str.= "<option>请选择</option>";
            }
            $str.= "<option value=\"{$value['district_id']}\">{$value['district']}</option>";
        }
        echo $str;
    }
    //类型二级分类
    public function checktype(){
        $id = input('id');
        $res = Db::name('type')->where(array('tid'=>$id))->where('del','1')->select();
        $str ='';
        foreach ($res as $key => $value) {
            if ($key ==0) {
                $str.= "<option>请选择</option>";
            }
            $str.= "<option value=\"{$value['id']}\">{$value['ttype']}</option>";
        }
        echo $str;
    }
}