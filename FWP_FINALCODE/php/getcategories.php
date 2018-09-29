<?php
	/*
		Returns all categories in an arary.
		Each category is represented by a structure
		containing the following info:
		{
			"categoryID":number,
			"name":"string"
		}
	*/

	include "DBconn.php";
	
	$sql = "SELECT * FROM Categories";
	$response = array();
	if($result = $conn->query($sql))
	{
		while($row = $result->fetch_assoc()){
			$response[] = $row;
		}
	}
	echo json_encode($response, JSON_NUMERIC_CHECK);
?>