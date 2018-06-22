$(document).ready(function() {
    $('#accHolderType').on('change',function(){
        if( $(this).val()==="company"){
        $("#business").show()
        }
        else{
        $("#business").hide()
        }
    });
$('.account').validate({
rules: {    
            card_number:{
                validCard: true
            },
            routing_number:{
                validRout: true
            },
            business_tax_id:{                   
                    number:true,
                    minlength: 9,						
                    maxlength: 9
            },
            phone : {						
                    required: true,	
                    number:true,
                    minlength: 10,						
                    maxlength: 12
            },
            ssn_last_4 : {						
                    required: true,	
                    number:true,
                    minlength: 4,						
                    maxlength: 4
            },
            accHolderType:{
                    selecttype: true
            },
            bmonth : {
                    selectmonth: true
            },
            bday : {
                    selectday:true
            },
            byear : {
                    selectyear:true,	
                    checkdate:true
            },
            acc_zip: {
                    number: true,
                    minlength: 4,
                    maxlength: 5			 
            }
	},
    submitHandler: function(form) {	
	var url_path = baseUrl + "dashboard/accounts";
	$('.loader').show();
        $.ajax({
			type: "POST",
			url: baseUrl + "usermanagement/api/saveBankAccount",
			data:$(form).serialize(),
			async:true,
			dataType : "json",
			success:function(data) {			
              if(data.status){
						$('.loader').hide();
					window.location.href = url_path;
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
            $('.error_box').html('Connection Error! Please try again.');
            }            
        });
    }
});
        Stripe.setPublishableKey('pk_test_l67m8FSQRjOdwMgm61AlgELz');	
        
        jQuery.validator.addMethod('validCard', function (value) {		
        if (Stripe.bankAccount.validateAccountNumber(value,'US')) {
        return true;  
        }	
        else{
        return false;
        }		
        }, "The account number appears to be invalid");

        jQuery.validator.addMethod('validRout', function (value) {
        if (Stripe.bankAccount.validateRoutingNumber(value,'US')) {
        return true;  
        }
        else{
        return false;
        }		
        }, "The  routing number appears to be invalid");

        jQuery.validator.addMethod('selecttype', function (value) {
			return (value != '0');
        }, "Select account holder type");	
               jQuery.validator.addMethod('selectmonth', function (value) {
			return (value != '0');
        }, "Month is required");
		
		jQuery.validator.addMethod('selectday', function (value) {
			return (value != '0');
        }, "Date is required");
	
		jQuery.validator.addMethod('selectyear', function (value) {
			return (value != '0');
        }, "Year is required");
        
        jQuery.validator.addMethod('checkdate', function (value) {
		var dd = $('#bday').val();
		var mm = $('#bmonth').val();
		var yy = $('#byear').val();			
		if ((mm==4 || mm==6 || mm==9 || mm==11) && dd ==31)
		return false;
		else if (mm == 2)
		{
		var isleap = (yy % 4 == 0 && (yy % 100 != 0 || yy % 400 == 0));
		if (dd> 29 || (dd ==29 && !isleap))
		return false;
		}
		return true;

});
 
});

