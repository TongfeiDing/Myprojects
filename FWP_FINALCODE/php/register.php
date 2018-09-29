<?php
	/*
	This file is for registering a user into the system.
	Http method: POST
	Input (body) parameters
		username: the unique username of the user
		password: password of the user
		email: unique email of the user
		firstname: first name of the user
		lastname: last name of the user
		address: (optional) address of the user
		phoneNo: (optional) phone number of the user
	
	Returns a JSON text with a 'success' key. 
	A positive 'success' key indicates the new userID added 
	to the database.
	When the request is not success, the following error codes may arise:
		0: Unknown error inserting the user 
		-1: One or more required fields are not defined
		-2: Username already in the system
		-3: Email already in the system
		
	*/
    error_reporting(0);
	include "../php/encrypt.php";
	include "../php/uploadimage.php";
	$response = array();
	$responsecode = 0;
	
	//If any of the required fields are not set, send an error
	if(isset($_POST['username']) && 
		isset($_POST['email']) &&
		isset($_POST['password']) &&
		isset($_POST['firstname']) &&
		isset($_POST['lastname']) ){
		
		//Username and email are always in a lower case
		$username = strtolower($_POST['username']);
		$password = $_POST['password'];
		$email = strtolower($_POST['email']);
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];		
		$address = null;
		$phoneNo = null;
		
		//Optional parameters
		if(isset($_POST['address'])){
			$address = $_POST['address'];
		}
		if(isset($_POST['phoneNo'])){
			$phoneNo = $_POST['phoneNo'];
		}
		$key = '123';
		$encrypt = encrypt($password, $key);
		
		//Checking for existing username
		$sql_select = "SELECT username FROM Users WHERE username = '$username'";
		include_once "../php/DBconn.php";
		$result = $conn->query($sql_select);
		if($result->fetch_assoc()){
			$responsecode = -2;
		}
		
		//Checking for existing email
		$sql_select = "SELECT email FROM Users WHERE email = '$email'";
		$result = $conn->query($sql_select);
		if($result->fetch_assoc()){
			$responsecode = -3;
		}
		
		if($responsecode == 0){
			
			//Perform the query only if no other error has arised
			$sql_insert = "INSERT INTO Users(username,email,password,firstName,lastName,address,phoneNo)"
							." VALUES ('$username','$email','$encrypt','$firstname','$lastname','$address','$phoneNo')";
			if($conn->query($sql_insert)){
				//Getting the id of the inserted user
				$responsecode = $conn->insert_id;
				mkdir('users/'.$responsecode);
				mkdir('users/'.$responsecode.'/items');
				
				if(isset($_FILES['profilepicture'])){
					$fp = uploadimage('users/'.$responsecode.'/', 'profilepicture');
					if($fp != null)
					{
						$sql_upate = "UPDATE Users SET image = '$fp' WHERE userID = ".$responsecode;
						$conn->query($sql_upate);
					}
				}
				
			}
		}
		
	}
	else {
		$responsecode = -1;
	}
    
	$response['success'] = $responsecode;
    echo json_encode($response, JSON_NUMERIC_CHECK);

	
?>
