<?php
error_reporting(0);
include 'DBconn.php';
include 'categories.php';
//posted parameters
$userid = $_POST['userID'];
$receivedword = $_POST['receivedword'];

//test data
//$userid = 1;

$keyword = '%'.str_replace(" ","%",$receivedword).'%';
if(isset($_POST["categories"])){
	$categories = json_decode($_POST["categories"],true);
}

else $categories = null;

if(isset($_POST["lat"])&&isset($_POST["lng"])){
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];
}

else {
	$lat = null;
	$lng = null;
}

if(isset($_POST["calorie"])){
	$calorie = $_POST["calorie"];
}
else $calorie = 100000;

if(isset($_POST["distancelimit"])){
	$distancelimit = $_POST["distancelimit"];
}
else $distancelimit = 500000;

//transfer keyword into a part of sql sentence for search


searchitem($conn,$keyword,$categories,$lat,$lng,$distancelimit,$calorie);

function searchitem($conn,$keyword,$categories,$lat,$lng,$distancelimit,$calorie){
	$responsecode = 0;
	$response = array();

	if($categories==null){
		$sql = "select Items.*, Users.username from Items inner join Users on Items.uploaderID = Users.userID where name like '{$keyword}' and status = 0 and calorie <= {$calorie}";
		$result = $conn->query($sql);
		$i = 0;
		while($row = $result->fetch_assoc())
		{
			if($lat==null||distancefilter($distancelimit,$lat,$lng,$row['gmapLatitude'],$row['gmapLongitude'])){

				$eachline['item']= $row;
				$itemID = $row['itemID'];
				$responsecode = 1;
				//show its categories
				$eachline['categories'] = showcategories($conn,$itemID);
				$resultarr[$i++] = $eachline;
			}

		}
		$response['success'] = $responsecode;
		$response['data'] = $resultarr;
		$conn->close();
		echo json_encode($response);
	}
	else {
		filterbyCategory($conn,$keyword,$categories,$lat,$lng,$distancelimit,$calorie);
	}
}


function filterbyCategory($conn,$keyword,$categories,$lat,$lng,$distancelimit,$calorie){
	$responsecode = 0;
	$response = array();
	$categories = getCategoryID($conn,$categories);
	$count = sizeof($categories);
	//four conditions to search
	$categoriessql = "select itemID from(select itemID from Item_category where categoryID in (".implode(",",$categories).")) as icgroup group by itemID having count(itemID) = {$count}";
	$sql = "select Items.*, Users.username from Items inner join Users on Items.uploaderID = Users.userID where name like '{$keyword}' and itemID in({$categoriessql}) and status = 0 and calorie <= {$calorie}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
	{
		if($lat==null||distancefilter($distancelimit,$lat,$lng,$row['gmapLatitude'],$row['gmapLongitude'])){
			$eachline['item']= $row;
			$itemID = $row['itemID'];
			$responsecode = 1;
			//show its categories
			$eachline['categories'] = showcategories($conn,$itemID);
			$resultarr[$i++] = $eachline;

		}


	}
	$response['success'] = $responsecode;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);


}

function getCategoryID($conn,$categories){
	$count = sizeof($categories);
	$i=0;
	while($i<$count){
		$sql = "select categoryID from Categories where name='{$categories[$i]}'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$categories[$i]= $row['categoryID'];
		$i++;
	}

	return $categories;

}

function distancefilter($distancelimit,$lat,$lng,$itemlat,$itemlng){
	if($lat==null||$lng==null){
		return false;
	}

	else{
		$radLat1=deg2rad($lat);

		$radLat2=deg2rad($itemlat);

		$radLng1=deg2rad($lng);

		$radLng2=deg2rad($itemlng);

		$a=$radLat1-$radLat2;

		$b=$radLng1-$radLng2;

		$s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137;

		if($s<=$distancelimit) return true;
		else return false;
	}

}


?>
