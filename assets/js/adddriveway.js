$(document).ready(function() {
$('.CCServerError').html('');	
$('.error_a').hide();
  	var $validator = $(".userForm").validate({
		  rules: {	
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
			
				
			 rent_zip: {
				number: true			 
			 },	
			
			
			 price: {
			 number: true,
			 range: [1, 150]
			 },
			 slot: {
			 number: true,
			 range: [1, 100]
			 },
                         flatprice: {
			 number: true,
			 range: [1, 150]
			 },
			 hourlyprice: {
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
			 chkbox4:
			 {
				required:true
			 }
			 
			 
		  },
				messages: {
				
				autocomplete2:{
				remote:"Driveway already exist"
				}
				
				}
		});

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
				var url_path = baseUrl + "dashboard";
	  			var $valid = $(".userForm").valid();
				if($valid){			
				$('.loader').show();				
				var formDataVal = document.forms.namedItem("userForm");
				var formVals = new FormData(formDataVal);
				$.ajax({
					method: "POST",
					url: baseUrl + "profile/saveDriveway",
					dataType : "json",
					contentType: false,
					cache: false,
					processData: false,           
					data: formVals,
					success:function(data){
                                                if(data.login){                        
                                                    window.location.href = url_path;
                                                }
						if(typeof data.status !== typeof undefined){
						if(data.status){						
						window.location.href = url_path;
						}else{						
						$('.CCServerError').html(data.message);						
						 $('.loader').hide();							
						}
						}
					},
                    error:function(data){
                            $('.loader').hide();
                            $('.CCServerError').html('Something went wrong! Please try again.');
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
        //var form = data.form, files = data.files, extra = data.extra,
         //   response = data.response, reader = data.reader;
        console.log('File batch pre upload');
		$(".fileinput-upload").removeClass('btn-danger pulse animated');	
		$(".fileinput-upload").addClass('btn-default');
		$(".fileinput-upload").tooltip('hide');
		
    });
		$('#drivewayphotos').on('fileloaded', function(event, file, previewId, index, reader) {
        $(".fileinput-upload").addClass('btn-danger pulse animated');	   
        $(".fileinput-upload").tooltip('show');
		//console.log('fileloaded');
    });
});