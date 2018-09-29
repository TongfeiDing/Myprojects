<?php

/*
  User authentication - Register
  @Tongfei Ding
  Register a new account by inputting username,password,email and phone number.
  Return a json including a status:
  1: Success
  0: Unknown error
  -1: username exists
  -2: eamil address exists
  -3: phone number exists
*/
error_reporting(0);

include 'DBconn.php';
include 'security.php';

$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$password = $_POST['password'];
$key = "111";
$encrypted = encrypt($password,$key);
//execute register function
if(checkDuplication($conn,$username,$email,$phone)){
	register($conn,$username,$email,$phone,$encrypted);
}





function checkDuplication($conn,$username,$email,$phone){
	$status = 1;
	$sqlusername = "select * from Users where username = '{$username}'";
	$sqlemail = "select * from Users where email = '{$email}'";
	$sqlphone = "select * from Users where phone = '{$phone}'";
	
	$result3 = $conn->query($sqlphone);
	if($result3->num_rows>0){
			$status = -3;
		}
	
	$result2 = $conn->query($sqlemail);
	if($result2->num_rows>0){
			$status = -2;
		}
	
	$result = $conn->query($sqlusername);		
	if($result->num_rows>0){
			$status = -1;
		}
	
	if($status != 1){
		$response = array();
		$response['status'] = $status;
		echo json_encode($response); 
		return false;
	}
	
	else return true;
	
	
}

function register($conn,$username,$email,$phone,$password){
	$response = array();
	$status = 0;
	$sql = "insert into Users(username,password,email,phone) values ('{$username}','{$password}','{$email}','{$phone}')";
	if($conn->query($sql)){
		$status = $conn->insert_id;
		$sql_select = "select * from Users where userID = {$status}";
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