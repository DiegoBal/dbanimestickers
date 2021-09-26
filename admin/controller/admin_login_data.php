<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
session_start();
include("../../db/config.php");

if ($_POST['flag']=='logindata') {

   $username = mysqli_real_escape_string($db,$_POST['username']);
   $password = mysqli_real_escape_string($db,$_POST['password']); 

   $sql = "SELECT * FROM admin_login WHERE Username = '$username' and Password = '$password'";
   $result = mysqli_query($db,$sql);
   $count = mysqli_num_rows($result);
   if($count == 1) {

      $_SESSION['Username'] = $_POST['username'];
      $_SESSION['Password'] = $_POST['password'];

  $response['message']="login successfully";
  $response['success']=1;
  echo json_encode($response);
      
   }else {

  $response['message']="Incorrect Username or Password";
  $response['success']=0;
  echo json_encode($response);
   }

}

?>