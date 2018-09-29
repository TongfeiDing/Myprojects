$(function(){
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
})

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
		window.location.href="search.php";
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
