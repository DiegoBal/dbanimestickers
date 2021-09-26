<?php
ob_start();
// error_reporting(-1);
// ini_set('display_errors', 'On');
include("../../db/config.php");
// admin password check for update token
if (isset($_POST['flag']) && $_POST['flag'] == 'edit_token_pass_check') {

	$userid = $_POST['userid'];
	$password=  $_POST['passcheck'];

	$query="SELECT * FROM admin_login WHERE Username='$userid' AND Password='$password'";
	$result=mysqli_query($db,$query);
	$count=mysqli_num_rows($result);
	if($count){
		$response['message'] = "success";
		$response['success']=1;    
		echo json_encode($response);
		
	}else{
		$response['message'] = "Wrong Password";
		$response['success']=0;    
		echo json_encode($response);
	}
}
// update token
if (isset($_POST['flag']) && $_POST['flag'] == 'update_secret_token') {

	$token = $_POST['token'];
	$tokenid = $_POST['tokenid'];

	$query="UPDATE api_authentication SET token='$token' WHERE id='$tokenid'";
	// $query="UPDATE api_authentication SET token='$token' WHERE id=''";
	$result=mysqli_query($db,$query);
	if($result){
		$response['message'] = "Token Updated Successfully.";
		$response['success']=1;    
		echo json_encode($response);
		
	}else{
		$response['message'] = "error";
		$response['success']=0;    
		echo json_encode($response);
	}
}

if (isset($_POST['flag']) && $_POST['flag'] == 'update_link') 
{
	$link = $_POST['link'];
	$tokenid = $_POST['tokenid'];

	$query="UPDATE api_authentication SET play_store_link='$link' WHERE id='$tokenid'";
	$result=mysqli_query($db,$query);
}