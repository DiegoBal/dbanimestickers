<?php
ob_start();
include("../../db/config.php");
// add category
if (isset($_POST['flag']) && $_POST['flag'] == "add_categories") {
	$categoriesname = $_POST['categoriesname'];

	$query = "SELECT categories_name from categories where categories_name='".$categoriesname."'";
	$result=mysqli_query($db,$query);
	$ecount=mysqli_num_rows($result);

	if($ecount > 0)
	{
		$response['category'] ="";
		$response['message'] = "Category already inserted!";
		$response['success']=0;      
		echo json_encode($response);
	}else{
		$sql = "INSERT INTO categories (categories_name) VALUES ('".$categoriesname."')";
		$result=mysqli_query($db,$sql);
		$last_id = $db->insert_id;

		$sql1 = "SELECT * FROM `categories` WHERE id='$last_id'";
		// $sql1 = "SELECT * FROM `categories` WHERE id='0'";
		$result1 = mysqli_query($db,$sql1);
		
		foreach ($result1 as $key => $value) {
			$response['category'] = $value;
			// $response['category'] = "";
			$response['success']=1;
			$response['message'] = "successfully added";       
			echo json_encode($response);
		}
	}
}
// edit category
if (isset($_POST['flag']) && $_POST['flag'] == "edit_categories") {
	$id=$_POST['id'];
	$name=$_POST['categoriesname'];
	$query = "SELECT categories_name from categories where categories_name='".$name."' AND id !='".$id."'";
	$result=mysqli_query($db,$query);
	$ecount1=mysqli_num_rows($result);

	if($ecount1 > 0)
	{
		$response['catname']="";
		$response['id']="";
		$response['message']="Category already inserted!";
		$response['success']=0;
		echo json_encode($response);
	}else
	{
		$sql = "UPDATE categories SET categories_name='".$name."' WHERE id='".$id."'";
		mysqli_query($db,$sql);

		$response['catname'] = $name;
		$response['id'] = $id;
		$response['success']=1;
		$response['message'] = "successfully added";
		echo json_encode($response);
	}
}
// remove category
if(isset($_GET['flag']) && $_GET['flag']="remove_categories"){

	// $id = $_REQUEST['id'];
	// $query = "UPDATE categories SET is_delete='1'  WHERE id=".$id.""; 
	// $result = mysqli_query($db, $query);

	// $query1 = "UPDATE categories_pack SET is_delete='1'  WHERE cat_name_id=".$id.""; 
	// $result1 = mysqli_query($db, $query1);

	// $selquery="SELECT id FROM categories_pack WHERE cat_name_id=".$id."";
	// $selresult = mysqli_query($db, $selquery);
	// while($selrow = mysqli_fetch_assoc($selresult)){ 
	// 	$selid[] = $selrow['id'];
	// }
	// $data=implode(',', $selid);

	// $query2 = "UPDATE stickers SET is_delete='1'  WHERE pack_id IN (".$data.")";
	// $result2 = mysqli_query($db, $query2);

	// header("Location:../categories.php");

	$id = $_REQUEST['id'];

	$selquery="SELECT id FROM categories_pack WHERE cat_name_id=".$id."";
	$selresult = mysqli_query($db, $selquery);
	while($selrow = mysqli_fetch_assoc($selresult)){ 
		$selid[] = $selrow['id'];
	}

	$query = "DELETE FROM categories WHERE id=".$id.""; 
	$result = mysqli_query($db, $query);

	$query1 = "DELETE FROM categories_pack WHERE cat_name_id=".$id.""; 
	$result1 = mysqli_query($db, $query1);

	
	$data=implode(',', $selid);

	$query2 = "DELETE FROM stickers WHERE pack_id IN (".$data.")";
	$result2 = mysqli_query($db, $query2);

	header("Location:../categories.php");
}
?>