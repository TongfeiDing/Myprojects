<?php
error_reporting(0);
include("DBTool.class.php");
//posted parameters
$action = $_POST['action'];

if($action != 'vieworder'){
$start = $_POST['startdate'];
$end = $_POST['enddate'];
}


if($action =='reserve'||$action =='vieworder'){

$customerID = $_POST['customerID'];
}

if($action =='reserve'){
	$roomID = $_POST['roomID'];
}

if($action == 'advancedsearch'){
	$type =$_POST['type'];
}


//excuting queries

$dbConn = new DBTool();

switch($action){
	case 'vieworder':
		vieworderbyID($dbConn,$customerID);
	case 'reserve':
		reserverooms($dbConn,$roomID,$customerID,$start,$end);
		break;
	case 'search':
		searchrooms($dbConn,$start,$end);
		break;
	case 'advancedsearch':
		searchrooms($dbConn,$start,$end,$type);
		break;
	default:
		echo 'Incorrect action';						
		
}

function vieworderbyID($dbConn,$customerID){
	$sql = "select * from Reservation where customerID = {$customerID}";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
            <td>{$row['orderID']}</td>
			<td>{$row['roomID']}</td>
			<td>{$row['startdate']}</td>
			<td>{$row['enddate']}</td>
			<td>{$row['currentstatus']}</td>
        </tr></br>";
    }
}






function reserverooms($dbConn,$roomID,$customerID,$start,$end){
	//check if this room is available at this period of time
	$findroom = 0;
	$sqlcheckroom = "select roomID,type,price from Rooms where roomID not in 
(select roomID from Reservation where (startdate>='{$start}' and startdate<='{$end}') or (enddate>='{$start}' and enddate<='{$end}') or (startdate<='{$start}' and enddate>='{$end}'))";
	$checkstate = $dbConn->query($sqlcheckroom);
	while($row = $checkstate->fetch_assoc())
    {
        if($roomID == $row['roomID']){
			$sql = "insert into Reservation (roomID,customerID,currentstatus,startdate,enddate) values ({$roomID},{$customerID},'ordered','{$start}','{$end}')";
	        $result = $dbConn->query($sql);
	        if($result){
				$findroom = 1;
				echo"reservation complete";
            }
			break;
			
		}
    }
	//if user input an invalid room id,give a warning back
	if($findroom == 0){
		echo "This room is not available";
	}
	
}
//search available rooms by inputting start and end date,default type:0.If it has been given a roomtype,it will only show records of this room type.
function searchrooms($dbConn,$start,$end,$type=0){
	if($type==0){//default mode
	$sql = "select roomID,type,price from Rooms where roomID not in 
(select roomID from Reservation where (startdate>='{$start}' and startdate<='{$end}') or (enddate>='{$start}' and enddate<='{$end}') or (startdate<='{$start}' and enddate>='{$end}'))";}
	else if($type=='asc'){//reorder search results by price(from low to hign)
	$sql = "select roomID,type,price from Rooms where roomID not in 
(select roomID from Reservation where (startdate>='{$start}' and startdate<='{$end}') or (enddate>='{$start}' and enddate<='{$end}') or (startdate<='{$start}' and enddate>='{$end}')) order by price asc";
	}
	else if($type=='desc'){//reorder search results by price(from hign to low)
	$sql = "select roomID,type,price from Rooms where roomID not in 
(select roomID from Reservation where (startdate>='{$start}' and startdate<='{$end}') or (enddate>='{$start}' and enddate<='{$end}') or (startdate<='{$start}' and enddate>='{$end}')) order by price desc";
		
	}
	else{//search specific types of rooms
	$sql = "select roomID,type,price from Rooms where roomID not in 
(select roomID from Reservation where (startdate>='{$start}' and startdate<='{$end}') or (enddate>='{$start}' and enddate<='{$end}') or (startdate<='{$start}' and enddate>='{$end}')) and type = '{$type}'";
		
	}
	
	$result = $dbConn->query($sql);
	if(!$result){
		echo 'Search failed,please doublecheck the inputting values!';
	}

	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
            <td>{$row['roomID']}</td>
			<td>{$row['type']}</td>
			<td>{$row['price']}</td>
			
        </tr></br>";
		searchfacilities($dbConn,$row['type']);
    }
	
	
	
}

//input a room type, list all facilities it has
function searchfacilities($dbConn,$roomtype){
	$cmdstr = 'isKRoom';//default room type'k'
	if($roomtype == 's'){
		$cmdstr = 'isSRoom';
	}
	else if($roomtype == 'm'){
		$cmdstr = 'isMRoom';
	}
	else if($roomtype == 'l'){
		$cmdstr = 'isLRoom';
	}
	else if($roomtype == 'k'){
		$cmdstr = 'isKRoom';
	}
	$sql = "select facilityname from Facilities where {$cmdstr} = 1";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
		
        echo"<tr>
            <td>{$row['facilityname']}</td>
        </tr>";
    }
	
	
}
						 


		


?>