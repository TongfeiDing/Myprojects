<?php
error_reporting(0);
include 'bid.php';

//posted parameters
$action = $_POST['action'];
$userID = $_POST['userID']; 


switch($action){
	
	case 'viewuserbidding':
		viewBiddingofUser($conn,$userID);
		break;
	case 'viewitembidding':
		viewBiddingofItem($conn,$_POST['itemID']);
	case 'viewtransactions':
		viewTransactionsofUser($conn,$userID);
		break;
	case 'bid':
		bidItem($conn,$userID);
		break;
	case 'makedeal':
		makeTransaction($conn,$_POST['itemID']);
		break;	
	default:
		echo 'Incorrect action';						
		
}



?>