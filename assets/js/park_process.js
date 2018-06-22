$(document).ready(function() {
$('#example').DataTable( {
 "pagingType": "full_numbers"
} );
$('#example2').DataTable( {
 "pagingType": "full_numbers"
} );
$('.cancelMessage').html('');
$('.CCServerError').html('');
$('.CCServerErrorb').html('');
	cancelBooking = function(bookingId,cancelType) {
	if (confirm('Are you sure you want to cancel this booking?')) {
	$('.loader').show();
			var data = $.param({
				//drivewayId : drivewayId,
				bookingId  : bookingId,
				cancelType : cancelType
				//fromDate : fromDate,
				//FromeTime  : FromeTime,
				//curDate    : curDate
			});
					$.ajax({
						method : "POST",
						url : baseUrl+ "booking/cancelBooking/",
						data : data,
						dataType : "json",
						success : function(response) {
							if (response.status) {										
								$('.loader').hide();
								$('.cancelled'+bookingId).html('Cancelled');
								$('.cancelled'+bookingId).removeClass("label-primary").addClass("label-danger");
							} else {
								$('.loader').hide();
								$('.CCServerError').html(response.message);												
							}
						},
            error:function(data){
                    $('.loader').hide();
                    $('.CCServerError').html('Something went wrong! Please try again.');
            }  
					});
	}
	};
	
	 addReview = function(drivewayId,userId,bookingID) {        
	 $('#inset_form').html('<form action="'+ baseUrl+'profile/addReviews" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="drivewayId" value="'+drivewayId+'" /><input type="text" name="bookingId" value="'+bookingID+'" /><input type="text" name="userId" value="'+userId+'" /></form>');
	 $( ".driveway" ).submit();
	
	};
	
	viewReview = function(drivewayId) {					
	 $('#inset_form').html('<form action="'+ baseUrl+'profile/view_review" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="drivewayId" value="'+drivewayId+'" /></form>');
	 $( ".driveway" ).submit();
	
	};

	 drivewaySetting = function(drivewayId) {
					 $('#inset_form').html('<form action="'+ baseUrl+'dashboard/drivewaySettings" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="drivewayId" value="'+drivewayId+'" /></form>');
					 $( ".driveway" ).submit();
					
	};
	
        verifydriveway = function(drivewayId) {
		$('#inset_form').html('<form action="'+ baseUrl+'dashboard/verifydriveway/" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="drivewayID" value="'+drivewayId+'" /></form>');
		$( ".driveway" ).submit();
					
	};
        
        parkinghistoryview = function(bookingID) {
		$('#inset_form').html('<form action="'+ baseUrl+'profile/parkhistory_view" name="parkinghistory" class="parkinghistory" method="post" style="display:none;"><input type="text" name="bookingID" value="'+bookingID+'" /></form>');
		$( ".parkinghistory" ).submit();
					
	};
	cancelDriveway = function(drivewayId,bookingId,fromDate,FromeTime,curDate) {
					if (confirm('Are you sure you want to cancel this booking?')) {
					$('.loader').show();
							var data = $.param({
								drivewayId : drivewayId,
								bookingId  : bookingId,
								fromDate : fromDate,
								FromeTime  : FromeTime,
								curDate    : curDate
							});
									$.ajax({
										method : "POST",
										url : baseUrl+ "booking/cancelDriveway/",
										data : data,
										dataType : "json",
										success : function(response) {
											if (response.status) {										
												$('.loader').hide();
												$('.cancelled'+bookingId).html('Cancelled');
												$('.cancelled'+bookingId).removeClass("label-primary").addClass("label-danger");
											} else {
												$('.loader').hide();
												$('.CCServerErrorb').html(response.message);												
											}
										}
									});
					}
					};
});