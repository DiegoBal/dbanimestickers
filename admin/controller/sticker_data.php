<?php
ob_start();
// error_reporting(-1);
// ini_set('display_errors', 'On');
include("../../db/config.php");

// Edit Sticker
if (isset($_POST['flag']) && $_POST['flag'] == "edit_sticker") 
{
  $id=$_POST['hiddenid'];
  $catid=$_POST['ecategoriesname'];
  $packid=$_POST['epackname'];
  $multi_images=ltrim($_POST['multiple_img'],',');
  $multi_images=rtrim($multi_images,',');

  $sql = "UPDATE stickers SET sticker='".$multi_images."' WHERE id='".$id."'";
  $result = mysqli_query($db,$sql);

  if($result) {
    $response['error'] = 0;
    $response['success']=1;
  }else{
    $response['error'] = 1;
    $response['success']=0;
  }

  echo json_encode($response);
}

// multipul image //
if($_POST['flag']=='multi_image') 
{
  $p_id=$_POST['pack_id'];
  $p_name="SELECT title FROM categories_pack WHERE id='$p_id'";
  $run = $db->query($p_name);
  $p=$run->fetch_object();

  $pack_name=$p->title;
  $new_name=str_replace(' ', '_', $pack_name);

  $target_dir = "../../uploadpack/";
  $image_array=array();
  foreach($_FILES["files"]["name"] as $key=>$filename)
  {
    $tmp_name = $_FILES["files"]["tmp_name"][$key];
    $filename = $_FILES["files"]["name"][$key];

    $tmp_name = $_FILES["files"]["tmp_name"][$key];
    $ex=mt_rand(100000, 999999);
    $extension = explode("/", $_FILES["files"]["type"][$key]);

    $new_image=$new_name.'_'.$ex.".".$extension[1];
    
    move_uploaded_file($tmp_name, $target_dir.$new_image);
    array_push($image_array,$new_image);
  }
  $result['data']=$image_array;
  $result['message']="Image upload successfuly";
  $result['success']=1;
  echo json_encode($result);
}

//select category pack//
if(!empty($_POST["id"])){
  $sql ="SELECT * FROM categories_pack WHERE cat_name_id ='".$_POST['id']."'";
  $result = mysqli_query($db,$sql);
  while($row = $result->fetch_assoc())
  {
    $rows[] = $row;
  }

  if($rows){  
    $result['data']=$rows;
  }else{
    $result['data']="";
  }
  echo json_encode($result);
}
// remove sticker
if(isset($_GET['flag']) && $_GET['flag']="remove_sticker"){
  // $id = $_REQUEST['id'];

  // $query = "UPDATE stickers SET is_delete='1'  WHERE id=".$id.""; 
  // $result = mysqli_query($db, $query);

  // $selquery="SELECT pack_id FROM stickers WHERE id=".$id."";
  // $selresult = mysqli_query($db, $selquery);
  // while($selrow = mysqli_fetch_assoc($selresult)){ 
  //   $selid = $selrow['pack_id'];
  // }
  // $query2 = "UPDATE categories_pack SET is_delete='1'  WHERE id=".$selid.""; 
  // $result2 = mysqli_query($db, $query2);
  // header("Location:../stickers.php");

  $id = $_REQUEST['id'];

  $selquery="SELECT pack_id FROM stickers WHERE id=".$id."";
  $selresult = mysqli_query($db, $selquery);
  while($selrow = mysqli_fetch_assoc($selresult))
  { 
    $selid = $selrow['pack_id'];
  }

  $query = "DELETE FROM stickers WHERE id=".$id.""; 
  $result = mysqli_query($db, $query);

  
  $query2 = "DELETE FROM categories_pack WHERE id=".$selid.""; 
  $result2 = mysqli_query($db, $query2);
  header("Location:../stickers.php");
}
?> 