<?php
//error_reporting(0);
include 'DBconn.php';
//posted parameters
$action = $_POST['action'];
$userid = $_POST['userID']; 


switch($action){
		//view transactions that a user provide items for others
	case 'viewsending':
		viewTransactionsofUser($conn,$userid);
		break;
		//view transactions that a user want to order from others
	case 'viewordering':
		viewOrdersofUser($conn,$userid);
		break;
	case 'makedeal':
		makeTransaction($conn,$userid);
		break;
	case 'find':
		findTransactionbyID($conn);
		break;
	default:
		echo 'Incorrect action';						
		
}




function viewTransactionsofUser($conn,$userid){
	$responsecode = 0;
    $response = array();
	
	$sql = "select Transactions.* from Transactions inner join Items on Transactions.itemID = Items.itemID where Items.uploaderID = {$userid}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$resultarr[$i++] = $row;
		$responsecode = 1;
			
       
    }
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response, JSON_NUMERIC_CHECK);
}

function viewOrdersofUser($conn,$userid){
	$responsecode = 0;
    $response = array();
	
	$sql = "select transDate, Users.*, Items.* from Transactions INNER JOIN Items ON Items.itemID = Transactions.itemID "
	."INNER JOIN Users ON Users.userID = Items.uploaderID where Transactions.userID = {$userid}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$resultarr[$i++] = $row;
		$responsecode = 1;
			
       
    }
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response, JSON_NUMERIC_CHECK);
}

function makeTransaction($conn,$userid){
	$responsecode = 0;
    $response = array();
	
	$itemID = $_POST['itemID'];
	
	$sql = "insert into Transactions (userID,itemID) values ({$userid},{$itemID})";
	$sqlupdate = "update Items set status = 2 where itemID = {$itemID}";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$resultupdate = $conn->query($sqlupdate);
		$responsecode = 1;
		$response['data'] = 'A new transaction proceeded';
	}
	$response['success'] = $responsecode;
	$conn->close();
	echo json_encode($response, JSON_NUMERIC_CHECK);
	
}


function findTransactionbyID($conn){
	$responsecode = 0;
    $response = array();
	
	$transID = $_POST['transID'];
	
	$sql = "select * from Transactions where transID = {$transID}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$resultarr[$i++] = $row;
		$responsecode = 1;
			
       
    }
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response, JSON_NUMERIC_CHECK);
}

	



?>