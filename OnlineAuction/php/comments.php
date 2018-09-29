<?php

/*

*/

error_reporting(0);
include 'DBconn.php';

function addComment($conn,$userID){
	$status = 0;
    $response = array();
	$response['data'] = 'error';		
	$sql = "insert into Comments (senderID,itemID,content) values({$userID},{$_POST['itemID']},'{$_POST['content']}')";
	$result = $conn->query($sql);
	
	if($result){
		$status = $conn->insert_id;
		$response['data'] = 'The comment is inserted';
	}
	$response['status'] = $status;
 
	echo json_encode($response);
	$conn->close();
	
}

function viewCommentsofitem($conn,$itemID){
	$sql = "select Comments.*,Users.username from Comments,Users where Comments.itemID = {$itemID} and Comments.senderID = Users.userID";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$resultarr[$i++] = $row;
       
    }
	return $resultarr;
	
}





	


	


?>