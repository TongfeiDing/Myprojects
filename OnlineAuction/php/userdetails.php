<?php

/*
  User details edit
  @Tongfei Ding
  Update a user's details
*/

error_reporting(0);
include 'DBconn.php';
include 'security.php';
include 'uploadimage.php';

$userID = $_POST['userID'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
if(isset($_POST['password'])){
	$password = $_POST['password'];
    $key = "111";
    $encrypted = encrypt($password,$key);	
}

else $encrypted = null;


$action = $_POST['action'];

//execute register function
switch($action){
	case 'update':
		updateDetails($conn,$userID,$username,$email,$phone,$address,$firstname,$lastname,$encrypted);
		break;
	case 'setp':
		setUserphoto($conn);
		break;
	default:
		echo 'unexpectable error';
		break;
		
}






function updateDetails($conn,$userID,$username,$email,$phone,$address,$firstname,$lastname,$password){
	$response = array();
	$status = 0;
	if($password==null){
		$sql = "update Users set username = '{$username}',email = '{$email}',phone = '{$phone}',address='{$address}',firstname = '{$firstname}', lastname = '{$lastname}' where userID = {$userID}";
	}
	else{
		$sql = "update Users set username = '{$username}',email = '{$email}',phone = '{$phone}',address='{$address}',firstname = '{$firstname}', lastname = '{$lastname}',password = '{$password}' where userID = {$userID}";
		}

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




?>