$(document).ready(function () { 
	var category = null;
    $("#on").click(function() {
		category = this.value;		
		var drivewayid = $('#drivewayID').val(); 
                var url_login = baseUrl + "login";
                var url_path = baseUrl + "dashboard/verifydriveway/"; 
                var url_path2 = baseUrl + "dashboard/addAccount";
		$.ajax({
            method: "POST",
            url: baseUrl + "dashboard/checkVerification", 
            //url: baseUrl + "dashboard/checkAccountExist", 
            data: {drivewayid:drivewayid},			
			dataType: "json",
            success:function(data){
                if(data.login){                        
                        window.location.href = url_login;
                    }
				if(typeof data.status !== typeof undefined){
					if(data.status == false && data.message == 'Admin not verified'){
						var agree = confirm("Admin has not verified your account.");
				    	if (agree) {					  
                                                    $('#on').prop('checked',false);					
						    $('#off').prop('checked',true);
						    return true;
						}
						$('#on').prop('checked',false);					
						$('#off').prop('checked',true);					
						return false;						
					}
					if(data.status == false && data.message == 'Not Verified'){							
						var agree = confirm("You need to verify your driveway before making it LIVE. Do you want to verify?");
						if (agree) {													  
							window.location.href = url_path+drivewayid;
							return true;
						}
						$('#on').prop('checked',false);					
						$('#off').prop('checked',true);					
						return false;						
					}
                                        if(data.status == false && data.message == 'No Account'){							
						var agree = confirm("You need to add your Bank Account Information before making your driveway LIVE. Do you want to add?");
						if (agree) {													  
							window.location.href = url_path2;
							return true;
						}
						$('#on').prop('checked',false);					
						$('#off').prop('checked',true);					
						return false;						
					}
					if(data.status == true){
						$('#on').prop('checked',true);					
						$('#off').prop('checked',false);						
					}	
				}
			},
            error:function(data){                   
                    $('.CCServerError').html('Something went wrong! Please try again.');
            } 
		});
		
	});
	
	

	
	$('.drivewaySetting').validate({
        rules: { 
		    startDate:{
						checkstartdate: true,
					//	checkstart : true  
					  },         
		    endDate:  {
					    checkenddate: true,
						checkend :true
					  },
			fromdate1: {
						checkftime1: true,
						checkftime1val: true
			           },
			todate1: {
						checkttime1: true,
                        checkttime1val: true						
			           },
			fromdate5: {
						checkftime5: true,
						checkftime5val: true
			           },
			todate5: {
						checkttime5: true,
                        checkttime5val: true						
			           },
			fromdate6: {
						checkftime6: true,
						checkftime6val: true
			           },
			todate6: {
						checkttime6: true,
                        checkttime6val: true						
			           },
			fromdate0: {
						checkftime7: true,
						checkftime7val: true
			           },
			todate0: {
						checkttime7: true,
						checkttime7val: true
			           },
		}
        		
    });

    jQuery.validator.addMethod('checkenddate', function (value) {
        if($('.startDate').val()!='' && $('.endDate').val()==''){		
           return false;
		}
        return true;
    }, "Required");

    jQuery.validator.addMethod('checkstartdate', function (value) {
        if($('.endDate').val()!='' && $('.startDate').val()==''){		
            return false;
		}
        return true;
    }, "Required");
	
	jQuery.validator.addMethod('checkstart', function (value) {
		var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output =  
    ((''+month).length<2 ? '0' : '') + month + '/' +
    ((''+day).length<2 ? '0' : '') + day + '/' +
    d.getFullYear();
        if($('.startDate').val()==''){
		return true;
		}else{
		if(new Date(output) <= new Date(value))
        {   
           return true;
        }
		}
		}, "Invalid date");	
		
		jQuery.validator.addMethod('checkend', function (value) {
        var edDate = $('.endDate').val();
		var stDate = $('.startDate').val();
		if (new Date(edDate) < new Date(stDate)) {
		return false;
		}
        return true;
    }, "Invalid");
	
		jQuery.validator.addMethod('checkftime1', function (value) {
		if($(".optionone").prop('checked') == true && $('#todate1').val()!='' && $('#fromdate1').val()==''){		
            return false;
		}
        return true;
		}, "Required");
	
	jQuery.validator.addMethod('checkttime1', function (value) {
		if($(".optionone").prop('checked') == true && $('#fromdate1').val()!='' && $('#todate1').val()==''){		
            return false;
		}
        return true;
		}, "Required");
		jQuery.validator.addMethod('checkftime5', function (value) {
		if($(".optionfive").prop('checked') == true && $('#todate5').val()!='' && $('#fromdate5').val()==''){		
            return false;
		}
        return true;
		}, "Required");
	
	jQuery.validator.addMethod('checkttime5', function (value) {
		if($(".optionfive").prop('checked') == true && $('#fromdate5').val()!='' && $('#todate5').val()==''){		
            return false;
		}
        return true;
		}, "Required");
		
	jQuery.validator.addMethod('checkftime6', function (value) {
		if($(".optionsix").prop('checked') == true && $('#todate6').val()!='' && $('#fromdate6').val()==''){		
            return false;
		}
        return true;
		}, "Required");
	
	jQuery.validator.addMethod('checkttime6', function (value) {
		if($(".optionsix").prop('checked') == true && $('#fromdate6').val()!='' && $('#todate6').val()==''){		
            return false;
		}
        return true;
		}, "Required");
		
	jQuery.validator.addMethod('checkftime7', function (value) {
		if($(".optionseven").prop('checked') == true && $('#todate0').val()!='' && $('#fromdate0').val()==''){		
            return false;
		}
        return true;
		}, "Required");
	
	jQuery.validator.addMethod('checkttime7', function (value) {
		if($(".optionseven").prop('checked') == true && $('#fromdate0').val()!='' && $('#todate0').val()==''){		
            return false;
		}
        return true;
		}, "Required");
		
	jQuery.validator.addMethod('checkftime1val', function (value) {
		if($(".optionone").prop('checked') == true && $('#fromdate1').val()!='' && $('#todate1').val()!=''){		
           var fromTime = converttime($('#fromdate1').val());
		   var toTime   = converttime($('#todate1').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");

	jQuery.validator.addMethod('checkttime1val', function (value) {
		if($(".optionone").prop('checked') == true && $('#fromdate1').val()!='' && $('#todate1').val()!=''){		
           var fromTime = converttime($('#fromdate1').val());
		   var toTime   = converttime($('#todate1').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");
		
	jQuery.validator.addMethod('checkftime5val', function (value) {
		if($(".optionfive").prop('checked') == true && $('#fromdate5').val()!='' && $('#todate5').val()!=''){		
           var fromTime = converttime($('#fromdate5').val());
		   var toTime   = converttime($('#todate5').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");

	jQuery.validator.addMethod('checkttime5val', function (value) {
		if($(".optionfive").prop('checked') == true && $('#fromdate5').val()!='' && $('#todate5').val()!=''){		
           var fromTime = converttime($('#fromdate5').val());
		   var toTime   = converttime($('#todate5').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");
		
	jQuery.validator.addMethod('checkftime6val', function (value) {
		if($(".optionsix").prop('checked') == true && $('#fromdate6').val()!='' && $('#todate6').val()!=''){		
           var fromTime = converttime($('#fromdate6').val());
		   var toTime   = converttime($('#todate6').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");

	jQuery.validator.addMethod('checkttime6val', function (value) {
		if($(".optionsix").prop('checked') == true && $('#fromdate6').val()!='' && $('#todate6').val()!=''){		
           var fromTime = converttime($('#fromdate6').val());
		   var toTime   = converttime($('#todate6').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");
		
	jQuery.validator.addMethod('checkftime7val', function (value) {
		if($(".optionseven").prop('checked') == true && $('#fromdate0').val()!='' && $('#todate0').val()!=''){		
           var fromTime = converttime($('#fromdate0').val());
		   var toTime   = converttime($('#todate0').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");

	jQuery.validator.addMethod('checkttime7val', function (value) {
		if($(".optionseven").prop('checked') == true && $('#fromdate0').val()!='' && $('#todate0').val()!=''){		
           var fromTime = converttime($('#fromdate0').val());
		   var toTime   = converttime($('#todate0').val());	
		   if (fromTime == toTime || fromTime > toTime) {
			return false;
			}
		}
        return true;
		}, "Invalid");
		
	$('.submitBtn').on('click',function(){
	var validation = 0;
	$('.optiononeerror').hide();
	$('.optionfiveerror').hide();
	$('.optionsixerror').hide();
	$('.optionsevenerror').hide();
	if($('.startDate').val()!='' && $('.endDate').val()!=''){

	   var ckbox1 = $('#one');
	   if (ckbox1.is(':checked')) {
           	var elements = [1];
            var res = checkDateandTime(elements);
			if(res == false){
			 $('.optiononeerror').show();
			 validation = 1;
			 //return;
			}
        }
        
		var ckbox2 = $('#five');
	    if (ckbox2.is(':checked')) {
           	var elements = [5];
            var res = checkDateandTime(elements);
			if(res == false){
			 $('.optionfiveerror').show();
			 validation = 1;
			// return;
			}
        }
		
		var ckbox3 = $('#six');
	    if (ckbox3.is(':checked')) {
           	var elements = [6];
            var res = checkDateandTime(elements);
			if(res == false){
			 $('.optionsixerror').show();
			 validation = 1;
			 //return;
			}
        }
		
		var ckbox4 = $('#seven');
	    if (ckbox4.is(':checked')) {
           	var elements = [0];
            var res = checkDateandTime(elements);
			if(res == false){
			 $('.optionsevenerror').show();
			  validation = 1;
			 //return;
			}
        }
	}
		if(validation == 0){
        var path = baseUrl + "dashboard";
         var url_login = baseUrl + "login";
        
	  	var $valid = $(".drivewaySetting").valid();
		if($valid){	
           
			$('.loader').show();				
			var formDataVal = document.forms.namedItem("drivewaySetting");
			var formVals = new FormData(formDataVal);
			$.ajax({
				method: "POST",
				url: baseUrl + "dashboard/saveSettings",
				dataType : "json",
				contentType: false,
				cache: false,
				processData: false,           
				data: formVals,
				success:function(data){
                                    if(data.login){                        
                        window.location.href = url_login;
                    }
						if(typeof data.status !== typeof undefined){
						if(data.status == true){					
						if($(".optionone").prop('checked') == false){
                            $('#fromdate1').timepicker("setTime",null); 
                            $('#todate1').timepicker("setTime",null);  							
                        }
						if($(".optionfive").prop('checked') == false){
                            $('#fromdate5').timepicker("setTime",null); 
                            $('#todate5').timepicker("setTime",null);  							
                        }
						if($(".optionsix").prop('checked') == false){
                            $('#fromdate6').timepicker("setTime",null); 
                            $('#todate6').timepicker("setTime",null);  							
                        }
						if($(".optionseven").prop('checked') == false){
                            $('#fromdate0').timepicker("setTime",null); 
                            $('#todate0').timepicker("setTime",null);  							
                        }
						$('.loader').hide();
						$("#mailSent").show().delay(2000).fadeOut();
						}else{
                        $('.loader').hide();					
					
						$('#checkValidationdate').val('1');
						$('#checkValidationtime').val('1');	
							
						if ( $('#on').data("original-value") == 1){
						$('#on').prop('checked',true);	
						} else {
						$('#on').prop('checked',false);	
						}
						if ( $('#off').data("original-value") == 1){
						$('#off').prop('checked',true);	
						} else {
						$('#off').prop('checked',false);	
						}					
						return false;
                  					
						}
						}
					}
			});
		}else{
		    $('.loader').hide();
		}			
	}
	});	
    $('.reset').click(function() {
        var val = $(this).attr("value");
		var optionval = $('.option'+val).data("original-value");
		if(optionval == 'checked'){
		    $('.option'+val).prop('checked', true);
		}else{
		    $('.option'+val).prop('checked', false);
		}
		$('.error'+val).html('');
		$('.error'+val).css('display','none');
	    $('.ftime'+val).timepicker("setTime",$('.ftime'+val).data("original-value"));
		$('.ttime'+val).timepicker("setTime",$('.ttime'+val).data("original-value"));
		
    });

	function converttime(time1){
	   // var time1 = $('#time1').val();
							var hours = Number(time1.match(/^(\d+)/)[1]);
							var minutes = Number(time1.match(/:(\d+)/)[1]);
							var AMPM = time1.match(/\s(.*)$/)[1];
							if (AMPM == "PM" && hours < 12)
								hours = hours + 12;
							if (AMPM == "AM" && hours == 12)
								hours = hours - 12;
							var sHours = hours.toString();
							var sMinutes = minutes.toString();
							if (hours < 10)
								sHours = "0" + sHours;
							if (minutes < 10)
								sMinutes = "0" + sMinutes;
							var fromtime = sHours + ":" + sMinutes;
							return fromtime;
	
	}
	
	function checkDateandTime(option){
		var edDate = new Date($('.endDate').val());
		var stDate = new Date($('.startDate').val());	
            while(stDate <= edDate){
			   dayIndex = stDate.getDay();
			    if (jQuery.inArray(dayIndex, option)!='-1') {
					return true;
				}          

			   var newDate = stDate.setDate(stDate.getDate() + 1);
			   stDate = new Date(newDate);
			}		
		 	return false;	
	    }

});

