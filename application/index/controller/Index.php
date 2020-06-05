<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use app\index\model\Area;
use app\index\validate\User;
use app\index\controller\MessageSend;
use think\Session;


use Qiniu\Auth;
class Index extends Controller
{
    //搜索以及首页
    public $randYZ;
    public $str = 5;
    public function __construct(){
        parent::__construct();
        $this->randYZ = rand(999,9999);
    }
    public function test()
    {
        $str = 0;
        ++$str;
        echo $str;
    }
    public function test2()
    {
        echo $this->str;
        
    }
    public function notify()
    {
        $testxml  = file_get_contents("php://input");
        $jsonxml = json_encode(simplexml_load_string($testxml, 'SimpleXMLElement', LIBXML_NOCDATA)); 
        $result = json_decode($jsonxml, true);//转成数组，
        // dump($result);die;
        if($result){
            //如果成功返回了
            $out_trade_no = $result['out_trade_no'];
            if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
                //执行业务逻辑
                $res = Db::name("order")->where('order_sn',"=",$out_trade_no)->update(['state'=>'1']);
                if($res){
                    return $this->success('支付成功');
                }else{
                    return $this->error('系统错误');
                }
            }
            
        }else{
            return $this->error('订单提交失败');
        }
    }
    public function index()
    {
        $info = input('post.');
        if(!empty($info)){
            $areaModel = new Area(); //实例化模型
            $arr1 = $areaModel->getInfo($info['sheng']);
            $arr2 = $areaModel->getInfo(isset($info['shi'])?$info['shi']:'');
            $arr3 = $areaModel->getInfo(isset($info['qu'])?$info['qu']:'');
            $sheng = $arr1['district'];
            $shi = $arr2['district'];
            $qu = $arr3['district'];
            $address  = "";
            if($sheng!=""){
                $address .=$sheng.'-';
            }
            if($shi!=""){
                $address .=$shi.'-';
            }
            if($qu!=""){
                $address .=$qu;
            }

            $typeA = Db::name("type")->where('id',"=",$info['typea'])->where('del',"=",1)->find();
            $typeB = Db::name("type")->where('id',"=",$info['typeb'])->where('del',"=",1)->find();
            $typea = $typeA['id'];
            $typeb = $typeB['id'];
            if(empty($typea)){
                $type = '';
            }
            else{
               if(empty($typeb)){
                     $typeb = '';
                }
                $type = $typea.'-'.$typeb; 
            }
            
            $flag = Db::name("user")
                            ->field(true)
                            ->where('address','like',"%".$address."%")
                            ->where('type','like','%'.$type."%")->where('del','0')
                            ->select();
            $count = count($flag);
            if($count<1){
                $str = "<script>";
                $str .="alert('暂无数据');";
                $str .="location.href='/';";
                $str .= "</script>";
                return $str;
            }
        }else{
            $flag = Db::name("user")->order('id','desc')->where('del','0')->select();
        }
            $arr=array();
            foreach($flag as $k=>$v){
                    $arr[] = $v['type'];
                    $typearr = $v['type'];
                    $type_type = Db::name("type")->field('ttype')->where('del',"=",1)->where('id',"=",$typearr)->find();
                    $flag[$k]['ttype']=$type_type['ttype'];
            }

            $sheng = Db::query("select * from huanyi_area where pid = level");
            $this->assign('sheng',$sheng);
            // $typea = Db::query("select * from huanyi_type where tid = level");
            $typea = Db::name('type')->where('tid','=','level')->where('del','=','1')->select();
            // dump($typea);die;

            $slide = Db::name('home')->where('del','0')->select();
            $content = Db::name('content')->where('del','0')->select();
            $this->assign('usertype',$flag[$k]['ttype']);
            $this->assign('typea',$typea);
            $this->assign('flag',$flag);
            $this->assign('slide',$slide);
            $this->assign('content',$content);
            return $this->fetch();
    }
  


