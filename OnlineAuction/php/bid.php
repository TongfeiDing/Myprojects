<?php
error_reporting(0);
include 'DBconn.php';


//return a list of items along with this user's bids on this item
function viewBiddingofUser($conn,$userID){
	$status = 0;
    $response = array();
	//select all item whicn is available and is bid by this user
	$sql = "select distinct Items.* from Items inner join Bids on Items.itemID = Bids.itemID and Bids.bidderID = {$userID}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];
		$eachline['bids'] = viewBiddingofItem($conn,$itemID);		
		$resultarr[$i++] = $eachline;
		$status = 1;
			
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
	
}

function viewBiddingofItem($conn,$itemID){
	
	$sql = "select Bids.* from Bids,Items where Items.itemID = Bids.itemID and Items.itemID = {$itemID}";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$resultarr[$i++] = $row;			
       
    }

	return $resultarr;
	
}

function viewTransactionsofUser($conn,$userID){
	$status = 0;
    $response = array();
	//select all item whicn is available and is bid by this user
	$sql = "select * from Items inner join Transactions on Items.itemID = Transactions.itemID and Transactions.buyerID = {$userID} and Items.status = 2";
	$result = $conn->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc())
    {
		$eachline['item']= $row;
		$itemID = $row['itemID'];	
		$resultarr[$i++] = $eachline;
		$status = 1;
			
       
    }
	$response['status'] = $status;
	$response['data'] = $resultarr;
	$conn->close();
	echo json_encode($response);
}

//Bid on an item
function bidItem($conn,$userID){
	$itemID = $_POST['itemID'];
	
	$sql_checktype = "select auctiontype from Items where itemID = {$itemID} and status = 0";
	$result = $conn->query($sql_checktype);
	if($result->num_rows>0)
    {
		$row = $result->fetch_assoc();
		$auctiontype = $row['auctiontype']; 
		//Ebay
	    if($auctiontype == '0'){
		bidinEBay($conn,$userID);
		}
	    //Vickrey
	    else if($auctiontype == '1'){
		bidinVickrey($conn,$userID);
	    }
	    //Dutch
	    else if($auctiontype == '2'){
		bidinDutch($conn,$userID);
	    }
		
    }
	
	else {
		$response = array();
		$response['data'] = 'The auction has ended';
		$response['status'] = 0;
		echo json_encode($response);
	}
	
}

function bidinEBay($conn,$userID){
	$itemID = $_POST['itemID'];
	$price = $_POST['price'];
	
	$status = 0;
    $response = array();
	$response['data'] = 'error';
	$sql_insert = "insert into Bids (itemID,bidderID,price) values ({$itemID},{$userID},{$price})";
	$result_insert = $conn->query($sql_insert);
	//use second price to replace the current price
	updateSecondprice($conn,$itemID);
	$status = 1;
	$response['data'] = 'success';
	
	$response['status'] = $status;
	echo json_encode($response);
	
}

function bidinVickrey($conn,$userID){
	$itemID = $_POST['itemID'];
	$price = $_POST['price'];
	
	$status = 0;
    $response = array();
	$response['data'] = 'error';
	//a user can only bid an item once
	$sql_checkbid = "select * from Bids where itemID = {$itemID} and bidderID = {$userID}";
	$result = $conn->query($sql_checkbid);
	if($result->num_rows>0){
		$response['data'] = 'You can only bid once in Vickrey auction';	
	}
	
	else {
		$sql_insert = "insert into Bids (itemID,bidderID,price) values ({$itemID},{$userID},{$price})";
		$result_insert = $conn->query($sql_insert);
		//use second price to replace the current price
		updateSecondprice($conn,$itemID);
		$status = 1;
		$response['data'] = 'success';
		}
	
	$response['status'] = $status;
	echo json_encode($response);
}

function bidinDutch($conn,$userID){
	$itemID = $_POST['itemID'];
	$price = $_POST['price'];
	
	$status = 0;
    $response = array();
	$response['data'] = 'error';
	
	$sql_select = "select * from Items where itemID = {$itemID} and status = 0 and currentprice <= {$price}";
	$result = $conn->query($sql_select);
	if($result->num_rows>0){
		$sql_insert = "insert into Bids (itemID,bidderID,price) values ({$itemID},{$userID},{$price})";
		$result_insert = $conn->query($sql_insert);
		if($result_insert){
			makeTransaction($conn,$itemID);
			$status = 1;
			$response['data'] = 'success';
		}
	}
	else{
		$response['data'] = 'Sorry,this item is not available now';
	}
	$response['status'] = $status;
	$conn->close();
	echo json_encode($response);
}

//Update the price of an item to the current second price
function updateSecondprice($conn,$itemID){
	$sql_getsp = "select MAX(price) from Bids where price < (select MAX(price) from Bids where itemID = {$itemID}) and itemID = {$itemID}";
	$result_getsp = $conn->query($sql_getsp);
	$row = $result_getsp->fetch_assoc();
	if($row['MAX(price)']>0){
	$sql = "update Items set currentprice = ({$sql_getsp}) where itemID = {$itemID}";
	$result = $conn->query($sql);
	}
	
	
}


//Choose the highest bid and generate a transaction
function makeTransaction($conn,$itemID){
	$sql_selectbid = "select bidderID from Bids where itemID = {$itemID} and price = (select max(price) from Bids where itemID = {$itemID})";
	$result = $conn->query($sql_selectbid);
	//make a transaction for this bidder
	if($result->num_rows>0){
		$row = $result->fetch_assoc();
		$buyerID = $row['bidderID'];
		$sql_maketransaction = "insert into Transactions (itemID,buyerID) values ({$itemID},{$buyerID})";
		$sql_changeitemstatus = "update Items set status = 2, duration = -1 where itemID = {$itemID}";
		
		$conn->query($sql_maketransaction);
		$conn->query($sql_changeitemstatus);
	}
	//no one wins this item, set it overtime
	else{
		$sql_proceededitem = "update Items set duration = -1 where itemID = {$itemID}";
		$conn->query($sql_proceededitem);
		return -3;
	}
}


?>