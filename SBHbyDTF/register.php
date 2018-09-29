<?php
error_reporting(0);
include("DBTool.class.php");
//posted parameters
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['emailaddress'];
$password = $_POST['password'];


//excuting queries

$dbConn = new DBTool();

$sql1 = "select * from Customers where (email = '{$email}')";
//check if the email has been registered
$result1 = $dbConn->query(sql1);
if(!$result1)
{
	$sql = "insert into Customers (firstname,surname,email,password) values('{$firstname}','{$lastname}','{$email}','{$password}')";
    $result = $dbConn->query($sql);
}
if(!$result)
{
	echo 'Writing failed!';
}

else
{
	echo 'Successful';
}

?>