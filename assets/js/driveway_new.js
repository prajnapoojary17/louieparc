$(document).ready(function() {
 $('#input-3').rating({displayOnly: true, step: 0.1});
 $('#input-4').rating({displayOnly: true, step: 0.1});
					var usernameG;
					var phoneG;
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
					var totalDaysG;
					var drivewayuserIdG;
					var mysrclat = 0;
					var mysrclong = 0;
					var markers = [];
					var userIdG = $('#loggedUser').val();
					if (navigator.geolocation) {
						// generate map if location is not shared
						var mapOptions = {
							zoom : 6,
							center : {
								lat : 37.090240,
								lng : -95.712891
							},
							mapTypeId : google.maps.MapTypeId.TERRAIN
						}
						map = new google.maps.Map(document.getElementById('map'), mapOptions);
						$.each(locations,function() {
											if (this.dPrice != null) {
												var newPrice = this.dPrice;
											} else {
												var newPrice = this.price;
											}
											var marker = new MarkerWithLabel(
													{
														id : this.drivewayID,
														address1 : this.building,
														address2 : this.route,
														address3 : this.streetAddress,
														address4 : this.city,
														address5 : this.state,
														address6 : this.zip,
														map : map,
														drivewayuserIdG : this.userID,
														position : new google.maps.LatLng(
																this.latitude,
																this.longitude),
														labelClass : 'maplabels',
														labelContent : '$'
																+ newPrice,
														labelAnchor : new google.maps.Point(
																15, 65),
														icon : {
															path : 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
															fillColor : '#a185c0',
															fillOpacity : 1,
															strokeColor : '#000000',
															strokeWeight : 1,
															scale : 2
														}
													});
											// marker.setIcon('https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png');
											marker.content = '<div class="infoWindowContent">'
													+ this.desc + '</div>';

											google.maps.event.addListener(marker,'click',function() {
																var datevalid = $(
																		'#date_valid')
																		.val();
																if (datevalid == '') {
																	infowindow1
																			.setContent('<div id="content">'
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
																					+ '(Please select Booking Date and time to proceed further)'
																					+ '</div>'
																					+ '</div>');
																	infowindow1
																			.open(
																					map,
																					marker);
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
																	infowindow2
																			.setContent('<div id="content">'
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
						navigator.geolocation.getCurrentPosition(function(
								position) {
							mysrclat = position.coords.latitude;
							mysrclong = position.coords.longitude;

							var mapOptions = {
								zoom : 14,
								center : new google.maps.LatLng(mysrclat,
										mysrclong),
								mapTypeId : google.maps.MapTypeId.TERRAIN
							}
							map = new google.maps.Map(document
									.getElementById('map'), mapOptions);

							for (i = 0; i < locations.length; i++) {
								createMarker(locations[i]);
							}
						});
						createMarker = function(info) {	
						
							if (info.dPrice != null) {
								var newPrice = info.dPrice;
							} else {
								var newPrice = info.price;
							}
							
							var marker = new MarkerWithLabel({
								id : info.drivewayID,
								address1 : info.building,
								address2 : info.route,
								address3 : info.streetAddress,
								address4 : info.city,
								address5 : info.state,
								address6 : info.zip,								
								map : map,
								drivewayuserIdG : info.userID,
								position : new google.maps.LatLng(
										info.latitude, info.longitude),
								labelClass : 'maplabels',
								labelContent : '$' + newPrice,
								labelAnchor : new google.maps.Point(15, 65),
								icon : pinSymbol('#a185c0')
							});
						
							// marker.content = '<div
							// class="infoWindowContent">' + info.desc +
							// '</div>';
							google.maps.event.addListener(marker,
											'click',
											function() {
												var datevalid = $('#date_valid').val();												
												if (datevalid == '') {
													infowindow1
															.setContent('<div id="content">'
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
																	+ '(Please select Booking Date and time to proceed further)'
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

						// Bias the SearchBox results towards current map's
						// viewport.
						map.addListener('bounds_changed', function() {
							searchBox.setBounds(map.getBounds());
						});

						// Listen for the event fired when the user selects a
						// prediction and retrieve
						// more details for that place.
						searchBox.addListener('places_changed',function() {
											$('#error').html('');
											var places = searchBox.getPlaces();
											if (places.length == 0) {
												$('#error').html('Enter valid Location');
												return;
											}
											// For each place, get the icon,
											// name and location.
											var bounds = new google.maps.LatLngBounds();
											places
													.forEach(function(place) {
														if (!place.geometry) {
															$('#error').html('Returned place contains no geometry');														
															return;
														}
														if (place.geometry.viewport) {
															// Only geocodes have viewport.															
															bounds
																	.union(place.geometry.viewport);
														} else {
															bounds
																	.extend(place.geometry.location);
														}
													});
											map.setOptions({
												maxZoom : 25
											});
											map.setOptions({
												minZoom : 9
											});
											map.fitBounds(bounds);

										});

						// function for filtering date, location and price
						pricerange = "";
						filterval = function() {
							$('#date_valid').val('');
							$('#errMessage').html('');
							$('#error').html('');
							var rangeclick = $('#prangeset').val();
							if (rangeclick == '') {
								var rangeprice = '';
							} else {
								var rangeprice = $('#pricerange').val();
							}
							var address = $('#pac-input').val();// input box value																
							if (address != '') {
								var places = searchBox.getPlaces();
								if (typeof places === "undefined") {
									$('#error').html('Enter valid Location');
									return;
								}
								if (places.length == 0) {
									$('#error').html('Enter valid Location');
									return;
								}
								// For each place, get the icon, name and location								
								var bounds = new google.maps.LatLngBounds();
								places.forEach(function(place) {
											if (!place.geometry) {
												$('#error')
														.html(
																'Returned place contains no geometry');
												// console.log("Returned place
												// contains no geometry");
												return;
											}

											if (place.geometry.viewport) {
												// Only geocodes have viewport.
												bounds
														.union(place.geometry.viewport);
											} else {
												bounds
														.extend(place.geometry.location);
											}
										});
								map.setOptions({
									maxZoom : 25
								});
								map.setOptions({
									minZoom : 9
								});
								map.fitBounds(bounds);
							}
							var fromdate = $('#date1').val();
							var todate = $('#date2').val();
							if (fromdate == '') {
								$('#errMessage')
										.html('Please select From Date');
								return;
							}
							if (todate == '') {
								$('#errMessage').html('Please select To Date');
								return;
							}
							if (new Date(fromdate) > new Date(todate)) {
								$('#errMessage')
										.html(
												'End date should be greater than start date');
								return;
							}
							$('#date_valid').val('valid');
							var time1 = $('#time1').val();
							var hours = Number(time1.match(/^(\d+)/)[1]);
							var minutes = Number(time1.match(/:(\d+)/)[1]);
							var AMPM = time1.match(/\s(.*)$/)[1];
							if (AMPM == "PM" && hours < 12)
								hours = hours + 12;
							if (AMPM == "AM" && hours == 12)
								hours = hours - 12;
							var sHours = hours.toString();
							var sMinutes = minutes.toString();
							if (hours < 10)
								sHours = "0" + sHours;
							if (minutes < 10)
								sMinutes = "0" + sMinutes;
							var fromtime = sHours + ":" + sMinutes;
							var time2 = $('#time2').val();
							var hours = Number(time2.match(/^(\d+)/)[1]);
							var minutes = Number(time2.match(/:(\d+)/)[1]);
							var AMPM = time2.match(/\s(.*)$/)[1];
							if (AMPM == "PM" && hours < 12)
								hours = hours + 12;
							if (AMPM == "AM" && hours == 12)
								hours = hours - 12;
							var sHours = hours.toString();
							var sMinutes = minutes.toString();
							if (hours < 10)
								sHours = "0" + sHours;
							if (minutes < 10)
								sMinutes = "0" + sMinutes;
							var totime = sHours + ":" + sMinutes;

							var data = $.param({
								rangeprice : rangeprice,
								fromdate : fromdate,
								todate : todate,
								fromtime : fromtime,
								totime : totime
							});
							$.ajax({
								method : "POST",
								url : baseUrl
										+ "driveway/driveway/searchDriveway",
								data : data,
								dataType : "json",
								success : function(response) {									
									cities = response;
									clearMarkers();
									cities.forEach(function(city) {
										createMarker(city);
									});
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
								path : 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
								fillColor : color,
								fillOpacity : 1,
								strokeColor : '#000000',
								strokeWeight : 2,
								scale : 2
							};
						}
						var infowindow1 = new google.maps.InfoWindow();
						
						infowindow2 = new google.maps.InfoWindow({
							content : " "
						});
						infowindow3 = new google.maps.InfoWindow({
							content : " "
						});

						myFunction = function(id) {
							var fromDate = $('#date1').val();
							var toDate = $('#date2').val();
							fromTimeG = $('#time1').val();
							toTimeG = $('#time2').val();

							var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
							var firstDate = new Date(fromDate);
							var secondDate = new Date(toDate);

							var diffDays = (Math.round(Math.abs((firstDate
									.getTime() - secondDate.getTime())
									/ (oneDay)))) + 1;

							infowindow2.close();
							$.ajax({
										method : "POST",
										url : baseUrl + "driveway/showdriveway",
										data : {
											id : id,
											fromDate : fromDate
										},
										dataType : "json",
										success : function(response) {
											latiG	= response['driveway'].latitude;
											longiG 	= response['driveway'].longitude;
											usernameG = response['driveway'].userName;
											ownerIdG = response['driveway'].userID;											
											phoneG = response['driveway'].phone;
											addressG = response['driveway'].city
													+ ' '
													+ response['driveway'].state
													+ '-'
													+ response['driveway'].zip;
											instructionsG = response['driveway'].instructions;
											priceG = response['driveway'].price;
											totalDaysG = diffDays;
											totalPriceG = parseFloat(response['driveway'].price * diffDays);
											drivewayIdG = id;
											fromDateG = fromDate;
											toDateG = toDate;
											$("label[for='myvalue']").html('$'+ response['driveway'].price);
											$("label[for='myname']").html(response['driveway'].userName);
											$("p[for='description']").html(response['driveway'].description);
											if ((response['driveway'].photo1 == null)
													&& (response['driveway'].photo2 == null)
													&& (response['driveway'].photo3 == null)
													&& (response['driveway'].photo4 == null)) {
												$("#slide1")
														.attr(
																"src",
																baseUrl
																		+ "assets/images/house.jpg");
												$("#slide21")
														.attr(
																"src",
																baseUrl
																		+ "assets/images/house.jpg");
												$("#slide31")
														.attr(
																"src",
																baseUrl
																		+ "assets/images/house.jpg");
												$(".item2").remove();
												$(".item3").remove();
												$(".item4").remove();
											} else {
												if (response['driveway'].photo1 != null) {
													$("#slide1")
															.attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo1);
													$("#slide21")
															.attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo1);
													$("#slide31")
															.attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo1);	
												} else {
													$(".item1").remove();
												}
												if (response['driveway'].photo2 != null) {
													$("#slide2")
															.attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo2);
																			
													$("#slide22")
															.attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo2);
													$("#slide32")
															.attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo2);
												} else {
													$(".item2").remove();
												}
												if (response['driveway'].photo3 != null) {
													$("#slide3").attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo3);
													$("#slide23").attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo3);	
													$("#slide33").attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo3);	
												} else {
													$(".item3").remove();
												}
												if (response['driveway'].photo4 != null) {
													$("#slide4").attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo4);
													$("#slide24").attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo4);
													$("#slide34").attr(
																	"src",
																	baseUrl
																			+ "assets/uploads/driveway/"
																			+ response['driveway'].photo4);
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
												var maincontent = '<div class="owl-carousel testimonial-owl owl-nonav">'
														+ '</div>';
												$('#review').append(maincontent);
												reviews.forEach(function(
																review) {
															if (review.profileImage == '0') {
																// alert();
																var src = baseUrl
																		+ 'assets/images/avatar.png';
															} else {
																var src = baseUrl
																		+ 'assets/uploads/profilephoto/'
																		+ review.profileImage;
															}
															var content = '<div class="item">'
																	+ '<div class="col-md-3 col-sm-3">'
																	+ '<figure class="figure-container"><img src="'
																	+ src
																	+ '" width="400" height="400" alt="LouieParc" class="img-responsive img-circle" />'
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
										}
									});
						}

						function fetch_markers() {
							var rangeclick = $('#prangeset').val();
							if (rangeclick == '') {
								var rangeprice = '';
							} else {
								var rangeprice = $('#pricerange').val();
							}
							var address = $('#pac-input').val();
							var fromdate = $('#date1').val();
							var todate = $('#date2').val();
							var time1 = $('#time1').val();
							var hours = Number(time1.match(/^(\d+)/)[1]);
							var minutes = Number(time1.match(/:(\d+)/)[1]);
							var AMPM = time1.match(/\s(.*)$/)[1];
							if (AMPM == "PM" && hours < 12)
								hours = hours + 12;
							if (AMPM == "AM" && hours == 12)
								hours = hours - 12;
							var sHours = hours.toString();
							var sMinutes = minutes.toString();
							if (hours < 10)
								sHours = "0" + sHours;
							if (minutes < 10)
								sMinutes = "0" + sMinutes;
							var fromtime = sHours + ":" + sMinutes;

							var time2 = $('#time2').val();
							var hours = Number(time2.match(/^(\d+)/)[1]);
							var minutes = Number(time2.match(/:(\d+)/)[1]);
							var AMPM = time2.match(/\s(.*)$/)[1];
							if (AMPM == "PM" && hours < 12)
								hours = hours + 12;
							if (AMPM == "AM" && hours == 12)
								hours = hours - 12;
							var sHours = hours.toString();
							var sMinutes = minutes.toString();
							if (hours < 10)
								sHours = "0" + sHours;
							if (minutes < 10)
								sMinutes = "0" + sMinutes;
							var totime = sHours + ":" + sMinutes;

							var data = $.param({
								rangeprice : rangeprice,
								fromdate : fromdate,
								todate : todate,
								fromtime : fromtime,
								totime : totime
							});
							$.ajax({
								method : "POST",
								url : baseUrl
										+ "driveway/driveway/searchDriveway",
								data : data,
								dataType : "json",
								success : function(response) {
									cities = response;
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
										'nextSelector' : '#fb-signup, .wizard .next, .btn-press, .gonext',
										'previousSelector' : '.goprevious',
										'onTabClick' : function(tab,
												navigation, index) {
											// alert('on tab click disabled');
											return false;
										},
										onTabShow : function(tab, navigation,
												index) {
											var $total = navigation.find('li').length;
											var $current = index + 1;
											var $percent = ($current / $total) * 100;
											$('#rootwizard .progress-bar').css(
													{
														width : $percent + '%'
													});
										}
									});

					$("#pricerange").on("change", function() {
						$("#prangeset").val('1');
					});
					$("#keeplooking").on("click", function() {
					    for(i=1;i<=5;i++){
							$('.star'+i).removeClass("icon-star");
							$('.star'+i).addClass("icon-star-o");
						}
						fetch_markers();						
					});
					$(".rentDriveway").on("click",function() {
										if(totalDaysG==1){
										$('.driveway-price').html('<p>'+totalDaysG +' day rental fee: <span> $'+ totalPriceG+' </span></p>');
										}
										else{
										$('.driveway-price').html('<p>'+totalDaysG +' days rental fee: <span> $'+ totalPriceG+' </span></p>');
										}
										$.ajax({
													method : "POST",
													url : baseUrl+ "driveway/getUser",
													data : '',
													dataType : "json",
													success : function(data) {
														if (data["login"][0]["status"]) {
															if (data["vehicle"][0]["vehicle"]) {
																$('#veicleList').val('1');										
																$('.vehicle').show();
																var carType = $("#carType");
																for ( var x in data["vehicle"]) {
																	for ( var y in data["vehicle"][x]) {
																		var vehicleId = data["vehicle"][x]['vehicleID'];
																		if (y == "vehicleType") {
																			carType
																					.append('<option value="'
																							+ vehicleId
																							+ '">'
																							+ data["vehicle"][x][y]
																							+ '</option>');
																		}
																	}
																}
															} else {															
																$('.addVehicle').show();
															}
															/*if (data["billing"][0]["billing"]) {
															$('#cardList').val('1');	
															$('.paymentExist').show();
																$('#name_oncard').html(data["billing"][0]["name_on_card"]);
															} else {
																$('.payment').show();

															}*/$('.payment').show();

														} else {
															$('.login').show();
															window.location.href = baseUrl
																	+ "login";
														}
													}
												});
									});
					paymentProcess = function() {
						$('#error_msg').html('');
						$('#error_msg_v').html('');
						var totalPriceCharge = totalPriceG;
						if(!$('#veicleList').val()) {
						var model = $('#model').val();
						var year = $('#year').val();
						var vehiclenumber = $('#vehiclenumber').val();
						var color = $('#color').val();
						if (model == '' || year == '' || color == '' || vehiclenumber == '') {
							$('#error_msg_v').html('Enter vehicle details');
							return;
						}
						else if (!validateYear(year)) {
							$('#error_msg_v').html('Invalid vehicle model year');
							return;
						}
						}
						var card_number = $('#card_number').val();
						var security_code = $('#security_code').val();
						var expiration_date = $('#expiration_date').val();
						var nameon_card = $('#nameon_card').val();
						var vehicleID = $('#carType').val();
						var cardList = $('#cardList').val();
						var veicleList = $('#veicleList').val();
						var billing_address = $('#billing_address').val();
						var billing_street = $('#billing_street').val();
						var billing_city = $('#billing_city').val();
						var billing_state = $('#billing_state').val();
						var billing_zip = $('#billing_zip').val();
						var billing_phone = $('#billing_phone').val();												
						Stripe.setPublishableKey('pk_test_l67m8FSQRjOdwMgm61AlgELz');							
						if (card_number == '' || security_code == '' || expiration_date == '' || nameon_card == ''
								|| billing_address == '' || billing_street == '' || billing_city == '' || billing_state == '' || billing_zip == '' || billing_phone == '' ) {
							$('#error_msg').html('Enter billing details');
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
						else {
							$('.wait').show();
							var data = $.param({
								card_number : card_number,
								security_code : security_code,
								expiration_date : expiration_date,
								nameon_card : nameon_card,
								vehicleID : vehicleID,
								drivewayID : drivewayIdG,
								fromDate : fromDateG,
								toDate : toDateG,
								fromTime: fromTimeG,
								toTime: toTimeG,
								price : priceG,
								totalPrice :  Math.round(totalPriceCharge*100),
								ownerId: ownerIdG,
								cardList: cardList,
								veicleList:veicleList,
								billing_address:billing_address,
								billing_street:billing_street,
								billing_city:billing_city,
								billing_state:billing_state,
								billing_zip:billing_zip,
								billing_phone:billing_phone								
							});
							$.ajax({
										method : "POST",
										url : baseUrl
												+ "booking/api/bookDriveway",
										data : data,
										dataType : "json",
										success : function(response) {

											if (response.status) {
												$('.wait').hide();
												$('.driveway-contact').html(
																'<h3>'
																		+ usernameG
																		+ '<a href="#"><i class="icon-info-with-circle"></i></a></h3><address>'
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
										}
									});

						}
					};
					function validateExpiration(value) {
						var today = new Date();
						var thisYear = today.getFullYear();
						var expMonth = +value.substr(0, 2);
						var expYear = +value.substr(3, 4);

						return (expMonth >= 1
								&& expMonth <= 12
								&& (expYear >= thisYear && expYear < thisYear + 20) && (expYear == thisYear ? expMonth >= (today
								.getMonth() + 1)
								: true));
					}
					function validateYear(value) {
						var today = new Date();
						var thisYear = today.getFullYear();
						return (value > 1900 && value != "" && value <= thisYear );
					}
					function validateZip(value) {
						var reg = /^[0-9]+$/;
						return ((value.length)== 5 && reg.test(value));
					}
					function validatePhone(value) {
						var intRegex = /[0-9 -()+]+$/;
						return (((value.length) <=10 && (value.length) >6 ) && intRegex.test(value));
					}

					
					$('a[href="#tab4"]').on('shown.bs.tab', function () {
					if (navigator.geolocation) {

						   finalMap();
					 }
					
					}).on('hide.bs.tab', function () {
					   
					});
					
					function finalMap() {						
							var myLatLng =  new google.maps.LatLng(latiG, longiG);

							var mapf = new google.maps.Map(document.getElementById('driveway-map'), {
							  zoom: 8,
							  center: myLatLng
							});

							var marker = new google.maps.Marker({
							  position: myLatLng,
							  map: mapf         
							});
						  }	
				});
