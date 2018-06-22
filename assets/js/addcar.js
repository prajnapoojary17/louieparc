$(document).ready(function() {
$('.addcar').validate({
rules:  {     
			model:{
				required: true
			},
			year:{
				required: true,
				carYear:true,
				number: true,
				maxlength: 4
			},
			color : {						
				required: true			
			},
			vnumber:{
				required: true
			}
		},
messages: {
			model: {
				required: "Please enter Car Model"				
			},
			year:{
				required: "Please enter Year"				
			},	
			color: {
				required: "Please enter Color"
			},
			vnumber: {
				required: "Please enter License Plate Number"
			}
		},
submitHandler: function(form) {	
	var url_path = baseUrl + "dashboard";
	$('.loader').show();
        $.ajax({
			type: "POST",
			url: baseUrl + "profile/savecarinfo",
			data:$(form).serialize(),
			async:true,
			success:function(data) {
                                if(data.login){                        
                                    window.location.href = url_path;
                                }
				if(typeof data.status == 0){							
					$('.loader').hide();
					$(".error_box").show();
					$("#submit").attr('disabled',false);
					$('.error_box').html(data.message);					
				
			   }
			   else
			   {
			    	$('.loader').hide();
					window.location.href = url_path;					
			   }
			  
            },
            error:function(data){
                    $('.loader').hide();
                    $('.error_box').html('Something went wrong! Please try again.');
            }            
        });
    }
});

jQuery.validator.addMethod("carYear", function(value, element) { 
			var today = new Date();
			var thisYear = today.getFullYear();
		    return value > 1900 && value != "" && value <= thisYear; 
		}, "Enter valid year");


 
});