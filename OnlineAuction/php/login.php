<?php

/*
  User authentication - Login
  @Tongfei Ding
  Get login information from browser and autheticate it to login into an account
*/
error_reporting(0);

include 'DBconn.php';


include 'security.php';

if(isset($_POST['user'])){
	$loginname = $_POST['user'];
}
if(isset($_POST['password'])){
	$password = $_POST['password'];
	$key = "111";
	$encrypted = encrypt($password,$key);
}

login($conn,$loginname,$encrypted);

//authenticate username/email and encrypted password to login
function login($conn,$loginname,$encrypted){
	$response = array();
	$status = 0;
	$sql = "select * from Users where (username = '{$loginname}' or email = '{$loginname}') and password = '{$encrypted}'";
	$result = $conn->query($sql);	
	if($row = $result->fetch_assoc()){
		$status = 1;
	    $response['data'] = $row;
	}
	
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response); 
}
	
	
?>