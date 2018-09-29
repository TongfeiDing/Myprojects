
	/*
	This files is for items' management and interaction with map.

	*/


//Global Variables
var positionX = null;
var positionY = null;
var addressX =null;
var addressY = null;
var address1 =null;
window.onload=getCurrentLocation();


/*
	Http method: POST
	Input (body) parameters
		userid : the id of user


	Returns a JSON text with a 'success' key.
	If the success key is 1, the login is valid
	and the data of the user will be returned with
	the following format:
	{
		"success":1,
		"data":{
			"userID":id,
			"itemname":"itemname",
			"calorie":"colorie of this item,
			"description":"description of this item",
			"quantity":"quantity of this item",
			"uploadDate":"the uploadDate information of this item",
			"uploadDate":"the uploadDate id of this item",
			"best before date":"the best before date of this item.",
			"image":"relative url to the profile image. It should be appended to the base URL defined at the beginning of this document"
		}
		"categories"
		{
			"categories[]": "an array of categories"

		}
	}
	When the request is not success, the following error codes may arise:
		0: there is no items uploaded by this user

*/
function viewItems(jsonText)
{


			  var html = "";
         var returnjson= jsonText;
         var viewItem = JSON.parse(returnjson);

		 var data = viewItem.data;
         if (viewItem.success == 0)
			 {
				 initMap(returnjson);
				 return "no relevant item";

			 }
	else {
for (var i=0;i<data.length;i++)
{
	var item = data[i];
    var itemdetail = item.item;


	var itemName = itemdetail.name;
    var itemID = itemdetail.itemID;
	var itemCalorie = itemdetail.calorie;
	var itemDescription = itemdetail.description;
	var quantity = itemdetail.quantity;
	var itemUploadDate = itemdetail.uploadDate;
	var itemUploaderID = itemdetail.uploaderID;
	var itemBestbeforeDate = itemdetail.bestbeforeDate;
	var itemImgURL = itemdetail.picURL
	var categories = item.categories;

	var category ='';
	if (categories != null){
			for (var j=0;j<categories.length;j++)
			{
					category += "<mark>"+categories[j].name+"</mark>";
			}
	}


	html = html +
			"<div class='list-group-item' id='itemlist'>"+
			"<div class='row'>"+
            "<div class='col-md-9'>"+
            "<div class='media'>"+
            "<div class='media-left media-middle'>"+
            " <img src='php/"+ itemImgURL + "' class='media-object' style='width:120px'>"+
            " </div>"+
            " <div class='media-body'>"+
            "<h4 class='media-heading'>"+itemName+"</h4>"+
						"<p class='best-before'>Best Before: <span>"+ itemBestbeforeDate +"</span></p>"+
						"<p class='calories'>Calories: "+ itemCalorie +"</p>"+
						"<p class='description'><i>"+ itemDescription +"</i></p>"+
						"<p class='qty'>Qty: "+ quantity +"</p>"+
						"<p><a href ='https://www.google.com/maps/search/?api=1&query="+itemdetail.gmapLatitude+","	+ itemdetail.gmapLongitude+"' target='_blank'>View location</a></p>"+
						"<p class='categories'>"+ category +"</p>"+
            " </div>"+
            " </div>"+
            " </div>"+
            "<div class='col-md-3'>"+
            " <div class='btn-group-vertical pull-right'>"+

            "<a button type='button' class='btn btn-primary'" +"id ="+itemID+" data-toggle='modal' data-target='#itemView"+itemID+"'>View</button>"+
			"</a>"+

    		"<a button type='button' class='btn btn-primary open-updateModal' data-toggle='modal' data-id='"+itemID+"' data-target='#itemUpdate'>Update</button>"+
			"</a>"+

            "<a button type='button' class='btn btn-danger open-removeModal' data-toggle='modal' data-id='"+itemID+"' data-target='#itemRemove'>Remove</button>"+
			"</a>"+
            "</div>"+
          	" </div>"+
          	"</div>"+
        	"</div>"+"<!-- Modal -->"+

   "<div class='modal fade' id='itemView"+itemID+"' role='dialog'>"+
      "<div class='modal-dialog'>"+
        "<!-- Modal content-->"+
        "<div class='modal-content'>"+
          "<div class='modal-header'>"+
            "<button type='button' class='close' data-dismiss='modal'>&times;</button>"+
            "<p><span class='glyphicon glyphicon-apple'></span>Item information</p></div>"+
          "<div class='modal-body'>"+
            "<div class='media'>"+
              "<div class='media-left media-middle'>"+
                "<img src='php/"+ itemImgURL + "' class='media-object' style='width:150px'>"+
              "</div>"+
				"<div class='media-body'>"+
                "<h4 class='media-heading'>"+ itemName +"</h4>"+
				"<p class='media-heading'> Calorie: " + itemCalorie +"</p>"+
				"<p class='media-heading'> Description:"+ itemDescription +"</p>"+
				"<p class='media-heading'> Quantity:"+ quantity +"</p>"+
				"<p class='media-heading'> Upload date:"+ itemUploadDate +"</p"+
				"<p class='media-heading'> Best before:"+ itemBestbeforeDate +"</p>"+
				"<p class='media-heading'> Categories: "+ category +"</p>"+
				"</div></div></div>"+
          "<div class='modal-footer'>"+
            "<button type='submit' class='btn btn-default' data-dismiss='modal'>Cancel</button>"+
          "</div></div></div></div>"
	;

}

        initMap(returnjson);
		return html;
   }

}


