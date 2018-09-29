<?php
error_reporting(0);
include("DBTool.class.php");

//posted parameters
$inputname = $_POST['emailaddress'];

$password = $_POST['password'];


//excuting queries

$dbConn = new DBTool();

$sql1 = "select * from Customers where (email = '{$inputname}' or phonenumber = '{$inputname}') and password = '{$password}'";
$sql2 = "select * from Managers where (adminusername = '{$inputname}') and password = '{$password}'";

$result1 = $dbConn->query($sql1);
$result2 = $dbConn->query($sql2);

if($result1->num_rows>0){
  $row = $result1->fetch_assoc();
  echo $row['customerID'];
}

else if($result2->num_rows>0){
  echo 'manager';
}

else {
  echo 'failed';
}

?>

