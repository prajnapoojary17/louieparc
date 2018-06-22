$(document).ready(function() {

$('.message').validate({
rules: {          
		subject:	{
						required: true
					},
		message:	{
						required:true
					},		
	}

});

$('.send-btn').on('click',function(){
var $valid = $(".message").valid();
				//$("#userForm").validate().element($(this));				
	  			if(!$valid) {
	  				$validator.focusInvalid();
	  				return false;
	  			}
var url_login = baseUrl + "login";
var url_path = baseUrl + "dashboard";
$('.loader').show();
	var formDataVal = document.forms.namedItem("message");
	var formVals = new FormData(formDataVal);
        $.ajax({	
		            method: "POST",		
					url: baseUrl + "profile/api/reportUsermail",
					dataType : "json",
					contentType: false,
					cache: false,
					processData: false,           
					data: formVals,			
			success:function(data) {
                            if(data.login){                        
                                window.location.href = url_login;
                            }
					if(typeof data.status !== typeof undefined){
						if(data.status){
                        $('.loader').hide();						
						$('.send-btn').toggleClass('send-clicked');
						$('.send-btn span').text(function(i, text) {
						return text === "Sent!" ? "Send" : "Sent!";
						});
                        $('#mailSent').show().delay(2500).fadeOut();
                        $('#subject').val('');
						$('#message').val('');						
						window.setTimeout(function(){						
						window.location.href = url_path;
						}, 4000);
						}else{						
						$('.CCServerError').html(data.message);						
													
						}
						}
			  
            }            
        });
});


});