<?php
error_reporting(0);
include("DBTool.class.php");
//posted parameters
$action = $_POST['action'];

if($action == 'findID'){
$customerID = $_POST['customerID'];
}
if($action!='view'&&$action!='findID'){
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
}

if($action =='update'){
$level = $_POST['level'];
$email = $_POST['emailaddress'];
$phonenumber = $_POST['phonenumber'];
$customerID = $_POST['customerID'];
$password = $_POST['password'];
}



//excuting queries

$dbConn = new DBTool();

switch($action){
	case 'view':
		showcustomers($dbConn);
		break;
	case 'findID':
		findcustomerbyID($dbConn,$customerID);
		break;
	case 'find':
		findcustomerbyname($dbConn,$firstname,$lastname);
		break;
	case 'update':
		updatedetails($dbConn,$firstname,$lastname,$level,$email,$phonenumber,$password,$customerID);
		break;
	default:
		echo 'Incorrect action';						
		
}


//show all
function showcustomers($dbConn){
	$sql = "select * from Customers";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
            <td>{$row['customerID']}</td>
			<td>{$row['firstname']}</td>
			<td>{$row['surname']}</td>
			<td>{$row['level']}</td>
			<td>{$row['email']}</td>
			<td>{$row['password']}</td>
			<td>{$row['phonenumber']}</td>
			<td>{$row['gender']}</td>
        </tr></br>";
		
    }
}
function findcustomerbyID($dbConn,$customerID){
	$sql = "select * from Customers where customerID = {$customerID}";
	$result = $dbConn->query($sql);
	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
			<b><td>{$row['firstname']}</td>
			<td>{$row['surname']}</td><br></b>
			<td>Customerlevel:</td>
			<td>{$row['level']}</td><br>
			<td>Emailaddress:</td>
			<td>{$row['email']}</td></br>
			<td>Phonenumber:</td>
			<td>{$row['phonenumber']}</td>
			</br>
        </tr></br>";
    }
	
}
function findcustomerbyname($dbConn,$firstname,$lastname){
	$sql = "select * from Customers where firstname = '{$firstname}' and surname = '{$lastname}'";
	$result = $dbConn->query($sql);
	if($result->num_rows<1){
		echo 'Customer does not exist!';
	}
	while($row = $result->fetch_assoc())
    {
        echo"<br><tr>
            <td>{$row['customerID']}</td>
			<td>{$row['firstname']}</td>
			<td>{$row['surname']}</td>
			<td>{$row['level']}</td>
			<td>{$row['email']}</td>
			<td>{$row['password']}</td>
			<td>{$row['phonenumber']}</td>
			<td>{$row['gender']}</td>
        </tr></br>";
    }
	
}

function updatedetails($dbConn,$firstname,$lastname,$level,$email,$phonenumber,$password,$customerID){
	$sql = "update Customers set firstname = '{$firstname}', surname = '{$lastname}',level = {$level},email = '{$email}',phonenumber = '{$phonenumber}',password = '{$password}' where customerID = {$customerID}";
	$result = $dbConn->query($sql);
	if($result){
		echo "customer {$customerID} is updated";
	}
	else echo 'Writing failed!';
	
}
	


	



?>