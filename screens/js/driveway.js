
//Angular App Module and Controller
angular.module('mapsApp', [])
.controller('MapCtrl', function ($scope, $http) {


  var mysrclat= 0; var mysrclong = 0;
    
 
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {

                mysrclat = position.coords.latitude; 
                mysrclong = position.coords.longitude;
             
 
    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(mysrclat, mysrclong),
        mapTypeId: google.maps.MapTypeId.TERRAIN
    }

    $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);

    $scope.markers = [];
    var infoWindow = new google.maps.InfoWindow();

    //init autocomplete
		var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
       // $scope.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        $scope.map.addListener('bounds_changed', function() {
          searchBox.setBounds($scope.map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
                      

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
		  $scope.map.setOptions({ maxZoom: 15 });
          $scope.map.fitBounds(bounds);

        });	

		var clearMarkers = function () {
        setMapOnAll(null);
        }
		
		function setMapOnAll(map) {
		
  for (var i = 0; i < $scope.markers.length; i++) {
    $scope.markers[i].setMap(map);
  }
}
		
		var createMarker = function (info){     
        var marker = new MarkerWithLabel({
		    id:info.drivewayID,
            map: $scope.map,
            position: new google.maps.LatLng(info.latitude, info.longitude),
			labelContent: info.price,
			labelAnchor: new google.maps.Point(15, 65),
			icon: pinSymbol('#a185c0'),
            url: baseUrl + "driveway/showdriveway"
        });
        marker.content = '<div class="infoWindowContent">' + info.desc + '</div>';
        
        google.maps.event.addListener(marker, 'click', function(){
			
		 var fromdate = $scope.date1;
	 var todate = $scope.date2;
	
	
	 if(fromdate == '' ){
		$scope.errMessage = 'Please select From Date to Proceed';
      return;
	 }
            $.ajax({
            method: "POST",
            url: baseUrl + "driveway/showdriveway",                       
            data: {id:marker.id},
			dataType: "json",
            success:function(response){
                console.log(response);
				$("label[for='myalue']").html(response.price);
				$("p[for='description']").html(response.description);
				$("#slide1").attr("src", baseUrl +"assets/images/"+response.photo1);
				$("#slide2").attr("src", baseUrl +"assets/images/"+response.photo2);
				$("#slide3").attr("src", baseUrl +"assets/images/"+response.photo3);
				$("#slide4").attr("src", baseUrl +"assets/images/"+response.photo4);
				$('#rootwizard').find('.pager .next').click();
				
            }
        });
        });
        
        $scope.markers.push(marker);
        
    }  
    
    for (i = 0; i < locations.length; i++){
	    
        createMarker(locations[i]);
    }
       
	  $scope.pricerange = "";  
     $scope.filterval = function () {
	 $scope.errMessage = '';
     var rangeprice = $scope.pricerange;
	 var fromdate = $scope.date1;
	 alert(fromdate);
	 var todate = $scope.date2;
	 var curDate = new Date();
	 var previousDay = new Date(curDate);
     previousDay.setDate(curDate.getDate()-1);
	 if(fromdate == '' ){
		$scope.errMessage = 'Please select From Date';
      return;
	 }
	 if(todate == '' ){
		$scope.errMessage = 'Please select To Date';
      return;
	 }
     if(new Date(fromdate) > new Date(todate)){
      $scope.errMessage = 'End Date should be greater than start date';
      return;
    }
    if(new Date(fromdate) < previousDay){
       $scope.errMessage = 'Start date should not be before current date';
       return;
    }
	
	geocoder = new google.maps.Geocoder();      
var address = $scope.location; //input box value
geocoder.geocode( { 'address': address}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
    $scope.map.setCenter(results[0].geometry.location);
    
}else{
$scope.errMessage = 'Enter valid Location';
       return;
}
});
	// if(rangeprice == 2){
	//  $("span[for='date_error']").html('Error');
	//  return;
	// }
	var data = $.param({
                rangeprice: rangeprice,
                fromdate: fromdate,
				todate   : todate
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            $http.post(baseUrl + "driveway/driveway/searchDriveway", data, config)
            .success(function (data, status, headers, config) {
                $scope.cities = data;
				clearMarkers();
               $scope.cities.forEach(function(city) {
               createMarker(city);
           });
            })
            .error(function (data, status, header, config) {
               
            });
	 
    };
	   
        });
		
	/*	
		filterMarkers = function (category) {
    for (i = 0; i < $scope.markers.length; i++) {
        marker = $scope.markers[i];
        // If is same category or category not picked
        if (marker.price == category || category.length === 0) {
            $scope.markers.push(marker);
        }
        
    }
}  */
var pinSymbol = function (color) {
    return {
        path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
        fillColor: color,
        fillOpacity: 1,
        strokeColor: '#000000',
        strokeWeight: 2,
        scale: 2
    };
}

	
	 }else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

	 
	
});