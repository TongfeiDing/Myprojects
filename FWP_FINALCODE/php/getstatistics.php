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
	    $a = 0;
		$g = 0;
		$r = 0;
		$sql_items="SELECT "
			."IFNULL(SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END), 0) AS available, "
			."IFNULL(SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END), 0) AS given FROM Items WHERE uploaderID = {$userId}";
		
		$sql_requested="SELECT Count(*) as requested FROM Transactions WHERE userID = {$userId}";
			
		if($result = $conn->query($sql_items))
		{
			if($row = $result->fetch_assoc()){
				$responsecode = 1;
				$a = $row['available'];
				$g = $row['given'];
			}
		}
		
		if($result = $conn->query($sql_requested))
		{
			if($row = $result->fetch_assoc()){
				$responsecode = 1;
				$r = $row['requested'];
			}
		}
		
		$response['data'] = array();
		$response['data']['available'] = $a;
		$response['data']['given'] = $g;
		$response['data']['requested'] = $r;
	
	}

	$response['success'] = $responsecode;
	echo json_encode($response, JSON_NUMERIC_CHECK);
?>