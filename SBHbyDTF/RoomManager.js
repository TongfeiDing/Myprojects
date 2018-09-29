// JavaScript Document
function toCustomer(){
	"use strict";
	window.location.href="CustomerManager.html"; 
}

function getTable(){
	"use strict";

        var modifyRoom = document.getElementById("modifyRoom");
        if(modifyRoom.style.display === "none"){
           modifyRoom.style.display = "block";
        }else if(modifyRoom.style.display === "block"){
           modifyRoom.style.display = "none";
        }
		else{
			modifyRoom.style.display = "block";
		}
}


//pass values from the input areas to the server as an ajax data String
function passValues(){
	var roomID = document.getElementById("roomID").value;
	var type = document.getElementById("type").value;
	var price = document.getElementById("price").value;
	var available = document.getElementById("available").value;
	return "roomID="+roomID+"&type="+type+"&price="+price+"&available="+available;
}



