<?php
error_reporting(0);

//add categories for an item
function setcategories($conn,$itemID){
	$responsecode = 0;
    $response = array();
	
	$categories = $_POST['categories'];
	
	$i = 0;
	$count = sizeof($categories);
	
	while($i<$count){
	//get a categoryID from Categories table	
	$sqlgetID = "select categoryID from Categories where name = '{$categories[$i]}' ";
	$getID = $conn->query($sqlgetID);
	if($row = $getID->fetch_assoc()){
	$categoryID = $row['categoryID'];
	//If the category exists, do next step, otherwise add a new category
	}
		
	else{
		$categoryID = addnewcategory($conn,$categories[$i]);		
	}
	
	$sqlset = "insert into Item_category (itemID,categoryID) values ({$itemID},{$categoryID})";
	$result = $conn->query($sqlset);
	$resultarr[$i] = "Category [$i] cannot be inserted";
	if($result){
		$responsecode = 1;
		$resultarr[$i] = "The {$i} category is inserted for item {$itemID}";
	}
	$i++;

	}
	
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	return $response;
	
}

function showcategories($conn,$itemID){
	$sql = "select Categories.name from Item_category,Categories where Item_category.categoryID = Categories.categoryID and Item_category.itemID = {$itemID}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$resultarr[$i++] = $row;
		$responsecode = 1;	
       
    }
	return $resultarr;

}

//delete all categories from an item
function unbindcategories($conn,$itemID){
	$responsecode = 0;
    $response = array();
	
	$category = $_POST['categories'];
	
	$sql = "delete from Item_category where itemID = {$itemID}";
	
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'The categories are removed';
	}
	$response['success'] = $responsecode;
	$conn->close();
	echo json_encode($response);
}

//delete a category from an item
function unbindacategory($conn,$itemID){
	$responsecode = 0;
    $response = array();
	
	$category = $_POST['categories'];
	
	$sql = "delete ic from Item_category ic,Categories where Item_category.itemID = {$itemID} and Item_category.categoryID = Categories.categoryID and Categories.name = '{$category}'";
	
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'The category is removed';
	}
	$response['success'] = $responsecode;
	$conn->close();
	echo json_encode($response);
}
	
	
//add a new kind of category into Categories table
function viewcategoriestable($conn){
	$sql = "SELECT * FROM Categories";
	$response = array();
	if($result = $conn->query($sql))
	{
		while($row = $result->fetch_assoc()){
			$response[] = $row;
		}
	}
	echo json_encode($response, JSON_NUMERIC_CHECK);

}

function addnewcategory($conn){
	$responsecode = 0;
    $response = array();
	
	$category = $_POST['categories'];
	
	$sql = "insert into Categories (name) values('{$category}') ";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'The category is inserted';
	}
	$response['success'] = $responsecode;
	echo json_encode($response);
	return $conn->insert_id;
	$conn->close();
	
}

// delete a category from Categories table
function removecategory($conn){
	$responsecode = 0;
    $response = array();
	
	$category = $_POST['categories'];
	
	$sql = "delete from Categories where name = '{$category}' ";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$responsecode = 1;
		$response['data'] = 'The category is deleted';
	}
	$response['success'] = $responsecode;
	$conn->close();
	echo json_encode($response);
	
}

?>