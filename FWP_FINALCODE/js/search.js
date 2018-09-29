var asyncreturn = null;
$(function(){
  updatelastid()
  fillCategories()
  $('#request-button').click(function(){
    //doTransaction()
    $('#request-item-modal').modal('toggle')
    ajaxrequest('php/transactions.php',passIDs(),null,3,makeDeal())
  })
})
//function for transaction
function passIDs(){
    //var uID = document.getElementById("userID").value;
    var uID=getCookie('userID');
    var iID = currentid
    var IDs;
    var action="makedeal";
    IDs="action="+action+"&userID="+uID+"&itemID="+iID;
    return IDs;
}

//view all available items, default userID is 1
function searchAll() {
    //var userID=getCookie('userID');
    var action="viewavailable";
    var searchAll="action=viewavailable&userID=1";
    //alert(searchAll);
    return searchAll;
}

//alert success when finish transaction
function makeDeal(){
    alert('success')
    sendmessage(currentuploader, 'Hi, I have requested the following item from you: ' + citemname)
    search()
}
var currentid = 0
var currentuploader = 0
var citemname = ''
//click transaction button, go to transaction.html
function jump(id, upid, inm){
  currentid = id
  currentuploader = upid
  citemname = inm
  $('#request-item-modal').modal('toggle')
}

//if the checkbox is checked, user can enter distance limit, else user can not use this element
function activateDistance(){
    if (document.getElementById("positioncheckbox").checked) {
        document.getElementById("distancelimit").disabled = false;}
        else{
        document.getElementById("distancelimit").disabled = true;
    }
}

//pass keyword+ categories+ lat+ lng+ distance limit
function search() {
  $('#searchResult').empty();
    this.asyncreturn = getCa();
    if (document.getElementById("positioncheckbox").checked) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var coords = position.coords;
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var dis = document.getElementById("distancelimit").value;

                this.asyncreturn += "&lat="+lat+"&lng="+lng+"&distancelimit="+dis;
                ajaxrequest('php/search2.php',asyncreturn,'searchResult',3,viewItems);
                //alert(asyncreturn);


            }, function (error) {
                alert("Please allow location access!");
            });
        } else {
            // Browser doesn't support Geolocation
            alert("This browser is not fit!");
        }



    }

    else ajaxrequest('php/search2.php',asyncreturn,'searchResult',3,viewItems);

}

//pass keyword+ categories
function getCa(){
    var ca1=document.getElementById("categories1").value;
    var ca2=document.getElementById("categories2").value;
    var ca3=document.getElementById("categories3").value;


    var keyword = document.getElementById("receivedword").value;
    var count = 0;
    var categories=""
    var searchdetail=""
    if(ca1!=""){ searchdetail += "categories[]=" + ca1;count++;}
    if(ca2!=""){ if(searchdetail != "") searchdetail += "&"; searchdetail += "categories[]=" + ca2;count++;}
    if(ca3!=""){ if(searchdetail != "") searchdetail += "&"; searchdetail += "categories[]=" + ca3;categories[count]=ca3;count++;}

    if(keyword != null && keyword != ''){
      if(searchdetail != "") searchdetail += "&";
      searchdetail+="receivedword=" + keyword
    }
    //searchdetail += "categories="+JSON.stringify(categories);
    console.log(searchdetail)
    return searchdetail;
}

function sendmessage(userid, content){
  var id = getCookie('userID')


  $.ajax({
    url: 'php/' + 'messages.php',
    type: "POST",
    dataType: 'json',
    data: {action: "send", userID: id, oppositeID: userid, content: content.trim()},
    success: function(response){

    }
  })

}

