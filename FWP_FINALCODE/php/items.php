<?php
//error_reporting(0);
include 'DBconn.php';
include 'categories.php';
include "uploadimage.php";
//posted parameters
$action = $_POST['action'];
$userID = $_POST['userID']; 


//test data
//$action = 'viewavailable';
//$userID = 1;


switch($action){
	case 'view':
		showitems($conn,$userID);
		break;
	case 'find':
		finditembyID($conn,$userID);
		break;
	case 'viewavailable':
		showavailable($conn,$userID);
		break;	
	case 'viewdelivered':
		showdelivered($conn,$userID);
		break;
	case 'viewremoved':
		showremoved($conn,$userID);
		break;
	case 'remove':
		removeitem($conn,$userID);
		break;
	case 'add':
		additem($conn,$userID);
		break;
	case 'update':
		updateitem($conn,$userID);
		break;
	case 'setcas':
		setcategories($conn,$_POST['itemID']);
		break;
	case 'unbindca':
		unbindacategory($conn,$_POST['itemID']);
		break;
	case 'unbindallca':
		unbindcategories($conn,$_POST['itemID']);
		break;
	case 'addca':
		addnewcategory($conn);
		break;
    case 'removeca':
		removecategory($conn);
		break;
	default:
		echo "incorrect action";						
		
}




//show all rooms in the database
function showitems($conn,$userID){
	$responsecode = 0;
	$eachline = array();
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$responsecode = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
       
    }
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showavailable($conn,$userID){
	$responsecode = 0;
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID} and status = 0";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$responsecode = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
       
    }
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showremoved($conn,$userID){
	$responsecode = 0;
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID} and status = 1";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$responsecode = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
			
       
    }
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showdelivered($conn,$userID){
	$responsecode = 0;
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID} and status = 2";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$responsecode = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
			
       
    }
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function finditembyID($conn,$userID){
	$responsecode = 0;
    $response = array();
	$itemID = $_POST['itemID'];
	
	$sql = "select * from Items where itemID = {$itemID}";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$responsecode = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
    }
	$response['success'] = $responsecode;
	$response['data'] = $eachline;
	$conn->close();
	echo json_encode($response);
	
}

function removeitem($conn,$userID){
	$responsecode = 0;
    $response = array();
	$itemID = $_POST['itemID'];
	
	//$sql = "delete from Items where itemID = {$itemID}";
	$sql = "update Items set status = 1 where itemID = {$itemID}";
	//set this item "Removed"
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'The item is removed';
	}
	$response['success'] = $responsecode;
	$conn->close();
	echo json_encode($response);
}

function additem($conn,$userID){
	$responsecode = 0;
    $response = array();
	//parameters
	$name = $_POST['name'];
	$quantity = $_POST['quantity'];
	$uploaderID = $userID;
	$bestbeforeDate = $_POST['bestbeforeDate'];
	
	
	$picURL = $_FILES['picURL'];
	$npicURL = uploadimage('users/'.$userID.'/items/', 'picURL'); //store picture and generate url address
	
	
	$calorie = $_POST['calorie'];
	$description = $_POST['description'];
	$gmapLatitude = $_POST['gmapLatitude'];
	$gmapLongitude = $_POST['gmapLongitude'];
	
	$sql = "insert into Items (name,quantity,uploaderID,bestbeforeDate,picURL,calorie,description,gmapLatitude,gmapLongitude) values('{$name}',{$quantity},{$uploaderID},'{$bestbeforeDate}','{$npicURL}',{$calorie},'{$description}','{$gmapLatitude}','{$gmapLongitude}')";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'The item is inserted';
		//add categories for it
		if(isset($_POST['categories'])){
			setcategories($conn,$conn->insert_id);			
		}
	}
	$response['success'] = $responsecode;
	//$conn->close();
	echo json_encode($response);
}




function updateitem($conn,$userID){
	$responsecode = 0;
    $response = array();
	//parameters
	$itemID = $_POST['itemID'];
	$name = $_POST['name'];
	$quantity = $_POST['quantity'];
	$uploaderID = $userID;
	$bestbeforeDate = $_POST['bestbeforeDate'];
	$picURL = $_POST['picURL'];
	$npicURL = uploadimage('users/'.$userID.'/items/', 'picURL'); //store picture and generate url address
	$calorie = $_POST['calorie'];
	$description = $_POST['description'];
	$gmapLatitude = $_POST['gmapLatitude'];
	$gmapLongitude = $_POST['gmapLongitude'];
	
	
	
	$sql = "update Items set name = '{$name}', quantity = {$quantity},uploaderID = {$uploaderID}, bestbeforeDate = '{$bestbeforeDate}', picURL='{$npicURL}', calorie = {$calorie}, description = '{$description}', gmapLatitude = '{$gmapLatitude}', gmapLongitude ='{$gmapLongitude}' where itemID = {$itemID}";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'The item is updated';
	}
	$response['success'] = $responsecode;
	$conn->close();
	echo json_encode($response);
	
}
	


	



?>