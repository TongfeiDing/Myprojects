<?php
	/*
	This file is for updating the info o a user in the system.
	Http method: POST
	Input (body) parameters
		username: the unique username of the user
		firstname: (optional) first name of the user
		lastname: (optional) last name of the user
		address: (optional) address of the user
		phoneNo: (optional) phone number of the user
	
	Returns a JSON text with a 'success' key. 
	A 'success' of 1 indicates the that the update was successful.
	When the request is not success, the following error codes may arise:
		0: Unknown error updating the user 
		-1: One or more required fields are not defined
		-2: Unable to upload with the provided credentials
		
	*/
	include "encrypt.php";
	include "uploadimage.php";	
	$response = array();
	$responsecode = 0;
	
	//If username is not defined, send an error
	if(!isset($_POST['username'])){
		$responsecode = -1;
	}
	else
	{
		$username = strtolower($_POST['username']);
		include_once "DBconn.php";
		$sql_id = "SELECT userID FROM Users WHERE username = '$username'";
		$userid = 0;
		if($result = $conn->query($sql_id))
		{
			if($row = $result->fetch_assoc()){
				$userid = $row['userID'];
			}
			else{
				$responsecode = -1;
			}
		} 
		if($responsecode == 0)
		{
			$sql_update = "UPDATE Users SET ";
			//Auxiliar variable to check when is neccesary to add a comma
			$previous = false;
			
			//check all possible input data on the request
			if(isset($_POST['firstname'])){
				$sql_update .= " firstName = '".$_POST['firstname']."'";
				$previous = true;
			}
			if(isset($_POST['lastname'])){
				if($previous)
				{
					$sql_update .= ",";
				}
				$sql_update .= " lastName = '".$_POST['lastname']."'";
				$previous = true;
			}
			if(isset($_POST['address'])){
				if($previous)
				{
					$sql_update .= ",";
				}
				$sql_update .= " address = '".$_POST['address']."'";
				$previous = true;
			}
			if(isset($_POST['phoneNo'])){
				if($previous)
				{
					$sql_update .= ",";
				}
				$sql_update .= " phoneNo = '".$_POST['phoneNo']."'";
				$previous = true;
			}
			if(isset($_FILES['profilepicture'])){
				$files = glob('users/'.$userid.'/*'); // get all file names
				foreach($files as $file){ // iterate files
				  if(is_file($file))
					unlink($file); // delete file
				}
				$fp = uploadimage('users/'.$userid.'/', 'profilepicture');
				if($fp != null)
				{
					if($previous)
					{
						$sql_update .= ",";
					}
					$sql_update .= " image = '$fp' ";
					$previous = true;
				}
			}
			
			$sql_update .= " WHERE username = '$username'";
			//Performing the query
			
			if($conn->query($sql_update))
			{
				//If the update was successful, the number of affected rows should be 1.
				$responsecode = $conn->affected_rows;
				if($responsecode)
				{
					$sql_select="SELECT userID, username, firstName, lastName, address, phoneNo, email, image FROM Users WHERE username = '$username' ";
					$result = $conn->query($sql_select);
					if($row = $result->fetch_assoc()){
						//If a result matches, show it on JSON.
						$response['data'] = $row;
					}
				}
			} 
			else{
				$responsecode = -2;
			}
		}
		
	}
	
	$response['success'] = $responsecode;
    echo json_encode($response, JSON_NUMERIC_CHECK);
	
	
?>
