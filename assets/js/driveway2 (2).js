$(document).ready(function() {
    $('#input-3').rating({displayOnly: true, step: 0.1});
    $('#input-4').rating({displayOnly: true, step: 0.1});
    var usernameG;
    var phoneG;
    var emailIDG;
    var addressG;
    var instructionsG;
    var priceG;
    var totalPriceG;
    var drivewayIdG;
    var fromDateG;
    var toDateG;
    var ownerIdG;
    var fromTimeG;
    var toTimeG;
    var latiG;
    var longiG;    
    var drivewayuserIdG;
    var filterG ;
    var locationG;
    var filterPriceG;
    var optionG;
    var mysrclat;
    var mysrclong;
    var markers = [];
    var search_latlangG;
    var locationltlnG;					
    var userIdG = $('#loggedUser').val();
    var hourChargeG=[];
    var searchTypeG =[];
    var hourlyPriceGl=0;
    var hourlyPrice = 0;
    var proc_feeG = 0;    
    var c_latG = 0;
    var c_longG = 0;
    var search_latG;	
    var search_lngG;
    var goclick = 0;
    var stripeChargeFeeC = 2.9;
    var stripeProcessFeeC = 0.3;
    var applicationFeeC = 1.23;
    //if browser supports geolocation
    if (navigator.geolocation)
    {
        search_latlangG = '37.090240,-95.712891';
        locationltlnG   = '(37.090240,-95.712891)';
        search_latG     = '37.090240';	
        search_lngG     = '-95.712891';		
        // generate map if location is not shared
        var mapOptions  = {
                    zoom    : 6,
                    minZoom : 5,
                    center  : {
                            lat : 37.090240,
                            lng : -95.712891
                    },
                    mapTypeId : google.maps.MapTypeId.roadmap
        }
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        $.each(locations,function() 
        {
            if (this.dPrice != null) {
                var newPrice = this.dPrice;
            } else {
                var newPrice = this.price;
            }
            var marker = new MarkerWithLabel(
            {
                    id 			: this.drivewayID,
                    address1		: this.building,
                    address2		: this.route,
                    address3 		: this.streetAddress,
                    address4 		: this.city,
                    address5 		: this.state,
                    address6 		: this.zip,
                    map                 : map,
                    drivewayuserIdG     : this.userID,
                    position		: new google.maps.LatLng(this.latitude,this.longitude),
                    labelClass 		: 'maplabels',
                    labelContent 	: '$'+ newPrice,labelAnchor : new google.maps.Point(15, 65),
                    icon 		: {
                                            path 			: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
                                            fillColor 		: '#a185c0',
                                            fillOpacity 	: 1,
                                            strokeColor 	: '#000000',
                                            strokeWeight 	: 1,
                                            scale 			: 2
                                        }
            });					
            marker.content = '<div class="infoWindowContent">'+ this.desc + '</div>';
            google.maps.event.addListener(marker,'click',function() 
            {
                var datevalid = $('#date_valid').val();
                if (datevalid == '') {
                        infowindow1.setContent('<div id="content">'
                            + '<div id="bodyContent">'
                            + marker.address1
                            + '<br />'
                            + marker.address3
                            + ' ,&nbsp'
                            + marker.address2
                            + '<br />'
                            + marker.address4
                            + ' ,&nbsp'
                            + marker.address6
                            + '&nbsp'
                            + marker.address5
                            + '<br />'
                            + '(Please enter search criteria to proceed further)'
                            + '</div>'
                            + '</div>');
                        infowindow1.open(map,marker);
                }
                else if (marker.drivewayuserIdG == userIdG) {
                        infowindow3.setContent('<div id="content">'
                            + '<div id="bodyContent">'
                            + marker.address1
                            + '<br />'
                            + marker.address3
                            + ' ,&nbsp'
                            + marker.address2
                            + '<br />'
                            + marker.address4
                            + ' ,&nbsp'
                            + marker.address6
                            + '&nbsp'
                            + marker.address5
                            + '</div>'
                            + 'Hey this is your driveway'
                            + '</div>');
                        infowindow3.open(map,marker);
                }
                else if (datevalid == 'valid') {
                        infowindow2.setContent('<div id="content">'
                            + '<div id="bodyContent">'
                            + marker.address1
                            + '<br />'
                            + marker.address3
                            + ' ,&nbsp'
                            + marker.address2
                            + '<br />'
                            + marker.address4
                            + ' ,&nbsp'
                            + marker.address6
                            + '&nbsp'
                            + marker.address5
                            + '</div>'
                            + '<a href="#" onclick="myFunction('
                            + marker.id
                            + ')">Click here to view this driveway</a>'
                            + '</div>');
                        infowindow2.open(map, marker);
                }
            });
            markers.push(marker);
        });

        // generate map if location is shared
        navigator.geolocation.getCurrentPosition(function(position) {
            mysrclat 		= position.coords.latitude;
            mysrclong 		= position.coords.longitude;		
            search_latlangG = mysrclat+','+mysrclong;
            locationltlnG	= mysrclat+','+mysrclong;	
            search_latG         = mysrclat;	
            search_lngG         = mysrclong;
            var mapOptions      = {
                    zoom      : 6,
                    minZoom   : 5,
                    center    : new google.maps.LatLng(mysrclat,mysrclong),
                    mapTypeId : google.maps.MapTypeId.roadmap
            }
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            for (i = 0; i < locations.length; i++) {
                createMarker(locations[i]);
            }
	});
	
        //create marker function to create the marker
        createMarker = function(info) 
        {					
            if (info.dPrice != null) {
                var newPrice = info.dPrice;
            } else if(searchTypeG[info.drivewayID] == 3){								
                var newPrice = info.dailyprice;
            }else{								
                var newPrice = info.price;
            }		
            var marker = new MarkerWithLabel({
                    id 		 	     : info.drivewayID,
                    address1 		 : info.building,
                    address2		 : info.route,
                    address3 		 : info.streetAddress,
                    address4 		 : info.city,
                    address5 	     : info.state,
                    address6 		 : info.zip,								
                    map			     : map,
                    drivewayuserIdG  : info.userID,
                    position 		 : new google.maps.LatLng(info.latitude, info.longitude),
                    labelClass 		 : 'maplabels',
                    labelContent     : '$' + newPrice,
                    labelAnchor      : new google.maps.Point(15, 65),
                    icon             : pinSymbol('#a185c0')
            });
	
            google.maps.event.addListener(marker,'click',function() 
            {
                var datevalid = $('#date_valid').val();			
                //shree modified below line. correct all infowindow logic
                var infowindowcontent='<div id="content">'
                    + '<div id="bodyContent">'
                    + marker.address1
                    + '<br />'
                    + marker.address3
                    + ' ,&nbsp'
                    + marker.address2
                    + '<br />'
                    + marker.address4
                    + ' ,&nbsp'
                    + marker.address6
                    + '&nbsp'
                    + marker.address5
                    + '<br />';
                if (datevalid == '') {				
                    infowindowcontent=infowindowcontent	+ '(Please enter search criteria to proceed further)';
                    infowindowcontent=infowindowcontent	+ '</div>'+ '</div>'
                }
                else if (marker.drivewayuserIdG == userIdG) {
                    infowindowcontent=infowindowcontent	+ '</div>((Please enter search criteria to proceed further)</div>';
                }
                else if (datevalid == 'valid') {
                    infowindowcontent=infowindowcontent	+ '</div>((Please enter search criteria to proceed further)</div>';
                }				
                if (datevalid == '') {
                    infowindow1.setContent('<div id="content">'
                        + '<div id="bodyContent">'
                        + marker.address1
                        + '<br />'
                        + marker.address3
                        + ' ,&nbsp'
                        + marker.address2
                        + '<br />'
                        + marker.address4
                        + ' ,&nbsp'
                        + marker.address6
                        + '&nbsp'
                        + marker.address5
                        + '<br />'
                        + '(Please enter search criteria to proceed further)'
                        + '</div>'
                        + '</div>');
                    infowindow1.open(map,marker);
                }
                else if (marker.drivewayuserIdG == userIdG) {												
                    infowindow3.setContent('<div id="content">'
                        + '<div id="bodyContent">'
                        + marker.address1
                        + '<br />'
                        + marker.address3
                        + ' ,&nbsp'
                        + marker.address2
                        + '<br />'
                        + marker.address4
                        + ' ,&nbsp'
                        + marker.address6
                        + '&nbsp'
                        + marker.address5
                        + '</div>'
                        + 'Hey this is your driveway'
                        + '</div>');
                    infowindow3.open(map,marker);
                }
                else if (datevalid == 'valid') {
                    infowindow2.setContent('<div id="content">'
                        + '<div id="bodyContent">'
                        + marker.address1
                        + '<br />'
                        + marker.address3
                        + ' ,&nbsp'
                        + marker.address2
                        + '<br />'
                        + marker.address4
                        + ' ,&nbsp'
                        + marker.address6
                        + '&nbsp'
                        + marker.address5
                        + '</div>'
                        + '<a href="#" onclick="myFunction('
                        + marker.id
                        + ')">Click here to view this driveway</a>'
                        + '</div>');
                    infowindow2.open(map,marker);
                }
	    });
            markers.push(marker);
	}
        // init autocomplete
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        // Listen for the event fired when the user selects a
        // prediction and retrieve more details for that place.
        searchBox.addListener('places_changed',function() {
           // alert('changed');
            $('#error').html('');						
            var places = searchBox.getPlaces(); 											
            if (places.length == 0) {
                    $('#error').html('Enter valid Location');
                    return;
            }
            // For each place, get the icon,
            // name and location.
            var bounds = new google.maps.LatLngBounds();						
            places.forEach(function(place) {		
                locationltlnG = place.geometry.location;
                search_latG = place.geometry.location.lat();
                search_lngG = place.geometry.location.lng();
                if (!place.geometry) {
                    $('#error').html('Returned place contains no geometry');														
                    return;
                }									
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);					 
                } else {
                    bounds.extend(place.geometry.location);					  
                }										
                map.setCenter(place.geometry.location);										
            });	 
						
            map.setOptions({
                maxZoom : 23
            });
            map.setOptions({
                minZoom : 9
            });
            map.fitBounds(bounds);
            if(map.getZoom() > 19){
                map.setZoom(19); 
            }						
	});

	// function for filtering date, location and price
        pricerange = "";
        filterval = function() {
            var check = 0;
            goclick   = 1;            
            $('#date_valid').val('');
            $('#errMessage').html('');
            $('#errMessage1').html('');
            $('#error').html('');
            var rangeclick  = $('#prangeset').val();
            var option 	    = $("input[name=bookingoption]:checked").val();
            optionG         = option;
            
            if (rangeclick == '') {
                var rangeprice = '';
            } else {
                var rangeprice = $('#pricerange').val();
            }
            filterPriceG    = rangeprice;
            var address    = $('#pac-input').val();// input box value	
            locationG      = address;
           // alert(locationG);
            if(!locationG) { 
            //   if ($('#location').val() == ''){ 
                if (address != '') {
                    var places = searchBox.getPlaces();
                    if (typeof places === "undefined") {
                        $('#error').html('Enter valid Location');
                        check = 1;
                        return;
                    }
                    if (places.length == 0) {
                        $('#error').html('Enter valid Location');
                        check = 1;
                        return;
                    }
                    // For each place, get the icon, name and location								
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {								
                        if (!place.geometry) {
                            $('#error').html('Returned place contains no geometry');
                            check = 1;
                            return;
                        }
                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                        search_latG = place.geometry.location.lat();
                        search_lngG = place.geometry.location.lng();
                        map.setCenter(place.geometry.location);
                    });
                    map.setOptions({
                        maxZoom : 25
                    });
                    map.setOptions({
                        minZoom : 9
                    });			
                    map.fitBounds(bounds);
                    if(map.getZoom() > 19){
                        map.setZoom(19); 
                    }
                }                
           }
            var fromdate	 = $('#date1').val();
            var todate 		 = $('#date2').val();
            var totime           = $('#time1').val();
            var fromtime         = $('#time2').val();
            
            fromTimeG 		= $('#time1').val();
            toTimeG 		= $('#time2').val();
            fromDateG       = $('#date1').val();
            toDateG         = $('#date2').val();
            var d                = daydiff(parseDate($('#date1').val()), parseDate($('#date2').val())) + 1;							
            if(d > totalDays ){
                $('#errMessage').html('Cannot book for more than 30 days');
                check = 1;
                return;
            }		
            var stt 	         = new Date("November 13, 2013 " + fromtime);
            stt			 = stt.getTime();
            var endt 	         = new Date("November 13, 2013 " + totime);
            endt 		 = endt.getTime();							
            if (fromdate == '') {
                $('#errMessage').html('Please select From Date');
                check = 1;
                return;
            }		
            if (todate == '') {
                $('#errMessage').html('Please select To Date');
                check = 1;
                return;
            }
            if (new Date(fromdate) > new Date(todate)) {
                $('#errMessage').html('End date should be greater than start date');
                check = 1;
                return;
            }
            if ((fromdate == todate) && (stt == endt)) {
                $('#errMessage').html('Invalid end time for booking date');
                check = 1;
                return;
            }
			
            var time1 		= $('#time1').val();
            var hours 		= Number(time1.match(/^(\d+)/)[1]);
            var minutes 	= Number(time1.match(/:(\d+)/)[1]);
            var AMPM 		= time1.match(/\s(.*)$/)[1];
            if (AMPM == "PM" && hours < 12)
            hours 			= hours + 12;
            if (AMPM == "AM" && hours == 12)
            hours 			= hours - 12;
            var sHours		= hours.toString();
            var sMinutes 	= minutes.toString();
            if (hours < 10)
            sHours 			= "0" + sHours;
            if (minutes < 10)
            sMinutes 		= "0" + sMinutes;
            var fromtime 	= sHours + ":" + sMinutes;
            var time2 		= $('#time2').val();
            var hours 		= Number(time2.match(/^(\d+)/)[1]);
            var minutes 	= Number(time2.match(/:(\d+)/)[1]);
            var AMPM 		= time2.match(/\s(.*)$/)[1];
            if (AMPM == "PM" && hours < 12)
            hours 			= hours + 12;
            if (AMPM == "AM" && hours == 12)
            hours 			= hours - 12;
            var sHours 		= hours.toString();
            var sMinutes	= minutes.toString();
            if (hours < 10)
            sHours 			= "0" + sHours;
            if (minutes < 10)
            sMinutes 		= "0" + sMinutes;
            var totime 		= sHours + ":" + sMinutes;	
	    if ($('#timecheck').val() == ''){	
                if (fromdate == todate && (fromtime == totime || fromtime > totime)) {
                    $('#errMessage').html('Please select Valid Time');
                    check = 1;
                    return;
                }		
                var currdate = new Date();
                var gdate = new Date(fromdate);
                var checkdate = (currdate.toDateString() === gdate.toDateString());

                if(checkdate){
                    var dt = new Date();
                    var time = dt.getHours() + ":" + dt.getMinutes();
                    if(fromtime < time){
                            $('#errMessage').html('Please select Valid Time');
                            check = 1;
                            return;
                    }
                }
            }	
            if($('input[name=bookingoption]:checked').length<=0)
            {
                $('#errMessage1').html('Confirm your booking Type');
                check = 1;
                return;
            }
            if(check == 0){
                $('#date_valid').attr('value','valid');
            }else{
                $('#date_valid').attr('value','');
            }
            if ($('#latitude').val() == ''){
                var NewMapCenter = map.getCenter();
                var c_lat 		 = NewMapCenter.lat();
                var c_long       = NewMapCenter.lng();
                c_latG 			 = c_lat;
                c_longG 		 = c_long;
            }else{ 
               var c_lat 		 = $('#latitude').val();
               var c_long        = $('#longitude').val();
               c_latG            = c_lat;
               c_longG           = c_long;                       
            }	
            var data = $.param({
                    rangeprice     : rangeprice,
                    fromdate       : fromdate,
                    todate         : todate,
                    fromtime       : fromtime,
                    totime         : totime,
                    option         : option,
                    location       : locationG,
                    search_latlang : search_latlangG,
                    centerlat      : c_lat,
                    centerlong     : c_long
            });
            $('.wait').show();	
            $.ajax({
                    method   : "POST",
                    url      : baseUrl+ "driveway/driveway/searchDriveway",
                    data     : data,
                    dataType : "json",
                    success  : function(response) {			
                    // accessing all the properties		
                            if(typeof response.status == 0){
                                hourChargeG = response.hours;                        
                                $('.wait').hide();										
                                clearMarkers();										
                            }
                            else
                            {
                                $('.wait').hide();
                                clearMarkers();																
                                hourChargeG = response.hours; 
                                console.log(hourChargeG);
                                console.log(filterPriceG);
                                searchTypeG = response.searchtype;						
                                cities = response.data;
                                cities.forEach(function(city) {											
                                        createMarker(city);
                                });					
                            }
                            $('.wait').hide();	
                    }
            });
	};
        // function to clear markers
        var clearMarkers = function() {
            setMapOnAll(null);
        }
		
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
		
        // function to create svg marker image
        var pinSymbol = function(color) {
                return {
                    path	 : 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
                    fillColor 	 : color,
                    fillOpacity  : 1,
                    strokeColor  : '#000000',
                    strokeWeight : 2,
                    scale 	 : 2
                };
        }
		
        var infowindow1 = new google.maps.InfoWindow();	
        infowindow2 = new google.maps.InfoWindow({
            content : " "
        });
        infowindow3 = new google.maps.InfoWindow({
            content : " "
        });
	
        //function to show driveway detail on click of infowindow.
        myFunction = function(id) {       
         
            var oneDay 		= 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            var firstDate 	= new Date(fromDateG);
            var secondDate 	= new Date(toDateG);
            if ($('#searchType').val() == ''){
                //var searchType = $("input[name=bookingoption]:checked").val();
                var searchType	= searchTypeG[id];
            }
            else{
                var searchType = $('#searchType').val();
            }
            var diffDays       = (Math.round(Math.abs((firstDate.getTime() - secondDate.getTime()) / (oneDay)))) + 1;
            var NewMapCenter   = map.getCenter();
            var clat 	       = NewMapCenter.lat();
            var clong          = NewMapCenter.lng();		
            infowindow2.close();            
            
            $.ajax({
                method : "POST",
                url    : baseUrl + "driveway/showdriveway",
                data   : {
                        id            : id,
                        fromDate      : fromDateG,
                        toDate        : toDateG,
                        fromTime      : fromTimeG,
                        toTime        : toTimeG,
                        searchtype    : searchType,
                        search_lat    : search_latG,
                        search_long   : search_lngG			
                },
                dataType : "json",
                success : function(response) {				
                        latiG	        = response['driveway'].latitude;
                        longiG 	        = response['driveway'].longitude;
                        usernameG       = response['driveway'].userName;
                        ownerIdG        = response['driveway'].userID;											
                        phoneG          = response['driveway'].phone;
                        emailIDG        = response['driveway'].emailID;
                        addressG        = response['driveway'].dbuilding+'<br>'+response['driveway'].dstreetAddress+',&nbsp'+response['driveway'].droute+'<br>'+response['driveway'].dcity+',&nbsp'+response['driveway'].dstate+'&nbsp - &nbsp'+response['driveway'].dzip;
                        instructionsG   = response['driveway'].instructions;
                        priceG          = response['driveway'].price;
                        var totalPrice  = priceG*hourChargeG[id];	
                        totalPriceG     = totalPrice.toFixed(2);		
                        drivewayIdG     = id;
                        console.log(hourChargeG);
                        console.log(totalPrice);
                        $("label[for='fromdate']").html(fromDateG);
                        $("label[for='todate']").html(toDateG);
                        $("label[for='fromtime']").html(fromTimeG);
                        $("label[for='totime']").html(toTimeG);
                        $("label[for='timezone']").html(response['driveway'].timeZone);
                        $("label[for='checkindate']").html(response['bookingFromdate']+'&nbsp'+response['bookingFromtime']);
                        $("label[for='checkoutdate']").html(response['bookingTodate']+'&nbsp'+response['bookingTotime']);
                        $("label[for='address']").html(response['driveway'].dbuilding+', '+response['driveway'].dstreetAddress+',&nbsp'+response['driveway'].droute+', '+response['driveway'].dcity+',&nbsp'+response['driveway'].dstate+'&nbsp - &nbsp'+response['driveway'].dzip);
                        $("label[for='userzone']").html(response['driveway'].userzone);
                        var searchaddress = $('#pac-input').val();																				
                        if (searchaddress != '') {
                            $("label[for='searchlocation']").html(searchaddress);
                        }else{
                            $('.searchlocation').remove();
                        }				
                        var option = response['driveway'].searchtype;
                        if(option == 1){											
                            $("label[for='message']").html('You Have selected Hourly Booking Type. '+hourChargeG[drivewayIdG]+' Hours rental fee is <span> $'+ totalPriceG+' </span>');
                        }else if(option == 2){
                            $("label[for='message']").html('You Have selected Recurring Booking Type. Total '+hourChargeG[drivewayIdG]+' Hours rental fee is <span> $'+ totalPriceG+'</span>.<br/> Everyday you can Check-In after '+ response['bookingFromtime']+' and Check-Out before '+ response['bookingTotime']);
                        }else if(option == 3){
                            $("label[for='message']").html('You Have selected Flat rate Booking Type. '+hourChargeG[drivewayIdG]+' Days rental fee is <span> $'+ totalPriceG+' </span>');
                        }		
				
                        $("label[for='myvalue']").html('$'+ response['driveway'].price);
                        $("label[for='myname']").html(response['driveway'].userName);
                        $("p[for='description']").html(response['driveway'].description);
                        $("p[for='emailID']").html(response['driveway'].emailID);
                        $("p[for='username']").html(response['driveway'].userName);
                        $("p[for='address']").html(response['driveway'].dbuilding+'<br>'+response['driveway'].dstreetAddress+',&nbsp'+response['driveway'].droute+'<br>'+response['driveway'].dcity+',&nbsp'+response['driveway'].dstate+'&nbsp - &nbsp'+response['driveway'].dzip);
                        if ((response['driveway'].photo1 == null) && (response['driveway'].photo2 == null) && (response['driveway'].photo3 == null) && (response['driveway'].photo4 == null)) {
                            $("#slide1").attr("src",baseUrl + "assets/images/house.jpg");
                            $("#slide21").attr("src",baseUrl+ "assets/images/house.jpg");
                            $("#slide31").attr("src",baseUrl+ "assets/images/house.jpg");
                            $(".item2").remove();
                            $(".item3").remove();
                            $(".item4").remove();
                        } else {
                            if (response['driveway'].photo1 != null) {
                                $("#slide1").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo1);
                                $("#slide21").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo1);
                                $("#slide31").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo1);	
                            } else {
                                $(".item1").remove();
                            }
                            if (response['driveway'].photo2 != null) {
                                $("#slide2").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo2);
                                $("#slide22").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo2);
                                $("#slide32").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo2);
                            } else {
                                $(".item2").remove();
                            }
                            if (response['driveway'].photo3 != null) {
                                $("#slide3").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo3);
                                $("#slide23").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo3);	
                                $("#slide33").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo3);	
                            } else {
                                $(".item3").remove();
                            }
                            if (response['driveway'].photo4 != null) {
                                $("#slide4").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo4);
                                $("#slide24").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo4);
                                $("#slide34").attr("src",baseUrl+ "assets/uploads/driveway/"+ response['driveway'].photo4);
                            } else {
                                $(".item4").remove();
                            }
                        }

                        if (response['reviews'] == 0) {
                            $(".owl-nonav").remove();
                            $("#review").html('<h3>No Reviews</h3>');
                        } else {
                            reviews = response['reviews'];
                            $('#review').html('');
                            var maincontent = '<div class="owl-carousel testimonial-owl owl-nonav">'+ '</div>';
                            $('#review').append(maincontent);
                            reviews.forEach(function(review) {
                                if (review.profileImage == '0') {								
                                    var src = baseUrl+ 'assets/images/avatar.png';
                                } else {
                                    var src = baseUrl+ 'assets/uploads/profilephoto/'+ review.profileImage;
                                }
                                var content = '<div class="item">'
                                                + '<div class="col-md-3 col-sm-3">'
                                                + '<figure class="figure-container"><img src="'
                                                + src
                                                + '" width="400" height="400" alt="LouiePark" class="img-responsive img-circle" />'
                                                + '</figure>'
                                                + '</div>'
                                                + '<div class="col-md-9 col-sm-9">'
                                                + '<blockquote>'
                                                + '<p>'
                                                + review.title
                                                + '<br>'
                                                + review.comments
                                                + '</p>'
                                                + '</blockquote>'
                                                + '<p class="blockquote-author"><span>'
                                                + review.userName
                                                + '</span></p>'
                                                + '</div>'
                                                + '</div>';
                                $('.owl-nonav').append(content);
                            });
			}																				
                        if (response['ratings'] != 0){
                            $('#input-3').rating('update', response['ratings']);
                            $('#input-4').rating('update', response['ratings']);
                        }else{
                            $('#input-3').rating('update', 0);
                            $('#input-4').rating('update', 0);
                        }
                        $("p[for='instruction']").html(response['driveway'].instructions);
                        $('#rootwizard').find('.pager .next').click();
		},
            error:function(data){                   
                    $('.CCServerError').html('Something went wrong! Please try again.');
            }  
            });
	}
        
        //function used to get all markers when keep looking is clicked
	function fetch_markers() {
            var rangeclick     = $('#prangeset').val();
            var option         = $("input[name=bookingoption]:checked").val();
            if (rangeclick == '') {
                    var rangeprice = '';
            } else {
                    var rangeprice = $('#pricerange').val();
            }
            
            var fromdate      = $('#date1').val();
            var todate        = $('#date2').val();
            var time1         = $('#time1').val();
            var hours         = Number(time1.match(/^(\d+)/)[1]);
            var minutes       = Number(time1.match(/:(\d+)/)[1]);
            var AMPM          = time1.match(/\s(.*)$/)[1];
            if (AMPM == "PM" && hours < 12)
                hours = hours + 12;
            if (AMPM == "AM" && hours == 12)
                hours = hours - 12;
            var sHours        = hours.toString();
            var sMinutes      = minutes.toString();
            if (hours < 10)
                sHours = "0" + sHours;
            if (minutes < 10)
                sMinutes = "0" + sMinutes;
            var fromtime      = sHours + ":" + sMinutes;
            var time2         = $('#time2').val();
            var hours         = Number(time2.match(/^(\d+)/)[1]);
            var minutes       = Number(time2.match(/:(\d+)/)[1]);
            var AMPM          = time2.match(/\s(.*)$/)[1];
            if (AMPM == "PM" && hours < 12)
                hours = hours + 12;
            if (AMPM == "AM" && hours == 12)
                hours = hours - 12;
            var sHours        = hours.toString();
            var sMinutes      = minutes.toString();
            if (hours < 10)
                sHours = "0" + sHours;
            if (minutes < 10)
                sMinutes = "0" + sMinutes;
            var totime        = sHours + ":" + sMinutes;                
            if ($('#latitude').val() == ''){
                var NewMapCenter         = map.getCenter();
                var c_lat 		 = NewMapCenter.lat();
                var c_long               = NewMapCenter.lng();
                c_latG 			 = c_lat;
                c_longG 		 = c_long;
            }else{ 
                var c_lat 		 = $('#latitude').val();
                var c_long       = $('#longitude').val();
                c_latG 		     = c_lat;
                c_longG 		 = c_long;                       
            }

            var data = $.param({
                rangeprice     : rangeprice,
                fromdate       : fromdate,
                todate         : todate,
                fromtime       : fromtime,
                totime         : totime,
                option         : option,
                location       : locationG,
                search_latlang : search_latlangG,
                centerlat      : c_lat,
                centerlong     : c_long
            });
            $.ajax({
                    method   : "POST",
                    url      : baseUrl + "driveway/driveway/searchDriveway",
                    data     : data,
                    dataType : "json",
                    success  : function(response) {
                            hourChargeG  = response.hours;
                            cities       = response.data;
                            clearMarkers();
                            cities.forEach(function(city) {
                                createMarker(city);
                            });
                    }
            });
	}
    } else {
	// Browser doesn't support Geolocation
	handleLocationError(false, infoWindow, map.getCenter());
    }

    $('#rootwizard').bootstrapWizard(
    {
        'nextSelector'     : '#fb-signup, .wizard .next, .btn-press, .gonext',
        'previousSelector' : '.goprevious',
        'onTabClick'       : function(tab, navigation, index) {											
                                        return false;
                            },
        onTabShow          : function(tab, navigation, index) {
                var $total   = navigation.find('li').length;
                var $current = index + 1;
                var $percent = ($current / $total) * 100;
                $('#rootwizard .progress-bar').css(
                {
                    width : $percent + '%'
                });
        }
    });
    
    // set prangeset value to 1 when range filter value is changed
    $("#pricerange").on("change", function() {
        $("#prangeset").val("1");
    });
    
    //remove all icon-star class from star rating in tab 2 when keeplooking is clicked 
    $("#keeplooking").on("click", function() {
        for(i=1;i<=5;i++){
            $('.star'+i).removeClass("icon-star");
            $('.star'+i).addClass("icon-star-o");
        }
        fetch_markers();						
    });

    $(".addBill").on("click",function() {
        $('#cardList').val('');
        $('.payment').show();
        $('.paymentExist').hide();
        $('.addBill').hide();
        $('.revertBill').show();
    });

    $(".revertBill").on("click",function() {
        $('#cardList').val('1');
        $('.payment').hide();
        $('.paymentExist').show();
        $('.addBill').show();
        $('.revertBill').hide();
    });
    
    $(".rentDriveway").on("click",function() 
    {
        var option = searchTypeG[drivewayIdG];
        var carType;
        var cardType
        var data = $.param({										
                drivewayID  : drivewayIdG,
                fromDate    : fromDateG,
                toDate      : toDateG,
                fromTime    : fromTimeG,
                toTime      : toTimeG,
                price       : priceG,
                totalPrice  : totalPriceG,
                ownerId     : ownerIdG,
                option      :option
        });
        $.ajax({
            method   : "POST",
            url      : baseUrl+ "driveway/getUser",
            data     :data,
            dataType : "json",
            success  : function(data) {													
                if (data["login"][0]["status"]) {
                    var totalHrPrice  = priceG*hourChargeG[drivewayIdG];	
                    hourlyPrice       = totalHrPrice.toFixed(2); 
                    proc_feeG         =  ((stripeChargeFeeC / 100) * hourlyPrice) + stripeProcessFeeC + applicationFeeC; 
                     proc_feeG        =  proc_feeG.toFixed(2);         
                    var grandTotal    =   parseFloat(hourlyPrice) + parseFloat(proc_feeG);
                    grandTotal        = grandTotal.toFixed(2);         
                    if (hourChargeG[drivewayIdG]){		
                        var optionG   = searchTypeG[drivewayIdG];			
                        if(optionG == 3){
                            $('.driveway-price').html('<p> <div>Total '+hourChargeG[drivewayIdG]+' Days rental fee: $'+hourlyPrice+'</div> <div> Processing Fee: $'+proc_feeG+'</div><div>Total Charge : <span>'+grandTotal+' </span></div> </p>'); 
                        }
                        else
                        {
                            $('.driveway-price').html('<p> <div>Total '+hourChargeG[drivewayIdG]+' Hours rental fee: $'+ hourlyPrice +' </div> <div> Processing Fee: $'+proc_feeG+'</div><div>Total Charge : <span> $'+grandTotal+'</span></div> </p>');
                        }
                    }														
                    if (data["vehicle"][0]["vehicle"]) {
                        $('#veicleList').val('1');										
                        $('.vehicle').show();
                        $("#carType").empty();
                        carType = $("#carType");
                        for ( var x in data["vehicle"]) {																
                            for ( var y in data["vehicle"][x]) {
                                var vehicleId = data["vehicle"][x]['vehicleID'];
                                if (y == "vehicleType") {
                                    carType.append('<option value="'+ vehicleId+ '">'+ data["vehicle"][x][y]+ '</option>');
                                }
                            }
                        }
                    } else {															
                        $('.addVehicle').show();
                    }
                    if (data["cards"][0]["cards"]) {
                        $('#cardList').val('1');	
                        $('.paymentExist').show();
                        $("#cardType").empty();
                        cardType = $("#cardType");
                        for ( var x in data["cards"]) {
                            for ( var y in data["cards"][x]) {
                                var billID = data["cards"][x]['billID'];
                                if (y == "name_on_card") {
                                    cardType.append('<option value="'+ billID+ '">'+ data["cards"][x][y]+ '</option>');
                                }
                            }
                        }
                    }
                    else 
                    {
                        $('.payment').show();
                    }
		} 
		else 
		{
                    var totalHourPrice = priceG*hourChargeG[drivewayIdG];
                    hourlyPriceGl      = totalHourPrice.toFixed(2);
                    var optionG        = searchTypeG[drivewayIdG];													
                    filterG            = 1;
                    $('.login').show();
                    $('#inset_form').html('<form action="'+ baseUrl+'login" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="drivewayId" value="' + drivewayIdG + '" /><input type="text" name="fromDate" value="' + fromDateG + '" /><input type="text" name="fromTime" value="' + fromTimeG + '" /><input type="text" name="toDate" value="' + toDateG + '" /><input type="text" name="toTime" value="' + toTimeG + '" /><input type="text" name="price" value="' + priceG + '" /><input type="text" name="totalPrice" value="' + hourlyPriceGl + '" /><input type="text" name="ownerId" value="' + ownerIdG + '" /><input type="text" name="filterPrice" value="' + filterPriceG + '" /><input type="text" name="totalHours" value="' + hourChargeG[drivewayIdG] + '" /><input type="text" name="location" value="' + locationG + '" /><input type="text" name="latitude" value="' + c_latG + '" /><input type="text" name="longitude" value="' + c_longG + '" /><input type="text" name="option" value="' + optionG + '" /></form>');
                    $( ".driveway" ).submit();
		}
            }
        });
    });
				
    paymentProcess = function()
    {
	var totalAmt;
	var latitude;	
	var longitude;    
	if(hourlyPrice){
            totalAmt  = parseFloat(hourlyPrice) + parseFloat(proc_feeG);
            totalAmt  = totalAmt.toFixed(2);
            latitude  = c_latG;
            longitude = c_longG;			
	}
	else{	
            totalAmt  = parseFloat($("#totalPrice").val()) + parseFloat($("#proc_fee").val());
            latitude  = $("#latitude").val();
            longitude = $("#longitude").val(); 
            totalAmt  = totalAmt.toFixed(2);
	}
	var saveBill  = 0;
	if ($('input.optionsave').is(':checked')) {
            saveBill  = 1;
	}
	$('#error_msg').html('');
	$('#error_msg_v').html('');
	var totalPriceCharge = totalPriceG;
	if(!$('#veicleList').val()) {
            var model = $('#model').val();
            var year = $('#year').val();
            var vehiclenumber = $('#vehiclenumber').val();
            var color = $('#color').val();
            if (model == ''){
                $('#error_msg_v').html('Enter vehicle model');
                return;
            }
            else if(year == '' ){ 
                $('#error_msg_v').html('Enter vehicle year');
                return;
            }
            else if(color == '' ){
                $('#error_msg_v').html('Enter vehicle color');
                return;
            }
            else if(vehiclenumber == '') {
                $('#error_msg_v').html('Enter vehicle number');
                return;
            }
            else if (!validateYear(year)) {
                $('#error_msg_v').html('Invalid vehicle model year');
                return;
            }
	}
	var vehicleID = $('#carType').val();	
	if(!$('#cardList').val()) {						
            var card_number        = $('#card_number').val();
            var security_code      = $('#security_code').val();
            var expiration_date    = $('#expiration_date').val();
            var nameon_card        = $('#nameon_card').val();						
            var cardList           = $('#cardList').val();
            var veicleList         = $('#veicleList').val();
            var billing_address    = $('#billing_address').val();
            var billing_street     = $('#billing_street').val();
            var billing_city       = $('#billing_city').val();
            var billing_state      = $('#billing_state').val();
            var billing_zip        = $('#billing_zip').val();
            var billing_phone      = $('#billing_phone').val();												
            Stripe.setPublishableKey('pk_test_l67m8FSQRjOdwMgm61AlgELz');							
            if (card_number == ''){$('#error_msg').html('Enter card number');} 
            else if (security_code == ''){$('#error_msg').html('Enter CVV Code'); } 
            else if (expiration_date == ''){$('#error_msg').html('Enter Card Expiration date');} 
            else if (nameon_card == ''){$('#error_msg').html('Enter name on the card');}
            else if (billing_address == ''){$('#error_msg').html('Enter Address');} 
            else if (billing_street == ''){$('#error_msg').html('Enter Street Address');} 
            else if (billing_city == ''){$('#error_msg').html('Enter City '); } 
            else if (billing_state == ''){$('#error_msg').html('Enter State ');}
            else if (billing_zip == ''){$('#error_msg').html('Enter Zip code ');}
            else if (billing_phone == '' ) {
                $('#error_msg').html('Enter contact number');
                return;
            } else if (!Stripe.card.validateCardNumber(card_number)) {
                $('#error_msg').html('Invalid Card Number');
                return;
            } else if (!Stripe.card.validateCVC(security_code)) {
                $('#error_msg').html('Invalid CVC code');
                return;
            } else if (!validateExpiration(expiration_date)) {
                $('#error_msg').html('Invalid Expiration date');
                return;
            } 
            else if (!validateZip(billing_zip)) {
                $('#error_msg').html('Invalid postal code');
                return;
            } 
            else if (!validatePhone(billing_phone)) {
                $('#error_msg').html('Invalid phone number');
                return;
            }
            else
            {						
                $('.wait').show();	
                var data = $.param({						
                    model            : model,
                    year             : year,
                    color            : color,
                    vehiclenumber    : vehiclenumber,
                    card_number      : card_number,
                    security_code    : security_code,
                    expiration_date  : expiration_date,
                    nameon_card      : nameon_card,
                    vehicleID        : vehicleID,
                    drivewayID       : drivewayIdG,
                    fromDate         : fromDateG,
                    toDate           : toDateG,
                    fromTime         : fromTimeG,
                    toTime           : toTimeG,
                    price            : priceG,
                    totalPrice       :  Math.round(totalAmt*100),
                    ownerId          : ownerIdG,
                    cardList         : cardList,
                    veicleList       :veicleList,
                    billing_address  :billing_address,
                    billing_street   :billing_street,
                    billing_city     :billing_city,
                    billing_state    :billing_state,
                    billing_zip      :billing_zip,
                    billing_phone    :billing_phone,
                    billID           : BillID,
                    saveBill         : saveBill,
                    option           : optionG,
                    c_lat            : latitude,
                    c_long           : longitude
                });
                $.ajax({
                        method   : "POST",
                        url      : baseUrl + "booking/api/bookDriveway",
                        data     : data,
                        dataType : "json",
                        success  : function(response) {
                            if (response.status) {
                                $('.wait').hide();
                                $("label[for='ownername']").html(usernameG);
                                $('.driveway-contact1').html(
                                                    '<address>'
                                                    + addressG
                                                    + '</address><h5>Contact Owner</h5><p>'
                                                    + phoneG
                                                    + '</p><h5>Instructions</h5><p>'
                                                    + instructionsG
                                                    + '</p>');
                                var wizard = $('#rootwizard')
                                                .bootstrapWizard();
                                wizard.bootstrapWizard('next');
                            } else {
                                $('.CCServerError').html(response.message);
                                $('.wait').hide();
                            }
                        },
                        error:function(data){
                            $('.loader').hide();
                            $('.error_box').html('Something went wrong! Please try again.');
                        }
                });		
            }	
        } 
	else
	{						
            $('.wait').show();
            var BillID = $('#cardType').val();	
            var data = $.param({
                model           : model,
                year            : year,
                color           : color,
                vehiclenumber   : vehiclenumber,
                card_number     : card_number,
                security_code   : security_code,
                expiration_date : expiration_date,
                nameon_card     : nameon_card,
                vehicleID       : vehicleID,
                drivewayID      : drivewayIdG,
                fromDate        : fromDateG,
                toDate          : toDateG,
                fromTime        : fromTimeG,
                toTime          : toTimeG,
                price           : priceG,
                totalPrice      : Math.round(totalAmt*100),
                ownerId         : ownerIdG,
                cardList        : cardList,
                veicleList      :veicleList,              
                billing_address :billing_address,
                billing_street  :billing_street,
                billing_city    :billing_city,
                billing_state   :billing_state,
                billing_zip     :billing_zip,
                billing_phone   :billing_phone,
                billID          : BillID,
                saveBill        : saveBill,
                option          : optionG,
                c_lat           : latitude,
                c_long          : longitude								
            });		
            $.ajax({
                method  : "POST",
                url     : baseUrl + "booking/api/bookDriveway",
                data    : data,
                dataType: "json",
                success : function(response) {
                    if (response.status) {
                        $('.wait').hide();
                        $("label[for='ownername']").html(usernameG);
                        $('.driveway-contact1').html('<address>'+ addressG+ '</address><h5>Contact Owner</h5><p>'+ phoneG+ '<br/>'+emailIDG+'</p><h5>Instructions</h5><p>'+ instructionsG+ '</p>');
                        var wizard = $('#rootwizard').bootstrapWizard();
                        wizard.bootstrapWizard('next');
                    } else {
                        $('.CCServerError').html(response.message);
                        $('.wait').hide();
                    }
                },
                error:function(data){
                    $('.loader').hide();
                    $('.CCServerError').html('Something went wrong! Please try again.');
                }
            });	
	}  
    };

    function validateExpiration(value) {
	var today       = new Date();
	var thisYear    = today.getFullYear();
	var expMonth    = +value.substr(0, 2);
	var expYear     = +value.substr(3, 4);
	return (expMonth >= 1 && expMonth <= 12	&& (expYear >= thisYear && expYear < thisYear + 20) && (expYear == thisYear ? expMonth >= (today.getMonth() + 1): true));
    }
    function validateYear(value) {
        var today       = new Date();
        var thisYear    = today.getFullYear();
        return (value > 1900 && value != "" && value <= thisYear );
    }

    function validateZip(value) {
        var reg         = /^[0-9]+$/;
        return (((value.length)== 5 || (value.length)== 4 )&& reg.test(value));
    }

    function validatePhone(value) {
        var intRegex    = /[0-9 -()+]+$/;
        return (((value.length) <=10 && (value.length) >6 ) && intRegex.test(value));
    }

    $('a[href="#tab4"]').on('shown.bs.tab', function () {
        if (navigator.geolocation) {
	   finalMap();
        }
    }).on('hide.bs.tab', function () {
   
    });

    function finalMap()
    {						
        var myLatLng    =  new google.maps.LatLng(latiG, longiG);
        var mapf        = new google.maps.Map(document.getElementById('driveway-map'), {
          zoom  : 8,
          center: myLatLng
        });

        var marker      = new google.maps.Marker({
          position: myLatLng,
          map     : mapf         
        });
    }	
	  
    function daydiff(first, second) 
    {
        return (second-first)/(1000*60*60*24)
    }  

    function parseDate(str) 
    {
        var mdy = str.split('/')
        return new Date(mdy[2], mdy[0]-1, mdy[1]);
    }	


    google.maps.event.addListener(map, 'dragend', function() 
    {
	if(goclick === 1){
            if ($('#latitude').val() == ''){
                var NewMapCenter         = map.getCenter();
                var clat                 = NewMapCenter.lat();
                var clong                = NewMapCenter.lng();
                c_latG 	                 = clat;
                c_longG 	         = clong;
            }else{ 
               var clat 		 = $('#latitude').val();
               var clong                 = $('#longitude').val();
               c_latG                    = clat;
               c_longG                   = clong;                       
            }
            var check = 0;
            $('#date_valid').val('');
            $('#errMessage').html('');
            $('#errMessage1').html('');
            $('#error').html('');
            var rangeclick = $('#prangeset').val();
            var option = optionG;          
            var rangeprice = filterPriceG;           
            var address = $('#pac-input').val();// input box value	
            locationG = address;
            if(!locationG) {
          //if ($('#location').val() == ''){ 
            if (address != '') {
                var places = searchBox.getPlaces();
                if (typeof places === "undefined") {
                        $('#error').html('Enter valid Location');
                        check = 1;
                        return;
                }
                if (places.length == 0) {
                        $('#error').html('Enter valid Location');
                        check = 1;
                        return;
                }
                // For each place, get the icon, name and location								
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {								
                    if (!place.geometry) {
                        $('#error').html('Returned place contains no geometry');
                        check = 1;
                        return;
                    }
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    //map.setCenter(place.geometry.location);
                });
           
                map.setOptions({
                    maxZoom : 25
                });
                map.setOptions({
                    minZoom : 9
                });

                //map.fitBounds(bounds);
                if(map.getZoom() > 19){
                    map.setZoom(19); 
                }
            }
           }          
            var fromdate     = fromDateG;
            var todate       = toDateG;
            var totime       = toTimeG;
            var fromtime     = fromTimeG;							  
            var d            = daydiff(parseDate($('#date1').val()), parseDate($('#date2').val())) + 1;							
            if(d > totalDays ){
                $('#errMessage').html('Cannot book for more than 30 days');
                check = 1;
                return;
            }

            var stt      = new Date("November 13, 2013 " + fromtime);
            stt          = stt.getTime();
            var endt     = new Date("November 13, 2013 " + totime);
            endt         = endt.getTime();							
            if (fromdate == '') {
                $('#errMessage').html('Please select From Date');
                check = 1;
                return;
            }
            if (todate == '') {
                $('#errMessage').html('Please select To Date');
                check = 1;
                return;
            }
            if (new Date(fromdate) > new Date(todate)) {
                $('#errMessage').html('End date should be greater than start date');
                check = 1;
                return;
            }
            if ((fromdate == todate) && (stt == endt)) {
                $('#errMessage').html('Invalid end time for booking date');
                check = 1;
                return;
            }
            
            var time1       = fromTimeG;
            var hours       = Number(time1.match(/^(\d+)/)[1]);
            var minutes     = Number(time1.match(/:(\d+)/)[1]);
            var AMPM        = time1.match(/\s(.*)$/)[1];
            if (AMPM == "PM" && hours < 12)
                    hours   = hours + 12;
            if (AMPM == "AM" && hours == 12)
                    hours   = hours - 12;
            var sHours      = hours.toString();
            var sMinutes    = minutes.toString();
            if (hours < 10)
                    sHours  = "0" + sHours;
            if (minutes < 10)
                    sMinutes = "0" + sMinutes;
            var fromtime     = sHours + ":" + sMinutes;
            var time2        = toTimeG;
            var hours        = Number(time2.match(/^(\d+)/)[1]);
            var minutes      = Number(time2.match(/:(\d+)/)[1]);
            var AMPM         = time2.match(/\s(.*)$/)[1];
            if (AMPM == "PM" && hours < 12)
                    hours    = hours + 12;
            if (AMPM == "AM" && hours == 12)
                    hours    = hours - 12;
            var sHours       = hours.toString();
            var sMinutes     = minutes.toString();
            if (hours < 10)
                    sHours   = "0" + sHours;
            if (minutes < 10)
                    sMinutes = "0" + sMinutes;
            var totime       = sHours + ":" + sMinutes;
            if (fromdate == todate && (fromtime == totime || fromtime > totime)) {
                $('#errMessage').html('Please select Valid Time');
                check = 1;
                return;
            }		
            var currdate = new Date();
            var gdate = new Date(fromdate);
            var checkdate = (currdate.toDateString() === gdate.toDateString());
			
            if(checkdate){
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes();
                if(fromtime < time){
                        $('#errMessage').html('Please select Valid Time');
                        check = 1;
                        return;
                }
            }
            if($('input[name=bookingoption]:checked').length<=0)
            {
                $('#errMessage1').html('Confirm your booking Type');
                check = 1;
                return;
            }
            if(check == 0){
                $('#date_valid').attr('value','valid');
            }else{
                $('#date_valid').attr('value','');
            }            
            var data = $.param({
                    rangeprice      : rangeprice,
                    fromdate        : fromdate,
                    todate          : todate,
                    fromtime        : fromtime,
                    totime          : totime,
                    option          : option,
                    location        : locationG,
                    search_latlang  : search_latlangG,
                    centerlat       : clat,
                    centerlong      : clong
            });

            $.ajax({
                    method   : "POST",
                    url      : baseUrl + "driveway/driveway/searchDriveway",
                    data     : data,
                    dataType : "json",
                    success  : function(response) {			
                    if(typeof response.status == 0){
                        hourChargeG = response.hours;
                        clearMarkers();										
                    }
                    else
                    {
                        clearMarkers();										
                        hourChargeG = response.hours;
                        searchTypeG = response.searchtype;
                        console.log(filterPriceG);
                        cities      = response.data;
                        cities.forEach(function(city) {			
                        createMarker(city);						
                        });											
                    }				
                    }
            });
        }
    });
});
