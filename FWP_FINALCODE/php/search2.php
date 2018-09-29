<?php
	//error_reporting(0);
	include_once 'DBconn.php';
	include 'categories.php';
	include 'distance.php';

	$resultarr = array();

	//header("Content-Type: application/json");

	//posted parameters
	$receivedword = null;
	$radius = 20;
	$categories = null;
	$status = 0;
	$currentlat = 54.767392;
	$currentlon = -1.570303;
	$calories = 100000;
	$userID = 0;
	if(isset($_POST['userID'])){
		$userID = $_POST['userID'];
	}
	if(isset($_POST['receivedword'])){
		$receivedword = $_POST['receivedword'];
	}
	if(isset($_POST['distancelimit'])){
		$radius = floatval($_POST['distancelimit']);
	}
	if(isset($_POST['categories'])){
		$categories = $_POST["categories"];
	}
	if(isset($_POST['lat'])){
		$currentlat = floatval($_POST['lat']);
	}
	if(isset($_POST['lng'])){
		$currentlon = floatval($_POST['lng']);
	}
	if(isset($_POST['status'])){
		$status = intval($_POST['status']);
	}
	if(isset($_POST['calorie'])){
		$calories = intval($_POST['calorie']);
	}

	$keyword = '%'.$receivedword."%";

	$responsecode = 0;
	$response = array();

	if($categories==null || sizeof($categories) == 0){
		$sql = "select Items.*, Users.username, Users.image as uploaderpicture from Items inner join Users ON Users.userID = Items.uploaderID "
		."where name like '{$keyword}' and status = {$status} and calorie <= {$calories} and Users.userID <> {$userID}"
		. " ORDER BY uploadDate DESC";
	}
	else {
		$cs = implode("','", $categories);
		$cs = "'".$cs."'";
		$sql = "SELECT Items.*, Users.username, Users.image as uploaderpicture FROM Items "
			."INNER JOIN Users ON Users.userID = Items.uploaderID "
			."INNER JOIN Item_category ON Items.itemID = Item_category.itemID "
			."INNER JOIN Categories ON Item_category.categoryID = Categories.categoryID "
			."WHERE Items.name like '{$keyword}' AND status = {$status} and calorie <= {$calories} "
			."AND Categories.name IN (".$cs.") and Users.userID <> {$userID} "
			."GROUP BY Items.itemID "
			."HAVING COUNT(DISTINCT Item_category.categoryID) = ".sizeof($categories)
			. " ORDER BY uploadDate DESC";

	}
//echo $sql;
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc())
	{
		$lat = $row['gmapLatitude'];
		$lon = $row['gmapLongitude'];
		$row['distance'] = round(earthDistance($currentlat, $currentlon, $lat, $lon) / 1000, 2);
		if($row['distance'] < $radius)
		{
			$r = array();
			$r['item'] = $row;
			$itemID = $row['itemID'];
			$r['categories'] = showcategories($conn,$itemID);
			$resultarr[] = $r;
			$responsecode = 1;
		}

	}
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;

	echo json_encode($response, JSON_NUMERIC_CHECK);
	$conn->close();

?>
