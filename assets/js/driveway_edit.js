$(document).ready(function() {
$('.drivewayinfo').validate({
rules: {          
		building:	{
						required: true
					},
		description:	{
			required: true
		},
		instructions:	{
			required: true
		},
		 slot: {
		 
		 number: true,
		 range: [1, 100]
		 },
		 hourlyprice: {
		 number: true,
		 range: [1, 150]
		 },
		 flatprice: {
		 number: true,
		 range: [1, 150]
		 }			
		},
submitHandler: function(form) {	
	var url_path = baseUrl + "dashboard";
	$('.loader').show();
	var formDataVal = document.forms.namedItem("drivewayinfo");
	var formVals = new FormData(formDataVal);
    $.ajax({	
		    method		: "POST",		
			url		: baseUrl + "profile/update_driveway",
			dataType 	: "json",
			contentType	: false,
			cache		: false,
			processData	: false,           
			data		: formVals,			
			success		:function(data) {
                                                    if(data.login){                        
                                                        window.location.href = url_path;
                                                    }
							if(typeof data.status !== typeof undefined){
							if(data.status){						
								window.location.href = url_path;
							}else{						
								$('.CCServerError').html(data.message);						
								$('.loader').hide();							
							}
							}
			  
			},
            error:function(data){
                    $('.loader').hide();
                    $('.CCServerError').html('Something went wrong! Please try again.');
            }            
	});
    }
});


		jQuery.validator.addMethod('checkslot', function (value) {
			var originalval = $('#slot').data("original-value")
			if(value >= originalval){
			return true;
			}			
        }, "Slots cannot be reduced");

		jQuery.validator.addMethod("checkprice", function(value, element) {
			var flatprice = $('#currency').val();			
		    if(value <= flatprice){
			    return true; 
			}
		}, "Hourly price cannot be greater than Flat price");





});