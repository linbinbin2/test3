<?php
namespace app\index\controller;
class MessageSend{
	const url ="https://dx.ipyy.net/sms.aspx";
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