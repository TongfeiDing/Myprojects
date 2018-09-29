// JavaScript Document
function toRoom(){
	"use strict";
	window.location.href="RoomManager.html"; 
}

function logout(){
	"use strict";
	window.location.href="Login.html"; 
}
function showIDInput(){
	"use strict";
		var enterRoomID = document.getElementById("enterRoomID");
        var modiDetail = document.getElementById("modiDetail");
		var modiReservation = document.getElementById("modiReservation");
        if(enterRoomID.style.display === "none"){
           enterRoomID.style.display = "block";
		   modiReservation.style.display = "none";
 			modiDetail.style.display = "none";
        }else if(enterRoomID.style.display === "block"){ 
           enterRoomID.style.display = "none";
        }
		else{
			enterRoomID.style.display = "block";
			modiReservation.style.display = "none";
			modiDetail.style.display = "none";
		}
    }


function getTable(){
	
	"use strict";
		var enterRoomID = document.getElementById("enterRoomID");
        var modiDetail = document.getElementById("modiDetail");
		var modiReservation = document.getElementById("modiReservation");
        if(modiDetail.style.display === "none"){
           modiDetail.style.display = "block";
		   modiReservation.style.display = "none";
 			enterRoomID.style.display = "none";
        }else if(modiDetail.style.display === "block"){ 
           modiDetail.style.display = "none";
        }
		else{
			modiDetail.style.display = "block";
			modiReservation.style.display = "none";
			enterRoomID.style.display = "none";
		}
    }
function getTableReservation(){
	
	"use strict";
	var enterRoomID = document.getElementById("enterRoomID");
		var modiDetail = document.getElementById("modiDetail");
        var modiReservation = document.getElementById("modiReservation");
        if(modiReservation.style.display === "none"){
           modiReservation.style.display = "block";
			modiDetail.style.display = "none";
			enterRoomID.style.display = "none";

        }else if (modiReservation.style.display === "block"){
           modiReservation.style.display = "none";
        }
		else{
			modiReservation.style.display = "block";
			modiDetail.style.display = "none";
			enterRoomID.style.display = "none";
		}
    }

//Use inputting firstname and lastname to make a data string to ajax
function passName(){
	var firstname = document.getElementById("firstname").value;
	var lastname = document.getElementById("lastname").value;
	return "firstname="+firstname+"&lastname="+lastname;
}

function passcustomerValues(){
	var customerID = document.getElementById("customerID").value;
	var nfirstname = document.getElementById("nfirstname").value;
	var nlastname = document.getElementById("nlastname").value;
	var level = document.getElementById("level").value;
	var emailaddress = document.getElementById("emailaddress").value;
	var password = document.getElementById("password").value;
	var phonenumber = document.getElementById("phonenumber").value;
	return "firstname="+nfirstname+"&lastname="+nlastname+"&level="+level+"&emailaddress="+emailaddress+"&password="+password+"&phonenumber="+phonenumber+"&customerID="+customerID;
}

function passreservationValues(){
	var orderID = document.getElementById("orderID").value;
	var customerID = document.getElementById("nncustomerID").value;
	var roomID = document.getElementById("nnroomID").value;
	var currentstatus = document.getElementById("currentstatus").value;
	var startdate = document.getElementById("startdate").value;
	var enddate = document.getElementById("enddate").value;
	
	return "orderID="+orderID+"&customerID="+customerID+"&roomID="+roomID+"&currentstatus="+currentstatus+"&startdate="+startdate+"&enddate="+enddate;
	
}