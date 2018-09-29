
//get current position and return it as an association array like {lat:"",lng""}

function getPosition(){
		if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {			
			var coords = position.coords; 
		    var positionarr = {};			
            positionarr["lat"] = position.coords.latitude;
            positionarr["lng"] = position.coords.longitude;
			var data = JSON.stringify(positionarr);
			

			
			return data;
			 
			

		}, function(error) {
            alert("Please allow location access!");
          });
        } else {
          // Browser doesn't support Geolocation
          alert("This browser is not fit!");
        }
		}// JavaScript Document

function transferPositionfromreturnjson(returnjson){
	var positions = [];
	var obj = JSON.parse(returnjson);
	var data = obj.data;
	var item = null;
	var count = 0;
	for(i in data){	
		var aposition = {};
		aposition["lat"] = parseFloat(data[i].item.gmapLatitude);
        aposition["lng"] = parseFloat(data[i].item.gmapLongitude);
		positions[i] = aposition;
	}
	return positions;
}

//search by address
function codeAddress(address) {             
            //address analysis   
			var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address' : address }, 
			function(results, status) { 
				
                if (status == google.maps.GeocoderStatus.OK) {    
                    //set centre 
					var coords = results[0].geometry.location;
					var aposition = {};
				
					aposition["lat"] =  results[0].geometry.location.lat();
            		aposition["lng"] = results[0].geometry.location.lng();
					
					return aposition;

                       
                } else {    
                    alert("Geocode was not successful for the following reason: " + status);    
                }    
            });    
        }


function initMap(returnjson) {

        var map = new google.maps.Map(document.getElementById('mapResult'), {
          zoom: 14,
          center: {lat: 54.7587, lng: -1.60947
}
        });

        // Create an array of alphabetical characters used to label the markers.
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
	    var locations = transferPositionfromreturnjson(returnjson);
		
        /*var markers = locations.map(function(location, i) {
          return marker = new google.maps.Marker({
            position: location,
            label: labels[i % labels.length],
			title: 'view item information'
          });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
			
			
			*/

    var viewItem = JSON.parse(returnjson);

    var data = viewItem.data;
	var markers = new Array();
	for(i=0;i<locations.length;i++){
		  markers[i] = new google.maps.Marker({
          position: locations[i],
          map: map,
		  title:"view information"
        });
		
		bindListener(markers[i],data[i]);
		

		
	}

      }

function bindListener(marker,data){
	 google.maps.event.addListener(marker, 'click', function (event) {  
        showitem(data);
    });  
}

function showitem(data){

    var item = data;
    var itemdetail = item.item;


    var itemName = itemdetail.name;
    var itemBBD = itemdetail.bestbeforeDate;
    var itemCalorie = itemdetail.calorie;
    var itemDescription = itemdetail.description;
    var itemID = itemdetail.itemID;
    var itemStatus=itemdetail.status;
    var categories = item.categories;

    var category ='';
    if (categories == null)
    {	category = "null";}
    else{
        for (var j=0;j<categories.length;j++)
        {
            category = category +' '+categories[j].name;
        }
    }


    alert(" item ID:"+itemID+
       "\n item name:"+itemName+
       "\n best before date:"+itemBBD+
        "\n Calorie:"+itemCalorie+
        "\n categories:"+category+
		"\n description:"+itemDescription);

}

		