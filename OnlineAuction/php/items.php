<?php

/*
  Item management 
  @Tongfei Ding
  show,add,remove,update items and categories
*/

error_reporting(0);
include 'DBconn.php';

include 'categories.php';
include 'uploadimage.php';
include 'comments.php';

$action = $_POST['action'];
$userID = $_POST['userID']; 

switch($action){
	case 'view':
		showitems($conn,$userID);
		break;
	case 'find':
		finditembyID($conn);
		break;
	case 'viewavailable':
		showavailable($conn,$userID);
		break;	
	case 'viewsold':
		showsold($conn,$userID);
		break;
	case 'viewremoved':
		showremoved($conn,$userID);
		break;
	case 'viewovertime':
		showovertime($conn,$userID);
	case 'viewbyat':
		showitemsbyauctiontype($conn,$_POST['auctiontype']);
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
	case 'relist':
		relistitem($conn,$userID);
		break;
	case 'viewcas':
		viewcategoriestable($conn,$userID);
		break;
	case 'setcas':
		setcategories($conn,$_POST['itemID']);
		break;
	case 'unbindallca':
		unbindcategories($conn,$_POST['itemID']);
		break;
	case 'addca':
		addnewcategory($conn,$userID,$_POST['categoryname']);
		break;
    case 'removeca':
		removecategory($conn,$userID,$_POST['categoryname']);
		break;
	case 'writecomment':
		addComment($conn,$userID);
		break;
	default:
		echo "incorrect action";						
		
}




//show all items in the database
function showitems($conn,$userID){
	$status = 0;
	$eachline = array();
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$status = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showavailable($conn,$userID){
	$status = 0;
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID} and status = 0";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$status = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showremoved($conn,$userID){
	$status = 0;
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID} and status = 1";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$status = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
			
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showsold($conn,$userID){
	$status = 0;
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID} and status = 2";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$status = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
			
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showovertime($conn,$userID){
	$status = 0;
    $response = array();
	$sql = "select * from Items where uploaderID = {$userID} and status = 3";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$status = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
			
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function showitemsbyauctiontype($conn,$auctiontype){
	$status = 0;
    $response = array();
	$sql = "select * from Items where auctiontype = {$auctiontype} and status = 0";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$status = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);		
		$resultarr[$i++] = $eachline;
			
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

function finditembyID($conn){
	$status = 0;
    $response = array();
	$itemID = $_POST['itemID'];
	
	$sql = "select * from Items where itemID = {$itemID}";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc())
    {
		$eachline['item'] = $row;
		$uploaderID = $row['uploaderID'];
		$sql_getseller = "select * from Users where userID = {$uploaderID}";
		$result_seller = $conn->query($sql_getseller);
		while($row_seller = $result_seller->fetch_assoc()){
			$eachline['seller'] = $row_seller;
		}
		$status = 1;
		//show its categories
		$eachline['categories'] = showcategories($conn,$itemID);
		//show its comments
		$eachline['comments'] = viewCommentsofitem($conn,$itemID);
		//count the number of pictures this item has
		$dir = "../image/".$uploaderID."/".$itemID."/";
		$pics = scandir($dir);
		$num_pics = count($pics)-2;
		if($num_pics>=1) $eachline['num_pics']= $num_pics;
		else $eachline['num_pics']= 1;
    }
	$response['status'] = $status;
	$response['data'] = $eachline;
	$conn->close();
	echo json_encode($response);
	
}

function removeitem($conn,$userID){
	$status = 0;
    $response = array();
	$itemID = $_POST['itemID'];
	
	//$sql = "delete from Items where itemID = {$itemID}";
	$sql = "update Items set status = 1 where itemID = {$itemID}";
	//set this item "Removed"
	$result = $conn->query($sql);
	if($result){
		$status = 1;
	}
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response);
}

function relistitem($conn,$userID){
	$status = 0;
    $response = array();
	$itemID = $_POST['itemID'];
	
	//$sql = "delete from Items where itemID = {$itemID}";
	$sql = "update Items set status = 0, currentprice = startingprice, uploadtime = CURRENT_TIMESTAMP, duration = 300 where itemID = {$itemID}";
	//set this item "Removed"
	$result = $conn->query($sql);
	if($result){
		$status = 1;
	}
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response);	
}

function additem($conn,$userID){
	$status = 0;
    $response = array();
	//parameters
	$itemname = $_POST['itemname'];
	$quantity = 1;
	$uploaderID = $userID;
	$auctiontype = $_POST['auctiontype'];
	$startingprice = $_POST['startingprice'];
	$duration = $_POST['duration'];
	$description = $_POST['description'];

	
	$sql = "insert into Items (itemname,quantity,auctiontype,uploaderID,startingprice,currentprice,duration,description) values('{$itemname}',{$quantity},{$auctiontype},{$uploaderID},{$startingprice},{$startingprice},{$duration},'{$description}')";
	
	if(isset($_POST['pricedown'])){
		$sql = "insert into Items (itemname,quantity,auctiontype,uploaderID,startingprice,currentprice,duration,description,pricedown) values('{$itemname}',{$quantity},{$auctiontype},{$uploaderID},{$startingprice},{$startingprice},{$duration},'{$description}',{$_POST['pricedown']})";	
	}
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$status = 1;
		$response['data'] = 'The item is inserted';
		$index = $conn->insert_id;
		//upload images for it
		saveItempictures($conn,$index);
		//add categories for it
		if(isset($_POST['categories'])){
			setcategories($conn,$index);			
		}
		
	}
	$response['status'] = $status;
	//$conn->close();
	echo json_encode($response);
}




function updateitem($conn,$userID){
	$status = 0;
    $response = array();
	//parameters
	$itemID = $_POST['itemID'];
	$itemname = $_POST['itemname'];
	$quantity = $_POST['quantity'];
	$uploaderID = $userID;
	$startingprice = $_POST['startingprice'];
	$duration = $_POST['duration'];
	$description = $_POST['description'];

	
	
	
	$sql = "update Items set itemname = '{$itemname}', quantity = {$quantity},uploaderID = {$uploaderID}, startingprice = {$startingprice}, duration = {$duration}, description = '{$description}', where itemID = {$itemID}";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$status = 1;
	}
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response);
	
}
	


	


?>