//短信验证
    public function Verify(){

        $phone = input('post.');
        $m_phone = $phone['id'];
        //短信验证

      
        $randYZ=mt_rand(999,9999);
        SESSION_START();
        Session::set('randYZ',$randYZ);

        //session['randYZ'] = $randYZ;

        $Verify = new MessageSend();
        $pass = md5('zypt123');
        //$randYZ = $this->randYZ;
       //$randYZ=mt_rand(999,9999);
        $userid = '64403';
        $account = 'zypt';
        $password = $pass;
        $mobiles = $m_phone;
        $extno = "";
        $content = "您的验证码：".$randYZ.'【群资源】';
        $sendtime = "2019-12-08 15:30:00";
        $result=MessageSend::send($account,$password,$mobiles,$extno,$content,$sendtime);
        $xml = simplexml_load_string($result);

        echo "返回信息提示:".$xml->message;
        echo "返回状态为:".$xml->returnstatus;
        echo "返回信息:".$xml->message;
        echo "返回余额:".$xml->remainpoint;
        echo "返回本次任务ID:".$xml->taskID;
        echo "返回成功短信数:".$xml->successCounts;
    }

    //添加页面
    public function add()
    {
            $sheng = Db::query("select * from huanyi_area where pid = level");
            $this->assign('sheng',$sheng);
            // $typea = Db::query("select * from huanyi_type where tid = level");
            $typea = Db::name('type')->where('tid','=','level')->where('del','=','1')->select();
            $this->assign('typea',$typea);   
            return $this->fetch();
    }

    //添加功能实现
    public function subadd(){
        // echo $this->randYZ;
        $flag = input('post.');
        // $file = request()->file('images');
        // dump($file);
        // dump($flag);die;
        //调用随机验证码
        //验证码类
        $result = $this->validate($flag,'User');
        if($result != 'true'){
            // 验证失败 输出错误信息
            //dump($result);
            //$this->error($result,'','500');
            return $this->error($result,'add');
        }

        $randYZ = session::get('randYZ');
        if($randYZ != $flag['phonecheck']){
            return $this->error('验证码输入错误','add');
        }
        unset($_SESSION['randYZ']);


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
        if($file == '')
        {
            return json(['code'=>'1001']);
        }
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
       /* $arr['type'] = $flag['typea'];*/
        $user = Db::name("type")->where('id',"=",$flag['typeb'])->find();
        $ttype = $user['ttype'];
        $usertype = $flag['typea'].'-'.$flag['typeb'];
        
        $arr['title'] = $ttype;
        $arr['contents'] = $flag['contents'];
        //$arr['number'] = $flag['number'];
        // $arr['topimg'] = '/uploads/'.$topimg;
        $arr['images'] = '/uploads/'.$images;
        $arr['status'] = $flag['status'];

        $arr['type'] = $flag['typea'];

        $sheng1 = Db::name("area")->where('district_id',"=",$flag['sheng'])->find();
        $sheng = $sheng1['district'];
        $shi1 = Db::name("area")->where('district_id',"=",$flag['shi'])->find();
        $shi = $shi1['district'];
        $qu1 = Db::name("area")->where('district_id',"=",$flag['qu'])->find();
        $qu = $qu1['district'];
        $arr['address'] = $sheng."-".$shi."-".$qu;
        $arr['create_time'] =  date('m-d H:i:s');
    //    var_dump($arr);
        $res = Db::name("user")->insert($arr);
        if($res){ 
            return json(['code'=>'1000']);
            // alert('发布成功！');
            // return $this->redirect('index/index');
                // return $this->success('上传成功','/');
        }else{
            // alert('系统错误，发布失败！');
            return $this->redirect('index/add');
                // return $this->error('上传失败');
        }
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
        $res = Db::name('type')->where(array('tid'=>$id))->where('del',"=",1)->select();
        $str ='';
        foreach ($res as $key => $value) {
            if ($key ==0) {
                $str.= "<option>请选择</option>";
            }
            $str.= "<option value=\"{$value['id']}\">{$value['ttype']}</option>";
        }
        echo $str;
    }
    
    /*-------------------------------------------------------------------------------------------------------------*/
    //登录页
    public function login()
    {
        return $this->fetch();
    }
    //登录 接收数据与数据库对比
    public function is_login()
    {
        $name = $_POST['name'];
        $password = md5($_POST['password']);
        if (empty($name) || empty($password)) {
            return json(['code'=>1]); 
            // return $this->error('请填写完整数据！');
        }
        $user = Db::name("users")->where('user_name',"=",$name)->where('user_status','0')->find();
        if (!$user) {
            return json(['code'=>2]); 
        }
        if ($password == $user['user_pwd']) {
            session::set('admin',$user['id']);
            // session::set('admin','');
            //登录成功
            return json(['code'=>3]); 
        } else {
            return json(['code'=>4]); 
        }
    }
    //短信验证
    public function note()
    {
        return $this->fetch();
    }
    //实现短信登录
    public function is_note()
    {
        $phone = $_POST['phone'];
        $code = $_POST['code'];
        if(empty($phone))
        {
            return json(['code'=>1]); 
        }
        if(empty($code))
        {
            return json(['code'=>2]);
        }
        $flag = input('post.');
        // dump($flag);die;
        //调用随机验证码
        //验证码类
        $result = $this->validate($flag,'User');
        if($result != 'true'){
            // 验证失败 输出错误信息
            //dump($result);
            //$this->error($result,'','500');
            // return $this->error($result,'add');
        }

        $randYZ = session::get('randYZ');
        if($randYZ != $flag['code']){
            return json(['code'=>4,'msg'=>'验证码输入错误']);
        }
        unset($_SESSION['randYZ']);
        $user = Db::name("users")->where('phone',"=",$phone)->count();
        if($user == 0)
        {
            return json(['code'=>5]);
        }
        $id = Db::name("users")->where('phone',$phone)->find();
        session::set('admin',$id['id']);
        return json(['code'=>3]);
    }
    //跳转注册页面
    public function register()
    {
        return $this->fetch();
    }
    //注册 添加到数据库
    public function register_data()
    {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        
        
        // dump($password);die;
        $code = $_POST['code'];
        if($name == '')
        {
            return json(['code'=>1,'msg'=>'请输入用户名']);
        }
        if($phone == '')
        {
            return json(['code'=>2,'msg'=>'请输入手机号']);
        }
        if($code == '')
        {
            return json(['code'=>3,'msg'=>'请输入验证码']);
        }
        $flag = input('post.');
        // dump($flag);die;
        //调用随机验证码
        //验证码类
        $result = $this->validate($flag,'User');
        if($result != 'true'){
            // 验证失败 输出错误信息
            //dump($result);
            //$this->error($result,'','500');
            // return $this->error($result,'add');
        }

        $randYZ = session::get('randYZ');
        if($randYZ != $flag['code']){
            return json(['code'=>4,'msg'=>'验证码输入错误']);
        }
        unset($_SESSION['randYZ']);
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if($password == null)
        {
            return json(['code'=>8,'msg'=>'请输入密码']);
        }else{
            if($password2 == '')
            {
                return json(['code'=>9,'msg'=>'请再次输入密码']);
            }else{
                if($password2 != $password)
                {
                    return json(['code'=>10,'msg'=>'密码不一致']);
                }else{
                    
                    $namedata = Db::name("users")->where('user_name',$name)->count();
                    $phonedata = Db::name("users")->where('phone',$phone)->count();
                    if($namedata>=1)
                    {
                        return json(['code'=>5]); 
                    }
                    if($namedata==0)
                    {
                        if($phonedata>=1)
                        {
                            return json(['code'=>7]); 
                        }
                        if($phonedata==0)
                        {
                            $arr['user_name'] = $name;
                            $arr['phone'] = $phone;
                            $arr['user_pwd'] = md5($password);
                            $res = Db::name("users")->insert($arr);
                            return json(['code'=>6]);
                        }
                        
                        
                    }
                }
            }
        }
        
        
        
       
    }
   //生成订单
    public function order()
    {
        // return $this->fetch('index/wxpay');
        //买家ID
        $user_session = input('user_session');
        //卖家ID
        $id = input('id');
        //订单号
        $order_sn = date("Ymdhis").mt_rand(100000, 999999);
        //用户手机号
        $res = Db::name("users")->where('id','=',$user_session)->find();
        $phone = $res['phone'];
        //生成订单时间
        $time = time();
        //金额
        // $money = '1';
        $moneydata = Db::name("money")->select();
        $money=$moneydata[0]['money'];
        // echo $money;exit;
        // echo $time;
        // exit;
        //订单
        $arr['order_sn'] = $order_sn;
        $arr['users_phone'] = $phone;
        $arr['seller_id'] = $id;
        $arr['state'] = 0;
        $arr['users_id'] = $user_session;
        $arr['add_time'] = $time;
        $arr['money'] = $money;
        $arr['is_del'] = 2;
        $res = Db::name("order")->insert($arr);
        
        session::set('order_sn', $arr['order_sn']);
        session::set('money', $arr['money']);
        return $res;
        // dump($arr);
        // return $assign;
        
        // dump($res);exit;
        // if($res==1){ 
        //     return $this->success('订单已生成','index/wxpay');
        // }else{
        //     return $this->error('系统错误，订单未生成');
        // }
        // echo $phone;
        

    }
    //H5支付
    // public function h5Pay($param)
    // {
        
    //     // 获取系统配置信息
    //     $setting = Settings::find(1);
    //     // 获取商家支付配置信息
    //     $pay_config = PayConfig::where('station_id', $order['station_id'])->first();
    //     if (empty($pay_config)) throw new Service_Exception(2005);
    //     $info = [];
        
    //     // 回调地址
    //     $notify_url = env('HOST').'/notify/wxNotify';
    //     // 场景信息 (固定内容)
    //     $scene_info ='{"h5_info":{"type":"Wap","wap_url":"http://www.123.com","wap_name":"测试支付"}}'; //场景信息
        
    //     $result = $this->wxPay($order['pay_order_sn'], $order['buyer_pay_amount'], $body = '加油', $pay_config, $notify_url, $scene_info, $setting);
        
    //     if($result['return_code'] == 'SUCCESS'){
    //         if ($result['result_code'] == 'SUCCESS') {
    //             $info['url'] = $result['mweb_url'];
                
    //             $str = 'isCallback=true&order_sn='.$order['order_sn'].'&key=a255a779eb8dfd0f1e22bb0fba309f3b';
    //             $sign = strtolower(md5($str));
    //             $redirect_url = env('HOST').'/api/external/payMoney?isCallback=true&order_sn='.$order['order_sn'].'&sign='.$sign;
    //             //$redirect_url = 'http://h5.sinopec-bj.zhihuiyouzhan.com/api/web/payMoney?isCallback=true&order_sn='.$order['order_sn'].'&sign='.$sign;
                
    //             $info['url'] = $result['mweb_url'].'&redirect_url='.urlencode($redirect_url);

    //             Log::debug('微信申请支付成功', [
    //                 'data' => $result,
    //             ]);
    //         }else{
    //             echo '申请失败';
    //         }
    //     }else{
    //         echo '申请失败';
    //     }
    //     return $info;
    // }
    //跳转到支付页
    public function wxpay()
    {
        $this->assign('order_sn', session::get('order_sn'));
        $this->assign('money', session::get('money'));
        return $this->fetch();
    }
    //H5支付
    public function pay()
    {
        $order = Db::name("order")->where('order_sn',"=", input('data'))->find();
        //充值金额 微信支付单位为分
        $money = $order['money']*100;
        //获得用户设备IP
        $userip = $this->get_client_ip();
        //应用APPID
        $appid  = "wx6a10e72fdabe6c2d";
        //微信支付商户号
        $mch_id = "1497522492";
        //微信商户API密钥
        $key    = "Z1dNhLNvLcxvR9QkqzIverR8LLtEVb2M";
        
        
        $out_trade_no = $order['order_sn'];//平台内部订单号
        $nonce_str = $this->createNoncestr();//随机字符串
        // dump($nonce_str);exit;
        $body = "获取手机号";//内容
        $total_fee = $money; //金额
        // dump($total_fee);
        $spbill_create_ip = $userip; //IP
        // $notify_url = "127.0.0.1/index/index/notify";
        $notify_url = "http://58qzy.com/index/index/notify";
        // $notify_url = "http://qq52o.me/wxpay/notify.php"; //回调地址
        $trade_type = 'MWEB';//交易类型 具体看API 里面有详细介绍
        $scene_info ='{"h5_info":{"type":"Wap","wap_url":"http://qq52o.me","wap_name":"支付"}}';//场景信息 必要参数
        $signA ="appid=$appid&attach=$out_trade_no&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url&out_trade_no=$out_trade_no&scene_info=$scene_info&spbill_create_ip=$spbill_create_ip&total_fee=$total_fee&trade_type=$trade_type";
        $strSignTmp = $signA."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML  是否正确
        $sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
        // $returnUrl = "https://www.wechatpay.com.cn";
        // $return_Url = urlencode($returnUrl);
        $post_data = "<xml>
                            <appid>$appid</appid>
                            <mch_id>$mch_id</mch_id>
                            <body>$body</body>
                            <out_trade_no>$out_trade_no</out_trade_no>
                            <total_fee>$total_fee</total_fee>
                            <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                            <notify_url>$notify_url</notify_url>
                            <trade_type>$trade_type</trade_type>
                            <scene_info>$scene_info</scene_info>
                            <attach>$out_trade_no</attach>
                            <nonce_str>$nonce_str</nonce_str>
                            <sign>$sign</sign>
                    </xml>";//拼接成XML 格式
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//微信传参地址
        $dataxml = $this->postXmlCurl($post_data,$url); //后台POST微信传参地址  同时取得微信返回的参数 
        $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
        // $return_code = $objectxml['return_code'];
        $mweb_url = json_encode($objectxml['mweb_url']);

        // $this->assign('return_code',$return_code);
        // $this->assign('mweb_url',$mweb_url);
        return $mweb_url;
        // return $objectxml2;
        // dump($mweb_url);

    }
    public function createNoncestr( $length = 32 ){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
    public function postXmlCurl($xml,$url,$second = 30){
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        }else{
            $error = curl_errno($ch);
            curl_close($ch);
            echo "curl出错，错误码:$error"."<br>";
        }
    }
    
    //设备IP
    public function get_client_ip()
    {
        $cip = "unknown";
        if($_SERVER['REMOTE_ADDR'])
        {
            $cip = $_SERVER['REMOTE_ADDR'];
        }
        elseif(getenv("REMOTE_ADDR"))
        {
            $cip = getenv("REMOTE_ADDR");
        }
        return $cip;
    }

    //我的
    public function mine(){
        $user_id = session::get('admin');
        $users = Db::name('users')->where('id',$user_id)->select();
        // dump($users);die;
        $user_order = Db::name("order")->where('state',"=",1)->where("users_id","=",$user_id)->select();
        $arr = array();
        foreach($user_order as $k=>$v){
            $arr[] = $v['seller_id']; 
        }
       //print_r($arr);
        $str = implode($arr,',');
        $user = Db::name("user")->where('id',"in",$str)->select();
        $arr2=array();
        foreach($user as $k=>$v){
                    $arr2[] = $v['type'];
                    $typearr = $v['type'];
                    $type_type = Db::name("type")->field('ttype')->where('id',"=",$typearr)->find();
                    $user[$k]['ttype']=$type_type['ttype'];
        }
        $this->assign('users',$users);
        $this->assign('user',$user);
        return $this->fetch();
    }
    
}
