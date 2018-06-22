$(document).ready(function() {
if($('#userId').val()){
$("#email").prop("readonly", true);
$("#password").prop("readonly", true);
$("#rpassword").prop("readonly", true);
}
$('.error_a').hide();
  	var $validator = $(".userForm").validate({
		  rules: {
			email: {
				required: true,
				email: true,
				remote: {url: baseUrl + "usermanagement/api/validation", type : "post",
						data: {entityExistence: function(){return false;} },
						async:false
				}},
			 inputMobile: {
		     required: true,
		     minlength: 3 
		    },
			password:{
                        minlength: 7,
                        maxlength: 32,
                        required:true
                    },
            rpassword:{
                        required:true,
                        equalTo:password
             },				
				username: {
				required: true,	
				noSpace: true,	
				remote: {url: baseUrl + "usermanagement/api/validation", type : "post",
						data: {entityExistence: function(){return false;} },
						async:false
				}},
				contactnum : {
						required: true,	
						number:true,
						minlength: 10,						
						maxlength: 12
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
			autocomplete: {
			   required: true,	
			   addressInfo: true			 
			 },
			autocomplete2: {
			   required: true,	
			   addressInfo2: true  
			 
			 },
			 card_number:{
			   validCard: true
			 },
			 expiration_date:{
			 expirationDate:true
			 },
			 security_code:{
			 number:true,
			 minlength:3,
			 maxlength:4
			 },
			 billing_phone : {						
						number:true,									
						maxlength: 12
				},
				
			 billing_mobile : {
						required: true,	
						number:true,
						minlength: 10,						
						maxlength: 12
				},
			 rent_zip: {
				number: true,
			    minlength: 5,
                maxlength: 5
			 
			 },
			 billing_zip: {
				number: true,
			    minlength: 5,
                maxlength: 5
			 
			 },
			 security_code:
			 {
				number: true
			 },
			 hearfrom: {
			   required:true
			 },
			 about: {
			  required : true
			  
			 },
			 price: {
			 number: true,
			 range: [1, 150]
			 },
			 chkbox1:
			 {
				required:true
			 },
			 chkbox2:
			 {
				required:true
			 },
			 chkbox3:
			 {
				required:true
			 },
			 agreement:
			 {
				tokenGen:true
			 }
			/* state:
			 {
			   remote: {
						
						url: baseUrl + "usermanagement/api/addreassvalidation", type : "post",
						data: {entityExistence: function(){return false;} },
						async:false
				}
			 },
			 city : {				
				remote: {		
						url: baseUrl + "usermanagement/api/addreassvalidation", type : "post",
						data: {entityExistence: function(){return false;} },
						async:false
			 }
			}*/
			 
		  },
				messages: {
				email: {
				required: "Please enter an email address",
				email: "Not a valid email address",
				remote:"Email ID already exist"
				},
				username:{
				required: "Please enter an username",				
				remote:"Username already exist"
				},
				byear:{
					checkdate: "Please select valid DOB"

					},
					
				/*state: {
					remote: "Please enter valid address"
				
				},
				city: {
					remote: "Please enter valid address"
				}*/
				}
		});
		jQuery.validator.addMethod("noSpace", function(value, element) { 
		return value.indexOf(" ") < 0 && value != ""; 
		}, "No space please and don't leave it empty");
		jQuery.validator.addMethod('selectmonth', function (value) {
			return (value != '0');
        }, "Month is required");
		
		jQuery.validator.addMethod('selectday', function (value) {
			return (value != '0');
        }, "Date is required");
	
		jQuery.validator.addMethod('selectyear', function (value) {
			return (value != '0');
        }, "Year is required");
		
		jQuery.validator.addMethod('addressInfo', function (value) {
		//return (value != '');
		if($('#postal_code').val()==''){		
		return false;}
		return true;
		}, "Select valid address here");
		
		jQuery.validator.addMethod('addressInfo2', function (value) {
		//return (value != '');
		if($('#postal_code2').val()==''){		
		return false;}
		return true;
		}, "Select valid address here");
		
		jQuery.validator.addMethod('validCard', function (value) {		
		if($("#cardResult").val()){		
			return true;
		}
		else{		
			
			return false;
		}
		return true;		
        }, "Invalid Credit Card");
		
		jQuery.validator.addMethod('tokenGen', function (value) {
 if($('#agreement').parent().find('input[type="checkbox"]').is(':checked'))
 {
 if($('#stripeToken').val()==''){
		Stripe.setPublishableKey('pk_test_l67m8FSQRjOdwMgm61AlgELz');
			Stripe.bankAccount.createToken({
			  country: 'US',
			  currency: 'USD',
			  routing_number: '111000025',
			  account_number:  '000123456789',
			  account_holder_name: $('#nameon_card').val(),
			  account_holder_type: 'individual'
			}, stripeResponseHandler);	}
} return true;			
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
		
		jQuery.validator.addMethod('checkdate', function (value) {
		var dd = $('#bday').val();
		var mm = $('#bmonth').val();
		var yy = $('#byear').val();
		//var mydate1 = mm+'/'+dd+'/'+yy;
		//var mydate = new Date(yy, mm - 1, dd);	
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

		
		
		
	  	$('#rootwizard').bootstrapWizard({
		'tabClass': 'nav nav-pills',
		'nextSelector': '#fb-signup, .btn-press',
        'onNext': function(tab, navigation, index) {
	  			var $valid = $("#userForm").valid();
	  			if(!$valid) {
	  				$validator.focusInvalid();
	  				return false;
	  			}

	  		},

			'onFinish' : function(tab, navigation, index) {
			
			 
			
				var url_path = baseUrl + "usermanagement/api/saveParkerInfo/";
	  			var $valid = $(".userForm").valid();
				if($valid){				
			
				  $("#CCUserSave").addClass('disabled')				
				var formDataVal = document.forms.namedItem("userForm");
				var formVals = new FormData(formDataVal);
				$.ajax({
					method: "POST",
					url: baseUrl + "usermanagement/api/saveRenter",
					dataType : "json",
					contentType: false,
					cache: false,
					processData: false,           
					data: formVals,
					success:function(data){									
						if(typeof data.status !== typeof undefined){
						if(data.status){						
						window.location.href = url_path+data.user_id;
						}else if(typeof data.message !== typeof undefined){						
						$('.CCServerError').html(data.message);						
						 $("#CCUserSave").removeClass('disabled')							
						}
						}
					},
					complete:function(){
						//$(".CCUserSave").attr('disabled', false);
					}
				});
				}else{
					$(".CCUserSave").attr('disabled', false);
				}
	  		},
			onTabShow: function(tab, navigation, index) {
				var $total = navigation.find('li').length;
				var $current = index+1;
				var $percent = ($current/$total) * 100;
				$('#rootwizard').find('.bar').css({width:$percent+'%'});
				
				// If it's the last tab then hide the last button and show the finish instead
				if($current >= $total) {
					$('#rootwizard').find('.pager .next').hide();
					$('#rootwizard').find('.pager .finish').show();
					$('#rootwizard').find('.pager .finish').removeClass('disabled');
				} else {
					$('#rootwizard').find('.pager .next').show();
					$('#rootwizard').find('.pager .finish').hide();
				}
				
			}
	  	});	

		
	$(".CCUserNext").click(function(){
		 
			var $valid = $("#userForm").valid();
	  			if(!$valid) {
	  				$validator.focusInvalid();					
                        return false;                
	  				
	  			}
				else{
				
				var wizard = $('#rootwizard').bootstrapWizard();
					wizard.bootstrapWizard('next');

				}
			});		

			$(".gonext").click(function(){
				$(".navbar li a[href='#tab8']").tab("show")
			});	
			
function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $('#userForm');

  if (response.error) { // Problem!

    // Show the errors on the form
    $form.find('.payment-errors').text(response.error.message);
   // $form.find('button').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token into the form so it gets submitted to the server:
    $('#stripeToken').val(token);
return token;
    // Submit the form:
   // $form.get(0).submit();

  }
}				
			
$(".upload-button").on('click', function() {
       $(".profImage").click();
    });

$("#drivewayphotos").fileinput({
	uploadUrl: baseUrl + 'usermanagement/api/uploaddriveway', // you must set a valid URL here else you will get an error
	allowedFileExtensions : ['jpg', 'png','gif'],
	uploadAsync: false,
	overwriteInitial: false,
	maxFileSize: 1000,
	//maxFilesNum: 4,
	maxFileCount: 4,
	//allowedFileTypes: ['image', 'video', 'flash'],
	slugCallback: function(filename) {	
	return filename.replace('(', '_').replace(']', '_');
	}
}).on('filebatchuploadsuccess', function(event, data, previewId, index) {
	$('.kv-file-remove').hide();
   var form = data.form, files = data.files, 
    response = data.response;
	  $("#flname").val(response);
   
});

	
 $(".profImage").on('change', function () {
 
     var countFiles = $(this)[0].files.length;
 
     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $(".pic");
     image_holder.empty();
 
     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
         if (typeof (FileReader) != "undefined") {
 
             for (var i = 0; i < countFiles; i++) {
 
                 var reader = new FileReader();
                 reader.onload = function (e) {
                     $("<img />", {
                         "src": e.target.result,
                             "class": "thumbimage"
                     }).appendTo(image_holder);
                 }
 
                 image_holder.show();
                 reader.readAsDataURL($(this)[0].files[i]);
             }
 
         } else {
             alert("It doesn't supports");
         }
     } else {
         alert("Select Only images");
     }
 });
 	
});

