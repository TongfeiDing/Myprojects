<?php

	include "DBconn.php";
  $id = $_POST['userID'];

	$sql = "SELECT itemID FROM Items ORDER BY itemID DESC Limit 1";
	$response = array();
	if($result = $conn->query($sql))
	{
		if($row = $result->fetch_assoc()){
      $lid = $row['itemID'];
			$sql_update = "UPDATE Users SET LastItemID = {$lid} WHERE userID = {$id}";
      $conn->query($sql_update);
      $response['success'] = 1;
		}
    else{
      $response['success'] = 0;
    }
	}
	echo json_encode($response, JSON_NUMERIC_CHECK);
?>
