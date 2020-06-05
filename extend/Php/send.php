<?php

     header("Content-type: text/html; charset=utf-8");
    
    $username="";							//改为实际账户名
    $password="";							//改为实际短信发送密码
    $mobiles="";							//目标手机号码，多个用半角“,”分隔
    $content="您的验证码：8888【华信】";
    $extnumber="";
    
    //定时短信发送时间,格式 2019-12-06T08:09:10，null或空串表示为非定时短信(即时发送)
    $plansendtime="";						    
    
    $result=WsMessageSend::send($username, $password, $mobiles, $content,$extnumber,$plansendtime);

    	//print_r($result);
        echo "返回信息提示：",$result->Description,"<br>";
        echo "返回状态为：",$result->StatusCode,"<br>";
        echo "返回余额：",$result->Amount,"<br>";
        echo "返回本次任务ID：",$result->MsgId,"<br>";
        echo "返回成功短信数：",$result->SuccessCounts,"<br>";

	/*webservice调用
     * 注意以下扩展需要启用（widnows环境，linux等类似）
     * extension=php_soap.dll
     * extension=php_curl.dll
     * extension=php_openssl.dll
     */
    class WsMessageSend
    {
    	const wsdl="";
    	
    	static function send($username,$password,$mobiles,$content,$extnumber,$plansendtime=null)
    	{
			try{
    		$client=new SoapClient(self::wsdl);
    		$sms=array(
    				'Msisdns'=>$mobiles,
    				'SMSContent'=>$content,
    				'ExtNumber'=>$extnumber,
    		);
    		if($plansendtime!=null && $plansendtime!=''){
    			$sms['PlanSendTime']=$plansendtime;
    		}
    		$body=array(
    				'userName'=>$username,
    				'password'=>$password,
					'sms'=>$sms
    		);
     		$result=$client->__call("SendSms", array($body));
			}catch(Exception $e){
			print_r($e);
			}
    		//$client->__soapCall("SendSms", array($body));
    		if(is_soap_fault($result))
    		{
    			echo "faultcode:",$result->faultcode,"faultstring:",$result->faultstring;
    			return null;
    		}
    		else 
    		{
    			$data=$result->SendSmsResult;
    			return $data;
    		}
    	}
    }
?>