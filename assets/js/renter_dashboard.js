$(document).ready(function () {    
    $(".owl-carousel").owlCarousel({
        items: 1,
		margin: 0,
		responsiveClass: true,
		loop: true,
		nav: true,
		dots: true,
		autoPlay: true,
		smartSpeed: 500,
		responsive:{
			0:{
				nav:false
			},
			480: {
				nav:false
			},
			768:{
				nav:false
			},
			1000:{
				nav:true,
			}
		},
		navigation : true,
		navigationText : [
			"<i class='icon-arrow-left owl-direction'></i>",
			"<i class='icon-arrow-right owl-direction'></i>"
		]
    });
	
	
	var category = null;
    $("input[name='live']").click(function() {
		category = this.value;
		var drivewayid = $('#drivewayid').val();
        var url_path = baseUrl + "renter/renter/saveParkerInfo/";		
		$.ajax({
            method: "POST",
            url: baseUrl + "renter/setdrivewaystatus",                       
            data: {drivewayid:drivewayid,category:category},
			dataType: "json",
            success:function(data){											
						if(typeof data.status !== typeof undefined){
						if(data.status == false){											
						window.location.href = url_path+data.user_id;						
						}else{
						
						
						}
						}
			}
		});
	});
	
	 drivewaySetting = function(drivewayId) {
					 $('#inset_form').html('<form action="'+ baseUrl+'dashboard/drivewaySettings" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="drivewayId" value="'+drivewayId+'" /></form>');
					 $( ".driveway" ).submit();					
	};
	
	drivewayEdit = function(drivewayId) {
					 $('#edit_form').html('<form action="'+ baseUrl+'dashboard/driveway_edit" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="drivewayId" value="'+drivewayId+'" /></form>');
					 $( ".driveway" ).submit();					
	};
	
});