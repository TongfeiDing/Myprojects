$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});

function loginValues(){
	var details;
	var user = document.getElementById("user").value;
	var password = document.getElementById("password2").value;
    details="user="+user+"&password="+password;
	return details;
}

function registerValues(){
	var details;
	var firstname = document.getElementById("firstname").value; 
	var lastname = document.getElementById("lastname").value; 
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value; 
	var address = document.getElementById("address").value;
	var email = document.getElementById("email").value; 
	var phoneNo = document.getElementById("phoneNo").value; 
	details="username="+username+"&password="+password+"&email="+email+"&firstname="+firstname+"&lastname="+lastname+"&address="+address+"&phoneNo="+phoneNo;
	return details;
}

function loginCheck(returnjson){
	var obj = JSON.parse(returnjson);
	

	if(obj.success==1){
		alert("Login sucess");
		var data = obj.data;
		setCookie('userID',data.userID,7);
		setCookie('username',data.username,7);
		setCookie('firstname',data.firstname,7);
		setCookie('lastname',data.lastname,7);
		setCookie('address',data.address,7);
		setCookie('email',data.email,7);
		setCookie('phoneNo',data.phoneNo,7);
		setCookie('image',data.image,7);	
		window.location.href="index.html";
	}
	
	if(obj.success==0){
		alert("invalid username or password, please try again");
	}
	
	
	
}

function inputCheck(){
	if(document.getElementById("agreement").checked==true){
	ajaxrequest('php/register.php',registerValues(),null,3,register);
	}
	else alert('please agree the agreement to continue');
}

function register(returnjson){	
	var obj = JSON.parse(returnjson);	
	if(obj.success>=0){
		alert('Register sucess');
		setCookie('userID',obj.sucess,7);
		setCookie('username',document.getElementById("username").value,7);
		setCookie('firstname',document.getElementById("firstname").value,7);
		setCookie('lastname',document.getElementById("lastname").value,7);
		setCookie('address',document.getElementById("address").value,7);
		setCookie('email',document.getElementById("email").value,7);
		setCookie('phoneNo',document.getElementById("phoneNo").value,7);
		setCookie('image',null,7);
		window.location.href="search.html";
		//storeUserdetail(data);
	}
	
	if(obj.success==-1){
		alert('invalid input');
	}
	
	if(obj.success==-2){
		alert('username already exists');
	}
	if(obj.success==-3){
		alert('email already exists');
	}
	
	
	
}


