$(document).ready(function(){
var emails=$('#email').val();
$(".error_box").hide();
$('.forgot').validate({
rules: {     
             
				email : {required: true}
				},
				 messages: {
                   
                  email: "<div class='error_box' style='display:block'>Please enter a valid email address</div>",
                  
                },
   

    submitHandler: function(form) {
	$('.loader').show();
        $.ajax({
           type: "POST",
        url: "login/forgot",
        data:$(form).serialize(),
        async:true,
        success:function(data) {
               if(data == 0)
			   {
					$('.loader').hide();
					$(".error_box").show();
					$("#submit").attr('disabled',false);
					$('.error_box').html("This email Id is not registered with us.");
			   }
			   else
			   {
					$('.loader').hide();
					$(".error_box").show();
					$("#submit").attr('disabled',true);
					$('.error_box').html("A link has been sent to your registered email id.Please check your email");
					$("form").trigger("reset");
			   }
            }            
        });
    }
});

var url_path = baseUrl + "dashboard";
$('.verify').validate({
			rules: {  
				vcode : {required: true,						
						maxlength: 5
				}
				},
				 messages: {
                  vcode: "<div class='error_box' style='display:block'>Please check your code</div>"                  
                },
   

    submitHandler: function(form) {
	$('.loader').show();
        $.ajax({
           type: "POST",
        url: "dashboard/verifyCode",
        data:$(form).serialize(),
        async:true,
        success:function(data) {
               if(data == 0)
			   {
					$('.loader').hide();
					$(".error_box").show();
					$("#submit").attr('disabled',false);
					 $('.error_box').html("Invalid Token.");
			   }
			   else
			   {					
					$("#submit").attr('disabled',true);
					window.location.href = url_path;
			   }
            }            
        });
    }
});
});