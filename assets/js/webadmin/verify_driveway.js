$(".verify").on('click',function(){
    var trid = $(this).closest('tr').attr('id');
    var currentTD = $(this).parents('tr').find('td');
    var userid = $('.userid'+trid).val();
    $('.loader').show();
    $.ajax({    
          method: "POST",        
          url: baseUrl + "webadmin/send_verificationcode",
          dataType : "json",                               
          data: {
                  drivewayId        : trid,
                  userId            : userid                
          },            
          success:function(data) { 
               $('.loader').hide();
              if(typeof data.status !== typeof undefined){
                  if(data.status){                        
                    //console.log('Updated');                            
                    currentTD.remove();
                    $("#mailSent").show().delay(2000).fadeOut();
                  }else{    
                      //console.log('failed');
                      $('.servererror').html('Failed to send verification Code')              
                  }
              }              
          }            
      });          
       
});