/*
	a method to get itemID by URL of html
*/

	function getID()
{
	var url = location.search;
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("=");

    }
		var itemID =strs[1];

	return itemID;

}

/*
	Http method: POST
	Form (body) parameters

		itemname: name of this item.
	 	calorie: colorie of this item.
		description: description of this item.
		quantity: quantity of this item.
		best before date: the best before date of this item.
		categories: the categories of this item
		picture: the picture information of item
		lgmapatitude: the latitude of this item
		gmapLongitude : the longitude of this item
		}

	Returns a JSON text with a 'success' key.
	If the success key is 1, the login is valid
	and the data of the user will be returned with
	the following format:
	{
		"success":1,
		"data":{
			"updated"
		}

	}
	When the request is not success, the following error codes may arise:
		0: this item is not exsited
	*/

function update()
{
	var id =getCookie('userID');
	var url = location.search;
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("=");

    }
		//var itemID =strs[1];
	var categories = new Array();
	$('input:checkbox:checked[name="check1"]').each(function(i) {  categories[i] = this.value; });

	var itemID = document.getElementById("hid").value;
	var form = $('#item-input-elements-formm')[0];
	var formData = new FormData(form);
	formData.append('userID', id);
	formData.append('action', 'update');
	formData.append('itemID', itemID);
	for(var i = 0; i<categories.length; i++){
		formData.append('categories[]', categories[i]);
	}
	if(document.getElementById("currentposition").checked)
		{
	formData.append('gmapLatitude', positionX);
	formData.append('gmapLongitude', positionY);
		}
	else
		{
			getAddress(document.getElementById("position").value);
			formData.append('gmapLatitude', addressX);
			formData.append('gmapLongitude', addressY);

		}

        for (var pair of formData.entries()) {
          console.log(pair[0]+ ', ' + pair[1]);
        }

		alert("updated!");
	$.ajax({
		url: 'php/items.php',
		type: "POST",
		dataType: 'json',
		data: formData,
		contentType: false,
		processData: false,
		success: function(response){
		  console.log(response);
		}
	})

	window.location.href='items.html';
}


/*
	Http method: POST
	Form (body) parameters

		itemname: name of this item.
	 	calorie: colorie of this item.
		description: description of this item.
		quantity: quantity of this item.
		best before date: the best before date of this item.
		categories: the categories of this item
		picture: the picture information of item
		lgmapatitude: the latitude of this item
		gmapLongitude : the longitude of this item
		}

	Returns a JSON text with a 'success' key.
	If the success key is 1, the login is valid
	and the data of the user will be returned with
	the following format:
	{
		"success":1,
		"data":{
			"inserted"
		}

	}
	When the request is not success, the following error codes may arise:
		0: some information is not suitable for the database format
	*/


function add()
{
	var id =getCookie('userID');
	var categories = new Array();
	$('input:checkbox:checked[name="check1"]').each(function(i) {  categories[i] = this.value; });


	var form = $('#item-input-elements-form')[0];
	var formData = new FormData(form);

	formData.append('userID', id);
	formData.append('action', 'add');
	for(var i = 0; i<categories.length; i++){
		formData.append('categories[]', categories[i]);
	}

	if(document.getElementById("currentposition2").checked)
		{
	formData.append('gmapLatitude', positionX);
	formData.append('gmapLongitude', positionY);
		}
	else
		{
			getAddress(document.getElementById("position2").value);
			formData.append('gmapLatitude', addressX);
			formData.append('gmapLongitude', addressY);

		}

		alert("added!");

	$.ajax({
		url: 'php/items.php',
		type: "POST",
		dataType: 'json',
		data: formData,
		contentType: false,
		processData: false,
		success: function(response){
		  console.log(response);
		}
	})
	//ajaxrequest("items.php","action=add&"+addPassValues(),"",3,null);
	//window.location.href='items.html';
	window.location.href='items.html';
}


/*
	Http method: POST
	pass parameters

		itemid: id of this item.

		}

	Returns a JSON text with a 'success' key.
	If the success key is 1, the login is valid
	and the data of the user will be returned with
	the following format:
	{
		"success":1,
		"data":{
			"removed"
		}

	}
	When the request is not success, the following error codes may arise:
		0: this item is not existed.
	*/

function remove()
{
        var removeID = document.getElementById("rhid").value;
        ajaxrequest("php/items.php","action=remove&itemID="+removeID,"result",3,null);
	    alert("removed");
	    window.location.href='items.html';
}


/*
	A method to get latitude and longitude via google map of current position
	*/

function getCurrentLocation(){
 if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
   var coords = position.coords;
            positionX = position.coords.latitude;
            positionY = position.coords.longitude;

     }, function(error) {
            alert("Please allow location access!");
          });
        } else {
          // Browser doesn't support Geolocation
          alert("This browser is not fit!");
        }
}


/*
	A method to get latitude and longitude via google map of input address
	*/

function getAddress(address) {
            //address analysis
			var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address' : address },
			function(results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    //set centre
					var coords = results[0].geometry.location;


					addressX =  results[0].geometry.location.lat();
            		addressY = results[0].geometry.location.lng();



                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }
