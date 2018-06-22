$(document).ready(function() {
$('#accHolderType').on('change',function(){
    if( $(this).val()==="company"){
    $("#business").show()
    }
    else{
    $("#business").hide()
    }
});
if($('#userId').val()){
$("#email").prop("readonly", true);
$("#password").prop("readonly", true);
$("#rpassword").prop("readonly", true);
}
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
                        maxlength: 128,
                        required:true
                    },
            rpassword:{
                        required:true,
                        equalTo:password
             },				
				username: {
				required: true,	
				noSpace: true,
                                regx: /^[a-zA-Z0-9_\. ]+$/,
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
			   addressInfo: true,
				remote: {url: baseUrl + "usermanagement/drivewayExist", type : "post",
						
						data: {						
							  route: function()
							  {
								  return $('#userForm :input[name="route"]').val();
							  },
							  city: function()
							  {
								  return $('#userForm :input[name="city"]').val();
							  },
							  state: function()
							  {
								  return $('#userForm :input[name="state"]').val();
							  },
							 street: function()
							  {
								  return $('#userForm :input[name="streetaddres"]').val();
							  },
							 zip: function()
							  {
								  return $('#userForm :input[name="zip"]').val();
							  },
							entityExistence: function()
							{return false;}	,						  
						
							},async:false
							
					}			   
			 },
			autocomplete2: {
			   required: true,	
			   addressInfo2: true,
				remote: {url: baseUrl + "usermanagement/drivewayExistCheck", type : "post",
						
						data: {						
							  route: function()
							  {
								  return $('#userForm :input[name="route2"]').val();
							  },
							  city: function()
							  {
								  return $('#userForm :input[name="rent_city"]').val();
							  },
							  state: function()
							  {
								  return $('#userForm :input[name="rent_state"]').val();
							  },
							 street: function()
							  {
								  return $('#userForm :input[name="rent_streetaddres"]').val();
							  },
							 zip: function()
							  {
								  return $('#userForm :input[name="rent_zip"]').val();
							  },
							entityExistence: function()
							{return false;}	,						  
						
							},async:false
							
					}			   
			 
			 },
			 card_number:{
			   number:true,
			   validCard: true
			 },
			 accHolderType:{
			   selecttype: true
			 },
			  routing_number:{
			   validRout: true
			 },
			 ssn_last_4 : {						
                            required: true,	
                            number:true,
                            minlength: 4,						
                            maxlength: 4
			 },
                         business_tax_id:{                   
                                number:true,
                                minlength: 9,						
                                maxlength: 9
                        },			 	
			 rent_zip: {
                            number: true,
                            minlength: 4,
                            maxlength: 5			 
			 },
			 acc_zip: {
                            number: true,
			    minlength: 4,
                            maxlength: 5			 
			 },
                         amonth : {
				selectmonth: true
			 },
			 aday : {
				selectday:true
			 },
			 ayear : {
				selectyear:true,	
				checkdate:true
			 },
			 hearfrom: {
			   required:true
			 },
			 about: {
			  required : true			  
			 },
                        flatprice: {
                            number: true,
                            range: [1, 150]
			 },
			 hourlyprice: {
                            number: true,
                            range: [1, 150]
			 },
			 
			 slot: {
                            number: true,
                            range: [1, 50]
			 },             
			 chkbox1:
			 {
                            required:true
			 },
			 chkbox2:
			 {
                            required:true
			 },
			 agreement:
			 {
                            tokenGen:true
			 }
			 
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
				autocomplete:{
				remote:"Driveway already exist"
				},
				autocomplete2:{
				remote:"Driveway already exist"
				}
				
				}
		});                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
        
		jQuery.validator.addMethod("noSpace", function(value, element) { 
		return value.indexOf(" ") < 0 && value != ""; 
		}, "No space please and don't leave it empty");     
                
                jQuery.validator.addMethod("regx", function(value, element, regexpr) {          
                return regexpr.test(value);
             }, "Please enter a valid username.");  
             
		jQuery.validator.addMethod('selectmonth', function (value) {
			return (value != '0');
        }, "Month is required");
		
		jQuery.validator.addMethod('selectday', function (value) {
			return (value != '0');
        }, "Date is required");
	
		jQuery.validator.addMethod('selectyear', function (value) {
			return (value != '0');
        }, "Year is required");
		
		jQuery.validator.addMethod('selecttype', function (value) {
			return (value != '0');
        }, "Select account holder type");
		
		jQuery.validator.addMethod('addressInfo', function (value) {		
		if($('#street_number').val()=='' || $('#route').val()=='' || $('#locality').val()=='' || $('#administrative_area_level_1').val()=='' || 
			$('#postal_code').val()=='' || $('#country').val()==''){		
		return false;}
		return true;
		}, "Please select valid address here");
		
		jQuery.validator.addMethod('addressInfo2', function (value) {		
		if($('#street_number2').val()=='' || $('#route2').val()=='' || $('#locality2').val()=='' || $('#administrative_area_level_12').val()=='' || 
			$('#postal_code2').val()=='' || $('#country2').val()==''){
		return false;}
		return true;
		}, "Please select valid address here");		
	
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

		
		jQuery.validator.addMethod('tokenGen', function (value) {
		 if($('#agreement').parent().find('input[type="checkbox"]').is(':checked'))
		 {		
			if($('#stripeError').val()==1)
			{
			return false;
			}
			
		} return true;			
		}, "Account details is invalid");
		
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

		jQuery.validator.addMethod("checkprice", function(value, element) {
			var flatprice = $('#currency').val();			
		    if(value <= flatprice){
			    return true; 
			}
		}, "Hourly price cannot be greater than Flat price");
        
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
'onPrevious': function(tab, navigation, index) {
	  			$(".CCServerError").html('');

	  		},
			'onFinish' : function(tab, navigation, index) {
				var url_path = baseUrl + "usermanagement/api/saveParkerInfo/";
	  			var $valid = $(".userForm").valid();
				if($valid){			
				$('.loader').show();				
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
						}else{						
						$('.CCServerError').html(data.message);						
						 $('.loader').hide();							
						}
						}
					},
					complete:function(){
						//$(".CCUserSave").attr('disabled', false);
					}
				});
				}else{
					 $('.loader').hide();
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
$('#drivewayphotos').on('filereset', function(event) {
    $(".fileinput-upload").tooltip('hide');	
});

    $('#drivewayphotos').on('filebatchpreupload', function(event, data, previewId, index) {
		$(".fileinput-upload").removeClass('btn-danger pulse animated');	
		$(".fileinput-upload").addClass('btn-default');
		$(".fileinput-upload").tooltip('hide');
		
    });
	
	$('#drivewayphotos').on('fileloaded', function(event, file, previewId, index, reader) {
        $(".fileinput-upload").addClass('btn-danger pulse animated');	   
        $(".fileinput-upload").tooltip('show');
    });
	
 $(".profImage").on('change', function () {
     var imgkbytes = this.files[0].size;
     var rsize = Math.round(parseInt(imgkbytes)/1024);
     //alert(rsize);  
     //  var imgkbytes = Math.round(parseInt(imgbytes)/1024);       
     
     var countFiles = $(this)[0].files.length; 
     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $(".pic");
     image_holder.empty();
    if (rsize <= 7000) {        
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
 } else {
    alert("Upload size is limited to 7MB"); 
 }
 });
 
 
 $(".gonext2").click(function(){ 
				$("#card_number").val('');
				$("#routing_number").val('');
                                $("#ssn_last_4").val('');			
                                $("#acc_fname").val('');
                                $("#acc_lname").val('');
                                $("#acc_address1").val('');
                                $("#acc_address2").val('');
                                $("#acc_city").val('');
                                $("#acc_state").val('');
                                $("#acc_zip").val('');
                                $("#business_name").val('');
                                $("#business_tax_id").val('');
				$("label[for='card_number']").html('');
                                $("label[for='ssn_last_4']").html('');
                                $("label[for='acc_fname']").html('');
                                $("label[for='acc_lname']").html('');
                                $("label[for='acc_address1']").html('');
                                $("label[for='acc_address2']").html('');
                                $("label[for='acc_city']").html('');
                                $("label[for='acc_state']").html('');
                                $("label[for='acc_zip']").html('');
				$("label[for='routing_number']").html('');					
				$("label[for='accHolderType']").html('');
                                $("label[for='amonth']").html('');
                                $("label[for='aday']").html('');
                                $("label[for='ayear']").html('');
                                $("label[for='business_name']").html('');
                                $("label[for='business_tax_id']").html('');
                                $("#aday").val('0');
                                $("#amonth").val('0');
                                $("#ayear").val('0');
                                $("#accHolderType").val('0');
				$(".navbar li a[href='#tab8']").tab("show")
			});	

 
});