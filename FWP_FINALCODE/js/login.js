$(function(){
  $('.form').find('input').on('keyup blur focus', function (e) {

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

function loginValues(){
	var details;
	var user = document.getElementById("user").value;
	var password = document.getElementById("password2").value;
    details="user="+user+"&password="+password;
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
		window.location.href="index.php";
	}

	if(obj.success==0){
		alert("invalid username or password, please try again");
	}

}
