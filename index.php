<?php

$access_token="EAAC3VhPOEdEBAKp7Qg5ZAHB7fXqIDCJBZC2DxOCYPDVziZBhA7fLiKuatGo9Xw0XUu3lSIEw3O1dcAOU9CZAebnEO567nAbEbyFUPixEeZBztYgHULImTRsZCfunzralzWiB8SZC1nz3aFKsfvMdvu3cZCyXTx63UBpMLcpMj09t1oXg91nUnLPx";
$verify_token="this-is-the-secret-token";
$hub_verify_token=null;


if(isset($_REQUEST['hub_mode']) && $_REQUEST['hub_mode']=='subscribe'){

$challenge=$_REQUEST['hub_challenge'];
$hub_verify_token=$_REQUEST['hub_verify_token'];

		if($hub_verify_token==$verify_token){

				header('http/1.1 200 OK ');	
				echo $challenge;
				die;	

		}
}
$input = json_decode (file_get_contents('http://input'),true);

$sender =$input['entry'][0]['messaging'][0]['sender']['id'];
$message =isset($input['entry'][0]['messaging'][0]['messaging']['text'])? $input['entry'][0]['messaging'][0]['messaging']['text']: '';

if($message){

	$message_to_reply="This is the message to send back to ";

	$url="https://graph.facebook.com/v2.6/me/messages?access_token=".$access_token;
	$jsonData='{
				"recipient"":{
								"id":"'.$render.'"
				             },
				"message"":{
								"text":"'.$message_to_reply.'"
				             }


			   }';

$ch=curl_init($url);
curl_setopt($ch, CURLPOT_POST,1);
curl_setopt($ch, CURLPOT_POSTFIELDS,$jsonData);
curl_setopt($ch, CURLPOT_HTTPHEADER,array('content-Type: application/json'));
curl_setopt($ch, CURLPOT_SSL_VERIFYPEER, false);
$result =curl_exec($ch);
curl_close($ch);
}


?>