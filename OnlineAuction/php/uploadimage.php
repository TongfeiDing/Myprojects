<?php

/*
  Recive images from the frontend and put them into users'(items') folders
  @Tongfei Ding
  Update a user's details
*/

error_reporting(0);
include 'DBconn.php';

//if(!isset($_POST['action']))
//{setUserphoto($conn);}




//a function to set the main photo of a user's
function setUserphoto($conn){

	$userID = $_POST['userID'];
	//check if there is a folder for this user,if not, create one folder with the name of his userID
	$dir = "../image/".$userID."/";
	if(!is_dir($dir)){
	mkdir($dir,0777,true);
	}
	
	$url = $dir."myphoto.jpg";
	//move the image to user's folder
	move_uploaded_file($_FILES["image"]["tmp_name"],$url);
	
	//write the url into database
	$response = array();
	$status = 0;
	$sql = "update Users set photoURL = 'image/{$userID}/myphoto.jpg' where userID = {$userID}";
	if($conn->query($sql)){
		$status = 1;
		$sql_select = "select * from Users where userID = {$userID}";
		$result = $conn->query($sql_select);
		if($row = $result->fetch_assoc()){
			$response['data'] = $row;
	}
		
	}
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response); 

}

function saveItempictures($conn,$itemID){
	
	$num_of_prepics = 0;
	
	$userID = $_POST['userID'];
	//check if there is a folder for this user,if not, create one folder with the name of his userID
	$dir = "../image/".$userID."/";
	if(!is_dir($dir)){
	mkdir($dir,0777,true);
	}
	//check if there is a folder for this item.if not, create one folder with the name of itemID
	$dir = "../image/".$userID."/".$itemID."/";
	if(!is_dir($dir)){
	mkdir($dir,0777,true);
	}
	//if the folder has existed, count the existing files in the folder 
	if(is_dir($dir)){
		$arr = scandir($dir); 
        $num_of_prepics = count($arr)-2;	
	}
	
	for($i=1;$i<=$_POST['num_of_pics'];$i++){
	$url = $dir.($i+$num_of_prepics).".jpg";
	//move the image to user's folder
	move_uploaded_file($_FILES["itempic".$i]["tmp_name"],$url);		
	
	}
	
	//write the url into database
	$sql = "update Items set pictureURL = 'image/{$userID}/{$itemID}/' where itemID = {$itemID}";
	$result = $conn->query($sql);
	
}




?>