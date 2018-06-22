$(document).ready(function() {

$(".savebtn").on('click',function(){
    var err = 0;   
    
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    var fromEmail = $('#fromEmail').val();
    if(fromEmail == ""){
        err = 1;
        $('#fromEmailerr').html('required');
    }else if(pattern.test(fromEmail) == false){
        err = 1;                        
        $('#fromEmailerr').html('Invalid Email');
    }            
    else{
        $('#fromEmailerr').html('');            
    }
    
    var hourlypriceIncrement = $('#hourlypriceIncrement').val();
    if(hourlypriceIncrement == ""){
        err = 1;
        $('#hourlypriceIncrementerr').html('required');    
    }            
    else if(!$.isNumeric($('#hourlypriceIncrement').val())){
        err = 1;
        $('#hourlypriceIncrementerr').html('Invalid');     
    }else{
        $('#hourlypriceIncrementerr').html('');            
    }
    
    var dailypriceIncrement = $('#dailypriceIncrement').val();
    if(dailypriceIncrement == ""){
        err = 1;
        $('#dailypriceIncrementerr').html('required');    
    }else if(!$.isNumeric($('#dailypriceIncrement').val())){
        err = 1;
        $('#dailypriceIncrementerr').html('Invalid');     
    }            
    else{
        $('#dailypriceIncrementerr').html('');            
    }
    
    
    var applicationFees = $('#applicationFees').val();
    if(applicationFees == ""){
        err = 1;
        $('#applicationFeeserr').html('required');    
    }else if(!$.isNumeric($('#applicationFees').val())){
        err = 1;
        $('#applicationFeeserr').html('Invalid');     
    }            
    else{
        $('#applicationFeeserr').html('');            
    }
    
    
     var applicationFeesdolars = $('#applicationFeesdolars').val();
    if(applicationFeesdolars == ""){
        err = 1;
        $('#applicationFeesdolarserr').html('required');    
    }else if(!$.isNumeric($('#applicationFeesdolars').val())){
        err = 1;
        $('#applicationFeesdolarserr').html('Invalid');     
    }            
    else{
        $('#applicationFeesdolarserr').html('');            
    }
    
     var startReminder = $('#startReminder').val();
    if(startReminder == ""){
        err = 1;
        $('#startRemindererr').html('required');    
    }else if(!$.isNumeric($('#startReminder').val())){
        err = 1;
        $('#startRemindererr').html('Invalid');     
    }            
    else{
        $('#startRemindererr').html('');            
    }
    
    
     var endReminder = $('#endReminder').val();
    if(endReminder == ""){
        err = 1;
        $('#endRemindererr').html('required');    
    }else if(!$.isNumeric($('#endReminder').val())){
        err = 1;
        $('#endRemindererr').html('Invalid');     
    }            
    else{
        $('#endRemindererr').html('');            
    }
    
     var totalBookingdays = $('#totalBookingdays').val();
    if(totalBookingdays == ""){
        err = 1;
        $('#totalBookingdayserr').html('required');    
    }else if(!$.isNumeric($('#totalBookingdays').val())){
        err = 1;
        $('#totalBookingdayserr').html('Invalid');     
    }            
    else{
        $('#totalBookingdayserr').html('');            
    }
    
     var drivewayDistance = $('#drivewayDistance').val();
    if(drivewayDistance == ""){
        err = 1;
        $('#drivewayDistanceerr').html('required');    
    }else if(!$.isNumeric($('#drivewayDistance').val())){
        err = 1;
        $('#drivewayDistanceerr').html('Invalid');     
    }            
    else{
        $('#drivewayDistanceerr').html('');            
    }
    
    
     var minutesLock = $('#minutesLock').val();
    if(minutesLock == ""){
        err = 1;
        $('#minutesLockerr').html('required');    
    }else if(!$.isNumeric($('#minutesLock').val())){
        err = 1;
        $('#minutesLockerr').html('Invalid');     
    }            
    else{
        $('#minutesLockerr').html('');            
    }
    
    
     var stripeFee = $('#stripeFee').val();
    if(stripeFee == ""){
        err = 1;
        $('#stripeFeeerr').html('required');    
    }else if(!$.isNumeric($('#stripeFee').val())){
        err = 1;
        $('#stripeFeeerr').html('Invalid');     
    }            
    else{
        $('#stripeFeeerr').html('');            
    }
    
     var stripeProcessfee = $('#stripeProcessfee').val();
    if(stripeProcessfee == ""){
        err = 1;
        $('#stripeProcessfeeerr').html('required');    
    }else if(!$.isNumeric($('#stripeProcessfee').val())){
        err = 1;
        $('#stripeProcessfeeerr').html('Invalid');     
    }            
    else{
        $('#stripeProcessfeeerr').html('');            
    }
    
    if(err == 0){
	var url_path = baseUrl + "webadmin/Settings";
	var formDataVal = document.forms.namedItem("settings");
	var formVals = new FormData(formDataVal);        
    $.ajax({	
		    method		: "POST",		
			url		: baseUrl + "webadmin/savesettings",                         
			dataType 	: "json",
                        contentType	: false,			
			processData	: false,
			data		:  formVals,			
			success		:function(data){                            
							if(typeof data.status !== typeof undefined){                                                           
							if(data.status){
                                                                $("#mailSent").show().delay(2000).fadeOut();
								window.location.href = url_path;
							}else{
                                                            
                      
                      $('.servererror').html('Failed to update')              
                  }
							}
			  
			},
            error:function(data){
                
                    $('.CCServerError').html('Something went wrong! Please try again.');
            }            
	});
    }
    });
    
 //$("#hourlypriceIncrement").on("keyup", function(){
  //  var valid = /^\d{0,3}(\.\d{0,2})?$/.test(this.value),
  //  val = this.value;    
  //  if(!valid){
  //      //console.log("Invalid input!");
  //      this.value = val.substring(0, val.length - 1);
  //  }
//});
   
    });