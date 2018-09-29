<?php
    
	/*
	This files is for loggin the user.
	Http method: POST
	Input (body) parameters
		user: it can be the username or the email
	 	password: user password
	
	Returns a JSON text with a 'success' key. 
	If the success key is 1, the login is valid
	and the data of the user will be returned with
	the following format:
	{
		"success":1,
		"data":{
			"userID":id,
			"username":"Unique username",
			"firstName":"First name of the user",
			"lastName":"Last name of the user",
			"address":"address of the user",
			"phoneNo":"Phone number of the user",
			"email":"email of the user",
			"image":"relative url to the profile image. It should be appended to the base URL defined at the beginning of this document"
		}
	}
	When the request is not success, the following error codes may arise:
		0: User not exists or password incorrect (invalid login)
		-1: password field not defined
		-2: user field not defined
		
	*/
	
	error_reporting(0);
	
	include_once "encrypt.php";
	$user = null;
	$password = null;
	$response = array();
	$responsecode = 0;
	
	//If the required fields are not specified, arise an error
	if(!isset($_POST['password'])){
		$responsecode = -1;
	} else {
		$password = $_POST['password'];
		$key = '123';
		$encrypt = encrypt($password, $key);
		if(isset($_POST['user'])){
			$user = $_POST['user'];
		} else {
			$responsecode = -2;
		}
		
		if($responsecode == 0)
		{
			$sql_select = "SELECT userID, username, firstName, lastName, address, phoneNo, email, image FROM Users WHERE password = '$encrypt' AND ";
			$sql_select .= "(username = '$user' OR email = '$user')"; //checking the user in both email and username
	
			include_once 'DBconn.php';
			$result = $conn->query($sql_select);
			if($row = $result->fetch_assoc()){
				//If a result matches, show it on JSON.
				$responsecode = 1;
				$response['data'] = $row;
			}
			
		}
		
	}
	
	$response['success'] = $responsecode;
	echo json_encode($response, JSON_NUMERIC_CHECK); 
