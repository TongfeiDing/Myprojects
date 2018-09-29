// JavaScript Document

//Remove default values from input boxes
function removePlaceholder(element,placeholder){
	if(element.value==placeholder){
		element.value='';
	    element.style.color='black';
		if(placeholder=='Password'){
			element.type='password';
		}
	}
}
//Show default values in input boxes
function setPlaceholder(element,placeholder){
	if(element.value==''||element.value==placeholder){
		element.value=placeholder;
		element.style.color='gray';
		if(placeholder=='Password'){
			element.type='text';
		}
	}
}

function loginValues(){
	if(checkLoginvalues()){
		var details;
	    var user = document.getElementById("user").value;
	    var password = document.getElementById("password").value;
        details = "user="+user+"&password="+password;
	    return details;
		
	}
	else{
		return null;
	}

}

function registerValues(){	
	if(checkRegistervalues()){
		var details;
	    var username = document.getElementById("username").value;
		var email = document.getElementById("email").value;
		var phone = document.getElementById("phone").value;
	    var password = document.getElementById("password").value;
        details = "username="+username+"&email="+email+"&phone="+phone+"&password="+password;
	    return details;
		
	}
	else{
		
		return null;
	}

}


function checkLoginvalues(){
	var user = document.getElementById("user").value;
	var password = document.getElementById("password").value;
	if(user == null||user == ''||user == 'Emailaddress/Username'){
		alert('please input correct username/email');
		return false;
	}
	if(password == null||password == ''||password == 'Password'){
		alert('please input password');
		return false;
	}
	
	else return true;
	
	
}

function checkRegistervalues(){
	var username = document.getElementById("username").value;
	var email = document.getElementById("email").value;
	var phone = document.getElementById("phone").value;
	var password = document.getElementById("password").value;
	if(username == null||username == ''||username == 'Username'){
		alert('please input username');
		return false;
	}
	
	if(email == null||email == ''||email == 'Emailaddress'){
		alert('please input email');
		return false;
	}
	
	if(phone == null||phone == ''||phone == 'PhoneNo'){
		alert('please input phoneNo');
		return false;
	}
	
	if(password == null||password == ''||password == 'Password'){
		alert('please input password');
		return false;
	}
	
	if(document.getElementById("agreement").checked==false){
		alert('you must agree the agreement to continue');
		return false;
	}
	
	else return true;
	
	
}

function login(returnjson){
	var obj = JSON.parse(returnjson);
	

	if(obj.status==1){
		alert("Login success");
		var data = obj.data;
		setCookie('userID',data.userID,7);
		setCookie('username',data.username,7);
		setCookie('firstname',data.firstname,7);
		setCookie('lastname',data.lastname,7);
		setCookie('address',data.address,7);
		setCookie('email',data.email,7);
		setCookie('phone',data.phone,7);
		setCookie('image',data.photoURL,7);	
		window.location.href="itemlist.php";
	}
	
	if(obj.status==0){
		alert("incorrect username or password, please try again");
	}
	
	
	
}

function register(returnjson){	
	var obj = JSON.parse(returnjson);	
	if(obj.status>0){
		var data = obj.data;
		alert('Register sucess');
		setCookie('userID',obj.status,7);
		setCookie('username',data.username,7);
		setCookie('firstname',data.firstname,7);
		setCookie('lastname',data.lastname,7);
		setCookie('address',data.address,7);
		setCookie('email',data.email,7);
		setCookie('phone',data.phone,7);
		setCookie('image',data.photoURL,7);
		window.location.href="myprofile.php";

		
	}
	
	if(obj.status==-1){
		alert('username already exists');
	}
	
	if(obj.status==-2){
		alert('email already exists');
	}
	if(obj.status==-3){
		alert('phone number already exists');
	}
	
	
	
}

function showAgreement(){
	alert('Thank you!');
}

