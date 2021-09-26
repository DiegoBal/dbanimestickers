<?php 
ob_start();
include("../db/config.php");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// $input = json_decode(file_get_contents('php://input'),true);

$headers = apache_request_headers();
if(isset($headers['Auth-Token'])){
	$sql_query="SELECT token FROM api_authentication WHERE token='".$headers['Auth-Token']."'";
	$result = mysqli_query($db,$sql_query);
	$count = mysqli_num_rows($result);

	if($count==1){

		$sql="SELECT categories_pack.*, categories.categories_name AS categories_name, stickers.sticker AS sticker FROM categories_pack LEFT JOIN categories ON categories_pack.cat_name_id = categories.id LEFT JOIN stickers ON categories_pack.id=stickers.pack_id ORDER BY categories.created_at DESC";
		$result = mysqli_query($db,$sql);

		$categories=array();
		$samedata=[];
		while ($data = mysqli_fetch_assoc($result)) {

			$stickers=explode(',', $data['sticker']);

			$de_url=explode('/', $_SERVER['REQUEST_URI']);
			$url="http://" . $_SERVER['SERVER_NAME']."/";
			$url1= $_SERVER['SERVER_NAME']."/";

			if(!empty($data['sticker'])){
				$images=[];
				foreach ($stickers as $key => $value){
					$ch = curl_init($url1."uploadpack/".$value);

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, TRUE);
					curl_setopt($ch, CURLOPT_NOBODY, TRUE);

					curl_exec($ch);
					$img_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

					curl_close($ch);

		// $img_size= filesize($url."uploadpack/".$value);
		// $img_size=$img_size/1024;
					$images[$key]['emojis']=[];
					$images[$key]['imageFileName']=$value;
					$images[$key]['size']=$img_size." KB";
					$images[$key]['uri']=$url."uploadpack/".$value;
					$total=$total+$img_size;
				}
				$data3 = array(
					'identifier' => $data['identifier'],
					'isWhitelisted' => "",
					'licenseAgreementWebsite' => $data['la_website'],
					'name' => $data['title'],
					'privacyPolicyWebsite' => $data['pp_website'],
					'publisher' => $data['publisher'],
					'publisherEmail' => "",
					'publisherWebsite' => $data['publisher_website'],
					'stickers' => $images,
					'stickersAddedIndex' => "",
					'totalSize' => $total." KB",
					'trayImageFile' => $data['try_icone'],
					'trayImageUri' => $url."uploadpack/".$data['try_icone']);

			}else{
				$data3=[];
			}
			if(!empty($data3)){
				if(in_array($data['categories_name'],$categories)){
					$samedata[$data['categories_name']][]=$data3;
				}else{
					array_push($categories,$data['categories_name']);
					$samedata[$data['categories_name']][]=$data3;
				}
			}
		}
		// ksort($samedata);
		foreach ($samedata as $key => $value) {

			rsort($value);

			$alldata[]=array(
				'categoryName' => $key,
				'stickerPack' => $value
			);
		}
		$jsondata['data']=$alldata;
		$jsondata['status']="200";
		$jsondata['message']="success";
		$jsondata['result']="true";
		$allinfo=json_encode($jsondata);
		echo $allinfo;
	}else{
		$data["data"]="";
		$data["status"]="400";
		$data["message"]="The provided auth token is invalid.";
		$data["result"]="false";
		$data=json_encode($data);
		echo $data;
	}
}else{
	$data["data"]="";
	$data["status"]="400";
	$data["message"]="You must use an auth token key to authenticate each request to WASticker APIs";
	$data["result"]="false";
	$data=json_encode($data);
	echo $data;
}
?>