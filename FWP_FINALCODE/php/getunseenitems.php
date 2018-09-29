<?php

	include "DBconn.php";
  $id = $_POST['userID'];

	$sql = "SELECT Count(*) as n FROM Items
INNER JOIN Item_category ON Item_category.itemID = Items.itemID
INNER JOIN Users ON Users.userID = Items.uploaderID
WHERE Item_category.categoryID IN (SELECT category_id FROM user_categories WHERE user_id = {$id})
AND Items.itemID > (SELECT LastItemID FROM Users WHERE userID = {$id})";
	$response = array();
	if($result = $conn->query($sql))
	{
		if($row = $result->fetch_assoc()){
      $number = $row['n'];
      $response['success'] = 1;
      $response['data'] = $number;
		}
    else{
      $response['success'] = 0;
    }
	}
	echo json_encode($response, JSON_NUMERIC_CHECK);
?>
