<?php
namespace app\admin\model;
use think\Model;
use app\common\util\PasswordHash;
class User extends Model
{

    protected $table='huanyi_adminuser';
    protected $pk = 'user_id';
    protected $autoWriteTimestamp = 'datetime'; //时间字段类型

    // 指定自动写入的时间戳字段名
    protected $createTime = 'user_registered';

    public  function getUserList(){
       
        $users  =   $this->alias('u')->field('u.*,r.role_name')
                    ->join('role r','r.role_id = u.user_role','LEFT')
                    ->where('u.user_status=0')
                    ->select();

        if($users) {

        	$users = collection($users)->toArray();
        }
        
        return $users;

    } 
    
    public function getUser($userId) {

        if(request()->isPost()){
        	$user  = $this->where("user_id=".$userId)->find();

            if($userId==1)

                $roles = array(array("role_id"=>1,"role_name"=>'超级管理员'));
            else

            	$roles = model('Role')->getSelectRoles();
           
	        if($user) {

	            $user = $user->toArray();


	            return json(['code'=>1,'msg'=>'数据获取成功','data'=>$user,'roles'=>$roles]);
	            
	        }else{

	            return json(['code'=>2,'msg'=>'数据丢失','data'=>'']); 
	        }

        }else{
            
            return json(['code'=>3,'msg'=>'非法请求','data'=>'']);
        }
        

    }

    public function addUser($input){

        if(request()->isPost()) {

	        if($input['handle_type'] == 'add') {
                
                $hasher = new PasswordHash(8,true);

                $input['user_pass'] = $hasher->HashPassword($input['user_pass']);

                $isHaveUser = $this->where("user_login ='".$input['user_login']."'")->find();

                if(!$isHaveUser) {
                    if($input['user_role']==1) {

                    	return json(['code'=>6,'msg'=>'不能添加为超管']);
                    }

                    $save = $this->allowField(true)->save($input);
                
	                if($save) {

	                	return json(['code'=>1,'msg'=>'添加成功']);

	                }else{

	                    return json(['code'=>2,'msg'=>'添加失败']);
	                }

                }else{
                    
                    return json(['code'=>3,'msg'=>'登入名已存在']);
                }

	        }else{

	            return json(['code'=>4,'msg'=>'非法数据']);

	        }

        }else {
           
            return json(['code'=>5,'msg'=>'非法请求']);
        }
		
    } 


    public function delUser($userId){
        
        //$del = $this->where('id='.$userId.' AND user_id <> 1')->delete();
        $data = array('del'=>1);
        $del = $this->where('id='.$userId)->update($data);
        $count = count($del);
        if($count<1) {
            return json(['code'=>0,'msg'=>'删除失败']);
        }else{
            return json(['code'=>1,'msg'=>'删除成功']);
        }

    } 

    public function updateUser($input) {

    	if(request()->isPost()) {
            if($input['handle_type'] == 'update') {
                
                $hasher = new PasswordHash(8,true);
                
                if($input['user_pass']) {

                	$input['user_pass'] = $hasher->HashPassword($input['user_pass']);

                }else{

                    unset($input['user_pass']);
                }
               
                $isHaveUser = $this->where("user_login='".$input['user_login']."'"." AND user_id <>".$input['user_id'])->find();
                
                if(!$isHaveUser) {
                    
                    if($input['user_id']==1) { // 只有admin才能编辑admin用户 

                        if(session("user_id")==1) {
                            $update = $this->allowField(true)->save($input,$input['user_id']);

                        }else{
                             
                            return json(['code'=>6,'msg'=>'	NO！你不是超级管理员']);
                        }
                       
                    }else{
                    	
                            if($input['user_role']==1) {

		                    	return json(['code'=>7,'msg'=>'不能添加为超管']);
		                    }

                            $update = $this->allowField(true)->save($input,$input['user_id']);
                    }


	            	if($update !==false) {

	            		return json(['code'=>1,'msg'=>'更新成功']);

	            	}else{

	            		return json(['code'=>2,'msg'=>'更新失败']);
	            	}

                }else{
                        return json(['code'=>3,'msg'=>'登入名已存在']);
                }
            	

            }else{

            	return json(['code'=>4,'msg'=>'非法数据']);
            }

    	}else{

    		    return json(['code'=>5,'msg'=>'非法请求']);
    	}

    }
       
}