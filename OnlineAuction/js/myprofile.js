// JavaScript Document
function showUserdetails(){
	document.getElementById("usernamelab").innerHTML = 'Hello,'+getCookie('username');
	document.getElementById("emaillab").innerHTML += getCookie('email');
	document.getElementById("phonelab").innerHTML += getCookie('phone');
	
	document.getElementById("email").value = getCookie('email');
	document.getElementById("username").value = getCookie('username');
	document.getElementById("phone").value = getCookie('phone');
	document.getElementById("address").value = getCookie('address');
	document.getElementById("firstname").value = getCookie('firstname');
	document.getElementById("lastname").value = getCookie('lastname');
	if(getCookie('image')!=null&&getCookie('image')!='')
	{document.getElementById("imageshow").src = getCookie('image');}
	//hideEditform();
}

function showEditform(){
	document.getElementById("editprofile").style.display="";
}
function hideEditform(){
	document.getElementById("editprofile").style.display="none";
}

function passValues(){
		var details;
		var userID = getCookie('userID');
	    var username = document.getElementById("username").value;
		var email = document.getElementById("email").value;
		var phone = document.getElementById("phone").value;
		var address = document.getElementById("address").value;
		var firstname = document.getElementById("firstname").value;
		var lastname = document.getElementById("lastname").value;
	    var password = document.getElementById("password").value;
		var action = 'update';
	if(document.getElementById("password").value==document.getElementById("confirm").value&&!(document.getElementById("password").value == null||document.getElementById("password").value == '')){

        details = "action="+action+"&username="+username+"&userID="+userID+"&email="+email+"&phone="+phone+"&address="+address+"&firstname="+firstname+"&lastname="+lastname+"&password="+password;
	    return details;
		
	}
	else if(document.getElementById("password").value == null||document.getElementById("password").value == ''){
		details = "action="+action+"&username="+username+"&userID="+userID+"&email="+email+"&phone="+phone+"&address="+address+"&firstname="+firstname+"&lastname="+lastname;
		alert(details);
		return details;
	}
	else{
		alert('Please input the same password to confirm');
		return null;
	}
}

function refreshDetails(returnjson){
	var obj = JSON.parse(returnjson);	
	if(obj.status>0){
		alert('update success');
		var data = obj.data;
		setCookie('username',data.username,7);
		setCookie('firstname',data.firstname,7);
		setCookie('lastname',data.lastname,7);
		setCookie('address',data.address,7);
		setCookie('email',data.email,7);
		setCookie('phone',data.phone,7);
		setCookie('image',data.photoURL,7);
		window.location.reload();

		
	}
	
}