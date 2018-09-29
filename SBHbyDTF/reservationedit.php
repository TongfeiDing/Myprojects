<?php
include("DBTool.class.php");
error_reporting(0);
//posted parameters
$action = $_POST['action'];
if($action=='find'||$action=='update'){
$orderID = $_POST['orderID'];

}
if($action=='customerfilter'||$action=='update'){
$customerID = $_POST['customerID'];

}

if($action =='update'){
$roomID = $_POST['roomID'];
$currentstatus = $_POST['currentstatus'];
$start = $_POST['startdate'];
$end = $_POST['enddate'];
}



//excuting queries

$dbConn = new DBTool();

switch($action){
	case 'view':
		showreservation($dbConn);
		break;
	case 'customerfilter':
		filterbycustomer($dbConn,$customerID);
		break;
	case 'find':
		findrecordbyID($dbConn,$orderID);
		break;
	case 'update':
		updaterecord($dbConn,$orderID,$roomID,$customerID,$currentstatus,$start,$end);
		break;
	default:
		echo 'Incorrect action';						
		
}




//show all rooms in the database
function showreservation($dbConn){
	$sql = "select * from Reservation";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
		    <td>{$row['orderID']}</td>
            <td>{$row['roomID']}</td>
			<td>{$row['customerID']}</td>
			<td>{$row['currentstatus']}</td>
			<td>{$row['startdate']}</td>
			<td>{$row['enddate']}</td>
        </tr></br>";
    }
}

function filterbycustomer($dbConn,$customerID){
	$sql = "select * from Reservation where customerID = {$customerID}";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
       echo "<br><tr>
		    <td>{$row['orderID']}</td>
            <td>{$row['roomID']}</td>
			<td>{$row['customerID']}</td>
			<td>{$row['currentstatus']}</td>
			<td>{$row['startdate']}</td>
			<td>{$row['enddate']}</td>
        </tr></br>";
    }
	
}


function findrecordbyID($dbConn,$orderID){
	$sql = "select * from Reservation where orderID = {$orderID}";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
       echo "<br><tr>
		    <td>{$row['orderID']}</td>
            <td>{$row['roomID']}</td>
			<td>{$row['customerID']}</td>
			<td>{$row['currentstatus']}</td>
			<td>{$row['startdate']}</td>
			<td>{$row['enddate']}</td>
        </tr></br>";
    }
	
}


function updaterecord($dbConn,$orderID,$roomID,$customerID,$currentstatus,$start,$end){
	$sql = "update Reservation set roomID = {$roomID}, customerID = {$customerID},currentstatus = '{$currentstatus}', startdate = '{$start}',enddate = '{$end}' where orderID = {$orderID}";
	$result = $dbConn->query($sql);
	if($result){
		echo "Order {$orderID} is updated";
	}
	
}
	


	



?>