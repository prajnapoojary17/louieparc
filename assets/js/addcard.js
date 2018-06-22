$(document).ready(function() {
$('.addcard').validate({
rules: {    
            card_number:{
                validCard: true
            },
            security_code: {						
                    required: true,	
                    number:true,
                    validCVC:true,
                    minlength: 4,						
                    maxlength: 4
            },
            expiration_date:{
                    expirationDate: true
            },            
            billing_zip: {
                    number: true,
                    minlength: 4,
                    maxlength: 5			 
            },
            billing_phone: {
                number: true,
                minlength: 10,
                maxlength: 12
            }
	},
    submitHandler: function(form) {	
    $('.loader').show();
	var url_path = baseUrl + "dashboard";
	$('.loader').show();
        $.ajax({
			type: "POST",
			url: baseUrl + "booking/api/saveCardInfo",
			data:$(form).serialize(),
			async:true,
			dataType : "json",
			success:function(data) {			
              if(data.status){
						$('.loader').hide();
					window.location.href = url_path;
			   }
                           else if(data.message=='session'){
                               $('.loader').hide();
                               window.location.href = baseUrl + "login";
                           }
			   else
			   { 
			    	$('.loader').hide();
					$(".error_box").show();
					$("#submit").attr('disabled',false);
					$('.error_box').html(data.message);						
			   }
			  
            },
            error:function(data){
                    $('.loader').hide();
                    $('.error_box').html('Something went wrong! Please try again.');
            }            
        });
    }
});

jQuery.validator.addMethod('expirationDate', function (value) {
			var today = new Date();
			var thisYear = today.getFullYear();
			var expMonth = +value.substr(0, 2);
			var expYear = +value.substr(3, 4);

		return (expMonth >= 1 
            && expMonth <= 12
            && (expYear >= thisYear && expYear < thisYear + 20)
            && (expYear == thisYear ? expMonth >= (today.getMonth() + 1) : true))
        }, "Invalid expiration date");
        
       Stripe.setPublishableKey('pk_test_l67m8FSQRjOdwMgm61AlgELz');
        
        jQuery.validator.addMethod('validCard', function (value) {		
        if (Stripe.card.validateCardNumber(value)) {
        return true;  
        }	
        else{
        return false;
        }		
        }, "Invalid Card Number");

        jQuery.validator.addMethod('validCVC', function (value) {
        if (Stripe.card.validateCVC(value)) {
        return true;  
        }
        else{
        return false;
        }		
        }, "Invalid CVC code");


 
});

