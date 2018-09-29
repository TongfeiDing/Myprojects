// JavaScript Document
function back(){
	"use strict";
	window.location.href="GuestAccount.html"; 
}

function getTable(){
	"use strict";

        var bookRoom = document.getElementById("bookRoom");
        if(bookRoom.style.display === "none"){
           bookRoom.style.display = "block";
        }else if(bookRoom.style.display === "block"){
           bookRoom.style.display = "none";
        }
		else{
			bookRoom.style.display = "block";
		}
}


function passsearchValues(){
	var startdate = document.getElementById("startdate").value;
	var enddate = document.getElementById("enddate").value;
	var type = document.getElementById("filter").value;
	//alert("startdate="+startdate+"&enddate="+enddate+"&type="+type);
	return "startdate="+startdate+"&enddate="+enddate+"&type="+type;
}

function passreserveValues(){
	var startdate = document.getElementById("rstartdate").value;
	var enddate = document.getElementById("renddate").value;
	var roomID = document.getElementById("rroomID").value;
	var customerID = getCookie('username');
	//alert("startdate="+startdate+"&enddate="+enddate+"&roomID="+roomID+"&customerID="+customerID);
	return "startdate="+startdate+"&enddate="+enddate+"&roomID="+roomID+"&customerID="+customerID;
}