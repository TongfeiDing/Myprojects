<?php

/*
  Search function
  @Tongfei Ding
  search specific items with titles, categories, auction types
*/

error_reporting(0);
include 'DBconn.php';

include 'categories.php';
//posted parameters
$userID = $_POST['userID'];



$receivedword = $_POST['receivedword'];


$keyword = '%'.str_replace(" ","%",$receivedword).'%';

if(isset($_POST["categories"])){
	$categories = $_POST["categories"];
}

else $categories = null;




//transfer keyword into a part of sql sentence for search


searchitem($conn,$keyword,$categories);

function searchitem($conn,$keyword,$categories){
	$status = 0;
    $response = array();
	
	if($categories==null){
	$sql = "select * from Items where itemname like '{$keyword}' and status = 0";
	$eachline = array();
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
	else {
		filterbyCategory($conn,$keyword,$categories);
	}
}


function filterbyCategory($conn,$keyword,$categories){
	$status = 0;
    $response = array();
	$categoriessql = "select itemID from Item_category where categoryID = {$categories}";
	$sql = "select * from Items where itemname like '{$keyword}' and itemID in({$categoriessql}) and status = 0";
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

function getCategoryID($conn,$categories){
	$sql = "select categoryID from Categories where name='{$categories[$i]} and status = 0'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$categories= $row['categoryID'];

	
	
	return $categories;
	
}


?>