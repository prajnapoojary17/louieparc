$(document).ready(function(){
if($('#userId').val()){
$("#email").prop("readonly", true);
$("#password").prop("readonly", true);
$("#rpassword").prop("readonly", true);
}

  	var $validator = $("#userForm").validate({
	 ignore: ":hidden",
		 rules: {
				email: {
				required: true,
				email: true,
				remote: {url: baseUrl + "usermanagement/api/validation", type : "post",
						data: {entityExistence: function(){return false;} },
						async:false
				}},
				password : {
				minlength: 7
				},
                rpassword : {
				minlength: 7,equalTo: "#password"

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
				name: {
				required: true
				},
				fname: {
				required: true
				},
				lname: {
				required: true
				},
				city: {
				required: true
				},
				state: {
				required: true
				},
				zip: {
				required: true
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
				billing_zip: {
					number: true,
					minlength: 5,
					maxlength: 5
				},
				rent_zip: {
					number: true,
					minlength: 5,
					maxlength: 5
				},
				street: {
				required: true
				},
				model: {
				required: true
				},
				year: {
				required: true,
				carYear:true,
				number: true,
				maxlength: 4
				},
				color: {
				required: true
				},
				'terms[]': {
				required: true
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

				name: {
				 required: "Please enter your name"
				},
				street: {
				required: "Please enter street name"
				},
				city: {
				required: "Please enter city name"
				},
				state: {
				required: "Please enter state name"
				},
				zip: {
				required: "Please enter zip name"
				},
				model: {
				required: "Please enter model name"
				},
				year: {
				required: "Please enter year"
				},
				color: {
				required: "Please enter color"
				},
				'terms[]': {
				required: "Please agree User Terms & Agreements"
				}
				}
		});
		jQuery.validator.addMethod("noSpace", function(value, element) { 
		  return value.indexOf(" ") < 0 && value != ""; 
		}, "No space please and don't leave it empty");

		jQuery.validator.addMethod("carYear", function(value, element) { 
		  return value > 1900 && value != ""; 
		}, "Enter valid year");
		jQuery.validator.addMethod('validCard', function (value) {		
		if($("#cardResult").val()){
			return true;
		}
		else{
			return false;
		}
		return true;		
        }, "Invalid Credit Card");
		
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
		
		
	  	$('#rootwizard').bootstrapWizard({
	  		'tabClass': 'nav nav-pills',
			'nextSelector': '#fb-signup, .btn-press',
			'onTabClick':  function(tab, navigation, index) {
		//alert('on tab click disabled');
		return false;
		},
	  		'onNext': function(tab, navigation, index) {
	  			var $valid = $("#userForm").valid();
				//$("#userForm").validate().element($(this));				
	  			if(!$valid) {
	  				$validator.focusInvalid();
	  				return false;
	  			}
				
	  		},
			'onFinish' : function(tab,navigation, index) {
				var url_path = baseUrl + "usermanagement/api/saveParkerInfo/";
	  			var $valid = $(".userForm").valid();
				if($valid){
				$("#finish").attr('disabled', true);
				var formDataVal = document.forms.namedItem("userForm");
				var formVals = new FormData(formDataVal);
				$.ajax({
					method: "POST",
					url: baseUrl + "usermanagement/api/saveParker",
					dataType : "json",
					contentType: false,
					cache: false,
					processData: false,           
					data: formVals,
					success:function(data){
						$(".CCUserSave").attr('disabled', false);						
						if(typeof data.status !== typeof undefined){
						if(data.status){ 
						
						window.location.href = url_path+data.user_id;
						
						}else if(typeof data.message !== typeof undefined){
						$('.CCServerError').html(data.message);//setTimeout(function() { $('#error').focus(); }, 50);	//$('.CCServerError').show().find('div').html(data.message);
						}
						}
					},
					complete:function(){
						$('.CCServerError').html(data.message);
					}
				});
				}
				else{
					$('.CCServerError').html('');
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
	
	$(".gonext").click(function(){
				$(".navbar li a[href='#tab3']").tab("show")
			});	
			
	$(".gonext2").click(function(){	

				$(".navbar li a[href='#tab4']").tab("show")
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

});

function bindValidation(){
     $.validator.addMethod("password_valid", function(value, element) {
        if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			return true;
		}
		if(value == ""){
			return false
		}
		return true;
    }, "This field is required");
	
	 $.validator.addMethod("rpassword_valid", function(value, element) {
        if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			return true;
		}
		if(value == ""){
			return false
		}
		return true;
    }, "This field is required");
	

jQuery.validator.addMethod("uniqueUser", function(value, element) {
    var response;
	
	var user=$('#username').val();
    $.ajax({
        type: "POST",
        url: baseUrl + "usermanagement/api/validation",
        data:{username:user},
        async:false,
        success:function(data){
		
         response = data;
        }
    });
	// if(parseInt($(".userForm").find('[name="id"]').val())> 0){
    if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			
		return true;
	}
		if(value == "" || response == "false"){

			return false
		}
		return true;
	
	
}, "user name is Already exist");

	
	 $.validator.addMethod("firstName_valid", function(value, element) {
        if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			return true;
		}
		if(value == ""){
			return false
		}
		return true;
    }, "This field is required");
	
	 $.validator.addMethod("lastName_valid", function(value, element) {
        if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			return true;
		}
		if(value == ""){
			return false
		}
		return true;
    }, "This field is required");
	
	$.validator.addMethod("model_valid", function(value, element) {
        if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			return true;
		}
		if(value == ""){
			return false
		}
		return true;
    }, "This field is required");
	
	$.validator.addMethod("year_valid", function(value, element) {
        if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			return true;
		}
		if(value == ""){
			return false
		}
		return true;
    }, "This field is required");
	
	$.validator.addMethod("color_valid", function(value, element) {
        if(parseInt($(".userForm").find('[name="id"]').val()) > 0){
			return true;
		}
		if(value == ""){
			return false
		}
		return true;
    }, "This field is required");
	

jQuery.validator.addMethod("uniqueEmail", function(value, element) {

    var response;
	
	var emails=$('#email').val();
    $.ajax({
        type: "POST",
        url: baseUrl + "usermanagement/api/validation",
        data:{email:emails, id: parseInt($(".userForm").find('[name="id"]').val())},
        async:false,
        success:function(data){
		
         response = data;
        }
    });
	
		if(value == "" || response == "false"){
			$('#errors').html('error');
			//return false;
		}
		//return true;
	

}, "Email Id is Already Exist");



    valObj = $(".userForm").validate({

        rules: {     
                username : { required: true,uniqueUser:true},
				email : {required: true,uniqueEmail:true},
				password : {password_valid: true,minlength: 7},
                rpassword : {rpassword_valid: true,minlength: 7,equalTo: "#password"},
				contactnum : {required: true, number: true},
				cardNumber : {required: true, number: true},
				firstName  : {required:true},
				lastName   : {required:true},
				model		: {required:true},
				year		: {required:true},
				color		: {required:true}
                //img : {image_valid: true}
        }

    });
	
	    
}

function clearForm(){
   
    $(".userForm").find('[name="id"]').val("0");
    $(".userForm").find('.CCInput').val('');
}



$(".upload-button").on('click', function() {
       $(".profImage").click();
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