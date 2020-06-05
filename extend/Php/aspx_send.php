<?php

   header("Content-type: text/html; charset=utf-8");
    
    $account="";				//改为实际账户名
    $password="";				//改为实际短信发送密码
    $mobiles="";				//目标手机号码，多个用半角“,”分隔
    $extno = "";
    $content="您的验证码：8888【华信】";
    $sendtime = "";

    $result=MessageSend::send($account,$password,$mobiles,$extno,$content,$sendtime);
    
    $xml = simplexml_load_string($result);

    echo "返回信息提示:：".$xml->message."<br>";
    echo "返回状态为:".$xml->returnstatus."<br>";
    echo "返回信息:".$xml->message."<br>";
    echo "返回余额:".$xml->remainpoint."<br>";
    echo "返回本次任务ID:".$xml->taskID."<br>";
    echo "返回成功短信数:".$xml->successCounts."<br>";


		//aspx接口调用
    class MessageSend
    {
    	const url ="";
    	static function send($account,$password,$mobiles,$extno,$content,$sendtime)
    	{
    		$body=array(
    				'action'=>'send',
    				'userid'=>'',
    				'account'=>$account,
    				'password'=>$password,
    				'mobile'=>$mobiles,
    				'extno'=>$extno,
    				'content'=>$content,
    				'sendtime'=>$sendtime    				
    		);
    		$ch=curl_init();
    		curl_setopt($ch, CURLOPT_URL, self::url);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    		$result = curl_exec($ch);
    		curl_close($ch);
    		return $result;
    	}
    }
?>