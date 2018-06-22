$(document).ready(function() {

$('#rating').on('rating.change', function(event, value, caption) {
    $('#starrating').val(value);	       
});

$('#rating').on('rating.clear', function(event) {
    $('#starrating').val('');	  
});

$('.reviews').validate({
rules:  {     
			reviewtitle:{
				required: true
			},
			review:{
				required: true				
			}
		},
messages: {
			reviewtitle: {
				required: "Please enter Review title"				
			},
			review:{
				required: "Please enter Review"				
			}
		},
submitHandler: function(form) {
    if($('.label-default').html() != 'Not Rated'){
	var url_path = baseUrl + "dashboard";
	$('.loader').show();
        $.ajax({
			type: "POST",
			url: baseUrl + "profile/saveReview",
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
			  
            }            
        });
	}else
		$("label[for='rating']").html('Plaese Select Rating');		
    }
});

});