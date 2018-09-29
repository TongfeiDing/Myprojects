<?php
error_reporting(0);
include("DBTool.class.php");
//posted parameters
$action = $_POST['action'];
if($action!='view'){
$roomID = $_POST['roomID'];

}

if($action =='update'||$action =='add'){
$type = $_POST['type'];
$price = $_POST['price'];
$available = $_POST['available'];
}



//excuting queries

$dbConn = new DBTool();

switch($action){
	case 'view':
		showrooms($dbConn);
		break;
	case 'find':
		findroombyID($dbConn,$roomID);
		break;
	case 'remove':
		removeroom($dbConn,$roomID);
		break;
	case 'add':
		addroom($dbConn,$roomID,$type,$price,$available);
		break;
	case 'update':
		updateroom($dbConn,$roomID,$type,$price,$available);
		break;
	default:
		echo 'Incorrect action';						
		
}




//show all rooms in the database
function showrooms($dbConn){
	$sql = "select * from Rooms";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
            <td>{$row['roomID']}</td>
			<td>{$row['type']}</td>
			<td>{$row['price']}</td>
			<td>{$row['available']}</td>
        </tr></br>";
    }
}

function findroombyID($dbConn,$roomID){
	$sql = "select * from Rooms where roomID = {$roomID}";
	$result = $dbConn->query($sql);
	if($result->num_rows<1){
		echo 'Room does not exist!';
	}
	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
            <td>{$row['roomID']}</td>
			<td>{$row['type']}</td>
			<td>{$row['price']}</td>
			<td>{$row['available']}</td>
        </tr></br>";
    }
	
}

function removeroom($dbConn,$roomID){
	$sql = "delete from Rooms where roomID = {$roomID}";
	$result = $dbConn->query($sql);
	if($result){
		echo "Room {$roomID} is removed";
	}
}

function addroom($dbConn,$roomID,$type,$price,$available){
	$sql = "insert into Rooms values({$roomID},'{$type}',{$price},{$available})";
	$result = $dbConn->query($sql);
	if($result){
		echo "Room {$roomID} is inserted";
	}
	
}

function updateroom($dbConn,$roomID,$type,$price,$available){
	$sql = "update Rooms set type = '{$type}', price = {$price},available = {$available} where roomID = {$roomID}";
	$result = $dbConn->query($sql);
	if($result){
		echo "Room {$roomID} is updated";
	}
	
}
	


	



?>