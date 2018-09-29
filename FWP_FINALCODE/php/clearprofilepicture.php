	<?php
	
	include 'DBconn.php';
	$responsecode = 0;
	$response = array();
	$userId = -1;
	error_reporting(0);
	
	//If the required fields are not specified, send an error
    if(!isset($_POST['userid'])){
		$responsecode = -1;
	} else {
		
	    $userId = $_POST['userid'];
	    
		$sql="UPDATE Users SET image = NULL WHERE userID = {$userId} ";
			
		if($conn->query($sql))
		{
			$responsecode = 1;
		}
	
	}

	$response['success'] = $responsecode;
	echo json_encode($response, JSON_NUMERIC_CHECK);
?>