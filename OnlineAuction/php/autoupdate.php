<?php 
//Update the data automatically per hour
include 'DBconn.php';
include 'bid.php';

autotest($conn);

function autotest($conn){
	
    ignore_user_abort(); 

    set_time_limit(0);
	$sleeptime = 10;
	
	echo 'start working!';

    while(!file_exists('close.txt')){
	  
	   
    updateDutchAuction($conn);
	updateDuration($conn,$sleeptime);
	   
	$myfile = fopen("log.txt", "a");

    $txt = "duration updated!!!  \n  ";

    fwrite($myfile, $txt);

    fclose($myfile);

    sleep($sleeptime);

   }
	
	if(file_exists('close.txt')){
		echo ' finished!';
		return 0;
	}

	
}
//For Dutch auction, the price of an item will keep going down until someone buys it 
function updateDutchAuction($conn){
	
	$status = 0;
	$sql = "update Items set currentprice = currentprice - pricedown where auctiontype = 2 and status = 0 and currentprice >0 ";
	$result = $conn->query($sql);
	if($result){
		$status = 1;
	}
	echo $status;
	
}

//For the experiment, update the duration of every item every 1 hour(instead of 1 days)
function updateDuration($conn,$sleeptime){
	
	$status = 0;
	$sql = "update Items set duration = duration-{$sleeptime} where status = 0";
	$result = $conn->query($sql);
	if($result){
		$status = 1;
		$sql_setovertime = 'update Items set status = 3 where duration = 0';
		$result_setovertime = $conn->query($sql_setovertime);
		if($result_setovertime){
			$sql_selectovertime = 'select * from Items where status = 3 and duration = 0 and auctiontype != 2';
			$result_selectovertime = $conn->query($sql_selectovertime);
			$i = 0;
			while($row = $result_selectovertime->fetch_assoc())
			{
				//select all overtime items and check if transactions can be made on these items
				makeTransaction($conn,$row['itemID']);
			}
		}
	}
	return $status;
	
}


?>