//function to display all available items
function viewItems(jsonText)
{
    var html = "";
    var returnjson= jsonText;
    var viewItem = JSON.parse(returnjson);

    var data = viewItem.data;
    if(data){


      for (var i=0;i<data.length;i++)
      {
          var item = data[i];
          var itemdetail = item.item;


          var itemName = itemdetail.name;
          var itemBBD = itemdetail.bestbeforeDate;
          var itemCalorie = itemdetail.calorie;
          var itemDescription = itemdetail.description;
          var itemID = itemdetail.itemID;
          var itemStatus=itemdetail.status;
          var categories = item.categories;
          var quantity=itemdetail.quantity;
          var username = itemdetail.username;
          var uploader = itemdetail.uploaderID;

          var category ='';
          if (categories != null){
              for (var j=0;j<categories.length;j++)
              {
                  category += "<mark>"+categories[j].name+"</mark>";
              }
          }
          buttons = ""
          if(getCookie('userID') != null && getCookie('userID') != ""){
            buttons = " <div class='btn-group-vertical pull-right'>" +
            "<button type='button' class='btn btn-primary' >Message</button>"+
            "<button type='button' class='btn btn-primary' onclick=jump(" + parseInt(itemID) + "," + parseInt(uploader) + ",'" + itemName + "') >Transaction</button>" +
            "<p id='itemID' hidden>"+ itemID +"</p>"+
            "</div>"
          }

          html +=
              "<div class='list-group-item'>"+
              "<div class='row'>"+
              "<div class='col-md-9'>"+
              "<div class='media'>"+
              "<div class='media-left'>"+
              " <img src='images/item-noimage.jpg' class='media-object' style='width:120px'>"+
              " </div>"+
              " <div class='media-body'>"+
              "<h4 class='media-heading'>"+itemName+"</h4>"+
              "<p class='best-before'>Best Before: <span>"+ itemBBD +"</span></p>"+
              "<p class='calories'>Calories: "+ itemCalorie +"</p>"+
              "<p class='description'><i>"+ itemDescription +"</i></p>"+

              "<p class='qty'>Qty: "+ quantity +"</p>"+
              "<p><a href ='https://www.google.com/maps/search/?api=1&query="+itemdetail.gmapLatitude+","	+ itemdetail.gmapLongitude+"' target='_blank'>View location</a></p>"+
              "<p class='categories'>"+ category +"</p>"+
              "<p class='user-tag'>User: @<mark class='user-mark'>"+username+"</mark></p>"+
              " </div>"+
              " </div>"+
              " </div>"+
              "<div class='col-md-3'>"+
               buttons +
              " </div>"+
              "</div>"+
              "</div>";

      }
    }
    else{
      html="";
    }

    initMap(jsonText);

    return html;
}

function fillCategories(){
  $.get('php/getcategories.php', null, function(response){

    for(var i = 1; i<=3; i++){
      var td = $('<td></td>')
      var select = $('<select></select>')
                      .attr('name', 'search-type').attr('id','categories'+i)
      response.forEach(function(element){
        select.append(
          $('<option></option>').attr('value', element.name).attr('selected', '')
            .text(element.name)
        )
      })

      select.append(
        $('<option></option>').attr('value', '').attr('selected', '')
          .text('None')
        )
      td.html(select)

      $('#cat-selectors').append(td)
      $('#cat-selectors').append($('<br>'))
    }
    /*
    <td>
        <select name="search-type" id="categories1">
            <option value="Italian" selected>Italian</option>
            <option value="Sweets" selected>Sweets</option>
            <option value="Savoury dish" selected>Savoury dish</option>
            <option value="Vegetarian" selected>Vegetarian</option>
            <option value="Vegan" selected>Vegan</option>
            <option value="Gluten Free" selected>Gluten Free</option>
            <option value="Low Fat" selected>Low Fat</option>
            <option value="Mexican" selected>Mexican</option>
            <option value="Chinese" selected>Chinese</option>
            <option value="Japanese" selected>Japanese</option>
            <option value="French" selected>French</option>
            <option value="Pasta" selected>Pasta</option>
            <option value="Pizza" selected>Pizza</option>
            <option value="Canned" selected>Canned</option>
            <option value="Fruits and vegetables" selected>Fruits and vegetables</option>
            <option value="Other" selected>Other</option>
            <option value="" selected>None</option>
        </select>
    </td> */
  }, 'json')
}

function updatelastid(){
  var id = getCookie('userID')
	if(id != null && id > 0){
		$.ajax({
	    url: 'php/' + 'updatelastid.php',
	    type: "POST",
	    dataType: 'json',
	    data: { userID: id},
	    success: function(response){
        console.log(response)
	    }
	  })
	}

}
