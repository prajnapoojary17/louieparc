$(document).ready(function() {
$('.profileinfo').validate({
    rules: {          
	firstname:{
		required: true
	},
	lastname:{
		required:true
	},
	mobileno:{
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
	var url_path    = baseUrl + "dashboard";
	$('.loader').show();
	var formDataVal = document.forms.namedItem("profileinfo");
	var formVals    = new FormData(formDataVal);
        $.ajax({	
		method      : "POST",		
		url         : baseUrl + "profile/update_profile",
		dataType    : "json",
		contentType : false,
		cache       : false,
		processData : false,           
		data        : formVals,			
		success:function(data) {
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

$(".upload-button").on('click', function() {
    $(".profImage").click();
});

$(".profImage").on('change', function () { 
    var imgkbytes = this.files[0].size;
    var rsize = Math.round(parseInt(imgkbytes)/1024);
    var countFiles      = $(this)[0].files.length; 
    var imgPath         = $(this)[0].value;
    var extn            = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    var image_holder    = $(".pic");
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

$(".editbtn").on('click',function(){
    var currentTD = $(this).parents('tr').find('td');
    if ($(this).html() == 'Edit') { 			
        $.each(currentTD, function () {
            var id = currentTD.closest("tr").find('.cid').text();
            $('.span_model'+id).hide();
            $('.span_cyear'+id).hide();
            $('.span_ccolor'+id).hide();
            $('.span_cnumber'+id).hide();
                        
            $('.input_model'+id).show();
            $('.input_cyear'+id).show();
            $('.input_ccolor'+id).show();
            $('.input_cnumber'+id).show();
            $('.undobtn'+id).show();
            $('.deletebtn'+id).hide();				
        });
	$(this).html('Save');	
    } else {		
            var cmodel   = 0;
            var cyear    = 0;
            var ccolor   = 0;
            var cnumber  = 0;
            var err      = 0;
            var $this    = $(this);
            var $tr      = $this.closest("tr");
            var	cid      = $tr.find('.cid').text();       		
            $.each(currentTD, function () {			
                cmodel = $tr.find('.input_model'+cid).val();
                if(cmodel == ""){
                        err = 1;
                        $tr.find('.input_model'+cid).addClass('tderror');					
                        $('.merror').html('Vehicle Model is required');}			
                else{
                        $('.merror').html('');
                        $tr.find('.input_model'+cid).removeClass('tderror');
                }
                cyear = $tr.find('.input_cyear'+cid).val();
                var today = new Date();
                var thisYear = today.getFullYear();
                var intRegex = /^\d+$/;
                if(cyear > thisYear){	
                        err = 1;					
                    $tr.find('.input_cyear'+cid).addClass('tderror');
                        $('.yerror').html('Enter valid Year');}
                else if(cyear == ""){	
                        err = 1;					
                    $tr.find('.input_cyear'+cid).addClass('tderror');
                        $('.yerror').html('Vehicle Year is required');}		
                else if(cyear < 1900 ){	
                        err = 1;					
                    $tr.find('.input_cyear'+cid).addClass('tderror');
                        $('.yerror').html('Enter valid Year');}	
                else if(!intRegex.test(cyear)){	
                        err = 1;					
                    $tr.find('.input_cyear'+cid).addClass('tderror');
                        $('.yerror').html('Enter numeric value');}            				
                else{
                        $('.yerror').html('');
                        $tr.find('.input_cyear'+cid).removeClass('tderror');
                }
                ccolor = $tr.find('.input_ccolor'+cid).val();
                if(ccolor == ""){
                        err = 1;
                    $tr.find('.input_ccolor'+cid).addClass('tderror');	
                        $('.cerror').html('vehicle Color is required');}	
                else{					
                        $tr.find('.input_ccolor'+cid).removeClass('tderror');
                        $('.cerror').html('');
                }
                cnumber = $tr.find('.input_cnumber'+cid).val();
                if(cnumber == ""){
                        err = 1;
                    $tr.find('.input_cnumber'+cid).addClass('tderror');
                        $('.nerror').html('License Plate Number is required');}	
                else{	
                        $('.nerror').html('');
                        $tr.find('.input_cnumber'+cid).removeClass('tderror');
                }			
            });
            if(err == 0){
                var url_path = baseUrl + "login";
		$.ajax({	
		    method: "POST",		
                    url: baseUrl + "profile/update_carinfo",
                    dataType : "json",					           
                    data: {	
                        id           : cid,
                        model        : cmodel,
                        year         : cyear,
                        color        : ccolor,
                        vehicleNumber: cnumber
                    },			
                    success:function(data) {
                        if(data.login){                        
                            window.location.href = url_path;
                        }
			if(typeof data.status !== typeof undefined){
                            if(data.status){
				$('.input_model'+cid).attr('value', cmodel);
                                $('.input_cyear'+cid).attr('value', cyear);
                                $('.input_ccolor'+cid).attr('value', ccolor);
                                $('.input_cnumber'+cid).attr('value', cnumber);

                                $('.input_model'+cid).attr('data-original-value', cmodel);
                                $('.input_cyear'+cid).attr('data-original-value', cyear);
                                $('.input_ccolor'+cid).attr('data-original-value', ccolor);
                                $('.input_cnumber'+cid).attr('data-original-value', cnumber);

                                $('.input_model'+cid).hide();
                                $('.input_cyear'+cid).hide();
                                $('.input_ccolor'+cid).hide();
                                $('.input_cnumber'+cid).hide();
                                
                                $('.undobtn'+cid).hide();
                                $('.deletebtn'+cid).show();
                                
                                $('.span_model'+cid).html(cmodel);
                                $('.span_cyear'+cid).html(cyear);
                                $('.span_ccolor'+cid).html(ccolor);
                                $('.span_cnumber'+cid).html(cnumber);				
                                $('.span_model'+cid).show();
                                $('.span_cyear'+cid).show();
                                $('.span_ccolor'+cid).show();
                                $('.span_cnumber'+cid).show();							
                            }else{							
                                $('.input_model'+cid).hide();
                                $('.input_cyear'+cid).hide();
                                $('.input_ccolor'+cid).hide();
                                $('.input_cnumber'+cid).hide();
                                $('.undobtn'+cid).hide();
                                $('.deletebtn'+cid).show();							
                                $('.span_model'+cid).show();
                                $('.span_cyear'+cid).show();
                                $('.span_ccolor'+cid).show();
                                $('.span_cnumber'+cid).show();
                                $('.merror').html('Failed To Update. Please try again');
                            }
			}			  
                    }            
		});
		$(this).html('Edit');				
            }			
    }
});

$(".deletebtn").on('click',function(){
  var agree = confirm("Are you sure that you want to delete this item?");
   if (agree) {
        var url_path = baseUrl + "login";
	var currentTD = $(this).parents('tr').find('td');
   	var id = $(this).parent().siblings(":first").text();
	$.ajax({	
		method      : "POST",		
		url         : baseUrl + "profile/api/delete_carinfo",
		dataType    : "json",					           
		data        : {id:id},			
		success     :function(data) {
                    if(data.login){                        
                        window.location.href = url_path;
                    }
                    if(typeof data.status !== typeof undefined){
			if(data.status){					
                            currentTD.remove();
                            $('.loader').hide();	
			}else{	
                            $('.merror').html('Failed To Delete. Please try again');					
                            $('.loader').hide();							
			}
                    }			  
                }            
	});   
	return true;
}
return false;	
});

$(".deletecard").on('click',function(){
    var agree = confirm("Are you sure that you want to delete this card?");
    if (agree) {
        var url_path = baseUrl + "login";
	var currentTD = $(this).parents('tr').find('td');
   	var id = $(this).parent().siblings(":first").text();
	$.ajax({	
            method      : "POST",		
            url         : baseUrl + "dashboard/card_delete",
            dataType    : "json",					           
            data        : {id:id},			
            success     :function(data) {
                if(data.login){                        
                        window.location.href = url_path;
                    }
                    if(typeof data.status !== typeof undefined){
                        if(data.cards){
                            $('.card_list').hide();
                        } else if(data.status){
                                currentTD.remove();							
                        } else{
                                $('.merror').html('Failed To Delete. Please try again');
                        }
                    }			  
            }            
	});   
	return true;
    }
    return false;	
});

 $('.undobtn').on('click',function(){		
    var $this = $(this);
    var $tr = $this.closest("tr");		
    var	cid = $tr.find('.cid').text();
    $tr.find('.editbtn').text('Edit');
    $('.input_model'+cid).val($('.input_model'+cid).data("original-value"));              
    $('.input_cyear'+cid).val($('.input_cyear'+cid).data("original-value"));
    $('.input_ccolor'+cid).val($('.input_ccolor'+cid).data("original-value"));
    $('.input_cnumber'+cid).val($('.input_cnumber'+cid).data("original-value"));

    $('.input_model'+cid).hide();
    $('.input_cyear'+cid).hide();
    $('.input_ccolor'+cid).hide();
    $('.input_cnumber'+cid).hide();
    $('.undobtn'+cid).hide();

    $('.deletebtn'+cid).show();
    $('.span_model'+cid).show();
    $('.span_cyear'+cid).show();
    $('.span_ccolor'+cid).show();
    $('.span_cnumber'+cid).show();
    $('.merror').html('');
    $('.yerror').html('');
    $('.cerror').html('');
    $('.nerror').html('');
    $tr.find('.input_model'+cid).removeClass('tderror');
    $tr.find('.input_cyear'+cid).removeClass('tderror');
    $tr.find('.input_ccolor'+cid).removeClass('tderror');
    $tr.find('.input_cnumber'+cid).removeClass('tderror');	
});

$(".remove-button").on('click', function() {
    var agree = confirm("Are you sure you want to remove profile image?");
    if (agree) {
        var url_login = baseUrl + "login";
        var url_path = baseUrl + "profile/profile_view";
        $.ajax({	
                method		: "POST",		
                url		: baseUrl + "profile/api/removeProfilleimg",
                dataType 	: "json",
                contentType	: false,
                cache		: false,
                processData	: false, 			
                success		:function(data) {
                                if(data.login){                        
                                    window.location.href = url_login;
                                }
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