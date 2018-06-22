$(document).ready(function() {
$('.profileinfo').validate({
rules: {          
		
                profImage:{
                required: true,              
                filesize: 7340032
                },
                firstname:	{
						required: true
					},
		lastname:	{
						required:true
					},
		mobileno:	{
						required: true,	
						number:true,
						minlength: 10,						
						maxlength: 12
					},
		bmonth: 	{
						selectmonth: true
					},
		bday:		{
						selectday:true
					},
		byear: 		{
						selectyear:true,	
						checkdate:true
					},
		},
messages: {				
		byear:		{
						checkdate: "Please select valid DOB"
					}				
		},
submitHandler: function(form) {	
	var url_path = baseUrl + "dashboard";
	$('.loader').show();
	var formDataVal = document.forms.namedItem("profileinfo");
	var formVals = new FormData(formDataVal);
    $.ajax({	
		    method		: "POST",		
			url			: baseUrl + "profile/update_renterprofile",
			dataType 	: "json",
			contentType	: false,
			cache		: false,
			processData	: false,           
			data		: formVals,			
			success		:function(data) {			
							if(typeof data.status !== typeof undefined){
							if(data.status){						
								window.location.href = url_path;
							}else{						
								$('.CCServerError').html(data.message);						
								$('.loader').hide();							
							}
							}
			  
			}            
	});
    }
});
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

$.validator.addMethod('filesize', function (value, element, param) {   
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than 7MB');

$(".upload-button").on('click', function() {
       $(".profImage").click();
});

$(".profImage").on('change', function () {
var imgkbytes = this.files[0].size;
var rsize = Math.round(parseInt(imgkbytes)/1024);   
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


$(".remove-button").on('click', function() {
  var agree = confirm("Are you sure you want to remove profile image?");
    if (agree) {
    var url_path = baseUrl + "profile";
    $.ajax({	
		    method		: "POST",		
			url			: baseUrl + "profile/api/removeProfilleimg",
			dataType 	: "json",
			contentType	: false,
			cache		: false,
			processData	: false, 			
			success		:function(data) {			
							if(typeof data.status !== typeof undefined){
							if(data.status){						
								window.location.href = url_path;
							}else{						
								$('.CCServerError').html(data.message);						
								$('.loader').hide();							
							}
							}
			  
			}            
	});   
    }
    return false;	
});



});