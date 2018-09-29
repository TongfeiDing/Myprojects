<?php
error_reporting(0);

//add categories for an item
function setcategories($conn,$itemID){
	$status = 0;
    $response = array();
	$categories = $_POST["categories"];
	
	$i = 0;
	$count = sizeof($categories);

	
	while($i<$count){
	//get a categoryID from Categories table
	$sqlgetID = "select categoryID from Categories where categoryname = '{$categories[$i]}' ";
	$getID = $conn->query($sqlgetID);
	if($row = $getID->fetch_assoc()){
	$categoryID = $row['categoryID'];
	//If the category exists, do next step, otherwise add a new category
	}
	
	$sqlset = "insert into Item_category (itemID,categoryID) values ({$itemID},{$categoryID})";
	$result = $conn->query($sqlset);
	$resultarr[$i] = "Category [$i] cannot be inserted";
	if($result){
		$status = 1;
		$resultarr[$i] = "The {$i} category is inserted for item {$itemID}";
	}
	$i++;

	}
	
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	return $response;
	
}

function showcategories($conn,$itemID){
	$sql = "select Categories.categoryname from Item_category,Categories where Item_category.categoryID = Categories.categoryID and Item_category.itemID = {$itemID}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$resultarr[$i++] = $row;
       
    }
	return $resultarr;

}

//delete all categories from an item
function unbindcategories($conn,$itemID){
	$status = 0;
    $response = array();
	
	$sql = "delete from Item_category where itemID = {$itemID}";
	
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$status = 1;
		$response['data'] = 'The categories are removed';
	}
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response);
}
	
	

function viewcategoriestable($conn,$userID){
	$sql = "SELECT * FROM Categories where status = 0 or status = {$userID}";
	$response = array();
	$response['status'] = 0;
	if($result = $conn->query($sql))
	{
		$i=0;
		while($row = $result->fetch_assoc()){
			$resultarr[$i++] = $row;
		}
		$response['status'] = 1;
		$response['data'] = $resultarr;
	}
	echo json_encode($response);

}

//add a new kind of category into Categories table
function addnewcategory($conn,$userID,$categoryname){
	$status = 0;
    $response = array();
	$response['data'] = 'error';
	
	$sql_select = "select * from Categories where categoryname = '{$categoryname}' and status = {$userID}";
	$checkduplication = $conn->query($sql_select);
	//if the category has existed, end with error, otherwise add a new category
	if($checkduplication->num_rows==0){
		
	$sql = "insert into Categories (categoryname,status) values('{$categoryname}',{$userID}) ";
	$result = $conn->query($sql);
	
	if($result){
		$status = $conn->insert_id;
		$response['data'] = 'The category is inserted';
	}
	$response['status'] = $status;
 }
	echo json_encode($response);
	$conn->close();
	
}

// delete a category from Categories table
function removecategory($conn,$userID,$categoryname){
	$status = 0;
    $response = array();
	
	$sql = "delete from Categories where categoryname = '{$categoryname}' and status = {$userID} ";
	$result = $conn->query($sql);
	$response['data'] = 'error';
	if($result){
		$status = 1;
		$response['data'] = 'The category is deleted';
	}
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response);
	
}

?>