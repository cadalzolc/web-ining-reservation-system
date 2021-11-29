<?php 
require_once('../class/Client.php');
if(session_status() == PHP_SESSION_NONE)
{
	session_start();//start session if session not start
}
if(isset($_POST['un']) && isset($_POST['pwd']) ){
	$un = $_POST['un'];
	$pwd = $_POST['pwd'];

	$pwd = md5($pwd);//hash

	$result = $user->loginClient($un, $pwd);
	if($result > 0){
		$return['valid'] = true;
		$return['url'] = "../home.php";
		$_SESSION['uid'] = $result['usename'];
	}else{
		$return['valid'] = false;
		$return['msg'] = "Invalid Username / Password!";
	}
	echo json_encode($return);
}//end isset

$user->Disconnect();