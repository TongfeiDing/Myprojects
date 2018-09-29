<?php
//error_reporting(0);
include 'DBconn.php';
//posted parameters
$action = $_POST['action'];  	  
$userid = $_POST['userID'];  


switch($action){
		
	case 'send':
		send($conn,$userid);
		break;
	case 'read':
		read($conn,$userid);
		break;
	case 'get-unread':
		getunreadnumber($conn, $userid);
		break;
	case 'get-unread-from':
		getunreadmessages($conn, $userid);
		break;
	case 'get-users':
		getContactsWithChats($conn, $userid);
		break;
	default:
		echo 'Incorrect action';						
		
}




function send($conn,$userid){
	$responsecode = 0;
    $response = array();
	
	$receiverID = $_POST['oppositeID'];
	$content = $_POST['content'];
		
	$sql = "insert into Messages (senderID,receiverID,content,isread) values ({$userid},{$receiverID},'{$content}',0)";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'Message sent';
	}
	$response['success'] = $responsecode;
	$conn->close();
	echo json_encode($response, JSON_NUMERIC_CHECK);
}

function read($conn,$userid){
	$responsecode = 0;
    $response = array();
	
	$senderID = $_POST['oppositeID'];
	
	$sql = "select * from Messages where (receiverID = {$userid} and senderID = {$senderID}) OR "
			."(receiverID = {$senderID} and senderID = {$userid}) ORDER BY messageTime ASC";
	$sqlupdate = "UPDATE Messages SET isread = 1 WHERE receiverID = {$userid} and senderID = {$senderID} ";
	
	$result = $conn->query($sql);	
	$resultarr = array();
	$unread = array();
	while($row = $result->fetch_assoc())
    {
		$resultarr[] = $row;
    }
	
	if(sizeof($resultarr) > 0)
	{
		$responsecode = 1;
	}	
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	echo json_encode($response, JSON_NUMERIC_CHECK);
	$conn->query($sqlupdate);
	//$conn->query($sqlremove);
	$conn->close();
	
}

function getunreadnumber($conn, $userid){
	$sql = "SELECT Count(*) as unreadmessages FROM Messages WHERE receiverID = {$userid} and isread = 0 ";
	$responsecode = 0;
	$response = array();
	if($result = $conn->query($sql)){
		if($row = $result->fetch_assoc()){
			$response['data'] = $row['unreadmessages'];
			$responsecode = 1;
		}
	}
	
	$response['success'] = $responsecode;
	echo json_encode($response, JSON_NUMERIC_CHECK);
}

function getContactsWithChats($conn, $userid){
	$sql = "SELECT senderID as id, Users.username, Users.image as profilepicture, Count(*) as messages ".
		"FROM Messages INNER JOIN Users ON senderID = Users.userID ".
		"WHERE receiverID = {$userid} AND isread = 0 GROUP BY senderID";
	$responsecode = 0;
	$response = array();
	$resultarr = array();
	$ids = array();
	if($result = $conn->query($sql)){
		while($row = $result->fetch_assoc()){
			$resultarr[] = $row;
			$ids[] = $row['id'];
			$responsecode = 1;
		}
	}
	$sql = "SELECT receiverID as id, Users.username,Users.image as profilepicture, 0 as messages ".
			"FROM Messages INNER JOIN Users ON receiverID = Users.userID ".
			"WHERE senderID = {$userid} ";
			
	if($responsecode == 1){
		$sql.= "AND receiverID NOT IN (".implode(",",$ids).") ";
	}
	$sql.="GROUP BY receiverID ";
	if($result = $conn->query($sql)){
		while($row = $result->fetch_assoc()){
			$resultarr[] = $row;
			$ids[] = $row['id'];
			$responsecode = 1;
		}
	}
	
	$sql = "SELECT senderID as id, Users.username, Users.image as profilepicture, 0 as messages ".
		"FROM Messages INNER JOIN Users ON senderID = Users.userID ".
		"WHERE receiverID = {$userid} AND isread = 1 ";
	if($responsecode == 1){
		$sql.= "AND senderID NOT IN (".implode(",",$ids).") ";
	}
	$sql.="GROUP BY senderID ";
	
	if($result = $conn->query($sql)){
		while($row = $result->fetch_assoc()){
			$resultarr[] = $row;
			$ids[] = $row['id'];
			$responsecode = 1;
		}
	}
	
	usort($resultarr, "cmp");	
	$response['data'] = $resultarr;
	$response['success'] = $responsecode;
	
	echo json_encode($response, JSON_NUMERIC_CHECK);
}

function getunreadmessages($conn, $userid){
	$responsecode = 0;
    $response = array();
	
	$senderID = $_POST['oppositeID'];
	
	$sql = "select Count(*) as number from Messages where receiverID = {$userid} and senderID = {$senderID} and isread = 0 ";
	
	if($result = $conn->query($sql)){
		if($row = $result->fetch_assoc())
		{
			$responsecode = 1;
			$response['data'] = $row['number'];
		}
	}		
	
	$response['success'] = $responsecode;	
	echo json_encode($response, JSON_NUMERIC_CHECK);
	$conn->close();
}
function cmp($a, $b)
{
    return strcmp(strtolower($a["username"]), strtolower($b["username"]));
}


?>