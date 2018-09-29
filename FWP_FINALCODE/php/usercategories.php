	<?php
    /*
	This file is for getting user's profile information.
	Http method: POST
	Input (body) parameters (At least one must be defined)
		username: the unique username of the user
		userid: the id of the user
	
	Returns a JSON text with a 'success' key. 
	If the success key is 1, the user exists
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
			"email":"email of the user"
		}
	}
	When the request is not success, the following error codes may arise:
		0: User not exists 
		-1: username field not defined
		
	*/
	include 'DBconn.php';
	$responsecode = 0;
	$response = array();
	$userId = -1;
	$username = ' ';
	error_reporting(0);
	
	//If the required fields are not specified, send an error
    if(!isset($_POST['username']) && !isset($_POST['userid'])){
		$responsecode = -1;
	} else {
	    if(isset($_POST['username'])){
	        $username = $_POST['username'];
	    }
		if(isset($_POST['userid'])){
	        $userId = $_POST['userid'];
	    }
		if(isset($_POST['categories'])){
			$sql_remove = "DELETE FROM user_categories WHERE user_id = {$userId}";
			$conn->query($sql_remove);
			foreach($_POST['categories'] as $category)
			{
				$sql = "INSERT INTO user_categories (user_id, category_id) VALUES ({$userId}, {$category})";
				$conn->query($sql);
			}
			$responsecode = 1;
		}
		else{
			$sql_select="SELECT category_id as id, Categories.name as name FROM user_categories  "
			."INNER JOIN Users ON Users.userID = user_categories.user_id "
			."INNER JOIN Categories ON user_categories.category_id = Categories.categoryID "
			."WHERE (Users.username= '$username' OR Users.userID = '$userId') ";
			
			$result = $conn->query($sql_select);
			while($row = $result->fetch_assoc()){
				//If a result matches, show it on JSON.
				$responsecode = 1;
				$response['data'][] = $row;
			}
		}
		
	}

	$response['success'] = $responsecode;
	echo json_encode($response, JSON_NUMERIC_CHECK);
?>