$(document).ready(function(){

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
        url: baseUrl+ "dashboard/verifydriveway/verify",
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